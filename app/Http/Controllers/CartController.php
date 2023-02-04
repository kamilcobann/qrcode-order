<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\User;
use App\Models\Product;

use Illuminate\Support\Facades\Auth;
class CartController extends Controller
{
     public function __construct() {
    //     $this->middleware('auth:api');
     }



    public function getCart()
    {
        $user= Auth::user();

        if($user->can('view-cart'))
        {
            if($cart = Cart::where('user_id','=',$user->id)->get())
        {
            return response()->json([
                'status' => true,
                'cart' => $cart,
            ]);
        }else{
            return response()->json([
                'status' => false,
                'message' => 'Cart Not Found',
            ]);
        }}else{
            return response()->json([
                'status' => false,
                'message' => 'You do not have permission',
            ]);
        }
    }


    public function addToCart(Request $request)
    {
        $user = Auth::user();
        
        if($user->can('create-cart'))
        {$request->validate([
            'product_id' => 'required|integer',
            'amount' => 'required|integer'
        ]);

        if($cart = Cart::where('user_id','=',$user->id)->where('product_id','=',$request->product_id)->first())
        {
            
            $cart->product_id = $request->product_id;
            $cart->amount = $request->amount;
            $cart->save();

            return response()->json([
                'status' => true,
                'message' => 'product added to cart',
                'cart' => $cart,
            ]);
        }

        if($product = Product::find($request->product_id)){
            
            if($product->amount >= $request->amount){
                
                $cart = Cart::create([
                    'user_id' => $user->id,
                    'product_id' => $request->product_id,
                    'boughtPrice' => $product->price,
                    'amount' => $request->amount,
                ]);

                return response()->json([
                    'status' => true,
                    'message' => 'product added to cart',
                    'cart' => $cart,
                ]);

            }else{

                return response()->json([
                    'status' => false,
                    'message' => 'amount must be bigger than stock',
                ]);

            }
        }else{

            return response()->json([
                'status' => false,
                'message' => 'product not found',
            ]);

        }}else{
            return response()->json([
                'status' => false,
                'message' => 'You do not have permission',
            ]);
        }
    }

    public function removeFromCart(Request $request)
    {
        $user = Auth::user();
        if($user->can('delete-cart'))
        {$request->validate([
            'product_id' => 'integer|required',
            'amount' => 'integer|nullable',
        ]);

        
        if($cart = Cart::where('user_id','=',$user->id)->where('product_id','=',$request->product_id)->get()){
            if($request->amount == null && $request->amount == $cart->amount){
                
                Cart::where('user_id','=',$user->id)->where('product_id','=',$request->product_id)->delete();

                return response()->json([
                    'status' => true,
                    'message' => 'product removed from cart',
                    'cart' => $cart,
                ]);
            }else if($request->amount > $cart->amount){
                
                return response()->json([
                    'status' => false,
                    'message' => 'invalid amount',
                ]);

            }else{
                $cart->amount = $request->amount;
                $cart->save();

                return response()->json([
                    'status' => true,
                    'message' => 'product removed from cart',
                    'cart' => $cart,
                ]);
            }
        }}else{
            return response()->json([
                'status'=>false,
                'message'=> 'You do not have permission'
            ]);
        }
    }

    public function deleteCart()
    {
        $user = Auth::user();
        if($user->can('delete-cart'))
        {$carts = Cart::where('user_id','=',$user->id)->delete();

        return response()->json([
            'status' => true,
            'message' => 'All carts deleted',
            'carts' => $carts,
        ]);}else{

            return response()->json([
                'status'=>false,
                'message'=> 'You do not have permission'
            ]);
        }
    }
}
