<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use App\Models\User;
use Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SupplierController extends Controller
{
    public function index()
    {
        return view('pos.supplier.supplier');
    }
    public function store(Request $request)
    {
        // dd($request->all());
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:250',
            'phone' => 'required|max:100',
        ]);


        if ($validator->passes()) {
            $supplier = new Supplier;
            $supplier->name =  $request->name;
            $supplier->branch_id =  Auth::user()->branch_id;
            $supplier->email = $request->email;
            $supplier->phone = $request->phone;
            $supplier->address = $request->address;
            $supplier->opening_receivable = $request->opening_receivable;
            $supplier->opening_payable = $request->opening_payable;
            $supplier->save();
            return response()->json([
                'status' => 200,
                'message' => 'Supplier Save Successfully',
            ]);
        } else {
            return response()->json([
                'status' => '500',
                'error' => $validator->messages()
            ]);
        }
    }
    public function view()
    {
        $suppliers = Supplier::get();
        return response()->json([
            "status" => 200,
            "data" => $suppliers
        ]);
    }
    public function edit($id)
    {
        $supplier = Supplier::findOrFail($id);
        if ($supplier) {
            return response()->json([
                'status' => 200,
                'supplier' => $supplier
            ]);
        } else {
            return response()->json([
                'status' => 500,
                'message' => "Data Not Found"
            ]);
        }
    }
    public function update(Request $request, $id)
    {
        // dd($request->all());
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:250',
            'phone' => 'required|max:100',
        ]);
        if ($validator->passes()) {
            $supplier = Supplier::findOrFail($id);
            $supplier->name =  $request->name;
            $supplier->branch_id =  Auth::user()->branch_id;
            $supplier->email = $request->email;
            $supplier->phone = $request->phone;
            $supplier->address = $request->address;
            $supplier->opening_receivable = $request->opening_receivable;
            $supplier->opening_payable = $request->opening_payable;
            $supplier->save();
            return response()->json([
                'status' => 200,
                'message' => 'Supplier Update Successfully',
            ]);
        } else {
            return response()->json([
                'status' => '500',
                'error' => $validator->messages()
            ]);
        }
    }
    public function destroy($id)
    {
        $supplier = Supplier::findOrFail($id);
        $supplier->delete();
        return response()->json([
            'status' => 200,
            'message' => 'Supplier Deleted Successfully',
        ]);
    }
}