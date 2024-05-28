<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\Branch;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Repositories\RepositoryInterfaces\CustomerInterfaces;
class CustomerController extends Controller
{

    private $customer_repo;
    public function __construct(CustomerInterfaces $customer_interface){
        $this->customer_repo = $customer_interface;
    }
    public function AddCustomer(){
        return view('pos.customer.add_customer');
    }//End Method
    public function CustomerStore(Request $request){
        $customer = new Customer;
        $customer->branch_id = Auth::user()->branch_id;
        $customer->name = $request->name;
        $customer->phone = $request->phone;
        $customer->email = $request->email;
        $customer->address = $request->address;
        // $customer->opening_receivable = $request->opening_receivable ?? 0;
        // $customer->opening_payable = $request->opening_payable ?? 0;
        $customer->wallet_balance = $request->wallet_balance ?? 0;
        // $customer->total_receivable = $request->total_receivable ?? 0;
        // $customer->total_payable = $request->total_payable ?? 0;
        $customer->created_at = Carbon::now();
        $customer->save();
        $notification = array(
           'message' =>'Customer Created Successfully',
            'alert-type'=> 'info'
        );
        return redirect()->route('customer.view')->with($notification);
        // return redirect()->route('pos.customer.view')->with($notification);
    }//End Method
    public function CustomerView(){
        $customers = $this->customer_repo->ViewAllCustomer();
        return view('pos.customer.view_customer',compact('customers'));
    }//
    public function CustomerEdit($id){
        $customer = $this->customer_repo->EditCustomer($id);
        return view('pos.customer.edit_customer',compact('customer'));
    }//
    public function CustomerUpdate(Request $request,$id){
        $customer = Customer::find($id);
        $customer->branch_id = Auth::user()->branch_id;
        $customer->name = $request->name;
        $customer->phone = $request->phone;
        $customer->email = $request->email;
        $customer->address = $request->address;
        // $customer->opening_receivable = $request->opening_receivable ?? 0;
        // $customer->opening_payable = $request->opening_payable ?? 0;
        $customer->wallet_balance = $request->wallet_balance ?? 0;
        // $customer->total_receivable = $request->total_receivable ?? 0;
        // $customer->total_payable = $request->total_payable ?? 0;
        $customer->updated_at = Carbon::now();
        $customer->save();
        $notification = array(
           'message' =>'Customer Updated Successfully',
            'alert-type'=> 'info'
        );
        return redirect()->route('customer.view')->with($notification);

    }//End Method
    public function CustomerDelete($id){
         Customer::findOrFail($id)->delete();
         $notification = array(
            'message' =>'Customer Deleted Successfully',
             'alert-type'=> 'info'
         );
         return redirect()->back()->with($notification);
    }
}
