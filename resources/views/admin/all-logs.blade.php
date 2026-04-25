{{-- resources/views/admin/all-logs.blade.phpsdsdsd --}}
@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold">All Time Logs</h1>
        <a href="{{ route('admin.dashboard') }}" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">
            Back to Dashboard
        </a>
    </div>
    
    {{-- Filter Form --}}
    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
        <form method="GET" action="{{ route('admin.all-logs') }}" class="grid md:grid-cols-4 gap-4">
            <div>
                <label class="block text-gray-700 text-sm font-bold mb-2">Date From</label>
                <input type="date" name="date_from" value="{{ request('date_from') }}" 
                       class="w-full px-3 py-2 border border-gray-300 rounded">
            </div>
            <div>
                <label class="block text-gray-700 text-sm font-bold mb-2">Date To</label>
                <input type="date" name="date_to" value="{{ request('date_to') }}" 
                       class="w-full px-3 py-2 border border-gray-300 rounded">
            </div>
            <div>
                <label class="block text-gray-700 text-sm font-bold mb-2">Employee</label>
                <select name="employee_id" class="w-full px-3 py-2 border border-gray-300 rounded">
                    <option value="">All Employees</option>
                    @foreach($employees as $employee)
                        <option value="{{ $employee->id }}" {{ request('employee_id') == $employee->id ? 'selected' : '' }}>
                            {{ $employee->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="flex items-end">
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 w-full">
                    Filter
                </button>
            </div>
        </form>
    </div>
    
    {{-- Logs Table --}}
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <table class="min-w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Employee</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Time In</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Time Out</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Duration</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($logs as $log)
                <tr>
                    <td class="px-6 py-4">{{ $log->user->name }}</td>
                    <td class="px-6 py-4">{{ $log->log_date->format('M d, Y') }}</td>
                    <td class="px-6 py-4">{{ $log->time_in ? $log->time_in->format('h:i A') : '-' }}</td>
                    <td class="px-6 py-4">{{ $log->time_out ? $log->time_out->format('h:i A') : '-' }}</td>
                    <td class="px-6 py-4">{{ $log->work_duration }}</td>
                    <td class="px-6 py-4">
                        <a href="{{ route('admin.edit-log', $log->id) }}" 
                           class="text-blue-600 hover:text-blue-800">
                            Edit
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-4 text-center text-gray-500">No logs found</td>
                </tr>
                @endforelse
            </tbody>
        </table>
        
        <div class="px-6 py-4">
            {{ $logs->appends(request()->query())->links() }}
        </div>
    </div>
</div>
@endsection