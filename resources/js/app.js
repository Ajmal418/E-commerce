require("./bootstrap");

window.getData = async function () {
    try {
        let response = await fetch("http://127.0.0.1:8000/api/cartitems");
        let json = await response.json();

        let html = "";
        if (json.data.length == 0) {
            html += `<div>
                <p class="text-center font-bold text-lg">Empty cart</p>
            </div>`;

            let checkout = `<div class="bg-white rounded-lg shadow-md p-6 flex flex-col col-span-2  gap-6">
                                <div class="bg-gray-50 p-6 rounded-2xl shadow-md">
                                    <h3 class="text-xl font-semibold mb-4 text-gray-700">Order Summary</h3>
                                    
                                    <div class="flex justify-between mb-2">
                                    <span class="text-gray-600">Subtotal</span>
                                    <span class="font-medium text-gray-800">₹0</span>
                                    </div>

                                    <div class="flex justify-between mb-2">
                                    <span class="text-gray-600">Shipping</span>
                                    <span class="font-medium text-gray-800">₹0</span>
                                    </div>

                                    <div class="flex justify-between border-t pt-4 mt-4">
                                    <span class="text-lg font-bold text-gray-700">Total</span>
                                    <span class="text-lg font-bold text-gray-900">₹0</span>
                                    </div>

                                    <button onclick="startPayment()" class="mt-6 w-full bg-slate-900 hover:bg-slate-600 text-white font-semibold py-3 rounded-xl transition duration-300">
                                    Proceed to Payment
                                    </button>
                                </div>
                            </div>`;
            document.getElementById("item_count").innerHTML = "0";
            document.getElementById("checkout").innerHTML = checkout;
            document.getElementById("item_list").innerHTML = html;
        } else {
            json.data.forEach((element) => {
                html += `<div class="bg-white rounded-lg shadow-md p-6 flex flex-col md:flex-row gap-6 mb-3">        
                    <img src="${element["image"][0]}" alt="${element["image"][0]}" class="rounded-lg w-40 h-40 ">

                    <div class="flex-1 space-y-4">
                            <h2 class="text-2xl font-semibold">${element["name"]}</h2>
                            <p class="text-gray-600">Experience high-quality sound with our wireless headphones. Comfortable design and long battery life.</p>
                            <p class="text-xl font-bold text-green-600">₹${element["price"]}</p>

                        
                            <div class="flex items-center gap-4">
                                <label for="quantity" class="font-medium">Qty:</label>
                                <input type="number" onchange="quantitychange(this)" data-id="${element["id"]}" id="quantity" min="1" value="${element["quantity"]}" class="border rounded px-2 w-20" >
                                <button onclick="removeitem(this)" data-id="${element["id"]}" class="bg-slate-800 hover:bg-slate-600 text-white px-4 py-2 rounded">
                                    Remove Item
                                </button> 
                            </div> 
                        </div>
                    </div>`;
            });
            let checkout = `<div class="bg-white rounded-lg shadow-md p-6 flex flex-col col-span-2  gap-6">
                                <div class="bg-gray-50 p-6 rounded-2xl shadow-md">
                                    <h3 class="text-xl font-semibold mb-4 text-gray-700">Order Summary</h3>
                                    
                                    <div class="flex justify-between mb-2">
                                    <span class="text-gray-600">Subtotal</span>
                                    <span class="font-medium text-gray-800">₹${
                                        json.totalPrice
                                    }</span>
                                    </div>

                                    <div class="flex justify-between mb-2">
                                    <span class="text-gray-600">Shipping</span>
                                    <span class="font-medium text-gray-800">₹5</span>
                                    </div>

                                    <div class="flex justify-between border-t pt-4 mt-4">
                                    <span class="text-lg font-bold text-gray-700">Total</span>
                                    <span class="text-lg font-bold text-gray-900">₹${
                                        json.totalPrice + 5
                                    }</span>
                                    </div>

                                    <button onclick="startPayment()" class="mt-6 w-full bg-slate-900 hover:bg-slate-600 text-white font-semibold py-3 rounded-xl transition duration-300">
                                    Proceed to Payment
                                    </button>
                                </div>
                            </div>`;
            document.getElementById("item_list").innerHTML = html;
            document.getElementById("checkout").innerHTML = checkout;
            document.getElementById("item_count").innerHTML = json.data.length;
        }
    } catch (e) {
        console.log(e);
    }
};

window.removeitem = async function (e) {
    let response = await fetch(
        `http://127.0.0.1:8000/api/removecartitem/${e.getAttribute("data-id")}`,
        {
            method: "DELETE",
            headers: {
                Accept: "application/json",
            },
        }
    );
    let json = await response.json();

    if (json.data == true) {
        let success_error = document.getElementById("success_error");
        success_error.classList.remove("hidden");
        setTimeout(() => {
            success_error.classList.add("hidden");
        }, 3000);

        getData();
    } else {
        let error = document.getElementById("error");
        error.classList.remove("hidden");
        setTimeout(() => {
            error.classList.add("hidden");
        }, 3000);
        getData();
    }
};

window.quantitychange = async function (e) {
    const id = e.getAttribute("data-id"); //product id
    if (e.value < 1) {
        e.value = 1;
        console.log(e.value);
    } else {
        console.log(
            JSON.stringify({
                quantity: parseInt(e.value),
            })
        );
        const id = e.getAttribute("data-id");
        let response = await fetch(
            `http://127.0.0.1:8000/api/updatecartitem/${id}`,
            {
                method: "PUT",

                headers: {
                    Accept: "application/json",
                    "content-type": "application/json",
                },
                body: JSON.stringify({
                    quantity: parseInt(e.value),
                }),
            }
        );
        let json = await response.json();
        if (json.data == true) {
            let success_error = document.getElementById("success_error");
            success_error.classList.remove("hidden");
            document.getElementById("success_message").innerHTML = json.message;
            setTimeout(() => {
                success_error.classList.add("hidden");
            }, 3000);

            getData();
        } else {
            let error = document.getElementById("error");
            error.classList.remove("hidden");
            document.getElementById("error_message").innerHTML = json.message;
            setTimeout(() => {
                error.classList.add("hidden");
            }, 3000);
        }
    }
};

window.startPayment = async function () {
    const res = await fetch("http://127.0.0.1:8000/api/create-order", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
        },
    });

    const data = await res.json();

    const options = {
        key: data.key,
        amount: data.amount,
        currency: "INR",
        order_id: data.order_id,
        name: "BuyNest",
        description: "Test Transaction",
        handler: async function (response) {
            let res = await fetch("http://127.0.0.1:8000/api/payment-webhook", {
                method: "POST",
                headers: {
                    accept: "application/json",
                    "content-type": "application/json",
                },
                body: JSON.stringify({
                    payment_id: response,
                }),
            });
            json = await res.json();
            console.log(json);
            let success_error = document.getElementById("success_error");
            success_error.classList.remove("hidden");
            document.getElementById("success_message").innerHTML =
                "Order placed successfully.";
            setTimeout(() => {
                success_error.classList.add("hidden");
            }, 3000);

            getData();
            // alert("Payment successful! ID: " + response.razorpay_payment_id);
        },
    };

    const rzp = new Razorpay(options);
    rzp.open();
};


window.addToCart= async function(data) {
    const productId = data.getAttribute('data-id');            
    //  updateTheCart(productId)

    //  updateTheCart =async function (productId) {
         try{
            const response = await fetch('http://127.0.0.1:8000/api/addtocart', {
                method: "post",
                headers: {
        
                    'Content-Type': "aplication/json"
                },
                body: JSON.stringify({
                    "product_id": productId
                })
            });
          const json = await response.json();
        
            if (json.status == 200) {
                alert(json.message);
              } else {
              alert(json.message);                   
            }
         }catch(e){
            console.log(e)
         }
     
        
    //  }
  }


  window.getProductlist =async function () {
   const response = await fetch('http://127.0.0.1:8000/api/productlist')
   const json = await response.json()
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

}
