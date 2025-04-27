<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>BuyNest - Home</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link href='https://fonts.googleapis.com/css?family=Poppins' rel='stylesheet'>
</head>

<body class="bg-gray-100 text-gray-800 relative">

    <!-- Navbar -->
    <nav class="bg-[#0B0B0B] shadow-md">
      <div class="max-w-7xl mx-auto px-4 py-4 flex justify-between items-center">
          <h1 class="text-2xl font-bold text-white">BuyNest</h1>
          <ul class="flex gap-6 font-medium">
              <li><a href="{{route('home.index')}}" class="hover:text-slate-200 text-white">Home</a></li>
              <li><a href="{{route('home.index')}}" class="hover:text-slate-200 text-white">Shop</a></li>
              <li><a href="{{route('home.cart')}}" class="hover:text-slate-200 text-white">Cart</a></li>
              {{-- <li><a href="#" class="hover:text-slate-200 text-white">Contact</a></li> --}}
          </ul>
      </div>
  </nav>

   

      @yield('content')

    <!-- Footer -->
    <footer class="bg-white mt-12 py-6 text-center shadow-inner w-full">
        <p class="text-gray-500">&copy; 2025 BuyNest . All rights reserved.</p>
    </footer>

    @yield('script')
    
</body>

</html>
