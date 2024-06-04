<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ItemCategory;
use App\Models\MakeItem;
use App\Models\MaterialList;
use Illuminate\Support\Facades\File;

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
        // Validate the request
        $validatedData = $request->validate([
            'make_category_id' => 'required|exists:item_categories,id',
            'item_name' => 'required',
            'sale_price' => 'required',
            'product_id' => 'required',
            'quantity' => 'required',
            'unit' => 'required',
            'apro_cost' => 'required',
        ]);

        if($request->id != 0){
            $cost_price = MaterialList::where('make_item_id', $request->id)->sum('apro_cost');
            $cost_price += (float) $request->apro_cost;
        } else {
            $cost_price = $request->apro_cost;
        }

        if ($request->hasFile('picture')) {
            $imageName = rand() . '.' . $request->picture->extension();
            $request->picture->move(public_path('uploads/make_item/'), $imageName);
            $requestData['picture'] = 'uploads/make_item/' . $imageName;
        } else {
            $requestData['picture'] = null;
        }

        $makeItem = MakeItem::updateOrCreate([
            'id' => $request->id ?? 0,
        ], [
            'make_category_id' => $request->input('make_category_id'),
            'item_name' => $request->input('item_name'),
            'barcode' => rand(100000, 123456789),
            'sale_price' => $request->input('sale_price'),
            'note' => $request->input('note'),
            'cost_price' => $cost_price,
            'picture' => $requestData['picture'] ?? null,
        ]);

        $makeItemId = $makeItem->id;

        // Check if the material already exists
        $material = MaterialList::where([
            ['make_item_id', '=', $makeItemId],
            ['product_id', '=', $validatedData['product_id']]
        ])->first();

        if ($material) {
            // Update existing material
            $material->quantity += $validatedData['quantity'];
            $material->apro_cost += $validatedData['apro_cost'];
            $material->save();
        } else {
            // Create new material
            $material = MaterialList::create([
                'make_item_id' => $makeItemId,
                'product_id' => $validatedData['product_id'],
                'quantity' => $validatedData['quantity'],
                'unit' => $validatedData['unit'],
                'apro_cost' => $validatedData['apro_cost'],
            ]);
        }

        $material->load('product','unit');


        return response()->json([
            'status' => 200,
            'message' => 'Item created successfully!',
            'makeItem' => $makeItem,
            'material' => $material,
            'makeItemId' => $makeItemId
        ]);
    }

    public function DestroyMaterials($id)
    {

        $material = MaterialList::findOrFail($id);

        if ($material) {
            $MakeItem = MakeItem::findOrFail($material->make_item_id);
            $cost = $MakeItem->cost_price - $material->apro_cost;
            $MakeItem->cost_price = $cost;
            $MakeItem->update();
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
        /////////////////////////////////////Make Item Manage //////////////////////////
        public function MakeItemManage(){
            $items = MakeItem::where('cost_price', '>', 0)
            ->get();
            return view('pos.make-item.make-item-manage',compact('items'));
        }//
        public function MakeItemEdit($id){
            $itemEditId = MakeItem::findOrFail($id);
            return view('pos.make-item.make-item-edit',compact('itemEditId'));
        }
        public function MakeItemFind($id){
            $status = 'active';
            $materialsItems = MaterialList::where('make_item_id', $id)->with('product','unit')->get();
            return response()->json([
                'status' => '200',
                'materialsItems' => $materialsItems,
            ]);
        }
        ////////////

        public function UpdateMakeItem(Request $request ){
            // Validate the request
            $validatedData = $request->validate([
                'make_category_id' => 'required|exists:item_categories,id',
                'item_name' => 'required',
                'sale_price' => 'required',
                'product_id' => 'required',
                'quantity' => 'required',
                'unit' => 'required',
                'apro_cost' => 'required',
            ]);

            if($request->id != 0){
                $cost_price = MaterialList::where('make_item_id', $request->id)->sum('apro_cost');
                $cost_price += (float) $request->apro_cost;
            } else {
                $cost_price = $request->apro_cost;
            }

            if ($request->hasFile('picture')) {
                $imageName = rand() . '.' . $request->picture->extension();
                $request->picture->move(public_path('uploads/make_item/'), $imageName);
                $requestData['picture'] = 'uploads/make_item/' . $imageName;
            } else {
                $requestData['picture'] = null;
            }

            $makeItem = MakeItem::updateOrCreate([
                'id' => $request->id ?? 0,
            ], [
                'make_category_id' => $request->input('make_category_id'),
                'item_name' => $request->input('item_name'),
                'barcode' => rand(100000, 123456789),
                'sale_price' => $request->input('sale_price'),
                'note' => $request->input('note'),
                'cost_price' => $cost_price,
                'picture' => $requestData['picture'] ?? null,
            ]);

            $makeItemId = $makeItem->id;

            // Check if the material already exists
            $material = MaterialList::where([
                ['make_item_id', '=', $makeItemId],
                ['product_id', '=', $validatedData['product_id']]
            ])->first();

            if ($material) {
                // Update existing material
                $material->quantity += $validatedData['quantity'];
                $material->apro_cost += $validatedData['apro_cost'];
                $material->save();
            } else {
                // Create new material
                $material = MaterialList::create([
                    'make_item_id' => $makeItemId,
                    'product_id' => $validatedData['product_id'],
                    'quantity' => $validatedData['quantity'],
                    'unit' => $validatedData['unit'],
                    'apro_cost' => $validatedData['apro_cost'],
                ]);
            }

            $material->load('product','unit');
            return response()->json([
                'status' => 200,
                'message' => 'Item created successfully!',
                // 'makeItem' => $makeItem,
                'material' => $material,
                'makeItemId' => $makeItemId
            ]);
        }
        public function MakeItemDelete(Request $request,$id){
                $item = MakeItem::findOrFail($id);
                $imagePath = public_path(asset($item->picture));
                if (File::exists($imagePath)) {
                    File::delete($imagePath);
                }
                $item->delete();
                $notification = array(
                    'message' =>'Make Item Successfully Deleted',
                    'alert-type'=> 'info'
                );
        return redirect()->back()->with($notification);

        }
        /////////////////////////////////////EndMake Item Manage //////////////////////////
}
