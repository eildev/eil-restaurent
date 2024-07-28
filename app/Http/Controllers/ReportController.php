<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\EmployeeSalary;
use App\Models\Expense;
use App\Models\Product;
use App\Models\Supplier;
use App\Models\Transaction;
use App\Models\Purchase;
use App\Models\PurchaseItem;
use App\Models\Sale;
use App\Models\SaleItem;
use App\Models\Employee;
use App\Models\SubCategory;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Sms;
use App\Models\Damage;
use Illuminate\Http\Request;
use App\Models\AccountTransaction;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{
    // today report function
    public function todayReport()
    {

        $todayDate = now()->toDateString();

        //Today Invoice
        $saleItemsForDate = SaleItem::whereDate('created_at', $todayDate);
        $todaySaleItemsToday = $saleItemsForDate->sum('qty');
        $totalInvoiceToday = Sale::whereDate('sale_date', $todayDate)->count();
        $totalSales = Sale::whereDate('sale_date', $todayDate)->get();
        $todayTotalSaleAmount = Sale::whereDate('sale_date', $todayDate)->sum('receivable');
        $todayTotalSaleQty = Sale::whereDate('sale_date', $todayDate)->sum('quantity');
        $todayTotalSaleDue = Sale::whereDate('sale_date', $todayDate)->sum('due');

        //Today Purchase
        $todayPurchaseItems = PurchaseItem::whereDate('created_at', $todayDate);
        $purchases = Purchase::whereDate('created_at', $todayDate)->get();
        $todayPurchaseItemsToday = $todayPurchaseItems->sum('quantity');
        $todayPurchaseToday = Purchase::whereDate('purchse_date', $todayDate)->get();
        // dd($todayPurchaseToday);
        $today_grand_total = $todayPurchaseToday->sum('grand_total');
        $todayTotalPurchaseAmount = Purchase::whereDate('purchse_date', $todayDate)->sum('grand_total');
        $todayTotalPurchaseQty = Purchase::whereDate('purchse_date', $todayDate)->sum('total_quantity');
        $todayTotalPurchaseDue = Purchase::whereDate('purchse_date', $todayDate)->sum('due');

        //Today invoice product
        $todayInvoiceProductItems = Sale::whereDate('sale_date', $todayDate);
        $todayInvoiceProductTotal = $todayInvoiceProductItems->sum('quantity');
        $todayInvoiceProductAmount = $todayInvoiceProductItems->sum('final_receivable');
        //today invoice amount
        $totalInvoiceTodaySum = Sale::whereDate('sale_date', $todayDate);
        $todayInvoiceAmount = $totalInvoiceTodaySum->sum('receivable');
        $todayProfit = $totalInvoiceTodaySum->sum('profit');
        //today expenses
        $todayExpenseDate = Expense::whereDate('expense_date', $todayDate);
        $todayExpenseAmount = $todayExpenseDate->sum('amount');
        //Today Customer
        $todayCustomer = Customer::whereDate('created_at', $todayDate);
        //Sale Profit
        $saleProfitAmount = $totalInvoiceTodaySum->sum('profit');

        $expense = Expense::whereDate('expense_date', $todayDate)->get();
        $expenseAmount = $expense->sum('amount');
        $salary = EmployeeSalary::whereDate('date', $todayDate)->get();
        $totalSalary = $salary->sum('debit');
        $totalSalaryDue = $salary->sum('balance');
        return view('pos.report.today.today', compact('todayInvoiceAmount', 'totalSales', 'today_grand_total', 'todayExpenseAmount', 'totalSalary', 'expense', 'todayTotalSaleAmount', 'todayTotalSaleDue', 'todayTotalSaleQty', 'purchases', 'todayTotalPurchaseDue', 'todayTotalPurchaseQty', 'todayTotalPurchaseAmount', 'salary'));
    }
    // summary report function
    public function summaryReport()
    {
        $products = Product::where('branch_id', Auth::user()->branch_id)
            ->orderBy('total_sold', 'desc')
            ->take(20)
            ->get();
        $expense =  Expense::all();
        $supplier = Transaction::whereNotNull('supplier_id')->get();
        $customer = Transaction::whereNotNull('customer_id')->get();
        $sale = Sale::where('branch_id', Auth::user()->branch_id)->get();
        $saleAmount = $sale->sum('receivable');
        $purchase = Purchase::where('branch_id', Auth::user()->branch_id)->get();
        $purchaseAmount = $purchase->sum('grand_total');
        $expense = Expense::where('branch_id', Auth::user()->branch_id)->get();
        $expenseAmount = $expense->sum('amount');
        $sellProfit = $sale->sum('profit');
        $salary = EmployeeSalary::where('branch_id', Auth::user()->branch_id)->get();
        $totalSalary = $salary->sum('debit');
        return view('pos.report.summary.summary', compact('saleAmount', 'purchaseAmount', 'expenseAmount', 'sellProfit', 'totalSalary', 'products', 'expense', 'supplier', 'customer'));
    }
    // customer due report function//
    public function customerDue()
    {
        if(Auth::user()->id == 1){
            $customer = Customer::where('wallet_balance', '>', 0)
            ->get();
        }else{
            $customer = Customer::where('branch_id', Auth::user()->branch_id)
            ->where('wallet_balance', '>', 0)
            ->get();
        }
        return view('pos.report.customer.customer_due', compact('customer'));
    }
    function damageReportPrint(Request $request)
    {
        // dd($request->all());
        $damageItem = Damage::when($request->startdatepurches && $request->enddatepurches, function ($query) use ($request) {
            return $query->whereBetween('date', [$request->startdatepurches, $request->enddatepurches]);
        })
            ->when($request->filterProduct, function ($query) use ($request) {
                return $query->where('product_id', $request->filterProduct);
            })
            ->when($request->branchId, function ($query) use ($request) {
                return $query->where('branch_id', $request->branchId);
            })
            ->get();

        if ($damageItem->isEmpty()) {
            $damageItem = Damage::all();
        }

        return view('pos.report.damages.print', compact('damageItem'));
    }
    // customer due filter function
    public function customerDueFilter(Request $request)
    {
        if(Auth::user()->id == 1){
            $customer = Customer::where('id', $request->customerId)->get();
        }else{
            $customer = Customer::where('branch_id', Auth::user()->branch_id)->where('id', $request->customerId)->get();
        }

        return view("pos.report.customer.table", compact('customer'))->render();
    }
    // supplier due report function
    public function supplierDueReport()
    {
        if(Auth::user()->id == 1){
            $customer = Supplier::where('wallet_balance', '>', 0)
            ->get();
        }else{
            $customer = Supplier::where('branch_id', Auth::user()->branch_id)
            ->where('wallet_balance', '>', 0)
            ->get();
        }
        return view('pos.report.supplier.supplier_due', compact('customer'));
    }
    // supplier due filter function
    public function supplierDueFilter(Request $request)
    {
        if(Auth::user()->id == 1){
        $customer = Supplier::where('id', $request->customerId)->get();
        }else{
            $customer = Supplier::where('branch_id', Auth::user()->branch_id)
            ->where('id', $request->customerId)->get();
        }
        return view("pos.report.customer.table", compact('customer'))->render();
    }
    // low stock report function
    public function lowStockReport()
    {
        if(Auth::user()->id == 1){
            $products = Product::where('stock', '<=', 10)
            ->get();
        }else{
            $products = Product::where('branch_id', Auth::user()->branch_id)
            ->where('stock', '<=', 10)
            ->get();
        }
        // dd($products);
        return view('pos.report.products.low_stock', compact('products'));
    }
    // Top Products  function
    public function topProducts()
    {
       if(Auth::user()->id == 1){
        $products = Product::orderBy('total_sold', 'desc')
        ->take(20)
        ->get();
       }else{
        $products = Product::where('branch_id', Auth::user()->branch_id)
        ->orderBy('total_sold', 'desc')
        ->take(20)
        ->get();
       }
        // dd($products);
        return view('pos.report.products.top_products', compact('products'));
    }


    // purchase Report function
    public function purchaseReport()
    {
        if(Auth::user()->id == 1){
            $purchaseItem = PurchaseItem::all();
        }else{
            $purchaseItem = PurchaseItem::whereHas('purchas', function ($query) {
                $query->where('branch_id', Auth::user()->branch_id);
            })->get();
        }

        return view('pos.report.purchase.purchase', compact('purchaseItem'));
    }

    public function PurchaseProductFilter(Request $request)
    {
            $purchaseItem = PurchaseItem::when($request->filterProduct, function ($query) use ($request) {
                return $query->where('product_id', $request->filterProduct);
            })

            ->when($request->startDatePurches && $request->endDatePurches, function ($query) use ($request) {
                return $query->whereHas('purchas', function ($query) use ($request) {
                    $query->whereBetween('purchse_date', [$request->startDatePurches, $request->endDatePurches]);
                });
            })
            ->get();

        return view('pos.report.purchase.purchase-filter-table', compact('purchaseItem'))->render();
    } //
    public function PurchaseDetailsInvoice($id)
    {
        $purchase = Purchase::findOrFail($id);
        return view('pos.report.purchase.purchase_invoice', compact('purchase'));
        return view('pos.report.purchase.purchase');
    }
    // public function purchaseReport()
    // {
    //     return view('pos.report.purchase.purchase');
    // }



    //damage reports starting

    public function damageReport()
    {

        if(Auth::user()->id == 1){
            $damageItem = Damage::all();
            }else{
            $damageItem = Damage::where('branch_id', Auth::user()->branch_id)->get();
            }
        // @dd($damageItem);
        return view('pos.report.damages.damage', compact('damageItem'));
    }
    public function DamageProductFilter(Request $request)
    {
        // dd($request);
        $damageItem = Damage::when($request->startDatePurches && $request->endDatePurches, function ($query) use ($request) {
            return $query->whereBetween('date', [$request->startDatePurches, $request->endDatePurches]);
        })
            ->when($request->filterProduct != "Select Product", function ($query) use ($request) {
                return $query->where('product_id', $request->filterProduct);
            })
            ->when($request->branchId != "Select Branch", function ($query) use ($request) {
                return $query->where('branch_id', $request->branchId);
            })
            ->get();
        return view('pos.report.damages.damage-filter-table', compact('damageItem'))->render();
    } //

    //damage reports endpoint
    // customer Ledger report function
    public function customerLedger()
    {
        return view('pos.report.customer.customer_ledger');
    }
    // customer Ledger Filter function
    public function customerLedgerFilter(Request $request)
    {
        $transactionQuery = Transaction::query();
        // Filter by supplier_id if provided
        if ($request->customerId != "Select Customer") {
            $transactionQuery->where('customer_id', $request->customerId);
        }
        // Filter by date range if both start_date and end_date are provided
        if ($request->startDate && $request->endDate) {
            $transactionQuery->whereBetween('date', [$request->startDate, $request->endDate]);
        }
        $transactions = $transactionQuery->get();
        $customer = Customer::findOrFail($request->customerId);
        return response()->json([
            'status' => 200,
            'transactions' => $transactions,
            'customer' => $customer,
        ]);

    }
    // supplier Ledger report function
    public function supplierLedger()
    {
        return view('pos.report.supplier.supplier_ledger');
    }
    // supplier Ledger Filter function
    public function supplierLedgerFilter(Request $request)
    {
        $transactionQuery = Transaction::query();
        // Filter by supplier_id if provided
        if ($request->supplierId != "Select Supplier") {
            $transactionQuery->where('supplier_id', $request->supplierId);
        }
        // Filter by date range if both start_date and end_date are provided
        if ($request->startDate && $request->endDate) {
            $transactionQuery->whereBetween('date', [$request->startDate, $request->endDate]);
        }
        $transactions = $transactionQuery->get();
        $supplier = Supplier::findOrFail($request->supplierId);
        return response()->json([
            'status' => 200,
            'transactions' => $transactions,
            'supplier' => $supplier,
        ]);

        // return view("pos.report.supplier.show_ledger", compact('supplier', 'transactions'))->render();
    }
    // bank Report function
    public function bankReport()
    {
        return view('pos.report.bank.bank');
    }
    //stock Report function
    public function stockReport()
    {
        if(Auth::user()->id == 1){
            $products = Product::all();
        }else{
            $products = Product::where('branch_id', Auth::user()->branch_id)->get();
        }

        return view('pos.report.products.stock', compact('products'));
    } //

    ////////////////Account Transaction Method  //////////////
    public function AccountTransactionView()
    {
        if(Auth::user()->id == 1){
            $accountTransaction = AccountTransaction::latest()->get();
        }else{
            $accountTransaction = AccountTransaction::where('branch_id', Auth::user()->branch_id)->get();
        }

        return view('pos.report.account_transaction.account_transaction_ledger', compact('accountTransaction'));
    }

    public function AccountTransactionFilter(Request $request)
    {
        // dd($request->all());
        $accountTransaction = AccountTransaction::when($request->accountId, function ($query) use ($request) {
            return $query->where('account_id', $request->accountId);
        })
            ->when($request->startDate && $request->endDate, function ($query) use ($request) {
                return $query->whereBetween('created_at', [$request->startDate, $request->endDate]);
            })
            ->get();
        return view('pos.report.account_transaction.account_transaction_table', compact('accountTransaction'))->render();
    }
    //////////////////Rexpense Report MEthod //////////////
    public function ExpenseReport()
    {
        if(Auth::user()->id == 1){
            $expense = Expense::latest()->get();
            }else{
                $expense = Expense::where('branch_id', Auth::user()->branch_id)->get();
            }

        return view('pos.report.expense.expense', compact('expense'));
    } //
    public function ExpenseReportFilter(Request $request)
    {
        //dd($request->all());
        $expense = Expense::when($request->startDate && $request->endDate, function ($query) use ($request) {
            return $query->whereBetween('expense_date', [$request->startDate, $request->endDate]);
        })->get();
        return view('pos.report.expense.expense-table', compact('expense'))->render();
    }
    //////////////////Employee Salary Report MEthod //////////////
    public function EmployeeSalaryReport()
    {
        if(Auth::user()->id == 1){
        $employeeSalary = EmployeeSalary::all();
        }else{
        $employeeSalary = EmployeeSalary::where('branch_id', Auth::user()->branch_id)->get();
        }
        return view('pos.report.employee_salary.employee_salary', compact('employeeSalary'));
    } //
    public function EmployeeSalaryReportFilter(Request $request)
    {
        $employeeSalary = EmployeeSalary::where('branch_id', Auth::user()->branch_id)
        ->when($request->salaryId, function ($query) use ($request) {
            return $query->where('employee_id', $request->salaryId);
        })
            ->when($request->startDate && $request->endDate, function ($query) use ($request) {
                return $query->whereBetween('date', [$request->startDate, $request->endDate]);
            })
            ->get();
        return view('pos.report.employee_salary.employee_salary-table', compact('employeeSalary'))->render();
    }
    ////////Product Info Report /////
    public function ProductInfoReport()
    {
        if(Auth::user()->id == 1){
            $productInfo = Product::all();
        }else{
            $productInfo = Product::where('branch_id', Auth::user()->branch_id)->latest()->get();
        }

        return view('pos.report.products.product_info_report', compact('productInfo'));
    } //
    public function ProductInfoFilter(Request $request)
    {
        // dd($request->filterBrand);
        $branchId = Auth::user()->branch_id;
        $productInfo = Product::where('branch_id', $branchId)
          ->when($request->filterStartPrice, function ($query) use ($request) {
            return $query->where('price', '<=', (float) $request->filterStartPrice);
        })
            ->when($request->filterBrand != "Select Brand", function ($query) use ($request) {
                return $query->where('brand_id', $request->filterBrand);
            })
            ->when($request->FilterCat != "Select Category", function ($query) use ($request) {
                return $query->where('category_id', $request->FilterCat);
            })
            ->when($request->filterSubcat != "Select Sub Category", function ($query) use ($request) {
                return $query->where('subcategory_id', $request->filterSubcat);
            })
            ->get();
        return view('pos.report.products.product-info-filter-rander-table', compact('productInfo'))->render();
    }
    ///SMS Report Method
    public function SmsView()
    {
        $smsAll = Sms::all();
        return view('pos.report.sms.sms_report', compact('smsAll'));
    } //
    public function SmsReportFilter(Request $request)
    {
        $smsAll = Sms::when($request->customerId != "Select Customer", function ($query) use ($request) {
            return $query->where('customer_id', $request->customerId);
        })
            ->when($request->startDate && $request->endDate, function ($query) use ($request) {
                return $query->whereBetween('created_at', [$request->startDate, $request->endDate]);
            })
            ->get();
        return view('pos.report.sms.sms-filter-table', compact('smsAll'))->render();
    }

    public function monthlyReport()
    {
        $monthlyReports = [];

        for ($i = 0; $i < 12; $i++) {
            // Calculate the start and end dates for the month
            $startOfMonth = now()->subMonths($i)->startOfMonth()->toDateString();
            $endOfMonth = now()->subMonths($i)->endOfMonth()->toDateString();

            // Calculate the totals for the month
            $totalPurchaseCost = Purchase::whereBetween('purchse_date', [$startOfMonth, $endOfMonth])
                ->sum('grand_total');
            $totalSale = Sale::whereBetween('sale_date', [$startOfMonth, $endOfMonth])
                ->sum('receivable');
            $totalProfit = Sale::whereBetween('sale_date', [$startOfMonth, $endOfMonth])
                ->sum('profit');
            $totalExpense = Expense::whereBetween('expense_date', [$startOfMonth, $endOfMonth])
                ->sum('amount');
            $totalSalary = EmployeeSalary::whereBetween('date', [$startOfMonth, $endOfMonth])
                ->sum('debit');
            $finalProfit = $totalProfit - ($totalExpense + $totalSalary);
            $monthName = now()->subMonths($i)->format('F Y');

            // Store the report data in the array
            $monthlyReports[now()->subMonths($i)->format('Y-m')] = [
                'month' => $monthName,
                'totalPurchaseCost' => $totalPurchaseCost,
                'totalSale' => $totalSale,
                'totalProfit' => $totalProfit,
                'totalExpense' => $totalExpense,
                'totalSalary' => $totalSalary,
                'finalProfit' => $finalProfit
            ];
        }

        // Pass the monthly reports array to the view
        return view('pos.report.monthly.monthly', compact('monthlyReports'));
    }
}
