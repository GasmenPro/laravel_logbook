{{-- resources/views/auth/login.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="max-w-md mx-auto bg-white rounded-lg shadow-md p-6">
    <h2 class="text-2xl font-bold mb-6 text-center">Employee Logbook Login</h2>
    
    <form action="{{ route('login.post') }}" method="POST">
        @csrf
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2">Email Address</label>
            <input type="email" name="email" required 
                   class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:border-blue-500">
        </div>
        
        <div class="mb-6">
            <label class="block text-gray-700 text-sm font-bold mb-2">Employee ID</label>
            <input type="text" name="employee_id" required 
                   class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:border-blue-500">
        </div>
        
        <button type="submit" 
                class="w-full bg-blue-500 text-white font-bold py-2 px-4 rounded hover:bg-blue-600">
            Login
        </button>
    </form>
    
    <div class="mt-4 text-sm text-gray-600">
        <p class="font-semibold">Demo Credentials:</p>
        <p>Admin: admin@example.com / EMP001</p>
        <p>Employee 1: john@example.com / EMP002</p>
        <p>Employee 2: jane@example.com / EMP003</p>
    </div>
</div>
@endsection