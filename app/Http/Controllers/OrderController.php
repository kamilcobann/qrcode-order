<?php

namespace App\Http\Controllers;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function __construct() {
        $this->middleware('auth:api');
    }

    public function createOrder(Request $request)
    {
        
    }

    public function deleteOrder($id)
    {
        # code...
    }
}
