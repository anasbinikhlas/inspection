<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Location;

class LocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $locations = [
            [
                'name' => 'Downtown Center - Main Office',
                'code' => 'DTC',
                'address' => 'Main Boulevard, Block A, Commercial Area',
                'city' => 'Karachi',
                'state' => 'Sindh',
                'zip_code' => '75500',
                'latitude' => 24.8607,
                'longitude' => 67.0011,
                'phone' => '+92-21-1234-5678',
                'email' => 'downtown@proinspect.com',
                'operating_hours' => [
                    'monday' => ['open' => '09:00', 'close' => '18:00'],
                    'tuesday' => ['open' => '09:00', 'close' => '18:00'],
                    'wednesday' => ['open' => '09:00', 'close' => '18:00'],
                    'thursday' => ['open' => '09:00', 'close' => '18:00'],
                    'friday' => ['open' => '09:00', 'close' => '18:00'],
                    'saturday' => ['open' => '10:00', 'close' => '16:00'],
                    'sunday' => null // Closed
                ],
                'services_offered' => ['basic', 'comprehensive', 'premium'],
                'mobile_service' => false,
                'max_daily_appointments' => 25,
                'status' => 'active'
            ],
            [
                'name' => 'North Branch - Industrial Area',
                'code' => 'NBA',
                'address' => 'Industrial Area, Sector 15, North Nazimabad',
                'city' => 'Karachi',
                'state' => 'Sindh',
                'zip_code' => '74700',
                'latitude' => 24.9056,
                'longitude' => 67.0822,
                'phone' => '+92-21-2345-6789',
                'email' => 'north@proinspect.com',
                'operating_hours' => [
                    'monday' => ['open' => '09:00', 'close' => '17:00'],
                    'tuesday' => ['open' => '09:00', 'close' => '17:00'],
                    'wednesday' => ['open' => '09:00', 'close' => '17:00'],
                    'thursday' => ['open' => '09:00', 'close' => '17:00'],
                    'friday' => ['open' => '09:00', 'close' => '17:00'],
                    'saturday' => ['open' => '10:00', 'close' => '15:00'],
                    'sunday' => null // Closed
                ],
                'services_offered' => ['basic', 'comprehensive', 'premium'],
                'mobile_service' => false,
                'max_daily_appointments' => 20,
                'status' => 'active'
            ],
            [
                'name' => 'South Branch - Commercial District',
                'code' => 'SBC',
                'address' => 'Shahrah-e-Faisal, Commercial Area, Clifton',
                'city' => 'Karachi',
                'state' => 'Sindh',
                'zip_code' => '75600',
                'latitude' => 24.8138,
                'longitude' => 67.0299,
                'phone' => '+92-21-3456-7890',
                'email' => 'south@proinspect.com',
                'operating_hours' => [
                    'monday' => ['open' => '09:00', 'close' => '18:00'],
                    'tuesday' => ['open' => '09:00', 'close' => '18:00'],
                    'wednesday' => ['open' => '09:00', 'close' => '18:00'],
                    'thursday' => ['open' => '09:00', 'close' => '18:00'],
                    'friday' => ['open' => '09:00', 'close' => '18:00'],
                    'saturday' => ['open' => '10:00', 'close' => '16:00'],
                    'sunday' => null // Closed
                ],
                'services_offered' => ['basic', 'comprehensive', 'premium'],
                'mobile_service' => false,
                'max_daily_appointments' => 22,
                'status' => 'active'
            ],
            [
                'name' => 'Mobile Service - We Come to You',
                'code' => 'MOB',
                'address' => 'Mobile Service Coverage Area',
                'city' => 'Karachi',
                'state' => 'Sindh',
                'zip_code' => '00000',
                'latitude' => 24.8607,
                'longitude' => 67.0011,
                'phone' => '+92-21-4567-8901',
                'email' => 'mobile@proinspect.com',
                'operating_hours' => [
                    'monday' => ['open' => '08:00', 'close' => '20:00'],
                    'tuesday' => ['open' => '08:00', 'close' => '20:00'],
                    'wednesday' => ['open' => '08:00', 'close' => '20:00'],
                    'thursday' => ['open' => '08:00', 'close' => '20:00'],
                    'friday' => ['open' => '08:00', 'close' => '20:00'],
                    'saturday' => ['open' => '09:00', 'close' => '18:00'],
                    'sunday' => ['open' => '10:00', 'close' => '16:00']
                ],
                'services_offered' => ['comprehensive', 'premium'],
                'mobile_service' => true,
                'max_daily_appointments' => 15,
                'status' => 'active'
            ]
        ];

        foreach ($locations as $locationData) {
            Location::create($locationData);
        }
    }
}