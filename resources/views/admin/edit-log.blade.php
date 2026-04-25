{{-- resources/views/admin/edit-log.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold">Edit Time Log</h1>
        <a href="{{ route('admin.all-logs') }}" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">
            Back to Logs
        </a>
    </div>
    
    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="mb-4">
            <p class="text-gray-600"><strong>Employee:</strong> {{ $log->user->name }}</p>
            <p class="text-gray-600"><strong>Date:</strong> {{ $log->log_date->format('F d, Y') }}</p>
        </div>
        
        <form action="{{ route('admin.update-log', $log->id) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Time In</label>
                <input type="datetime-local" name="time_in" value="{{ $log->time_in ? $log->time_in->format('Y-m-d\TH:i') : '' }}" 
                       required class="w-full px-3 py-2 border border-gray-300 rounded">
            </div>
            
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Time Out</label>
                <input type="datetime-local" name="time_out" value="{{ $log->time_out ? $log->time_out->format('Y-m-d\TH:i') : '' }}" 
                       class="w-full px-3 py-2 border border-gray-300 rounded">
            </div>
            
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Notes</label>
                <textarea name="notes" rows="3" class="w-full px-3 py-2 border border-gray-300 rounded">{{ $log->notes }}</textarea>
            </div>
            
            <button type="submit" class="w-full bg-blue-500 text-white font-bold py-2 px-4 rounded hover:bg-blue-600">
                Update Log
            </button>
        </form>
    </div>
</div>
@endsection