<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\Models\SetMenu;
use App\Models\MakeItem;
use App\Models\MenuItems;
class SetController extends Controller
{
    public function Setitem(){
        return view('pos.set.set-item-add');
    }

    public function SetMenuStore(Request $request){
        $request->validate([
            'menu_name' => 'required|string|max:250',
            'cost_price' => 'required',
            'sale_price' => 'required',
        ]);

        $menuItem = new SetMenu();
        $menuItem->menu_name = $request->menu_name;
        $menuItem->discount = $request->discount;
        $menuItem->cost_price = $request->cost_price;
        $menuItem->barcode = rand(1000000, 123456789);
        $menuItem->sale_price = $request->sale_price;
        $menuItem->discount_type = $request->discount_type;
        $menuItem->note = $request->note ;
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time().'.'.$image->getClientOriginalExtension();
            $image->move(public_path('uploads/menu_Items/'), $imageName);
            $menuItem->image = $imageName;
        }
        $menuItem->save();
        // Return success response
        return response()->json([
            'status' => 200,
            'message' => 'Menu Item added successfully!',
            'data' => [
                'menuItem' => $menuItem
            ]
        ]);

    }
    public function getItemPrice(Request $request)
    {
        $itemID = $request->input('item_id');
        $item = MakeItem::find($itemID);
        if ($item) {
            return response()->json(['itemPrice' => $item->sale_price]);
        } else {
            return response()->json(['error' => 'Item not found.'], 404);
        }
    }//
    public function StoreSetItem(Request $request){
        $validatedData = $request->validate([
            'menu_id' => 'required',
            'item_id' => 'required',
            'quantity' => 'required|integer',
            'apro_cost' => 'required',
        ]);
        $menuId = $validatedData['menu_id'];
        $itemId = $validatedData['item_id'];
            $myMenuId = $request->id;
            $material = MenuItems::where([
                ['menu_id', '=', $menuId],
                ['item_id', '=', $itemId]
            ])->first();

            if ($material) {
                // Update existing material
                $material->quantity += $validatedData['quantity'];
                $material->apro_cost += $validatedData['apro_cost'];
                $material->save();
            } else {
                // Create new material
                $material = MenuItems::create([
                'menu_id' => $menuId,
                'item_id' =>  $itemId,
                'quantity' => $validatedData['quantity'],
                'apro_cost' => $validatedData['apro_cost'],
                ]);
            }

        $material->load('makeItems', 'menuItems');
        return response()->json([
            'status' => 200,
            'message' => 'Menu Item added Successfully!',
            'menuItemId' =>$myMenuId,
            'data' => [
                'menuItem' => $material,
            ]
        ]);
    }//
    public function DeleteMenuItem($id){
        $menuItems = MenuItems::findOrFail($id);
        $menuItems->delete();
            return response()->json([
                'status' => 200,
                'message' => 'Menu Item Deleted successfully!',
            ]);

    }
 

}


