<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Expense;
use App\Models\ExpenseCategory;
use App\Models\Bank;
use Validator;
use Illuminate\Support\Facades\Auth;

class ExpenseController extends Controller
{
    public function ExpenseCategoryStore(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
        ],[
            'name' => 'required Expense Category Name'
        ]);
        $expenseCategory = new ExpenseCategory;
        if ($validator->passes()) {
            $expenseCategory->name =  $request->name;
            $expenseCategory->save();
            return response()->json([
                'status' => 200,
                'message' => "Expense Category Added Successfully"
            ]);
        }
    } //End Method
    public function ExpenseAdd()
    {
        $bank = Bank::latest()->get();
        $expenseCategory = ExpenseCategory::latest()->get();
        return view('pos.expense.add_expanse', compact('expenseCategory', 'bank'));
    } //
    public function ExpenseStore(Request $request)
    {
        $request->validate([
            'purpose' => 'required',
            'amount' => 'required',
            'spender' => 'required',
            'expense_category_id' => 'required',
            'expense_date' => 'required',
        ]);
        $expense = new Expense;
        $expense->branch_id =  Auth::user()->branch_id;
        $expense->expense_date =  $request->expense_date;
        $expense->expense_category_id =  $request->expense_category_id;
        $expense->amount =  $request->amount;
        $expense->purpose =  $request->purpose;
        $expense->spender =  $request->spender;
        $expense->bank_account_id =  $request->bank_account_id;
        $expense->note =  $request->note;
        if ($request->image) {
            $imageName = rand() . '.' . $request->image->extension();
            $request->image->move(public_path('uploads/expense/'), $imageName);
            $expense->image = $imageName;
        }
        $expense->save();
        $notification = [
            'message' => 'Expense Added Successfully',
            'alert-type' => 'info'
        ];
        return redirect()->route('expense.view')->with($notification);
    } //

    public function ExpenseView()
    {
        $expenseCat = ExpenseCategory::latest()->get();
        $bank = Bank::latest()->get();
        $expenseCategory = ExpenseCategory::latest()->get();
        // $expenseCategory  = ExpenseCategory::latest()->get();
        $expense = Expense::latest()->get();
        return view('pos.expense.view_expense', compact('expense', 'expenseCat','bank','expenseCategory'));
    } //

    public function ExpenseEdit($id)
    {
        $expense = Expense::findOrFail($id);
        $bank = Bank::latest()->get();
        $expenseCategory = ExpenseCategory::latest()->get();
        return view('pos.expense.edit_expense', compact('expense', 'expenseCategory', 'bank'));
    } //
    public function ExpenseUpdate(Request $request, $id)
    {
        $expense = Expense::findOrFail($id);
        $expense->branch_id =  Auth::user()->branch_id;
        $expense->expense_date =  $request->expense_date;
        $expense->expense_category_id =  $request->expense_category_id;
        $expense->amount =  $request->amount;
        $expense->purpose =  $request->purpose;
        $expense->spender =  $request->spender;
        $expense->bank_account_id =  $request->bank_account_id;
        $expense->note =  $request->note;
        if ($request->image) {
            $imageName = rand() . '.' . $request->image->extension();
            $request->image->move(public_path('uploads/expense/'), $imageName);
            $expense->image = $imageName;
        }
        $expense->save();
        $notification = [
            'message' => 'Expense Updated Successfully',
            'alert-type' => 'info'
        ];
        return redirect()->route('expense.view')->with($notification);
    } //
    public function ExpenseDelete($id)
    {

        $expense = Expense::findOrFail($id);
        if ($expense->image) {
            $previousImagePath = public_path('uploads/expense/') . $expense->image;
            if (file_exists($previousImagePath)) {
                unlink($previousImagePath);
            }
        }
        $expense->delete();
        $notification = [
            'message' => 'Expense Deleted Successfully',
            'alert-type' => 'info'
        ];
        return redirect()->route('expense.view')->with($notification);
    } //
    public function ExpenseCategoryDelete($id)
    {
        $expenseCategory = ExpenseCategory::findOrFail($id);
        $expenseCategory->delete();
        $notification = [
            'message' => 'Expense Category Deleted Successfully',
            'alert-type' => 'info'
        ];
        return redirect()->route('expense.view')->with($notification);
    } //
    public function ExpenseCategoryEdit($id)
    {
        $category = ExpenseCategory::findOrFail($id);
        if ($category) {
            return response()->json([
                'status' => 200,
                'category' => $category
            ]);
        } else {
            return response()->json([
                'status' => 500,
                'message' => "Data Not Found"
            ]);
        }
    } //
    public function ExpenseCategoryUpdate(Request $request, $id)
    {

        $category = ExpenseCategory::findOrFail($id)->update([
            'name' => $request->name
        ]);
        // dd($category);
        // Return success response
        return response()->json([
            'status' => 200,
            'message' => 'Expense Category updated successfully',
        ]);
    }//
    ///Expense Filter view //
    public function ExpenseFilterView(Request $request){
        $expenseCat = ExpenseCategory::latest()->get();
        // $expenseCategory  = ExpenseCategory::latest()->get();
        $expense =  Expense::when($request->startDate && $request->endDate, function ($query) use ($request) {
            return $query->whereBetween('expense_date', [$request->startDate, $request->endDate]);
        })->get();

        return view('pos.expense.expense-filter-rander-table', compact('expense', 'expenseCat'))->render();
    }
}
