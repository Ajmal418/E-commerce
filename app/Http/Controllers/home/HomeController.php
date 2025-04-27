<?php

namespace App\Http\Controllers\home;

use App\Http\Controllers\Controller;
use App\Models\ProductModel;
use App\Models\CartItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use function PHPSTORM_META\map;

class HomeController extends Controller
{
    public function index()
    { 
        
       
        return view('home.productList');
    }

    public function productlist(){      
        $data= ProductModel::all()->toArray();
        $min= array_map(function($item){
        
            $item['image'] =  array_map(function($arr){
                if(file_exists(public_path().'/assets/product/'.$arr)){
                        $arr=asset('assets/product/'.$arr);
                       
                        return $arr;
                    }
                    
               },json_decode($item['image']));

               return $item;

        },$data);

        return response()->json([
            
            'message' => 'Product List',
            'data' => $min
            
        ], 200);
    }


    public function addToCart(Request $request){
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

    public function cart(){

        return view('home.cart');
    }

    public function  removeCartItem($id){
        $data=CartItem::where('product_id',$id)->delete();
        if($data){

            return response()->json([
    
                'message' => 'Cart Item Removed',
                'data' => $data
    
            ], 200);
        }else{

            return response()->json([
    
                'message' => 'Cart Item  Not  Removed',
                'data' => false
     
            ], 409);
        }
    
    }
    public function updateCartItem(Request $request ,$id){
        $quantity=$request->quantity;
        if($quantity < 1){
            return response()->json([

                'message' => 'Invalid Quantity',
                'data' => false

            ], 409);
        }else{

        
        $data=cartItem::where('product_id', $id)->update(['quantity' => $request->quantity]);
        if($data){

            return response()->json([

                'message' => 'Quantity is  Updated',
                'data' => $data

            ], 200);
        }else{

            return response()->json([

                'message' => 'Quantity is  Not  Updated',
                'data' => false

            ], 409);
        }
        }

    }
}
