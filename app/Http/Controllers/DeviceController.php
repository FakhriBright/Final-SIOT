<?php

namespace App\Http\Controllers;

use App\Models\Device;
use Illuminate\Http\Request;

class DeviceController extends Controller
{
    public function index()
    {
        $devices = Device::latest()->get();
        return view('devices.index', compact('devices'));
    }

    public function create()
    {
        return view('devices.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_device' => 'required|string|max:255',
            'serial_number' => 'required|string|unique:devices,serial_number',
            'mqtt_client_id' => 'nullable|string|max:255',
            'topic_prefix' => 'required|string|max:255',
        ]);

        Device::create($request->all());

        return redirect()->route('device.index')->with('success', 'Device berhasil ditambahkan');
    }

    public function edit(Device $device)
    {
        return view('devices.edit', compact('device'));
    }

    public function update(Request $request, Device $device)
    {
        $request->validate([
            'nama_device' => 'required|string|max:255',
            'serial_number' => 'required|string|unique:devices,serial_number,' . $device->id,
            'mqtt_client_id' => 'nullable|string|max:255',
            'topic_prefix' => 'required|string|max:255',
        ]);

        $device->update($request->all());

        return redirect()->route('device.index')->with('success', 'Device berhasil diupdate');
    }

    public function destroy(Device $device)
    {
        $device->delete();

        return redirect()->route('device.index')->with('success', 'Device berhasil dihapus');
    }
}