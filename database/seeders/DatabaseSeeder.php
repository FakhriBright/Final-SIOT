<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Device;
use App\Models\Sensor;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Seed Users
        User::updateOrCreate(
            ['email' => 'admin@iot.local'],
            [
                'name' => 'Administrator',
                'password' => Hash::make('password'),
                'role' => 'admin',
            ]
        );

        User::updateOrCreate(
            ['email' => 'user@iot.local'],
            [
                'name' => 'Regular User',
                'password' => Hash::make('password'),
                'role' => 'user',
            ]
        );

        // Seed Devices
        Device::updateOrCreate(
            ['serial_number' => 'ESP32_001'],
            [
                'nama_device' => 'ESP32 Smart Home',
                'mqtt_client_id' => 'ESP32_001_Client',
                'topic_prefix' => 'fakhri',
                'status' => 'offline',
                'last_seen' => null,
            ]
        );

        // Seed Sensors
        Sensor::updateOrCreate(
            ['nama_sensor' => 'Suhu'],
            [
                'lokasi' => 'Living Room',
                'nilai' => 24,
                'status' => true,
            ]
        );

        Sensor::updateOrCreate(
            ['nama_sensor' => 'Kelembapan'],
            [
                'lokasi' => 'Living Room',
                'nilai' => 60,
                'status' => true,
            ]
        );
    }
}
