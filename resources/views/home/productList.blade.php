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
      document.addEventListener('DOMContentLoaded', () => {
                getProductlist();
        });
</script>
@endsection
