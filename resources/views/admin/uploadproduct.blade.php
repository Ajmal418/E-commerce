 @extends('admin.app')
 @section('content')
 <!-- Upload Product Form -->
 @if (!Request::route('id'))
     

 <div class="bg-white p-6 rounded-xl shadow max-w-3xl">    
     @if (Session::has('success'))
     <div class="flex items-center p-4 mb-4 text-sm text-green-700 bg-green-100 rounded-lg border border-green-300" role="alert">
        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
          <path fill-rule="evenodd" d="M2 10a8 8 0 1116 0A8 8 0 012 10zm8-5a1 1 0 00-1 1v4H7a1 1 0 000 2h4v4a1 1 0 002 0v-4h4a1 1 0 000-2h-4V6a1 1 0 00-1-1h-2z" clip-rule="evenodd" />
        </svg>
        <span class="font-medium">Success alert!</span> {{Session::get('success')}}
      </div>
      @elseif (Session::has('error')) 
      <div class="flex items-center p-4 mb-4 text-sm text-red-700 bg-red-100 rounded-lg border border-red-300" role="alert">
        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
          <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-3a1 1 0 00-1 1v3a1 1 0 102 0V8a1 1 0 00-1-1zm-1 7a1 1 0 112 0 1 1 0 01-2 0z" clip-rule="evenodd" />
        </svg>
        <span class="font-medium">Error alert!</span> {{Session::get('error')}}
      </div>             
     @endif
        
    <h2 class="text-xl font-semibold mb-4">Upload Product</h2>

    <form method="POST" action="{{ route('products.store') }}" enctype="multipart/form-data">
    
        @csrf 
        <div class="mb-4">
            <label class="block text-sm font-medium mb-1">Product Name</label>
            <input type="text" name="name"  value="{{old('name')}}" class="w-full p-2 border rounded">
            @error('name')
            <span class="text-red-700">{{ $message }}</span>
            @enderror
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium mb-1">Price</label>
            <input type="number" name="price" step="0.01"  value="{{old('price')}}" class="w-full p-2 border rounded">
            @error('price')
            <span class="text-red-700">{{ $message }}</span>
            @enderror
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium mb-1">Product Images (multiple)</label>
            <input type="file" name="images[]" id="image" multiple  class="w-full p-2 border rounded">         
        @if ($errors->has('images.*'))
            <ul class="text-red-700">              
                @foreach ($errors->get('images.*') as $error)                
                    <li>{{$error[0]}}</li>
                @endforeach
            </ul>
        @endif
            @error('images')
            <span class="text-red-700">{{ $message }}</span>
            @enderror
        </div>

        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
            Upload Product
        </button>
    </form>
</div>
@else
<div class="bg-white p-6 rounded-xl shadow max-w-3xl">    
    @if (Session::has('success'))
    <div class="flex items-center p-4 mb-4 text-sm text-green-700 bg-green-100 rounded-lg border border-green-300" role="alert">
       <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
         <path fill-rule="evenodd" d="M2 10a8 8 0 1116 0A8 8 0 012 10zm8-5a1 1 0 00-1 1v4H7a1 1 0 000 2h4v4a1 1 0 002 0v-4h4a1 1 0 000-2h-4V6a1 1 0 00-1-1h-2z" clip-rule="evenodd" />
       </svg>
       <span class="font-medium">Success alert!</span> {{Session::get('success')}}
     </div>
     @elseif (Session::has('error')) 
     <div class="flex items-center p-4 mb-4 text-sm text-red-700 bg-red-100 rounded-lg border border-red-300" role="alert">
       <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
         <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-3a1 1 0 00-1 1v3a1 1 0 102 0V8a1 1 0 00-1-1zm-1 7a1 1 0 112 0 1 1 0 01-2 0z" clip-rule="evenodd" />
       </svg>
       <span class="font-medium">Error alert!</span> {{Session::get('error')}}
     </div>             
    @endif
       
   <h2 class="text-xl font-semibold mb-4">Upload Product</h2> 
   <form method="POST" action="{{ route('products.update' ,$product['id']) }}" enctype="multipart/form-data">
   
       @csrf 
       <div class="mb-4">
           <label class="block text-sm font-medium mb-1">Product Name</label>
           <input type="text" name="name"  value="{{old('name',$product['name'])}}" class="w-full p-2 border rounded">
           @error('name')
           <span class="text-red-700">{{ $message }}</span>
           @enderror
       </div>

       <div class="mb-4">
           <label class="block text-sm font-medium mb-1">Price</label>
           <input type="number" name="price" step="0.01"  value="{{old('price',$product['price'])}}" class="w-full p-2 border rounded">
           @error('price')
           <span class="text-red-700">{{ $message }}</span>
           @enderror
       </div>

       <div class="mb-4">
           <label class="block text-sm font-medium mb-1">Product Images (multiple)</label>
           <input type="file" name="images[]" id="image" multiple  class="w-full p-2 border rounded">         
       @if ($errors->has('images.*'))
           <ul class="text-red-700">              
               @foreach ($errors->get('images.*') as $error)                
                   <li>{{$error[0]}}</li>
               @endforeach
           </ul>
       @endif
           @error('images')
           <span class="text-red-700">{{ $message }}</span>
           @enderror
       </div>
        <div class="flex  gap-2 mb-2">
            @foreach (json_decode($product['image']) as $img )
            <img src="{{asset('assets/product/'.$img)}}" alt="{{$img}}" class="h-20 w-20">
                
            @endforeach
        </div>
       <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
           Upload Product
       </button>
   </form>
</div>
@endif

 @endsection