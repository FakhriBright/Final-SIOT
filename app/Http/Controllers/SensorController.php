<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sensor;

class SensorController extends Controller
{
    // TAMPIL DATA SENSOR
    public function index()
    {
        $sensors = Sensor::all();
        return view('sensor.index', compact('sensors'));
    }

    // FORM TAMBAH SENSOR
    public function create()
    {
        return view('sensor.create');
    }

    // SIMPAN SENSOR
    public function store(Request $request)
    {
        $request->validate([
            'nama_sensor' => 'required',
            'lokasi' => 'required',
            'nilai' => 'required',
        ]);

        Sensor::create([
            'nama_sensor' => $request->nama_sensor,
            'lokasi' => $request->lokasi,
            'nilai' => $request->nilai,
            'status' => true,
        ]);

        return redirect('/sensor')->with('success', 'Sensor berhasil ditambahkan');
    }

    // FORM EDIT
    public function edit($id)
    {
        $sensor = Sensor::findOrFail($id);
        return view('sensor.edit', compact('sensor'));
    }

    // UPDATE SENSOR
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_sensor' => 'required',
            'lokasi' => 'required',
            'nilai' => 'required',
        ]);

        $sensor = Sensor::findOrFail($id);

        $sensor->update([
            'nama_sensor' => $request->nama_sensor,
            'lokasi' => $request->lokasi,
            'nilai' => $request->nilai,
            'status' => $request->status ?? true,
        ]);

        return redirect('/sensor')->with('success', 'Sensor berhasil diupdate');
    }

    // DELETE SENSOR
    public function destroy($id)
    {
        Sensor::destroy($id);

        return redirect('/sensor')->with('success', 'Sensor berhasil dihapus');
    }
}