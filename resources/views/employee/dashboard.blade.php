{{-- resources/views/employee/dashboard.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto">
    <h1 class="text-3xl font-bold mb-6">Employee Dashboard</h1>
    
    <div class="grid md:grid-cols-2 gap-6 mb-8">
        {{-- Time In Card --}}
        <div class="bg-white rounded-lg shadow-md p-6">
            <h3 class="text-xl font-semibold mb-4">Time In</h3>
            @if(!$todayLog || !$todayLog->time_in)
                <form action="{{ route('employee.time-in') }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm mb-2">Notes (Optional)</label>
                        <textarea name="notes" rows="3" 
                                  class="w-full px-3 py-2 border border-gray-300 rounded"></textarea>
                    </div>
                    <button type="submit" 
                            class="w-full bg-green-500 text-white font-bold py-2 px-4 rounded hover:bg-green-600">
                        <i class="fas fa-clock"></i> Time In
                    </button>
                </form>
            @else
                <div class="text-center py-4">
                    <div class="text-green-600 text-2xl mb-2">✓ Already Timed In</div>
                    <p class="text-gray-600">Time: {{ $todayLog->time_in->format('h:i A') }}</p>
                </div>
            @endif
        </div>
        
        {{-- Time Out Card --}}
        <div class="bg-white rounded-lg shadow-md p-6">
            <h3 class="text-xl font-semibold mb-4">Time Out</h3>
            @if($todayLog && $todayLog->time_in && !$todayLog->time_out)
                <form action="{{ route('employee.time-out') }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm mb-2">Notes (Optional)</label>
                        <textarea name="notes" rows="3" 
                                  class="w-full px-3 py-2 border border-gray-300 rounded"></textarea>
                    </div>
                    <button type="submit" 
                            class="w-full bg-red-500 text-white font-bold py-2 px-4 rounded hover:bg-red-600">
                        <i class="fas fa-sign-out-alt"></i> Time Out
                    </button>
                </form>
            @elseif($todayLog && $todayLog->time_out)
                <div class="text-center py-4">
                    <div class="text-blue-600 text-2xl mb-2">✓ Already Timed Out</div>
                    <p class="text-gray-600">Time: {{ $todayLog->time_out->format('h:i A') }}</p>
                </div>
            @else
                <div class="text-center py-4 text-gray-500">
                    Please time in first
                </div>
            @endif
        </div>
    </div>
    
    {{-- Today's Status --}}
    @if($todayLog)
        <div class="bg-white rounded-lg shadow-md p-6 mb-8">
            <h3 class="text-xl font-semibold mb-4">Today's Log</h3>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <p class="text-gray-600">Time In:</p>
                    <p class="font-semibold">{{ $todayLog->time_in ? $todayLog->time_in->format('h:i A') : 'Not yet' }}</p>
                </div>
                <div>
                    <p class="text-gray-600">Time Out:</p>
                    <p class="font-semibold">{{ $todayLog->time_out ? $todayLog->time_out->format('h:i A') : 'Not yet' }}</p>
                </div>
                <div class="col-span-2">
                    <p class="text-gray-600">Duration:</p>
                    <p class="font-semibold">{{ $todayLog->work_duration }}</p>
                </div>
                @if($todayLog->notes)
                <div class="col-span-2">
                    <p class="text-gray-600">Notes:</p>
                    <p>{{ $todayLog->notes }}</p>
                </div>
                @endif
            </div>
        </div>
    @endif
    
    {{-- Recent Logs --}}
    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-xl font-semibold">Recent Logs</h3>
            <a href="{{ route('employee.my-logs') }}" class="text-blue-500 hover:text-blue-700">View All →</a>
        </div>
        
        <div class="overflow-x-auto">
            <table class="min-w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Time In</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Time Out</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Duration</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($recentLogs as $log)
                    <tr>
                        <td class="px-6 py-4">{{ $log->log_date->format('M d, Y') }}</td>
                        <td class="px-6 py-4">{{ $log->time_in ? $log->time_in->format('h:i A') : '-' }}</td>
                        <td class="px-6 py-4">{{ $log->time_out ? $log->time_out->format('h:i A') : '-' }}</td>
                        <td class="px-6 py-4">{{ $log->work_duration }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection