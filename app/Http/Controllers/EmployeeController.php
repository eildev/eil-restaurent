<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

use App\Repositories\RepositoryInterfaces\EmployeeInterface;

class EmployeeController extends Controller
{

    private $employee_repo;
    public function __construct(EmployeeInterface $employee_interface){
        $this->employee_repo = $employee_interface;
    }

    public function EmployeeView(){
        $employees = $this->employee_repo->ViewAllEmployee();
        return view('pos.employee.view_employee',compact('employees'));
    }//
    public function EmployeeAdd(){
        return view('pos.employee.add_employee');
    }//
    public function EmployeeStore(Request $request){

        if ($request->image) {
            $employee = new Employee();
            $imageName = rand() . '.' . $request->image->extension();
            $request->image->move(public_path('uploads/employee'), $imageName);
            $employee->pic = $imageName;
            }
            $employee = new Employee();
            $employee->branch_id = Auth::user()->branch_id;
            $employee->full_name = $request->full_name;
            $employee->email = $request->email;
            $employee->phone = $request->phone;
            $employee->address = $request->address;
            $employee->salary = $request->salary;
            $employee->nid = $request->nid;
            $employee->designation = $request->designation;
            $employee->status = 0;
            // $employee->pic = $imageName;
            $employee->created_at = Carbon::now();
            $employee->save();
            $notification = array(
                'message' =>'Employee Added Successfully',
                'alert-type'=> 'info'
             );
             return redirect()->route('employee.view')->with($notification);
    }//
    public function EmployeeEdit($id){
        $employees =  $this->employee_repo->EditEmployee($id);
        return view('pos.employee.edit_employee',compact('employees'));
    }//
    public function EmployeeUpdate(Request $request){
        $validated = $request->validate([
            'phone' => 'required|max:15',
        ]);
        if ($request->image) {
            $employee = new Employee();
            $imageName = rand() . '.' . $request->image->extension();
            $request->image->move(public_path('uploads/employee'), $imageName);
            $employee->branch_id = Auth::user()->branch_id;
            $employee->full_name = $request->full_name;
            $employee->email = $request->email;
            $employee->phone = $request->phone;
            $employee->address = $request->address;
            $employee->salary = $request->salary;
            $employee->nid = $request->nid;
            $employee->designation = $request->designation;
            $employee->status = 0;
            $employee->pic = $imageName;
            $employee->save();
            }else{
                $employee = new Employee();
                $employee->branch_id = Auth::user()->branch_id;
                $employee->full_name = $request->full_name;
                $employee->email = $request->email;
                $employee->phone = $request->phone;
                $employee->address = $request->address;
                $employee->salary = $request->salary;
                $employee->nid = $request->nid;
                $employee->designation = $request->designation;
                $employee->status = 0;
                $employee->updated_at = Carbon::now();
                $employee->update();
            }
            $notification = array(
                'message' =>'Employee Updated Successfully',
                'alert-type'=> 'info'
             );
             return redirect()->route('employee.view')->with($notification);
    }//
    public function EmployeeDelete($id){
        $employee = Employee::findOrFail($id);
        $path = public_path('uploads/employee/'.$employee->image);
    if(file_exists($path)){
        @unlink($path);
    }
        $employee->delete();
        $notification = array(
            'message' =>'Employee Deleted Successfully',
            'alert-type'=> 'info'
         );
         return redirect()->route('employee.view')->with($notification);
    }
}
