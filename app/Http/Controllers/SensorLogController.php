<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SensorLog;
use App\Models\Device;
use App\Models\Sensor;
use Illuminate\Support\Carbon;

class SensorLogController extends Controller
{
    /**
     * Store a new sensor log via API.
     */
    public function store(Request $request)
    {
        $request->validate([
            'topic' => 'required|string',
            'value' => 'required|string',
        ]);

        $topic = $request->input('topic');
        $value = $request->input('value');

        // Resolve device and type
        $device = null;
        $type = 'unknown';

        // Detect type from topic
        if (str_ends_with($topic, '/suhu')) {
            $type = 'suhu';
        } elseif (str_ends_with($topic, '/kelembapan')) {
            $type = 'kelembapan';
        } elseif (str_ends_with($topic, '/status')) {
            $type = 'status';
        } elseif (str_ends_with($topic, '/servo')) {
            $type = 'servo';
        } elseif (str_ends_with($topic, '/lcd')) {
            $type = 'lcd';
        }

        // Try to match device serial number in topic (e.g. fakhri/ESP32_001/status)
        // Matches fakhri/{serial_number}/status
        if ($type === 'status') {
            $parts = explode('/', $topic);
            if (count($parts) >= 3) {
                $serialNumber = $parts[count($parts) - 2];
                $device = Device::where('serial_number', $serialNumber)->first();
            }
        }

        // Fallback: Resolve by topic prefix
        if (!$device) {
            $parts = explode('/', $topic);
            $prefix = $parts[0] ?? '';
            if ($prefix) {
                $device = Device::where('topic_prefix', $prefix)->first();
            }
        }

        // Update device status and last_seen if this is a status log
        if ($device) {
            if ($type === 'status') {
                $device->update([
                    'status' => strtolower($value) === 'online' ? 'online' : 'offline',
                    'last_seen' => Carbon::now(),
                ]);
            } else {
                $device->update([
                    'last_seen' => Carbon::now(),
                ]);
            }

            // Sync values to the old sensors table for compatibility
            if ($type === 'suhu' || $type === 'kelembapan') {
                $sensorName = $type === 'suhu' ? 'Suhu' : 'Kelembapan';
                $sensor = Sensor::where('nama_sensor', $sensorName)->first();
                if ($sensor) {
                    $sensor->update([
                        'nilai' => (int)$value,
                        'status' => $device->status === 'online',
                    ]);
                }
            }
        }

        // Create log entry
        $log = SensorLog::create([
            'device_id' => $device ? $device->id : null,
            'topic' => $topic,
            'type' => $type,
            'value' => $value,
            'status' => $device ? $device->status : 'unknown',
        ]);

        return response()->json([
            'status' => 'success',
            'data' => $log,
        ], 201);
    }

    /**
     * Display log history list.
     */
    public function history(Request $request)
    {
        $query = SensorLog::with('device');

        // Search
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function($q) use ($search) {
                $q->where('topic', 'like', "%{$search}%")
                  ->orWhere('type', 'like', "%{$search}%")
                  ->orWhere('value', 'like', "%{$search}%")
                  ->orWhereHas('device', function($dq) use ($search) {
                      $dq->where('nama_device', 'like', "%{$search}%")
                        ->orWhere('serial_number', 'like', "%{$search}%");
                  });
            });
        }

        // Filter Device
        if ($request->filled('device_id')) {
            $query->where('device_id', $request->input('device_id'));
        }

        // Filter Type
        if ($request->filled('type')) {
            $query->where('type', $request->input('type'));
        }

        // Sorting
        $sortField = $request->input('sort', 'created_at');
        $sortOrder = $request->input('direction', 'desc');
        
        $allowedSorts = ['created_at', 'type', 'value'];
        if (!in_array($sortField, $allowedSorts)) {
            $sortField = 'created_at';
        }
        if (!in_array($sortOrder, ['asc', 'desc'])) {
            $sortOrder = 'desc';
        }

        $query->orderBy($sortField, $sortOrder);

        // Export CSV
        if ($request->has('export')) {
            return $this->exportCsv($query->get());
        }

        $logs = $query->paginate(15)->withQueryString();
        $devices = Device::all();
        $types = ['suhu', 'kelembapan', 'status', 'servo', 'lcd'];

        return view('sensor.history', compact('logs', 'devices', 'types'));
    }

    /**
     * Export logs to CSV.
     */
    private function exportCsv($logs)
    {
        $filename = "sensor_logs_" . Carbon::now()->format('Y-m-d_H-i-s') . ".csv";
        $headers = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$filename",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $callback = function() use($logs) {
            $file = fopen('php://output', 'w');
            
            // CSV Headings
            fputcsv($file, ['ID', 'Device Name', 'Serial Number', 'Topic', 'Type', 'Value', 'Status', 'Timestamp']);

            foreach ($logs as $log) {
                fputcsv($file, [
                    $log->id,
                    $log->device ? $log->device->nama_device : 'N/A',
                    $log->device ? $log->device->serial_number : 'N/A',
                    $log->topic,
                    ucfirst($log->type),
                    $log->value,
                    ucfirst($log->status),
                    $log->created_at->format('Y-m-d H:i:s')
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
