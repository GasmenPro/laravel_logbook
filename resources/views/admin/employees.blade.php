{{-- resources/views/admin/employees.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold">Employees</h1>
        <a href="{{ route('admin.dashboard') }}" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">
            Back to Dashboard
        </a>
    </div>
    
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <table class="min-w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Employee ID</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Name</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Email</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($employees as $employee)
                <tr>
                    <td class="px-6 py-4">{{ $employee->employee_id }}</td>
                    <td class="px-6 py-4">{{ $employee->name }}</td>
                    <td class="px-6 py-4">{{ $employee->email }}</td>
                    <td class="px-6 py-4">
                        <a href="{{ route('admin.employee-logs', $employee->id) }}" 
                           class="text-blue-600 hover:text-blue-800">
                            View Logs
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection