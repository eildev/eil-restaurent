<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ItemCategory;
use Validator;
class MakeItemsController extends Controller
{
    public function index(){
        return view('pos.make-item.make-items');
    }
    public function MakeItemCategory(Request $request){
        $validator = Validator::make($request->all(), [
            'category_name' => 'required|string|max:255|unique:item_categories,category_name', // Adjust table name if necessary
        ]);

        // Check if validation fails
        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'error' => $validator->errors()
            ]);
        }

        $category = new ItemCategory();
        $category->category_name = $request->category_name;
        $category->save();
        return response()->json([
            'status' => 200,
            'message' => 'Category added successfully!',
            'data' => [
                'id' => $category->id,
                'category_name' => $category->category_name
            ]
        ]);

    }
}
