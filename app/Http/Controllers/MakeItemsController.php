<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ItemCategory;
use App\Models\MakeItem;
use App\Models\MaterialList;
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
    //Store Data
    public function MakeItemStore(Request $request){
        $validatedData = $request->validate([
            'make_category_id' => 'required|exists:item_categories,id',
            'item_name' => 'required|string|max:255',
            'sale_price' => 'required|numeric',
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required',
            'unit' => 'required|exists:units,id',
            'apro_cost' => 'required',
        ]);

        if ($request->hasFile('picture')) {
            $imageName = rand() . '.' . $request->picture->extension();
            $request->picture->move(public_path('uploads/make_item/'), $imageName);
             $requestData['picture'] = 'uploads/make_item/' . $imageName;
             $makeItem =  MakeItem::updateOrCreate([
                    'id' => $request->id ?? 0,
             ],
                [
                'make_category_id' => $request->input('make_category_id'),
               'item_name' => $request->input('item_name'),
               'sale_price' => $request->input('sale_price'),
               'note' => $request->input('note'),
               'cost_price' => $request->total_cost_price,
               'picture' => $requestData['picture'] ?? null,
                  // Add more fields as needed
               ]
            );
        }else{
               $makeItem =  MakeItem::updateOrCreate([
                            'id' => $request->id ?? 0,
                    ],
                        [
                    'make_category_id' => $request->input('make_category_id'),
                    'item_name' => $request->input('item_name'),
                    'sale_price' => $request->input('sale_price'),
                    'note' => $request->input('note'),
                    'cost_price' => $request->total_cost_price,
                    'picture' => $requestData['picture'] ?? null,
                        // Add more fields as needed
                    ]);
        }

        $makeItemId = $makeItem->id;
       $material =   MaterialList::create([
            'make_item_id' => $makeItemId,
            'product_id' => $validatedData['product_id'],
            'quantity' => $validatedData['quantity'],
            'unit' => $validatedData['unit'],
            'apro_cost' => $validatedData['apro_cost'],
            // Add any other fields as needed
        ]);
        $material->load('product');
        $material->load('unit');
        return response()->json([
            'status' => 200,
            'message' => 'Item created successfully!',
            // 'makeItem' => $makeItem,
            'material' =>$material
        ]);

    }
    public function DestroyMaterials($id)
    {
        $material = MaterialList::findOrFail($id);

        if ($material) {
            $material->delete();
            return response()->json([
                'status' => 200,
                'message' => 'Item deleted successfully!',
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'Item not found!',
            ]);
        }
    }

}
