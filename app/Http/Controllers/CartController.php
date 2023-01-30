<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Product;

use Illuminate\Support\Facades\Auth;
class CartController extends Controller
{
    public function __construct() {
        $this->middleware('auth:api');
    }

    public function getCart()
    {
        $user_id = Auth::id();

        if($cart = Cart::where('user_id','=',$user_id)->get())
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
        }
    }


    public function addToCart(Request $request)
    {
        $user_id = Auth::id();

        $request->validate([
            'product_id' => 'required|integer',
            'amount' => 'required|integer'
        ]);

        if($cart = Cart::where('user_id','=',$user_id)->where('product_id','=',$request->product_id)->first())
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
                    'user_id' => $user_id,
                    'product_id' => $request->product_id,
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

        }
    }

    public function removeFromCart(Request $request)
    {
        $request->validate([
            'product_id' => 'integer|required',
            'amount' => 'integer|nullable',
        ]);

        $user_id = Auth::id();

        if($cart = Cart::where('user_id','=',$user_id)->where('product_id','=',$request->product_id)->get()){
            if($request->amount == null && $request->amount == $cart->amount){
                
                Cart::where('user_id','=',$user_id)->where('product_id','=',$request->product_id)->delete();

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
        }
    }

    public function deleteCart()
    {
        $user_id = Auth::id();

        $carts = Cart::where('user_id','=',$user_id)->delete();

        return response()->json([
            'status' => true,
            'message' => 'All carts deleted',
            'carts' => $carts,
        ]);
    }
}
