<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Product;
class ProductController extends Controller
{

    // public function __construct() {
    //     $this->middleware('auth:api',['except'=>[
    //         'getAllProducts',
    //         'getProductById',
    //     ]]);
    // }

    public function getAllProducts()
    {
        $products = Product::all();

        return response()->json([
            'status' => true,
            'products' => $products,
        ]);
    }

    public function getProductById($id)
    {
        if($product = Product::find($id))
        {
            return response()->json([
                'status' => true,
                'message' => 'product found',
                'product' => $product,
            ]);
        }else{
            return response()->json([
                'status' => false,
                'message' => 'product not found'
            ]);
        }
    }

    public function addProduct(Request $request)
    {
        $user = Auth::user();
        
        if($user->can('create-product'))
        {
            $request->validate([
            'category_id' => 'required|integer',
            'name' => 'required|string',
            'description' => 'required|string',
            'image' => 'required|string',
            'amount' => 'required|integer',
            'price'=>'required|regex:/^[0-9]+(\.[0-9][0-9]?)?$/',
            ]);
        
        
            if($product = Product::find(str_slug($request->name)))
            {
            return response()->json([
                'status' => false,
                'message' => 'product exists',
                'product' => $product,
            ]);
            }else{
            $product = Product::create([
                'category_id' => $request->category_id,
                'name' => $request->name,
                'slug' => str_slug($request->name),
                'description' => $request->description,
                'image' => $request->image,
                'amount' => $request->amount,
                'price' => $request->price,
            ]);

            return response()->json([
                'status' => true,
                'message' => 'Product successfully created',
                'product' => $product,
            ]);
        }}else{
            return response()->json([
                'status' => false,
                'message' => 'You do not have permission',
            ]);
        }
    }

    public function updateProductById(Request $request,$id)
    {
        $user = Auth::user();

        if($user->can('edit-product'))
        {
            $request->validate([
                'category_id' => 'required|integer',
                'name' => 'required|string',
                'description' => 'required|string',
                'image' => 'required|string',
                'amount' => 'required|integer',
                'price' => 'required|regex:/^[0-9]+(\.[0-9][0-9]?)?$/',
            ]);

            if($product = Product::find($id)){
                $product->category_id = $request->category_id;
                $product->name = $request->name;
                $product->slug = str_slug($request->name);
                $product->description = $request->description;
                $product->image = $request->image;
                $product->amount = $request->amount;
                $product->price = $request->price;

                $product->save();

                return response()->json([
                    'status' => true,
                    'message' => 'Product updated successfully',
                    'product' => $product,
                ]);
            }
                return response()->json([
                    'status' => false,
                    'message' => 'Product not found',
                ]);
        }else{
            return response()->json([
                'status' => false,
                'message' => 'You do not have permission',
            ]);
        }
        
    }

    public function deleteProductById($id)
    {
        $user = Auth::user();

        if($user->can('delete-product'))
        {if($product = Product::find($id))
        {
            $product->delete();
            return response()->json([
                'status' => true,
                'message' => 'Product successfully deleted',
                'product' => $product,
            ]);
        }else{
            return response()->json([
                'status' => false,
                'message' => 'Product not found',
            ]);
        }}else{
            return response()->json([
                'status' => false,
                'message' => 'You do not have permission',
            ]);
        }
    }
}