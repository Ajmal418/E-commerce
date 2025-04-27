<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="{{asset('css/app.css')}}">
    <link href='https://fonts.googleapis.com/css?family=Poppins' rel='stylesheet'>
    <script src="https://cdn.tailwindcss.com"></script>
    
</head>

<body class="bg-gray-100 min-h-screen">

    <div class="flex relative">
        <!-- Sidebar -->
        <aside class="w-64 bg-white shadow-md h-screen p-6 sticky top-0  overflow-y-auto">
            {{-- @extends('admin.sidebar') --}}
            <div>
                <h2 class="text-xl font-bold mb-4">E-Commerce</h2>
                <nav>
                    <ul class="space-y-2">
                        {{-- <li><a href="#" class="block p-2 rounded hover:bg-gray-200 text-lg text-green-500 font-bold">{{strtoupper(substr(Auth::user()->name, 0, 1))}}</a></li> --}}
                        <li><a href="#" class="block p-2 rounded hover:bg-gray-200 text-lg text-green-500 font-bold">{{ucfirst(Auth::user()->name)}}</a></li>
                        <li><a href="{{ route('admin.dashboard') }}"
                            class="block p-2 rounded hover:bg-gray-200">Dashboard</a></li>
                            <li><a href="{{ route('products') }}" class="block p-2 rounded hover:bg-gray-200">Upload
                                Product</a></li>
                                <li><a href="{{route('admin.logout')}}" class="block p-2 rounded hover:bg-gray-200">logout</a></li>
                    </ul>
                </nav>
            </div>

        </aside>

        <!-- Main Content -->
        <main class="flex-1 p-8 overflow-y-auto">

            @yield('content')


        </main>
    </div>

</body>

</html>
