{{-- resources/views/admin/dashboard.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto">
    <h1 class="text-3xl font-bold mb-6">Admin Dashboard</h1>
    
    {{-- Stats Cards --}}
    <div class="grid md:grid-cols-4 gap-6 mb-8">
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="text-3xl font-bold text-blue-600">{{ $totalEmployees }}</div>
            <div class="text-gray-600">Total Employees</div>
        </div>
        
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="text-3xl font-bold text-green-600">{{ $presentToday }}</div>
            <div class="text-gray-600">Present Today</div>
        </div>
        
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="text-3xl font-bold text-yellow-600">{{ $totalEmployees - $presentToday }}</div>
            <div class="text-gray-600">Absent Today</div>
        </div>
        
        <div class="bg-white rounded-lg shadow-md p-6">
            <a href="{{ route('admin.all-logs') }}" class="block">
                <div class="text-3xl font-bold text-purple-600">View All</div>
                <div class="text-gray-600">Time Logs</div>
            </a>
        </div>
    </div>
    
    {{-- Quick Actions --}}
    <div class="grid md:grid-cols-2 gap-6 mb-8">
        <div class="bg-white rounded-lg shadow-md p-6">
            <h3 class="text-xl font-semibold mb-4">Quick Navigation</h3>
            <div class="space-y-2">
                <a href="{{ route('admin.employees') }}" class="block text-blue-600 hover:text-blue-800">
                    → Manage Employees
                </a>
                <a href="{{ route('admin.all-logs') }}" class="block text-blue-600 hover:text-blue-800">
                    → View All Time Logs
                </a>
            </div>
        </div>
        
        <div class="bg-white rounded-lg shadow-md p-6">
            <h3 class="text-xl font-semibold mb-4">Today's Summary</h3>
            <div class="space-y-2">
                @foreach($employees as $employee)
                    @php
                        $todayLog = $employee->timeLogs()->whereDate('log_date', now())->first();
                    @endphp
                    <div class="flex justify-between items-center">
                        <span>{{ $employee->name }}</span>
                        @if($todayLog && $todayLog->time_in)
                            <span class="text-green-600 text-sm">
                                In: {{ $todayLog->time_in->format('h:i A') }}
                                @if($todayLog->time_out)
                                    | Out: {{ $todayLog->time_out->format('h:i A') }}
                                @endif
                            </span>
                        @else
                            <span class="text-red-600 text-sm">Not timed in</span>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    
    {{-- Recent Logs --}}
    <div class="bg-white rounded-lg shadow-md p-6">
        <h3 class="text-xl font-semibold mb-4">Recent Time Logs</h3>
        <div class="overflow-x-auto">
            <table class="min-w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Employee</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Time In</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Time Out</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Duration</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($recentLogs as $log)
                    <tr>
                        <td class="px-6 py-4">{{ $log->user->name }}</td>
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