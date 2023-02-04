<?php

namespace App\Http\Controllers;
use App\Models\Cart;
use App\Models\Product;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use QrCode;
use Zxing\QrReader;

class QRCodeController extends Controller
{

    public function __construct() {
        //$this->middleware('auth:api');
    }

    public function cartQR() //get
    {
        $user = Auth::user();
        if($user->can('create-qr'))
        {$cart = Cart::where('user_id','=',$user->id)->get();

        $data = array('user'=>$user->id,'cart'=>$cart);
        $qrcode = QrCode::size(250)->format('png')->backgroundColor(255,255,255)
        ->generate(json_encode($data),public_path('/generated'.'/qrcode'.$user->name.ucfirst($user->surname).'.png'));
        
        
        return view('qrcode.cart',compact('qrcode','data','user'));}else{
            return response()->json([
                'status' => false,
                'message' => 'You do not have permission'
            ]);
        }
    }

    public function readQR(Request $request) //post
    {

        $user = Auth::user();
        if($user->can('read-qr'))
        {
            $request->validate([
            'cart_qrcode' => 'required'
            ]);

            if($request->hasFile('cart_qrcode'))
            {
            $im_name = $user->name.ucfirst($user->surname).'Scanned'.$request->cart_qrcode->getClientOriginalExtension();
            //$im_name = "kamil".ucfirst("coban").'Scanned.'.$request->cart_qrcode->getClientOriginalExtension();
            $request->cart_qrcode->move(public_path('uploaded'),$im_name);
            $qrcode = new QrReader('uploaded/'.$im_name);
            }

        
        $total_price = 0.0;
        $qrdata = json_decode($qrcode->text());

        //return dd($qrdata->cart);

        foreach ($qrdata->cart as $c) {
            $prod = Product::where('id','=',$c->product_id)->first();
            $total_price += ($prod->price * $c->amount);
        }

        $order = Order::create([
            'carts' => json_encode($qrdata->cart),
            'user_id' => 1, //$user->id,
            'address' => "usak",//$user->address,
            'total_price' => $total_price,
        ]);

        $order_id = $order->id;

        return view('qrcode.order',compact('qrdata','total_price','order_id'));}
        else{
            return response()->json([
                'status' => false,
                'message' => 'You do not have permission'
            ]);
        }
    }

    public function page() //get
    {
        $user = Auth::user();
        if($user->can('read-qr')){
            return view('qrcode.read');
        }else{
            return response()->json([
                'status' => false,
                'message' => 'You do not have permission'
            ]);
        }
    }


}
