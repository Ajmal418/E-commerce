

@extends('layouts.app')
@section('content') 
 <div class="max-w-6xl mx-auto p-6" >

    <!-- Header / Cart Icon -->
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold">Awesome Store</h1>
        <div class="relative">
            <button class="relative">
                <svg class="w-8 h-8 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M3 3h2l.4 2M7 13h14l-1.5 8H6L4 6h16"></path>
                </svg>
                <span id="item_count" class=" absolute top-0 right-0 bg-red-500 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center"
                      x-text="cart"></span>
            </button>
        </div>
    </div>

    <!-- Product Display -->
    <div id="item_list" class="grid gap-y-3">

        <div class="bg-white rounded-lg shadow-md p-6 flex flex-col md:flex-row gap-6">
           
            <div class="flex-1">
                <img src="https://via.placeholder.com/400" alt="Product Image" class="rounded-lg w-full">
            </div>
    
          
            <div class="flex-1 space-y-4">
                <h2 class="text-2xl font-semibold">Wireless Headphones</h2>
                <p class="text-gray-600">Experience high-quality sound with our wireless headphones. Comfortable design and long battery life.</p>
                <p class="text-xl font-bold text-green-600">₹2,999</p>
    
               
                <div class="flex items-center gap-4">
                    <label for="quantity" class="font-medium">Qty:</label>
                    <input type="number" id="quantity" min="1" class="border rounded px-2 w-20" >
                    {{-- <button  class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">
                        Add to Cart
                    </button> --}}
                </div>
    
     
               
            </div>
        </div>
    </div>

</div>
@endsection
@section('script')
<script>
    (async function getData() {
        response = await fetch('http://127.0.0.1:8000/api/cartitems')
        json = await response.json()
        let html = ''
       
        json.data.forEach(element => {
            

            html += `<div class="bg-white rounded-lg shadow-md p-6 flex flex-col md:flex-row gap-6">
       
                <img src="${element['image'][0]}" alt="${element['image'][0]}" class="rounded-lg w-40 h-40 ">
       

      
        <div class="flex-1 space-y-4">
            <h2 class="text-2xl font-semibold">${element['name']}</h2>
            <p class="text-gray-600">Experience high-quality sound with our wireless headphones. Comfortable design and long battery life.</p>
            <p class="text-xl font-bold text-green-600">₹${element['price']}</p>

           
            <div class="flex items-center gap-4">
                <label for="quantity" class="font-medium">Qty:</label>
                <input type="number" id="quantity" min="1" value="${element['quantity']}" class="border rounded px-2 w-20" >
                 <button  class="bg-slate-800 hover:bg-slate-600 text-white px-4 py-2 rounded">
                    Remove Item
                </button> 
            </div>

 
           
        </div>
    </div>`;


    document.getElementById('item_list').innerHTML = html;
    document.getElementById('item_count').innerHTML = json.data.length;
});

    })()

</script>
@endsection
