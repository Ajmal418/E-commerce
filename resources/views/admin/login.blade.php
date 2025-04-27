<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">

    <div class="w-full max-w-md bg-white p-8 rounded-xl shadow-lg">
        @if (Session::has('status'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
           
            <span class="block sm:inline">{{Session::get('status')}}</span>
            <span class="absolute top-0 bottom-0 right-0 px-4 py-3">
              <svg class="fill-current h-6 w-6 text-red-500" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><title>Close</title><path d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z"/></svg>
            </span>
          </div>
        @endif
        <h2 class="text-2xl font-semibold mb-6 text-center">Admin Login</h2>
        <form method="POST" action="{{ route('admin.login') }}">
            @csrf             
            <div class="mb-4">
                <label class="block mb-1 text-sm font-medium text-gray-700" for="email">Email</label>
                <input type="email" name="email" required value="{{ old('email') }}"  class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400">
                @error('email')
                <span class="text-red-700">{{ $message }}</span>
                @enderror
            </div>
            
            <div class="mb-4">
                <label class="block mb-1 text-sm font-medium text-gray-700" for="password">Password</label>
                <input type="password" name="password"  required  class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400">
                @error('password')
                <div class="text-red-700">{{ $message }}</div>
                @enderror
            </div>

            

            <button type="submit" class="w-full bg-blue-800 text-white py-2 rounded-lg hover:bg-blue-700">Login</button>
        </form>
    </div>

</body>
</html>
