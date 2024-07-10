<?php

namespace App\Http\Controllers;

use App\Models\Bank;
use App\Repositories\RepositoryInterfaces\BankInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BankController extends Controller
{
    private $bankrepo;
    public function __construct(BankInterface $bankInterface)
    {
        $this->bankrepo = $bankInterface;
    }
    public function index()
    {

        return view('pos.bank.bank');
    }
    public function store(Request $request)
    {
        // dd($request->all());
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:99',
            'branch_name' => 'required|max:149',
            'phone_number' => 'required|max:19',
            'account' => 'required',
            'opening_balance' => 'required',
        ]);

        if ($validator->passes()) {
            $bank = new Bank;
            $bank->name =  $request->name;
            $bank->branch_name = $request->branch_name;
            $bank->manager_name = $request->manager_name;
            $bank->phone_number = $request->phone_number;
            $bank->account = $request->account;
            $bank->email = $request->email;
            $bank->opening_balance = $request->opening_balance;
            $bank->save();
            return response()->json([
                'status' => 200,
                'message' => 'Bank Save Successfully',
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
        // $banks = Bank::get();
        $banks = $this->bankrepo->getAllBank();
        return response()->json([
            "status" => 200,
            "data" => $banks
        ]);
    }
    public function edit($id)
    {
        $bank = $this->bankrepo->editBank($id);
        if ($bank) {
            return response()->json([
                'status' => 200,
                'bank' => $bank
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
            'name' => 'required|max:99',
            'branch_name' => 'required|max:149',
            'phone_number' => 'required|max:19',
            'account' => 'required',
            'opening_balance' => 'required',
        ]);
        if ($validator->passes()) {
            $bank = Bank::findOrFail($id);
            $bank->name =  $request->name;
            $bank->branch_name = $request->branch_name;
            $bank->manager_name = $request->manager_name;
            $bank->phone_number = $request->phone_number;
            $bank->account = $request->account;
            $bank->email = $request->email;
            $bank->opening_balance = $request->opening_balance;
            $bank->save();
            return response()->json([
                'status' => 200,
                'message' => 'Bank Update Successfully',
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
        $bank = Bank::findOrFail($id);
        $bank->delete();
        return response()->json([
            'status' => 200,
            'message' => 'Bank Deleted Successfully',
        ]);
    }
}
