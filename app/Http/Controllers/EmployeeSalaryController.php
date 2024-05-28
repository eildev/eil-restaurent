<?php

namespace App\Http\Controllers;
use App\Models\EmployeeSalary;
use App\Models\Employee;
use App\Models\Branch;
use Illuminate\Http\Request;
use Carbon\Carbon;

use function Laravel\Prompts\alert;

class EmployeeSalaryController extends Controller
{
public function EmployeeSalaryAdd(Request $request){
    // $employees = Employee::whereNotIn('id', function($query) {
    //     $query->select('employee_id')->from('employee_salaries')->whereYear('date', Carbon::now()->format('Y'))
    //     ->whereMonth('date', Carbon::now()->format('m'));;
    // })->get();
    $employees = Employee::latest()->get();
    $branch = Branch::latest()->get();
    return view('pos.employee_salary.add_employee_salary',compact('employees','branch'));
}//
public function EmployeeSalaryStore(Request $request){
        $requestMonth = Carbon::createFromFormat('Y-m-d', $request->date)->format('m');
        $requestYear = Carbon::createFromFormat('Y-m-d', $request->date)->format('Y');
        // Get the first and last day of the month
        $firstDayOfMonth = Carbon::create($requestYear, $requestMonth, 1)->startOfMonth();
        $lastDayOfMonth = Carbon::create($requestYear, $requestMonth, 1)->endOfMonth();
        $employeeSalary = EmployeeSalary::where('employee_id', $request->employee_id)
        ->where('branch_id', $request->branch_id)
        // ->where('date', $request->date)
        ->whereBetween('date', [$firstDayOfMonth, $lastDayOfMonth])
        ->first();
        // dd($employeeSalary->balance."Re".(float) $request->debit);
        $debit = (float) $request->debit;
        // dd($employeeSalary->balance);
        $now_balance=0;
        if ($employeeSalary) {
            $now_balance=(float) $employeeSalary->creadit  - $debit;
        } else {
            $now_balance=(float) $request->debit;
        }
    if (!empty($employeeSalary) && (float) $employeeSalary->balance < $debit) {
        $notification = [
            'error' =>'Salary for this employee and branch has already been inserted to to this month you can update your employee Salaries',
            'alert-type'=> 'error'
        ];
        return back()->with($notification);

    }
    if ($employeeSalary) {
        $notification = [
            'error' =>'Salary for this employee and branch has already been inserted to to this month you can update your employee Salaries',
            'alert-type'=> 'error'
        ];
        return back()->with($notification);

    }
     else {
        $employeeSalary = new EmployeeSalary;
        $employeeSalary->employee_id =  $request->employee_id;
        $employeeSalary->branch_id =  $request->branch_id;
        $requiestDebit=  $employeeSalary->debit =  $request->debit;
        $employeeSalary->date =  $request->date;
        $employee = Employee::findOrFail( $request->employee_id);
        $employeeSalary->creadit = $employee->salary;
        $employeeSalary->balance = $now_balance;
        $employeeSalary->note =  $request->note;
        $employeeSalary->save();
        $notification = array(
            'message' =>'Employee Salary Send Successfully',
            'alert-type'=> 'info'
        );
        return redirect()->route('employee.salary.view')->with($notification);
    }
}
//
public function EmployeeSalaryView(){
    $employeSalary = EmployeeSalary::all();
    return view('pos.employee_salary.view_employee_salary',compact('employeSalary'));
}//
public function EmployeeSalaryEdit($id){
    $employeeSalary = EmployeeSalary::findOrFail($id);
    $employees = Employee::latest()->get();
    $branch = Branch::latest()->get();
    return view('pos.employee_salary.edit_employee_salary',compact('employeeSalary','employees','branch'));
}//EmployeeSalaryEdit
public function EmployeeSalaryUpdate(Request $request,$id){
    // dd($request->all());
    $employeeSalary = EmployeeSalary::findOrFail($id);
    $requiestDebit = $employeeSalary->debit = $employeeSalary->debit + $request->debit;
    $employeeSalary->date =  $request->date;
    $employeeSalary->balance = $employeeSalary->creadit - $requiestDebit;
    $employeeSalary->note  = $request->note;
    $employeeSalary->update();
    $notification = array(
       'message' =>'Employee Salary Update Successfully',
        'alert-type'=> 'info'
    );
    return redirect()->route('employee.salary.view')->with($notification);

}//
public function EmployeeSalaryDelete($id){
    EmployeeSalary::findOrFail($id)->delete();
    $notification = array(
       'message' =>'Employee Salary Deleted Successfully',
        'alert-type'=> 'info'
    );
    return redirect()->route('employee.salary.view')->with($notification);
}

///////////////////////////Employee Salary Advanced //////////////////////////////

public function EmployeeSalaryAdvancedAdd(){
    $employees = Employee::latest()->get();
    $branch = Branch::latest()->get();
    return view('pos.employee_salary.advanced_employee_salary_add',compact('employees','branch'));
}//End

public function EmployeeSalaryAdvancedStore(Request $request){
    $requestMonth = Carbon::createFromFormat('Y-m-d', $request->date)->format('m');
    $requestYear = Carbon::createFromFormat('Y-m-d', $request->date)->format('Y');

    // Get the first and last day of the month
    $firstDayOfMonth = Carbon::create($requestYear, $requestMonth, 1)->startOfMonth();
    $lastDayOfMonth = Carbon::create($requestYear, $requestMonth, 1)->endOfMonth();
    $employeeSalary = EmployeeSalary::where('employee_id', $request->employee_id)
    ->where('branch_id', $request->branch_id)
    // ->where('date', $request->date)
    ->whereBetween('date', [$firstDayOfMonth, $lastDayOfMonth])
    ->first();
 if ($employeeSalary) {
    $notification = [
        'error' =>'Salary for this employee and branch has already been Advanced to this month you can update your Employee Salaries Payment',
        'alert-type'=> 'error'
    ];
    return redirect()->route('employee.salary.advanced.view')->with($notification);

 } else {
    $employeeSalary = new EmployeeSalary;
    $employeeSalary->employee_id =  $request->employee_id;
    $employeeSalary->branch_id =  $request->branch_id;
    $requiestDebit=  $employeeSalary->debit =  $request->debit;
    $employeeSalary->date =  $request->date;
    $employee = Employee::findOrFail( $request->employee_id);
    $employeeSalary->creadit = $employee->salary;
    $employeeSalary->balance = $employee->salary - $requiestDebit;
    $employeeSalary->note =  $request->note;
    $employeeSalary->save();
    $notification = array(
        'message' =>'Employee Salary Send Successfully',
         'alert-type'=> 'info'
     );
    return redirect()->route('employee.salary.advanced.view')->with($notification);
}
}
public function EmployeeSalaryAdvancedView(){
    $employeSalary = EmployeeSalary::where('debit', '>', 'creadit')->get();
    return view('pos.employee_salary.view_advanced_employee_salary',compact('employeSalary'));
}//
public function EmployeeSalaryAdvancedEdit($id){
    $employeeSalary = EmployeeSalary::findOrFail($id);
    $employees = Employee::latest()->get();
    $branch = Branch::latest()->get();
    return view('pos.employee_salary.edit_advanced_employee_salary',compact('employeeSalary','employees','branch'));
}
public function EmployeeSalaryAdvancedUpdate(Request $request,$id){
    // dd($request->all());
    $employeeSalary = EmployeeSalary::findOrFail($id);
    $requiestDebit = $employeeSalary->debit = $employeeSalary->debit + $request->debit;
    $employeeSalary->date =  $request->date;
    $employeeSalary->balance = $employeeSalary->creadit - $requiestDebit;
    $employeeSalary->note  = $request->note;
    $employeeSalary->update();
    $notification = array(
       'message' =>'Employee Salary Advanced Update Successfully',
        'alert-type'=> 'info'
    );
    return redirect()->route('employee.salary.advanced.view')->with($notification);

}//
public function EmployeeSalaryAdvancedDelete($id){
    EmployeeSalary::findOrFail($id)->delete();
    $notification = array(
       'message' =>'Employee Advanced Salary Deleted Successfully',
        'alert-type'=> 'info'
    );
    return redirect()->route('employee.salary.advanced.view')->with($notification);
}
//Dependancy
    public function BranchAjax($branch_id){
        $branch =Employee::where('branch_id',$branch_id)->get();
          return  json_encode($branch);
    }//
    public function getEmployeeInfo(Request $request,$employee_id){
        $requestMonth = Carbon::createFromFormat('Y-m-d', $request->date)->format('m');
        $requestYear = Carbon::createFromFormat('Y-m-d', $request->date)->format('Y');
        // Get the first and last day of the month
        $firstDayOfMonth = Carbon::create($requestYear, $requestMonth, 1)->startOfMonth();
        $lastDayOfMonth = Carbon::create($requestYear, $requestMonth, 1)->endOfMonth();
        $employee = EmployeeSalary::where('employee_id',$employee_id)
        ->whereBetween('date', [$firstDayOfMonth, $lastDayOfMonth])
        ->latest()->first();
        return response()->json([
            'data' => $employee
        ]);

    }
}
