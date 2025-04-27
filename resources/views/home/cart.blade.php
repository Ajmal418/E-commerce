

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
    <!-- Error Section -->
     <div id="success_error" class="hidden">
    <div  id="success_message" class="flex items-center p-4 mb-4 text-sm text-green-700 bg-green-100 rounded-lg border border-green-300" role="alert">
        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
          <path fill-rule="evenodd" d="M2 10a8 8 0 1116 0A8 8 0 012 10zm8-5a1 1 0 00-1 1v4H7a1 1 0 000 2h4v4a1 1 0 002 0v-4h4a1 1 0 000-2h-4V6a1 1 0 00-1-1h-2z" clip-rule="evenodd" />
        </svg>
        <span class="font-medium">Success alert!</span> Cart Item Removed
      </div>
      </div>
      <div id="error" class="hidden">
      <div id="error_message" class="flex items-center p-4 mb-4 text-sm text-red-700 bg-red-100 rounded-lg border border-red-300" role="alert">
        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
          <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-3a1 1 0 00-1 1v3a1 1 0 102 0V8a1 1 0 00-1-1zm-1 7a1 1 0 112 0 1 1 0 01-2 0z" clip-rule="evenodd" />
        </svg>
        <span class="font-medium">Error alert!</span> Cart Item Not Removed
      </div>    
      </div>
    <!-- Product Display -->
    <div id="item_list" class="grid gap-y-3">

       <div>
        <p class="text-center font-bold text-lg">Empty cart</p>
       </div>
    </div>
      
</div>
@endsection
@section('script')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        getData();
    });
    async function getData() {
        response = await fetch('http://127.0.0.1:8000/api/cartitems')
        json = await response.json()
        console.log(json)
        let html = ''
        if(json.data.length==0){
            html = `<div>
            <p class="text-center font-bold text-lg">Empty cart</p>
           </div>`
           document.getElementById('item_count').innerHTML ='0';
        }else{
        json.data.forEach(element => {
            

            html += `<div class="bg-white rounded-lg shadow-md p-6 flex flex-col md:flex-row gap-6">
       
                <img src="${element['image'][0]}" alt="${element['image'][0]}" class="rounded-lg w-40 h-40 ">
       

      
        <div class="flex-1 space-y-4">
            <h2 class="text-2xl font-semibold">${element['name']}</h2>
            <p class="text-gray-600">Experience high-quality sound with our wireless headphones. Comfortable design and long battery life.</p>
            <p class="text-xl font-bold text-green-600">₹${element['price']}</p>

           
            <div class="flex items-center gap-4">
                <label for="quantity" class="font-medium">Qty:</label>
                <input type="number" onchange="quantitychange(this)" data-id="${element['id']}" id="quantity" min="1" value="${element['quantity']}" class="border rounded px-2 w-20" >
                 <button onclick="removeitem(this)" data-id="${element['id']}" class="bg-slate-800 hover:bg-slate-600 text-white px-4 py-2 rounded">
                    Remove Item
                </button> 
            </div> 
         </div>
    </div>`;
        
    

});
html+=`    <div class="bg-white rounded-lg shadow-md p-6 flex flex-col  gap-6">
      <div class="bg-gray-50 p-6 rounded-2xl shadow-md">
        <h3 class="text-xl font-semibold mb-4 text-gray-700">Order Summary</h3>
        
        <div class="flex justify-between mb-2">
          <span class="text-gray-600">Subtotal</span>
          <span class="font-medium text-gray-800">₹${json.totalPrice}</span>
        </div>

        <div class="flex justify-between mb-2">
          <span class="text-gray-600">Shipping</span>
          <span class="font-medium text-gray-800">₹5</span>
        </div>

        <div class="flex justify-between border-t pt-4 mt-4">
          <span class="text-lg font-bold text-gray-700">Total</span>
          <span class="text-lg font-bold text-gray-900">₹${json.totalPrice+5}</span>
        </div>

        <button class="mt-6 w-full bg-slate-900 hover:bg-slate-600 text-white font-semibold py-3 rounded-xl transition duration-300">
          Proceed to Payment
        </button>
      </div>
    </div>`;
document.getElementById('item_list').innerHTML = html;
document.getElementById('item_count').innerHTML = json.data.length;
    }

    }

 async  function removeitem(e){
        //console.log(e.getAttribute('data-id'))
       response = await fetch(`http://127.0.0.1:8000/api/removecartitem/${e.getAttribute('data-id')}`,{
        method: 'DELETE', 
        headers: { 
            
            'Accept': 'application/json',
           
        }
       });
       json = await response.json();
       
       if(json.data==true){
       let success_error= document.getElementById('success_error');
        success_error.classList.remove('hidden');
        setTimeout(()=>{
            success_error.classList.add('hidden');
        },3000)
       
        getData()
      
       }else{
        let error = document.getElementById('error');
        error.classList.remove('hidden');
        setTimeout(()=>{
            error.classList.add('hidden');
        },3000)
       }
    }

   async function quantitychange(e){
            const id = e.getAttribute('data-id'); //product id 
        if(e.value<1){
                  e.value=1;
                  console.log(e.value)
                }else{
                    
                  console.log(JSON.stringify({
                       'quantity': parseInt(e.value)
                    }))
            const id = e.getAttribute('data-id');
            let response= await   fetch(`http://127.0.0.1:8000/api/updatecartitem/${id}`,{
                    method:'PUT', 
                    
                    headers: { 
            
                        'Accept': 'application/json',
                        'content-type': 'application/json'
                    
                    },
                    body:JSON.stringify({
                        'quantity': parseInt(e.value)
                    })
                })
                json = await response.json();
                if(json.data==true){
       let success_error= document.getElementById('success_error');
        success_error.classList.remove('hidden');
        document.getElementById('success_message').innerHTML = json.message;
        setTimeout(()=>{
            success_error.classList.add('hidden');
        },3000)
       
        getData()
      
       }else{
        let error = document.getElementById('error');
        error.classList.remove('hidden');
        document.getElementById('error_message').innerHTML = json.message;
        setTimeout(()=>{
            error.classList.add('hidden');
        },3000)
       }
              }   
           
    }

</script>
@endsection
