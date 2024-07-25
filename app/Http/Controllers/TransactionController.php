<?php

namespace App\Http\Controllers;

use App\Models\Bank;
use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\AccountTransaction;
use App\Models\Supplier;
use App\Models\Customer;
use App\Models\Purchase;
use App\Models\Investor;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    public function TransactionAdd()
    {
        $paymentMethod = Bank::all();
        $supplier = Supplier::latest()->get();
        $customer = Customer::latest()->get();
        if(Auth::user()->id == 1){
            $investors = Investor::latest()->get();
        }else{
            $investors = Investor::where('branch_id', Auth::user()->branch_id)->latest()->get();
        }
        if(Auth::user()->id == 1){
            $transaction = Transaction::latest()->get();
        }else{
            $transaction = Transaction::where('branch_id', Auth::user()->branch_id)->latest()->get();
        }

        return view('pos.transaction.transaction_add', compact('paymentMethod', 'supplier', 'customer', 'transaction', 'investors'));
    } //
    // public function TransactionView(){
    //     return view('pos.transaction.transaction_view');
    // }
    public function getDataForAccountId(Request $request)
    {
        $accountId = $request->input('id');
        $account_type = $request->input('account_type');
        //dd($accountId);
        if ($account_type == "supplier") {
            $info = Supplier::findOrFail($accountId);
            $count = Purchase::where('supplier_id', $accountId)->where('due', '>', 0)->count();
        } else {
            $info = Customer::findOrFail($accountId);
            $count = Purchase::where('supplier_id', $accountId)->where('due', '>', 0)->count();
        }
        return response()->json([
            "info" => $info,
            "count" => $count
        ]);
    } // End function
    public function TransactionStore(Request $request)
    {
        // dd($request->payment_method);
        if ($request->account_type == 'supplier') {
            //Here change
            $oldBalance = AccountTransaction::where('account_id', $request->payment_method)->latest('created_at')->first();
            if ($oldBalance->balance > 0 && $oldBalance->balance >= $request->amount) {
                //Here change End
                $supplier = Supplier::findOrFail($request->account_id);
                // dd($request->account_id);
                $currentBalance = $supplier->wallet_balance;
                $currentBalance = $currentBalance ?? 0;
                $newBalance = floatval($currentBalance) - floatval($request->amount);
                $supplier->wallet_balance = $newBalance;
                $newPayble = $supplier->total_payable ?? 0;
                $updatePaybele = floatval($newPayble) + floatval($request->amount);
                // dd($tracBalance->balance);
                $supplier->total_payable = $updatePaybele;
                $tracBalance = Transaction::where('supplier_id', $supplier->id)->latest()->first();
                if ($tracBalance !== null) {
                    $debitBalance = floatval($tracBalance->balance);
                    $updateTraBalance = ($debitBalance ?? 0) - floatval($request->amount);
                } else {
                    $updateTraBalance = floatval($request->amount); // Set to default value or handle
                }
                // dd($updateTraBalance);
                $transaction = Transaction::create([
                    'branch_id' =>Auth::user()->branch_id,
                    'date' => $request->date,
                    'payment_type' => 'pay',
                    'particulars' => 'PurchaseDue',
                    'debit' => $request->amount,
                    'payment_method' => $request->payment_method,
                    'balance' => $updateTraBalance,
                    'note' => $request->note,
                    'supplier_id' => $request->account_id
                ]);

                $supplier->update([
                    'wallet_balance' => $newBalance,
                    'total_payable' => $updatePaybele
                ]);
                //account Transaction Crud
                $accountTransaction = new AccountTransaction;
                $accountTransaction->branch_id =  Auth::user()->branch_id;
                $accountTransaction->reference_id = $transaction->id;
                $accountTransaction->purpose =  'PurchaseDue';
                $accountTransaction->account_id =  $request->payment_method;
                $accountTransaction->debit = $request->amount;
                $oldBalance = AccountTransaction::where('account_id', $request->payment_method)->latest('created_at')->first();
                $accountTransaction->balance = $oldBalance->balance - $request->amount;
                $accountTransaction->created_at = Carbon::now();
                $accountTransaction->save();
                $notification = [
                    'message' => 'Transaction Payment Successful',
                    'alert-type' => 'info'
                ];
                return redirect()->back()->with($notification);
            } else {
                $notification = [
                    'warning' => 'Your account Balance is low Please Select Another account',
                    'alert-type' => 'warning'
                ];
                return redirect()->back()->with($notification);
            }
            //End
        } else if ($request->account_type == 'customer') {
            //Customer Table Update
            $customer = Customer::findOrFail($request->account_id);
            $newBalance = $customer->wallet_balance - $request->amount;
            $newPayable = $customer->total_payable + $request->amount;
            $customer->update([
                'wallet_balance' => $newBalance,
                'total_payable' => $newPayable
            ]);

            // transaction crud Update
            $tracsBalance = Transaction::where('customer_id', $customer->id)->latest()->first();
            $transBalance = $tracsBalance->balance ?? 0;
            $newTrasBalance = $transBalance + $request->amount;
            $transaction = Transaction::create([
                'branch_id' =>Auth::user()->branch_id,
                'date' => $request->date,
                'payment_type' => 'receive',
                'particulars' => 'SaleDue',
                'credit' => $request->amount,
                'payment_method' => $request->payment_method,
                'note' => $request->note,
                'balance' => $newTrasBalance,
                'customer_id' => $request->account_id
            ]);

            //account Transaction Crud
            $accountTransaction = new AccountTransaction;
            $accountTransaction->branch_id =  Auth::user()->branch_id;
            $accountTransaction->reference_id = $transaction->id;
            $accountTransaction->purpose =  'SaleDue';
            $accountTransaction->account_id =  $request->payment_method;
            $accountTransaction->credit = $request->amount;
            $oldBalance = AccountTransaction::where('account_id', $request->payment_method)->latest('created_at')->first();
            $accountTransaction->balance = $oldBalance->balance + $request->amount;
            $accountTransaction->created_at = Carbon::now();
            $accountTransaction->save();
            $notification = [
                'message' => 'Transaction Payment Successful',
                'alert-type' => 'info'
            ];
            return redirect()->back()->with($notification);
        } else if ($request->account_type == 'other') {
            $tracsBalances = Transaction::where('others_id', $request->account_id)->latest()->first();
            $currentBalance = $tracsBalances->balance ?? 0;
            if ($request->transaction_type == 'pay') {
                $payBalance = $currentBalance - $request->amount;
                // dd($currentBalance - $request->amount);
                $transaction = Transaction::create([
                    'branch_id' =>Auth::user()->branch_id,
                    'date' => $request->date,
                    'payment_type' => $request->transaction_type,
                    'particulars' => 'OthersPayment',
                    'debit' => $request->amount,
                    'payment_method' => $request->payment_method,
                    'note' => $request->note,
                    'balance' => $payBalance,
                    'others_id' => $request->account_id,
                ]);
                $investor = Investor::findOrFail($request->account_id);
                $currentBalance = $investor->balance;
                $newBalance = $currentBalance  - $request->amount;
                $oldDebit = $investor->debit  + $request->amount;
                $investor->update([
                    'type' => $request->type,
                    'debit' =>  $oldDebit,
                    'balance' => $newBalance,
                ]);
                // account transaction
                $accountTransaction = new AccountTransaction;
                $accountTransaction->branch_id =  Auth::user()->branch_id;
                $accountTransaction->reference_id = $investor->id;
                $accountTransaction->purpose =  'OthersPayment';
                $accountTransaction->account_id =  $request->payment_method;
                $accountTransaction->debit = $request->amount;
                $oldBalance = AccountTransaction::where('account_id', $request->payment_method)->latest('created_at')->first();
                $accountTransaction->balance = $oldBalance->balance - $request->amount;
                $accountTransaction->created_at = Carbon::now();
                $accountTransaction->save();
            } else if ($request->transaction_type == 'receive') {
                $receiveBalance = $currentBalance + $request->amount;
                $transaction = Transaction::create([
                    'branch_id' =>Auth::user()->branch_id,
                    'date' => $request->date,
                    'payment_type' => $request->transaction_type,
                    'particulars' => 'OthersReceive',
                    'credit' => $request->amount,
                    'payment_method' => $request->payment_method,
                    'note' => $request->note,
                    'balance' => $receiveBalance,
                    'others_id' => $request->account_id,
                ]);
                $investor = Investor::findOrFail($request->account_id);
                $currentBalance = $investor->balance;
                $newBalance = $currentBalance  + $request->amount;
                $oldCredit = $investor->credit + $request->amount;
                $investor->update([
                    'type' => $request->type,
                    'credit' =>  $oldCredit,
                    'balance' => $newBalance,
                ]);

                // account Transaction
                $accountTransaction = new AccountTransaction;
                $accountTransaction->branch_id =  Auth::user()->branch_id;
                $accountTransaction->reference_id = $investor->id;
                $accountTransaction->purpose =  'OthersReceive';
                $accountTransaction->account_id =  $request->payment_method;
                $accountTransaction->credit = $request->amount;
                $oldBalance = AccountTransaction::where('account_id', $request->payment_method)->latest('created_at')->first();
                $accountTransaction->balance = $oldBalance->balance + $request->amount;
                $accountTransaction->created_at = Carbon::now();
                $accountTransaction->save();
            }

            // $tracsBalances->update(['balance' => $newBalance]);

            $notification = [
                'message' => 'Transaction Others Successfull',
                'alert-type' => 'info'
            ];
            return redirect()->back()->with($notification);
        }
    } //
    public function TransactionDelete($id)
    {
        Transaction::find($id)->delete();
        $notification = [
            'message' => 'Transaction Deleted Successfully',
            'alert-type' => 'info'
        ];
        return redirect()->back()->with($notification);
    } //
    public function TransactionFilterView(Request $request)
    {
        // $customerName="";
        // $suplyerName="";
        // if($request->filterCustomer == 'Select Customer'){
        //     $customerName = null;
        // }
        // if($request->filterSupplier == 'Select Supplier'){
        //     $suplyerName = null;
        // }
        $transaction = Transaction::when($request->filterCustomer != 'Select Customer', function ($query) use ($request) {
            return $query->where('customer_id', $request->filterCustomer);
        })
            ->when($request->filterSupplier != 'Select Supplier', function ($query) use ($request) {
                return $query->where('supplier_id', $request->filterSupplier);
            })
            ->when($request->startDate && $request->endDate, function ($query) use ($request) {
                return $query->whereBetween('date', [$request->startDate, $request->endDate]);
            })
            ->get();
        return view('pos.transaction.transaction-filter-rander-table', compact('transaction'))->render();
    }
    public function TransactionInvoiceReceipt($id)
    {
        $transaction = Transaction::findOrFail($id);
        return view('pos.transaction.invoice', compact('transaction'));
    }
    public function InvestmentStore(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'phone' => 'required',
        ]);

        if ($validator->passes()) {
            $investor = new Investor;
            $investor->branch_id =Auth::user()->branch_id;
            $investor->name = $request->name;
            $investor->phone = $request->phone;
            $investor->created_at = Carbon::now();
            $investor->save();
            return response()->json([
                'status' => 200,
                'message' => 'Successfully Save',
            ]);
        } else {
            return response()->json([
                'status' => '500',
                'error' => $validator->messages()
            ]);
        }
    }
    public function GetInvestor()
    {
        $data = Investor::latest()->get();
        return response()->json([
            'status' => 200,
            'message' => 'Successfully save',
            'allData' => $data
        ]);
    }
    public function InvestorInvoice($id)
    {
        $investors = Investor::findOrFail($id);
        return view('pos.investor.investor-invoice', compact('investors'));
    }
}
