<?php

namespace App\Http\Controllers\home;

use App\Http\Controllers\Controller;
use App\Models\ProductModel;
use App\Models\Order;
use App\Models\CartItem;
use Illuminate\Http\Request;
use Razorpay\Api\Api;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;


class HomeController extends Controller
{  
    
    public function __construct()
    {
        // {
        //     razorpay_payment_id: 'pay_QOqwd0jArhe8La',
        //     razorpay_order_id: 'order_QOqwO8sO1rXmWt',
        //     razorpay_signature: '9be516276c03968fcb67c7dd53467bbfef9c3a0dbc94c45607f6e9112fcd3ba5'
        //   }
           
    }

    public function index()
    {


        return view('home.productList');
    }

    public function productlist()
    {
        $data = ProductModel::all()->toArray();
        $min = array_map(function ($item) {

            $item['image'] =  array_map(function ($arr) {
                if (file_exists(public_path() . '/assets/product/' . $arr)) {
                    $arr = asset('assets/product/' . $arr);

                    return $arr;
                }
            }, json_decode($item['image']));

            return $item;
        }, $data);

        return response()->json([

            'message' => 'Product List',
            'data' => $min

        ], 200);
    }


    public function addToCart(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:product_models,id',
        ]);

        $exists = CartItem::where('user_id', 1)
            ->where('product_id', $validated['product_id'])
            ->exists();

        if (!$exists) {
            CartItem::create([
                'user_id' => 1,
                'product_id' => $validated['product_id'],
                'quantity' => 1,
                'price' => 1,
            ]);

            return response()->json(['message' => 'Product added to cart.'], 200);
        }
        return response()->json(['message' => 'Product already in cart.'], 409);
    }

    public function cartItems(){

        $data=DB::table('cart_items')
        ->select('product_models.id','product_models.name','product_models.price','product_models.image','cart_items.quantity','cart_items.user_id')
        ->leftJoin('product_models','product_models.id','=','cart_items.product_id')
        ->where('cart_items.user_id',1)
        ->get()->toArray();
        $min= array_map(function($item){ 
            
           
           $item['image'] =  array_map(function($arr){
                if(file_exists(public_path().'/assets/product/'.$arr)){
                        $arr=asset('assets/product/'.$arr);
                       
                        return $arr;
                    }
                    
               },json_decode($item['image']));
               $item['price'] =  $item['price'] * $item['quantity'];

              
               
               return $item;

        },json_decode(json_encode($data), true));
            $totalPrice = 0;
        foreach ($min as $key => &$value) {
            $totalPrice += $value['price'];
        }
        Session::put('cart_total', $totalPrice);
        if(count($data)> 0){

        return response()->json([

            'message' => 'Cart List',
            'data' => $min,
            'totalPrice'=>$totalPrice

        ], 200);
      }else{
        return response()->json([

            'message' => 'Cart List',
            'data' => []

        ], 409);
      }
        
    
    }

    public function cart()
    {

        return view('home.cart');
    }

    public function  removeCartItem($id)
    {
        $data = CartItem::where('product_id', $id)->delete();
        if ($data) {

            return response()->json([

                'message' => 'Cart Item Removed',
                'data' => $data

            ], 200);
        } else {

            return response()->json([

                'message' => 'Cart Item  Not  Removed',
                'data' => false

            ], 409);
        }
    }
    public function updateCartItem(Request $request, $id)
    {
        $quantity = $request->quantity;
        if ($quantity < 1) {
            return response()->json([

                'message' => 'Invalid Quantity',
                'data' => false

            ], 409);
        } else {


            $data = cartItem::where('product_id', $id)->update(['quantity' => $request->quantity]);
            if ($data) {

                return response()->json([

                    'message' => 'Quantity is  Updated',
                    'data' => $data

                ], 200);
            } else {

                return response()->json([

                    'message' => 'Quantity is  Not  Updated',
                    'data' => false

                ], 409);
            }
        }
    }


    public function createOrder(Request $request)
    {      
        try {            
        
        
        $data=DB::table('cart_items')
        ->select('product_models.price','cart_items.quantity')
        ->leftJoin('product_models','product_models.id','=','cart_items.product_id')
        ->where('cart_items.user_id',1)
        ->get()->toArray();
        $data=json_decode(json_encode($data),true);
        $totalPrice = 0;
        foreach ($data as $key => &$value) {
            $totalPrice += $value['price'];
        }
        $api = new Api(env('RAZORPAY_KEY'), env('RAZORPAY_SECRET'));
       
        $amount = ($totalPrice+5)*100; // 100 in paise
        
        $order = $api->order->create([
            'receipt' => 'receipt_' . rand(999,10000),
            'amount' => $amount,
            'currency' => 'INR',
            'payment_capture' => 1 
        ]);
        
      
        return response()->json([
            'order_id' => $order->id,
            'amount' => $amount,
            'key' => env('RAZORPAY_KEY'),
        ]);

    } catch (\Exception $e) {
        return response()->json([
            'status' => 'error',
            'message' => 'Something went wrong.',
            'error' => $e->getMessage()
        ], 500); //throw $th;
    } 
        
    }

    public function handleWebhook(Request $request){
            
            $data= $request->payment_id;          
            $razorpay_order_id= $data['razorpay_order_id'];
            $razorpay_order_id= $data['razorpay_order_id'];
            $razorpay_payment_id= $data['razorpay_payment_id'];
            $cart= new CartItem;
            $shipingAmount=5;
            $product = $cart->select('product_id')->where('user_id',1)->get()->toArray();
            $amount=0; 
            foreach ($product as  $value) {
                $product_id = $value['product_id'];
              $data=  ProductModel::Select('price')->where('id',$product_id)->get()->toArray(); 
                foreach ($data as  $value) {
                    $price = floatval($value['price']);
                    $amount += $price;
                    $amount+=$shipingAmount;
                } 
                $data=   Order::create([
                       'product_id' =>$product_id,
                       'order_amount' => $amount,
                       'user_id' => 1,
                       'payment_id' => $razorpay_payment_id,              
                   ]); 
            }
           
           $output= $cart->where('user_id', 1)->delete();
             log::message("cart is empty ${$output}");   
            if($data){

                return response()->json([
                    'message'=>'Order place succfully',
                    'data'=>$data
                ],200);
            }else{
                return response()->json([
                    'message'=>'Order place succfully',
                    'data'=>false
                ],409);

            }

        
            


    }


}
