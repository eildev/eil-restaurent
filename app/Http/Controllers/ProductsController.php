<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\PromotionDetails;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class ProductsController extends Controller
{
    public function index()
    {
        return view('pos.products.product.product');
    }
    public function store(Request $request)
    {
        // dd($request->all());
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'category_id' => 'required',
            'cost' => 'required:max:7',
            'unit_id' => 'required:max:11',
            'barcode' => [
                'required',
                Rule::unique('products', 'barcode')->where(function ($query) use ($request) {
                    return $query->where('barcode', $request->barcode);
                }),
            ],
        ]);

        if ($validator->passes()) {
            $product = new Product;
            $product->name =  $request->name;
            $product->branch_id =  Auth::user()->branch_id;
            $product->barcode =  $request->barcode;
            $product->category_id =  $request->category_id;
            if ($request->subcategory_id !== "Please add Subcategory") {
                $product->subcategory_id =  $request->subcategory_id;
            }
            $product->brand_id  =  $request->brand_id;
            $product->cost  =  $request->cost;
            $product->price  =  $request->price;
            $product->details  =  $request->details;
            $product->color  =  $request->color;
            $product->unit_id  =  $request->unit_id;
            if ($request->size_id !== 'Please add Size') {
                $product->size_id  =  $request->size_id;
            }
            if ($request->stock) {
                $product->stock  =  $request->stock;
            }
            if ($request->main_unit_stock) {
                $product->main_unit_stock  =  $request->main_unit_stock;
            }
            if ($request->image) {
                $imageName = rand() . '.' . $request->image->extension();
                $request->image->move(public_path('uploads/product/'), $imageName);
                $product->image = $imageName;
            }
            $product->save();
            return response()->json([
                'status' => 200,
                'message' => 'Product Save Successfully',
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
        $products = Product::all();
        return view('pos.products.product.product-show', compact('products'));
    }
    public function edit($id)
    {
        $product = Product::findOrFail($id);
        return view('pos.products.product.product-edit', compact('product'));
    }
    public function update(Request $request, $id)
    {
        // dd($request->all());
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'category_id' => 'required',
            'cost' => 'required:max:7',
            'unit_id' => 'required:max:11',
        ]);
        if ($validator->passes()) {
            $product = Product::findOrFail($id);
            $product->name =  $request->name;
            $product->branch_id =  Auth::user()->branch_id;
            $product->barcode =  $request->barcode;
            $product->category_id =  $request->category_id;
            if ($request->subcategory_id !== "Please add Subcategory") {
                $product->subcategory_id =  $request->subcategory_id;
            }
            $product->brand_id  =  $request->brand_id;
            $product->cost  =  $request->cost;
            $product->price  =  $request->price;
            $product->details  =  $request->details;
            $product->color  =  $request->color;
            $product->size_id  =  $request->size_id;
            $product->unit_id  =  $request->unit_id;
            if ($request->stock) {
                $product->stock  =  $request->stock;
            }
            if ($request->main_unit_stock) {
                $product->main_unit_stock  =  $request->main_unit_stock;
            }
            if ($request->image) {
                $imageName = rand() . '.' . $request->image->extension();
                $request->image->move(public_path('uploads/product/'), $imageName);
                if ($product->image) {
                    $previousImagePath = public_path('uploads/product/') . $product->image;
                    if (file_exists($previousImagePath)) {
                        unlink($previousImagePath);
                    }
                }
                $product->image = $imageName;
            }
            $product->save();
            return response()->json([
                'status' => 200,
                'message' => 'Product Update Successfully',
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
        $product = Product::findOrFail($id);
        if ($product->image) {
            $previousImagePath = public_path('uploads/product/') . $product->image;
            if (file_exists($previousImagePath)) {
                unlink($previousImagePath);
            }
        }
        $product->delete();
        return back()->with('message', "Product deleted successfully");
    }
    public function find($id)
    {
        $status = 'active';
        $product = Product::findOrFail($id);
        $promotionDetails = PromotionDetails::whereHas('promotion', function ($query) use ($status) {
            return $query->where('status', '=', $status);
        })->where('promotion_type', 'products')->where('logic', 'like', '%' . $id . "%")->latest()->first();
        // dd($promotionDetails->promotion);
        if ($promotionDetails) {
            return response()->json([
                'status' => '200',
                'data' => $product,
                'promotion' => $promotionDetails->promotion,
            ]);
        } else {
            return response()->json([
                'status' => '200',
                'data' => $product
            ]);
        }
    }
    //
    public function ProductBarcode($id)
    {
        $product = Product::findOrFail($id);
        return view('pos.products.product.product-barcode', compact('product'));
    }
}