<?php

namespace App\Http\Controllers;

use App\Models\TimeLog;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;

class EmployeeController extends Controller
{
    private function checkAuth()
    {
        if (!Session::has('user_id')) {
            return redirect()->route('login');
        }
        return null;
    }

    public function dashboard()
    {
        $redirect = $this->checkAuth();
        if ($redirect) return $redirect;

        $userId = Session::get('user_id');
        $today = Carbon::today();
        
        $todayLog = TimeLog::where('user_id', $userId)
                          ->whereDate('log_date', $today)
                          ->first();
        
        $recentLogs = TimeLog::where('user_id', $userId)
                            ->orderBy('log_date', 'desc')
                            ->limit(10)
                            ->get();
        
        return view('employee.dashboard', compact('todayLog', 'recentLogs'));
    }

    public function timeIn(Request $request)
    {
        $redirect = $this->checkAuth();
        if ($redirect) return $redirect;

        $userId = Session::get('user_id');
        $today = Carbon::today();
        
        $existingLog = TimeLog::where('user_id', $userId)
                             ->whereDate('log_date', $today)
                             ->first();
        
        if ($existingLog && $existingLog->time_in) {
            return redirect()->route('employee.dashboard')
                            ->with('error', 'You have already timed in today!');
        }
        
        TimeLog::create([
            'user_id' => $userId,
            'time_in' => Carbon::now(),
            'log_date' => $today,
            'notes' => $request->notes,
        ]);
        
        return redirect()->route('employee.dashboard')
                        ->with('success', 'Time in recorded successfully!');
    }

    public function timeOut(Request $request)
    {
        $redirect = $this->checkAuth();
        if ($redirect) return $redirect;

        $userId = Session::get('user_id');
        $today = Carbon::today();
        
        $timeLog = TimeLog::where('user_id', $userId)
                         ->whereDate('log_date', $today)
                         ->first();
        
        if (!$timeLog || !$timeLog->time_in) {
            return redirect()->route('employee.dashboard')
                            ->with('error', 'You need to time in first!');
        }
        
        if ($timeLog->time_out) {
            return redirect()->route('employee.dashboard')
                            ->with('error', 'You have already timed out today!');
        }
        
        $timeLog->update([
            'time_out' => Carbon::now(),
            'notes' => $request->notes ?? $timeLog->notes,
        ]);
        
        return redirect()->route('employee.dashboard')
                        ->with('success', 'Time out recorded successfully!');
    }

    public function myLogs()
    {
        $redirect = $this->checkAuth();
        if ($redirect) return $redirect;

        $userId = Session::get('user_id');
        $logs = TimeLog::where('user_id', $userId)
                      ->orderBy('log_date', 'desc')
                      ->paginate(15);
        
        return view('employee.logs', compact('logs'));
    }
}