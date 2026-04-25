{{-- resources/views/admin/employee-logs.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-3xl font-bold">{{ $employee->name }}'s Logs</h1>
            <p class="text-gray-600">Employee ID: {{ $employee->employee_id }}</p>
        </div>
        <a href="{{ route('admin.employees') }}" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">
            Back to Employees
        </a>
    </div>
    
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <table class="min-w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Time In</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Time Out</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Duration</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Notes</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($logs as $log)
                <tr>
                    <td class="px-6 py-4">{{ $log->log_date->format('F d, Y') }}</td>
                    <td class="px-6 py-4">{{ $log->time_in ? $log->time_in->format('h:i A') : '-' }}</td>
                    <td class="px-6 py-4">{{ $log->time_out ? $log->time_out->format('h:i A') : '-' }}</td>
                    <td class="px-6 py-4">{{ $log->work_duration }}</td>
                    <td class="px-6 py-4">{{ $log->notes ?? '-' }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-4 text-center text-gray-500">No logs found</td>
                </tr>
                @endforelse
            </tbody>
        </table>
        
        <div class="px-6 py-4">
            {{ $logs->links() }}
        </div>
    </div>
</div>
@endsection