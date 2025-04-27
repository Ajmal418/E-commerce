<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\ProductModel;
use Illuminate\Http\Request;

class ProdcutController extends Controller
{
    
    public function index()
    {
        return view('admin.uploadproduct');
    }
    public function dashboard()
    {       
       $products= ProductModel::get()->toArray();
   
        return view('admin.dashboard',compact('products'));
    }

    public function products(Request $request){

        $validation = $request->validate([
            'name'=>'required',
            'price'=>'required',
            'images'=>'required',
            'images.*' => 'mimes:jpeg|max:2048',
        ],[
                'name.required' => 'Please enter the product name.',
                'price.required' => 'Please enter the product price.',
                'images.required' => 'Please upload at least one product image.',
                'images.*.mimes' => 'Only JPG, PNG, and JPEG image formats are allowed.',
            ]);
        
        // dd($request->all());

       $productName=str_replace(' ','_',$request->name);
       $productprice=$request->price;
        $imageArray=array();
        if($request->hasFile('images')){
            
            $filepath=public_path('assets/product');
            // $filename=
            foreach ($request->file('images') as $key => $value) {
               $imagesName =$productName .'_'.$key.time().'.'. $value->getClientOriginalExtension();
               $value->move($filepath,$imagesName,'public');
               $imageArray[]=$imagesName; 
              

            }
        }
        
        $product= new ProductModel();
        $product->name=$request->name;
        $product->price=$productprice;
        $product->image=json_encode($imageArray);
        $product->save();
        if(!$product->save()){
        return redirect()->back()->with('error', 'Failed to upload product.');
        }
        return redirect()->back()->with('success', 'Product uploaded successfully.');
        dd(json_encode($imageArray));
        exit;  
    }

    public   function destroy($id){
        $product=ProductModel::find($id);
        $product->delete();
        return redirect()->back()->with('success', 'Product deleted successfully.');
    }

    public function editProduct($id){
        $product=ProductModel::find($id);
        return view('admin.uploadproduct', compact('product'));
    }

    public function  updateproduct(Request $request, $id){
        $validation = $request->validate([
            'name'=>'required',
            'price'=>'required',
            'images.*' => 'mimes:jpeg|max:2048',
        ],[
                'name.required' => 'Please enter the product name.',
                'price.required' => 'Please enter the product price.',
                'images.*.mimes' => 'Only JPG, PNG, and JPEG image formats are allowed.',
            ]);

        // dd($request->all());

       $productName=str_replace(' ', '_', $request->name);
       $productprice=$request->price;
        $imageArray=array();
        $filepath=public_path('assets/product');
        $product= ProductModel::find($id);
        $product->name=$request->name;
        $product->price=$productprice;
        if($request->hasFile('images')){

            
            foreach ($request->file('images') as $key => $value) {
               $imagesName =$productName .'_'.$key.time().'.'. $value->getClientOriginalExtension();
               $value->move($filepath, $imagesName, 'public');
               $imageArray[]=$imagesName;
               
            }
            $product->image=json_encode($imageArray);
        }

 
      
        $product->save();
        if(!$product->save()){
        return redirect()->back()->with('error', 'Failed to upload product.');
        }
        return redirect()->back()->with('success', 'Product uploaded successfully.');
        
    }
}
