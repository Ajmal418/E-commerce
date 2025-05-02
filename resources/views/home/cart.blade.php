@extends('layouts.app')
@section('content')
    <div class="max-w-6xl mx-auto p-6 ">

        <!-- Header / Cart Icon -->
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold">Awesome Store</h1>
            <div class="relative">
                <button class="relative">
                    <svg class="w-8 h-8 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 3h2l.4 2M7 13h14l-1.5 8H6L4 6h16"></path>
                    </svg>
                    <span id="item_count"
                        class=" absolute top-0 right-0 bg-red-500 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center"
                        x-text="cart"></span>
                </button>
            </div>
        </div>
        <!-- Error Section -->
        <div id="success_error" class="hidden">
            <div id="success_message"
                class="flex items-center p-4 mb-4 text-sm text-green-700 bg-green-100 rounded-lg border border-green-300"
                role="alert">
                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd"
                        d="M2 10a8 8 0 1116 0A8 8 0 012 10zm8-5a1 1 0 00-1 1v4H7a1 1 0 000 2h4v4a1 1 0 002 0v-4h4a1 1 0 000-2h-4V6a1 1 0 00-1-1h-2z"
                        clip-rule="evenodd" />
                </svg>
                <span class="font-medium">Success alert!</span> Cart Item Removed
            </div>
        </div>
        <div id="error" class="hidden">
            <div id="error_message"
                class="flex items-center p-4 mb-4 text-sm text-red-700 bg-red-100 rounded-lg border border-red-300"
                role="alert">
                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd"
                        d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-3a1 1 0 00-1 1v3a1 1 0 102 0V8a1 1 0 00-1-1zm-1 7a1 1 0 112 0 1 1 0 01-2 0z"
                        clip-rule="evenodd" />
                </svg>
                <span class="font-medium">Error alert!</span> Cart Item Not Removed
            </div>
        </div>
        <!-- Product Display -->
        <div class="grid lg:grid-cols-5  sm:gap-4">
            <div id="item_list" class="lg:col-span-3 ">

            </div>
            <div id="checkout" class="lg:col-span-2">

            </div>
        </div>

    </div>
@endsection
@section('script')

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            getData();
        });
       
    </script>
@endsection
