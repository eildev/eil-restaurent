<?php

namespace App\Http\Controllers;

use App\Models\AccountTransaction;
use App\Models\ActualPayment;
use App\Models\Customer;
use App\Models\Product;
use App\Models\Promotion;
use App\Models\PromotionDetails;
use App\Models\Sale;
use App\Models\SaleItem;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;

class SaleController extends Controller
{
    public function index()
    {
        return view('pos.sale.sale');
    }
    public function getCustomer()
    {
        $data = Customer::where('branch_id', Auth::user()->branch_id)->latest()->get();
        return response()->json([
            'status' => 200,
            'message' => 'successfully save',
            'allData' => $data
        ]);
    }
    public function addCustomer(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'phone' => 'required',
        ]);

        if ($validator->passes()) {
            $customer = new Customer;
            $customer->branch_id = Auth::user()->branch_id;
            $customer->name = $request->name;
            $customer->phone = $request->phone;
            $customer->email = $request->email;
            $customer->address = $request->address;
            $customer->opening_receivable = $request->opening_receivable ?? 0;
            $customer->opening_payable = $request->opening_payable ?? 0;
            $customer->wallet_balance = $request->wallet_balance ?? 0;
            $customer->total_receivable = $request->total_receivable ?? 0;
            $customer->total_payable = $request->total_payable ?? 0;
            $customer->created_at = Carbon::now();
            $customer->save();
            return response()->json([
                'status' => 200,
                'message' => 'successfully save',
            ]);
        } else {
            return response()->json([
                'status' => '500',
                'error' => $validator->messages()
            ]);
        }
    }

    public function store(Request $request)
    {
        // dd($request->all());
        $validator = Validator::make($request->all(), [
            'customer_id' => 'required',
            'sale_date' => 'required',
            'payment_method' => 'required',
            'paid' => 'required',
        ]);

        if ($validator->passes()) {

            // product Cost 
            $productCost = 0;
            $productAll = $request->products;
            foreach ($productAll as $product) {
                $items = Product::findOrFail($product['product_id']);
                $productCost += $items->cost;
            }

            // Sale Table CRUD 
            $sale = new Sale;
            $sale->branch_id = Auth::user()->branch_id;
            $sale->customer_id = $request->customer_id;
            $sale->sale_date = $request->sale_date;
            $sale->sale_by = 0;
            $sale->invoice_number = rand(123456, 99999);
            $sale->order_type = "general";
            $sale->quantity = $request->quantity;
            $sale->total = $request->total_amount;
            $sale->discount = $request->discount;
            $sale->change_amount = $request->total;
            $sale->actual_discount = $request->actual_discount;
            $sale->tax = $request->tax;
            $sale->receivable = $request->change_amount;
            // $sale->paid = $request->paid;
            $sale->due = $request->due;
            if ($request->due < 0) {
                $sale->paid = $request->paid + $request->due;
            } else {
                $sale->paid = $request->paid;
            }
            // $sale->returned = $request->due;
            $sale->final_receivable = $request->change_amount;
            $sale->payment_method = $request->payment_method;
            $sale->profit = $request->change_amount - $productCost;
            $sale->note = $request->note;
            $sale->created_at = Carbon::now();
            $sale->save();


            $saleId = $sale->id;

            // products table CRUD 
            $products = $request->products;
            foreach ($products as $product) {
                $items2 = Product::findOrFail($product['product_id']);
                $items = new SaleItem;
                $items->sale_id = $saleId;
                $items->product_id = $product['product_id']; // Access 'product_id' as an array key
                $items->rate = $product['unit_price']; // Access 'unit_price' as an array key
                $items->qty = $product['quantity'];
                $items->discount = $product['discount'];
                $items->sub_total = $product['total_price'];
                $items->total_purchase_cost = $items2->cost * $product['quantity'];
                $items->save();


                $items2->stock = $items2->stock - $product['quantity'];
                $items2->total_sold = $items2->total_sold + $product['quantity'];
                $items2->save();
            }

            // customer table CRUD 
            $customer = Customer::findOrFail($request->customer_id);
            $customer->total_receivable = $customer->total_receivable + $request->change_amount;
            $customer->total_payable = $customer->total_payable + $request->paid;
            $customer->wallet_balance = $customer->wallet_balance + ($request->change_amount - $request->paid);
            $customer->save();

            // actual Payment 
            $actualPayment = new ActualPayment;
            $actualPayment->branch_id =  Auth::user()->branch_id;
            $actualPayment->payment_type =  'receive';
            $actualPayment->payment_method =  $request->payment_method;
            $actualPayment->customer_id = $request->customer_id;
            $actualPayment->amount = $request->paid;
            $actualPayment->date = $request->sale_date;
            $actualPayment->save();

            // accountTransaction table 
            $accountTransaction = new AccountTransaction;
            $accountTransaction->branch_id =  Auth::user()->branch_id;
            $accountTransaction->purpose =  'Withdraw';
            $accountTransaction->account_id =  $request->payment_method;
            $accountTransaction->credit = $request->paid;
            // $accountTransaction->balance = $accountTransaction->balance + $request->paid;
            $accountTransaction->save();

            $transaction = Transaction::where('customer_id', $request->customer_id)->first();

            if ($transaction) {
                // Update existing transaction
                $transaction->date =  $request->sale_date;
                $transaction->payment_type = 'receive';
                $transaction->particulars = 'Sale#' . $saleId;
                $transaction->credit = $transaction->credit + $request->change_amount;
                $transaction->debit = $transaction->debit + $request->paid;
                $transaction->balance = $transaction->balance + ($request->change_amount - $request->paid);
                $transaction->payment_method = $request->payment_method;
                $transaction->save();
            } else {
                // Create new transaction
                $transaction = new Transaction;
                $transaction->date =  $request->sale_date;
                $transaction->payment_type = 'receive';
                $transaction->particulars = 'Sale#' . $saleId;
                $transaction->customer_id = $request->customer_id;
                $transaction->credit = $request->change_amount;
                $transaction->debit = $request->paid;
                $transaction->balance = $request->change_amount - $request->paid;
                $transaction->payment_method = $request->payment_method;
                $transaction->save();
            }

            return response()->json([
                'status' => 200,
                'saleId' => $saleId,
                'message' => 'successfully save',
            ]);
        } else {
            return response()->json([
                'status' => '500',
                'error' => $validator->messages(),
            ]);
        }
    }
    public function invoice($id)
    {
        $sale = Sale::findOrFail($id);
        return view('pos.sale.invoice', compact('sale'));
    }
    public function print($id)
    {
        $sale = Sale::findOrFail($id);
        return view('pos.sale.pos-print', compact('sale'));
    }

    public function view()
    {
        $sales = Sale::where('branch_id', Auth::user()->branch_id)->latest()->get();
        return view('pos.sale.view', compact('sales'));
    }
    // public function viewAll()
    // {
    //     $sales = Sale::where('branch_id', Auth::user()->branch_id)->get();
    //     return response()->json([
    //         'status' => 200,
    //         'allData' => $sales,
    //     ]);
    // }
    public function viewDetails($id)
    {
        $sale = Sale::findOrFail($id);
        return view('pos.sale.show', compact('sale'));
    }

    public function edit($id)
    {
        $sale = Sale::findOrFail($id);
        return view('pos.sale.edit', compact('sale'));
    }
    public function update(Request $request, $id)
    {
        // dd($request->all());
        $validator = Validator::make($request->all(), [
            'customer_id' => 'required',
            'products' => 'required',
            'sale_date' => 'required',
            'payment_method' => 'required',
        ]);

        if ($validator->passes()) {

            // product Cost 
            $productCost = 0;
            $productAll = $request->products;
            foreach ($productAll as $product) {
                $items = Product::findOrFail($product['product_id']);
                $productCost += $items->cost;
            }

            // Sale Table CRUD 
            $sale = Sale::findOrFail($id);
            $sale->branch_id = Auth::user()->branch_id;
            $sale->customer_id = $request->customer_id;
            $sale->sale_date = $request->sale_date;
            $sale->sale_by = 0;
            $sale->invoice_number = rand(123456, 99999);
            $sale->order_type = "general";
            $sale->quantity = $request->quantity;
            $sale->total = $request->total_amount;
            $sale->discount = $request->discount;
            $sale->change_amount = $request->total;
            $sale->actual_discount = $request->actual_discount;
            $sale->tax = $request->tax;
            $sale->receivable = $request->change_amount;
            // $sale->paid = $request->paid;
            $sale->due = $request->due;
            if ($request->due < 0) {
                $sale->paid = $request->paid + $request->due;
            } else {
                $sale->paid = $request->paid;
            }
            // $sale->returned = $request->due;
            $sale->final_receivable = $request->change_amount;
            $sale->payment_method = $request->payment_method;
            $sale->profit = $request->change_amount - $productCost;
            $sale->note = $request->note;
            $sale->created_at = Carbon::now();
            $sale->save();


            // $saleId = $sale->id;

            // products table CRUD 
            $products = $request->products;
            foreach ($products as $product) {
                $items2 = Product::findOrFail($product['product_id']);
                $items = new SaleItem;
                $items->sale_id = $sale->id;
                $items->product_id = $product['product_id']; // Access 'product_id' as an array key
                $items->rate = $product['unit_price']; // Access 'unit_price' as an array key
                $items->qty = $product['quantity'];
                $items->discount = $product['discount'];
                $items->sub_total = $product['total_price'];
                $items->total_purchase_cost = $items2->cost * $product['quantity'];
                $items->save();


                $items2->stock = $items2->stock - $product['quantity'];
                $items2->total_sold = $items2->total_sold + $product['quantity'];
                $items2->save();
            }

            // customer table CRUD 
            $customer = Customer::findOrFail($request->customer_id);
            $customer->total_receivable = $customer->total_receivable + $request->change_amount;
            $customer->total_payable = $customer->total_payable + $request->paid;
            $customer->wallet_balance = $customer->wallet_balance + ($request->change_amount - $request->paid);
            $customer->save();

            // actual Payment 
            $actualPayment = new ActualPayment;
            $actualPayment->branch_id =  Auth::user()->branch_id;
            $actualPayment->payment_type =  'receive';
            $actualPayment->payment_method =  $request->payment_method;
            $actualPayment->customer_id = $request->customer_id;
            $actualPayment->amount = $request->paid;
            $actualPayment->date = $request->sale_date;
            $actualPayment->save();

            // accountTransaction table 
            $accountTransaction = new AccountTransaction;
            $accountTransaction->branch_id =  Auth::user()->branch_id;
            $accountTransaction->purpose =  'Withdraw';
            $accountTransaction->account_id =  $request->payment_method;
            $accountTransaction->credit = $request->paid;
            // $accountTransaction->balance = $accountTransaction->balance + $request->paid;
            $accountTransaction->save();

            $transaction = Transaction::where('customer_id', $request->customer_id)->first();

            if ($transaction) {
                // Update existing transaction
                $transaction->date =  $request->sale_date;
                $transaction->payment_type = 'receive';
                $transaction->particulars = 'Sale#' . $sale->id;
                $transaction->credit = $transaction->credit + $request->change_amount;
                $transaction->debit = $transaction->debit + $request->paid;
                $transaction->balance = $transaction->balance + ($request->change_amount - $request->paid);
                $transaction->payment_method = $request->payment_method;
                $transaction->save();
            } else {
                // Create new transaction
                $transaction = new Transaction;
                $transaction->date =  $request->sale_date;
                $transaction->payment_type = 'receive';
                $transaction->particulars = 'Sale#' . $sale->id;
                $transaction->customer_id = $request->customer_id;
                $transaction->credit = $request->change_amount;
                $transaction->debit = $request->paid;
                $transaction->balance = $request->change_amount - $request->paid;
                $transaction->payment_method = $request->payment_method;
                $transaction->save();
            }

            return response()->json([
                'status' => 200,
                'saleId' => $sale->id,
                'message' => 'successfully Updated',
            ]);
        } else {
            return response()->json([
                'status' => '500',
                'error' => $validator->messages(),
            ]);
        }
    }
    public function destroy($id)
    {
        $sale = Sale::findOrFail($id);
        $sale->delete();
        return back()->with('message', "Sale successfully Deleted");
    }
    public function filter(Request $request)
    {
        // dd($request->all());
        $saleQuery = Sale::query();

        // Filter by product_id if provided
        if ($request->product_id != "Select Product") {
            $saleQuery->whereHas('saleItem', function ($query) use ($request) {
                $query->where('product_id', $request->product_id);
            });
        }

        // Filter by customer_id if provided
        if ($request->customer_id != "Select Customer") {
            $saleQuery->where('customer_id', $request->customer_id);
        }

        // Filter by date range if both start_date and end_date are provided
        if ($request->start_date && $request->end_date) {
            $saleQuery->whereBetween('sale_date', [$request->start_date, $request->end_date]);
        }

        // Execute the query
        $sales = $saleQuery->get();

        return view('pos.sale.table', compact('sales'))->render();
    }
    public function find($id)
    {
        // dd($id);
        // $purchaseId = 'Purchase#' + $id;
        $sale = Sale::findOrFail($id);
        return response()->json([
            'status' => 200,
            'data' => $sale
        ]);
    }
    public function saleTransaction(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            "transaction_account" => 'required',
            "amount" => 'required|',
        ]);

        $validator->after(function ($validator) use ($id, $request) {
            $sale = Sale::findOrFail($id);
            if ($request->amount > $sale->due) {
                $validator->errors()->add('amount', 'The amount cannot be greater than the due amount.');
            }
        });
        if ($validator->passes()) {
            $sales = Sale::all();
            $sale = Sale::findOrFail($id);
            $sale->paid = $sale->paid + $request->amount;
            $sale->due = $sale->due - $request->amount;
            $sale->save();

            $customer = Customer::findOrFail($sale->customer_id);
            $customer->total_payable = $customer->total_payable + $request->amount;
            $customer->wallet_balance = $customer->wallet_balance - $request->amount;
            $customer->save();

            // accountTransaction table 
            $accountTransaction = new AccountTransaction;
            $accountTransaction->branch_id =  Auth::user()->branch_id;
            $accountTransaction->purpose =  'Withdraw';
            $accountTransaction->account_id =  $request->transaction_account;
            $accountTransaction->credit = $request->amount;
            // $accountTransaction->balance = $accountTransaction->balance + $request->paid;
            $accountTransaction->save();

            $transaction = new Transaction;
            $transaction->date = $request->payment_date;
            $transaction->payment_type = 'receive';
            $transaction->particulars = 'Sale#' . $id;
            $transaction->customer_id = $customer->id;
            $transaction->debit = $transaction->debit + $request->amount;
            $transaction->balance = $transaction->balance + $request->amount;
            $transaction->payment_method = $request->transaction_account;
            $transaction->save();

            // return view('pos.sale.table', compact('sales'))->render();

            return response()->json([
                'status' => 200,
                'message' => "Update successful",
                'sales' => $sales
            ]);
        } else {
            return response()->json([
                'status' => 500,
                'error' => $validator->errors()
            ]);
        }
    }

    public function findQty($id)
    {
        $product = Product::findOrFail($id);

        return response()->json([
            'status' => 200,
            'product' => $product
        ]);
    }


    public function saleCustomer($id)
    {

        $status = 'active';
        $customer = Customer::findOrFail($id);
        $promotionDetails = PromotionDetails::whereHas('promotion', function ($query) use ($status) {
            return $query->where('status', '=', $status);
        })->where('promotion_type', 'customers')->where('logic', 'like', '%' . $id . "%")->get();
        $promotions = [];
        foreach ($promotionDetails as $promo) {
            $promotions[] = $promo->promotion;
        }
        // dd($promotion);
        if ($promotions) {
            return response()->json([
                'status' => '200',
                'data' => $customer,
                'promotions' => $promotions,
            ]);
        } else {
            return response()->json([
                'status' => '200',
                'data' => $customer
            ]);
        }
    }

    public function salePromotions($id)
    {
        $promotions = Promotion::findOrFail($id);
        return response()->json([
            'status' => '200',
            'promotions' => $promotions
        ]);
    }


    public function findProductWithBarcode($id)
    {
        $status = 'active';
        $products = Product::where('branch_id', Auth::user()->branch_id)->where('barcode', $id)->latest()->first();

        if ($products) { // Check if $products is not null
            if ($products->stock > 0) {
                $promotionDetails = PromotionDetails::whereHas('promotion', function ($query) use ($status) {
                    return $query->where('status', '=', $status);
                })->where('promotion_type', 'products')->where('logic', 'like', '%' . $products->id . "%")->latest()->first();

                if ($promotionDetails) {
                    return response()->json([
                        'status' => '200',
                        'data' => $products,
                        'promotion' => $promotionDetails->promotion,
                    ]);
                } else {
                    return response()->json([
                        'status' => '200',
                        'data' => $products
                    ]);
                }
            } else if ($products->stock <= 0) {
                return response()->json([
                    'status' => '300',
                    'error' => 'Not Enough Stock Available'
                ]);
            }
        } else { // Handle the case where no product is found
            return response()->json([
                'status' => '500',
                'error' => 'Product Not Available'
            ]);
        }
    }


    // public function saleProductFind($id)
    // {
    //     $saleItems = SaleItem::where('sale_id', $id)->get();
    //     // $products = Product::where('branch_id', Auth::user()->branch_id)->where('stock', '>', 0)->where('barcode', $id)->latest()->first();

    //     return response()->json([
    //         'status' => '200',
    //         'data' => $saleItems
    //     ]);
    // }
    public function saleProductFind($id)
    {
        $status = 'active';
        $saleItems = SaleItem::where('sale_id', $id)->get();

        $items = $saleItems->map(function ($saleItem) use ($status) {
            $product = Product::find($saleItem->product_id);
            $promotionDetails = PromotionDetails::whereHas('promotion', function ($query) use ($status) {
                return $query->where('status', '=', $status);
            })->where('promotion_type', 'products')->where('logic', 'like', '%' . $product->id . "%")->latest()->first();
            // dd($saleItem->qty);
            return [
                'product' => $product,
                'promotion' => $promotionDetails ? $promotionDetails->promotion : null,
                'quantity' => $saleItem->qty,
            ];
        });

        return response()->json([
            'status' => '200',
            'items' => $items
        ]);
    }
}
