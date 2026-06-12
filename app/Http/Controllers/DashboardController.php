<?php

namespace App\Http\Controllers;

use App\Models\Device;
use App\Models\Sensor;
use App\Models\User;
use App\Models\SensorLog;

class DashboardController extends Controller
{
    public function index()
    {
        $devices = Device::latest()->get();
        $sensors = Sensor::latest()->get();
        $userCount = User::count();
        $deviceCount = Device::count();
        $logsCount = SensorLog::count();

        // Get recent logs for initial activity feed (e.g. latest 10 logs)
        $recentLogs = SensorLog::with('device')->latest()->take(10)->get();

        return view('dashboard.index', compact(
            'devices',
            'sensors',
            'userCount',
            'deviceCount',
            'logsCount',
            'recentLogs'
        ));
    }
}