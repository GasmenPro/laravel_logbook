<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\TimeLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;

class AdminController extends Controller
{
    private function checkAdmin()
    {
        if (!Session::has('user_id') || Session::get('user_role') !== 'admin') {
            return redirect()->route('login');
        }
        return null;
    }

    public function dashboard()
    {
        $redirect = $this->checkAdmin();
        if ($redirect) return $redirect;

        $today = Carbon::today();
        $totalEmployees = User::where('role', 'employee')->count();
        $presentToday = TimeLog::whereDate('log_date', $today)
                              ->whereNotNull('time_in')
                              ->count();
        
        $recentLogs = TimeLog::with('user')
                            ->orderBy('created_at', 'desc')
                            ->limit(10)
                            ->get();
        
        $employees = User::where('role', 'employee')->get();
        
        return view('admin.dashboard', compact('totalEmployees', 'presentToday', 'recentLogs', 'employees'));
    }

    public function employees()
    {
        $redirect = $this->checkAdmin();
        if ($redirect) return $redirect;

        $employees = User::where('role', 'employee')->orderBy('name')->get();
        return view('admin.employees', compact('employees'));
    }

    public function employeeLogs($id)
    {
        $redirect = $this->checkAdmin();
        if ($redirect) return $redirect;

        $employee = User::findOrFail($id);
        $logs = TimeLog::where('user_id', $id)
                      ->orderBy('log_date', 'desc')
                      ->paginate(20);
        
        return view('admin.employee-logs', compact('employee', 'logs'));
    }

    public function allLogs(Request $request)
    {
        $redirect = $this->checkAdmin();
        if ($redirect) return $redirect;

        $query = TimeLog::with('user');
        
        if ($request->has('date_from') && $request->date_from) {
            $query->whereDate('log_date', '>=', $request->date_from);
        }
        
        if ($request->has('date_to') && $request->date_to) {
            $query->whereDate('log_date', '<=', $request->date_to);
        }
        
        if ($request->has('employee_id') && $request->employee_id) {
            $query->where('user_id', $request->employee_id);
        }
        
        $logs = $query->orderBy('log_date', 'desc')
                     ->orderBy('time_in', 'desc')
                     ->paginate(20);
        
        $employees = User::where('role', 'employee')->get();
        
        return view('admin.all-logs', compact('logs', 'employees'));
    }

    public function editLog($id)
    {
        $redirect = $this->checkAdmin();
        if ($redirect) return $redirect;

        $log = TimeLog::with('user')->findOrFail($id);
        return view('admin.edit-log', compact('log'));
    }

    public function updateLog(Request $request, $id)
    {
        $redirect = $this->checkAdmin();
        if ($redirect) return $redirect;

        $request->validate([
            'time_in' => 'required|date',
            'time_out' => 'nullable|date|after:time_in',
            'notes' => 'nullable|string',
        ]);

        $log = TimeLog::findOrFail($id);
        $log->update([
            'time_in' => $request->time_in,
            'time_out' => $request->time_out,
            'notes' => $request->notes,
        ]);

        return redirect()->route('admin.all-logs')
                        ->with('success', 'Log updated successfully!');
    }
}