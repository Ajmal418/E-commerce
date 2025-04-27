@extends('admin.app')
@section('content')
    <div>
        <h1 class="text-2xl font-bold mb-6">Dashboard</h1>

        <!-- Stats Section -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
            <div class="bg-white p-6 rounded-xl shadow">
                <h3 class="text-lg font-semibold">Users</h3>
                <p class="mt-2 text-gray-600">1,245</p>
            </div>
            <div class="bg-white p-6 rounded-xl shadow">
                <h3 class="text-lg font-semibold">Revenue</h3>
                <p class="mt-2 text-gray-600">$34,210</p>
            </div>
            <div class="bg-white p-6 rounded-xl shadow">
                <h3 class="text-lg font-semibold">Performance</h3>
                <p class="mt-2 text-gray-600">98%</p>
            </div>
        </div>
        @if (Session::has('success'))
     <div class="flex items-center p-4 mb-4 text-sm text-green-700 bg-green-100 rounded-lg border border-green-300" role="alert">
        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
          <path fill-rule="evenodd" d="M2 10a8 8 0 1116 0A8 8 0 012 10zm8-5a1 1 0 00-1 1v4H7a1 1 0 000 2h4v4a1 1 0 002 0v-4h4a1 1 0 000-2h-4V6a1 1 0 00-1-1h-2z" clip-rule="evenodd" />
        </svg>
        <span class="font-medium">Success alert!</span> {{Session::get('success')}}
      </div>
      @endif
        <table class="min-w-full table-auto border-collapse border border-gray-200">
            <thead>
                <tr class="bg-gray-100">
                    <th class="px-6 py-3 text-left text-sm font-medium text-gray-500">#</th>
                    <th class="px-6 py-3 text-left text-sm font-medium text-gray-500">Prodcut Name</th>
                    <th class="px-6 py-3 text-left text-sm font-medium text-gray-500">Product Price</th>
                    <th class="px-6 py-3 text-left text-sm font-medium text-gray-500">Product Images</th>
                    <th class="px-6 py-3 text-left text-sm font-medium text-gray-500">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($products as $key => $product)
                    <tr class="border-t border-gray-200">
                        <td class="px-6 py-4 text-sm text-gray-700">1</td>
                        <td class="px-6 py-4 text-sm text-gray-700">{{ $product['name'] }}</td>
                        <td class="px-6 py-4 text-sm text-gray-700">{{ $product['price'] }}</td>
                        <td class="px-6 py-4 text-sm text-gray-700 ">
                            <div class="flex">
                                @foreach (json_decode($product['image']) as $img)
                                <img src="{{ asset('assets/product/' . $img) }}" class="w-20 h-20"
                                alt="{{ $img }}">
                                @endforeach
                            </div>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-700">
                                <button class="btn bg-green-600 py-2 px-4 rounded-md text-white"><a href="{{route('products.edit',$product['id'])}}">Edit</a></button>
                                <button class="btn bg-red-600 py-2 px-4 rounded-md text-white"><a href="{{route('products.destroy',$product['id'])}}">Delete</a></button>
                                
                        </td>

                    </tr>
                @endforeach

            </tbody>
        </table>

    </div>
@endsection
