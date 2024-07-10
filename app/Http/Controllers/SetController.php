<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
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
        public function SetMenuUpdate(Request $request, $itemId)
        {
            $request->validate([
                'menu_name' => 'required|string|max:250',
                'cost_price' => 'required',
                'sale_price' => 'required',
            ]);

            $menuItem = SetMenu::findOrFail($itemId);
            $menuItem->menu_name = $request->menu_name;
            $menuItem->discount = $request->discount;
            $menuItem->cost_price = $request->cost_price;
            $menuItem->sale_price = $request->sale_price;
            $menuItem->discount_type = $request->discount_type;
            $menuItem->note = $request->note;
            if ($request->hasFile('images')) {
                // If there's an existing image, delete it
                if ($menuItem->image) {
                    unlink(public_path('uploads/menu_Items/' . $menuItem->image));
                }
                // Upload the new image
                $image = $request->file('images');
                $imageName = time() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('uploads/menu_Items/'), $imageName);
                $menuItem->image = $imageName;
            }

            $menuItem->update([
                'menu_name' => $menuItem->menu_name,
                'discount' => $menuItem->discount,
                'cost_price' => $menuItem->cost_price,
                'sale_price' => $menuItem->sale_price,
                'discount_type' => $menuItem->discount_type,
                'note' => $menuItem->note,
                'image' => $menuItem->image,
            ]);

            // Return success response
            $notification = [
                'message' => 'Menu Update Successfully',
                'alert-type' => 'info'
            ];
            return redirect()->back()->with($notification);
        }

        public function SetMenuDelete($id){
            $menuItem = SetMenu::findOrFail($id);

            $path = public_path('uploads/menu_Items/'.$menuItem->image);
            if(file_exists($path)){
                @unlink($path);
            }
            $menuItem->delete();
            $notification = [
                'message' => 'Menu  Deleted Successfully',
                'alert-type' => 'success'
            ];
            return redirect()->back()->with($notification);
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
    public function ManageSetItem(){
        $menuItems = MenuItems::with('items')->get();
        return view('pos.set.all-set-item',compact('menuItems'));
    }//
    public function ManageSetMenu(){
        $setMenu = SetMenu::all();
        return view('pos.set.all-set-menu',compact('setMenu'));
    }//
    public function ManageItemEdit($id){
        $menuItems = MenuItems::findOrFail($id);
        return view('pos.set.set-item-edit',compact('menuItems'));
    }
    public function MenuItemFind($id){
        $status = 'active';
        $menuItems = MenuItems::where('id', $id)->with('makeItems', 'menuItems')->get();
        // $menuItems->load('makeItems', 'menuItems');

        return response()->json([
            'status' => '200',
            'menuItemsAll' => $menuItems,
        ]);
    }

    public function UpdateSetItem(Request $request){
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
    }

    public function MenuItemDelete($id){
        MenuItems::findOrFail($id)->delete();
        $notification = [
            'message' => 'Menu Item Deleted Successfully',
            'alert-type' => 'info'
        ];
        return redirect()->back()->with($notification);
    }
}


