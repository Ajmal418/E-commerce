@extends('layouts.app')
@section('content')
@include('home.banner')
    <section id="products" class="max-w-7xl mx-auto py-12 px-4">
        <h3 class="text-3xl font-semibold text-center mb-10">Featured Products</h3>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8" id="product">
           
        </div>
    </section>
@endsection

@section('script')
<script>
    (async function getData() {
        response = await fetch('http://127.0.0.1:8000/api/productlist')
        json = await response.json()
        let html = ''
        json.data.forEach(element => {


            html += `<div class="bg-white rounded-lg shadow-md overflow-hidden">
     <img src="${element['image'][0]}" alt="${element['name']}" class="w-full h-50 object-fill">
     <div class="p-4">
       <h4 class="text-lg font-semibold">${element['name']}</h4>
       <p class="text-gray-500 mb-2">₹${element['price']}</p>
       <button onclick="addToCart(this)" class="bg-slate-800 text-white px-4 py-2"  data-id="${element['id']}" rounded hover:bg-slate-600 w-full">Add to Cart</button>
     </div>
   </div>`;


            document.getElementById('product').innerHTML = html;
        });

    })()

    function addToCart(data) {
        const productId = data.getAttribute('data-id');            
         updateTheCart(productId)

      }
      async function updateTheCart(productId) {
          const response = await fetch('http://127.0.0.1:8000/api/addtocart', {
              method: "post",
              headers: {

                  'Content-Type': "aplication/json"
              },
              body: JSON.stringify({
                  "product_id": productId
              })
          });
          json = await response.json();

          if (json.status == 200) {
              alert(json.message);
            } else {
            alert(json.message);                   
          }

         
      }
</script>
@endsection