<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Location;
use App\Models\Inspector;
use App\Models\Customer;
use App\Models\Appointment;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Create Admin User
        $adminUser = User::create([
            'name' => 'ProInspect Admin',
            'email' => 'admin@proinspect.com',
            'password' => Hash::make('password123'),
            'email_verified_at' => now(),
        ]);

        // Create Inspector Users
        $inspector1User = User::create([
            'name' => 'John Smith',
            'email' => 'john.smith@proinspect.com',
            'password' => Hash::make('password123'),
            'email_verified_at' => now(),
        ]);

        $inspector2User = User::create([
            'name' => 'Sarah Johnson',
            'email' => 'sarah.johnson@proinspect.com',
            'password' => Hash::make('password123'),
            'email_verified_at' => now(),
        ]);

        // Create Locations
        Location::create([
            'name' => 'Downtown Center',
            'code' => 'DTC',
            'address' => '123 Main Street',
            'city' => 'Cityville',
            'state' => 'CA',
            'zip_code' => '12345',
            'latitude' => 34.0522,
            'longitude' => -118.2437,
            'phone' => '+1 (555) 123-4567',
            'email' => 'downtown@proinspect.com',
            'operating_hours' => [
                'Monday' => ['09:00', '17:00'],
                'Tuesday' => ['09:00', '17:00'],
                'Wednesday' => ['09:00', '17:00'],
                'Thursday' => ['09:00', '17:00'],
                'Friday' => ['09:00', '17:00'],
                'Saturday' => ['09:00', '15:00'],
                'Sunday' => null
            ],
            'services_offered' => ['basic', 'complete', 'premium'],
            'mobile_service' => false,
            'max_daily_appointments' => 20,
            'status' => 'active'
        ]);

        Location::create([
            'name' => 'North Branch',
            'code' => 'NB',
            'address' => '456 North Avenue',
            'city' => 'Northtown',
            'state' => 'CA',
            'zip_code' => '12346',
            'latitude' => 34.1522,
            'longitude' => -118.3437,
            'phone' => '+1 (555) 234-5678',
            'email' => 'north@proinspect.com',
            'operating_hours' => [
                'Monday' => ['08:00', '18:00'],
                'Tuesday' => ['08:00', '18:00'],
                'Wednesday' => ['08:00', '18:00'],
                'Thursday' => ['08:00', '18:00'],
                'Friday' => ['08:00', '18:00'],
                'Saturday' => ['09:00', '16:00'],
                'Sunday' => null
            ],
            'services_offered' => ['basic', 'complete', 'premium'],
            'mobile_service' => false,
            'max_daily_appointments' => 15,
            'status' => 'active'
        ]);

        Location::create([
            'name' => 'South Branch',
            'code' => 'SB',
            'address' => '789 South Boulevard',
            'city' => 'Southville',
            'state' => 'CA',
            'zip_code' => '12347',
            'latitude' => 33.9522,
            'longitude' => -118.1437,
            'phone' => '+1 (555) 345-6789',
            'email' => 'south@proinspect.com',
            'operating_hours' => [
                'Monday' => ['09:00', '17:00'],
                'Tuesday' => ['09:00', '17:00'],
                'Wednesday' => ['09:00', '17:00'],
                'Thursday' => ['09:00', '17:00'],
                'Friday' => ['09:00', '17:00'],
                'Saturday' => ['10:00', '14:00'],
                'Sunday' => null
            ],
            'services_offered' => ['basic', 'complete'],
            'mobile_service' => false,
            'max_daily_appointments' => 12,
            'status' => 'active'
        ]);

        Location::create([
            'name' => 'Mobile Service',
            'code' => 'MOB',
            'address' => 'Service Area Coverage',
            'city' => 'Various Locations',
            'state' => 'CA',
            'zip_code' => '00000',
            'phone' => '+1 (555) 456-7890',
            'email' => 'mobile@proinspect.com',
            'operating_hours' => [
                'Monday' => ['08:00', '20:00'],
                'Tuesday' => ['08:00', '20:00'],
                'Wednesday' => ['08:00', '20:00'],
                'Thursday' => ['08:00', '20:00'],
                'Friday' => ['08:00', '20:00'],
                'Saturday' => ['09:00', '18:00'],
                'Sunday' => ['10:00', '16:00']
            ],
            'services_offered' => ['complete', 'premium'],
            'mobile_service' => true,
            'max_daily_appointments' => 8,
            'status' => 'active'
        ]);

        // Create Inspectors
        Inspector::create([
            'user_id' => $inspector1User->id,
            'employee_id' => 'INS001',
            'first_name' => 'John',
            'last_name' => 'Smith',
            'email' => 'john.smith@proinspect.com',
            'phone' => '+1 (555) 111-2222',
            'license_number' => 'CA-INS-12345',
            'license_expiry' => now()->addYears(2),
            'certifications' => [
                'ASE Certified Master Technician',
                'Automotive Service Excellence',
                'State Certified Vehicle Inspector'
            ],
            'specializations' => ['sedan', 'suv', 'truck', 'motorcycle'],
            'status' => 'active',
            'hourly_rate' => 45.00,
            'hire_date' => now()->subMonths(18),
            'bio' => 'Experienced automotive technician with over 10 years in the industry. Specializes in comprehensive vehicle inspections and diagnostics.'
        ]);

        Inspector::create([
            'user_id' => $inspector2User->id,
            'employee_id' => 'INS002',
            'first_name' => 'Sarah',
            'last_name' => 'Johnson',
            'email' => 'sarah.johnson@proinspect.com',
            'phone' => '+1 (555) 222-3333',
            'license_number' => 'CA-INS-67890',
            'license_expiry' => now()->addYears(3),
            'certifications' => [
                'ASE Certified',
                'Hybrid Vehicle Specialist',
                'Electric Vehicle Certified'
            ],
            'specializations' => ['sedan', 'suv', 'hatchback', 'van'],
            'status' => 'active',
            'hourly_rate' => 50.00,
            'hire_date' => now()->subYears(2),
            'bio' => 'Expert in modern vehicle systems including hybrid and electric vehicles. Known for thorough and detailed inspections.'
        ]);

        // Create Sample Customers
        $customers = [
            [
                'first_name' => 'Michael',
                'last_name' => 'Brown',
                'email' => 'michael.brown@email.com',
                'phone' => '+1 (555) 001-1111',
                'address' => '101 Oak Street',
                'city' => 'Cityville',
                'state' => 'CA',
                'zip_code' => '12345',
                'status' => 'active'
            ],
            [
                'first_name' => 'Jennifer',
                'last_name' => 'Davis',
                'email' => 'jennifer.davis@email.com',
                'phone' => '+1 (555) 002-2222',
                'address' => '202 Pine Avenue',
                'city' => 'Northtown',
                'state' => 'CA',
                'zip_code' => '12346',
                'status' => 'active'
            ],
            [
                'first_name' => 'Robert',
                'last_name' => 'Wilson',
                'email' => 'robert.wilson@email.com',
                'phone' => '+1 (555) 003-3333',
                'address' => '303 Elm Drive',
                'city' => 'Southville',
                'state' => 'CA',
                'zip_code' => '12347',
                'status' => 'active'
            ]
        ];

        foreach ($customers as $customerData) {
            Customer::create($customerData);
        }

        // Create Sample Appointments
        $appointments = [
    [
        'appointment_number' => 'APPT-2025-001',
        'customer_id' => 1,
        'location_id' => 1,
        'inspector_id' => 1,
        'vehicle_make' => 'Honda',
        'vehicle_model' => 'Civic',
        'vehicle_year' => 2018,
        'vehicle_type' => 'sedan',
        'vin' => '1HGBH41JXMN109186',
        'license_plate' => 'ABC123',
        'mileage' => 45000,
        'color' => 'Silver',
        'package_type' => 'complete',
        'price' => 199.00,
        'appointment_date' => now()->addDays(2),
        'appointment_time' => '10:00',
        'status' => 'confirmed',
        'customer_notes' => 'Please check the brake system carefully. I noticed some squeaking sounds.',
        'confirmed_at' => now()
    ],
    [
        'appointment_number' => 'APPT-2025-002',
        'customer_id' => 2,
        'location_id' => 2,
        'inspector_id' => 2,
        'vehicle_make' => 'Toyota',
        'vehicle_model' => 'RAV4',
        'vehicle_year' => 2020,
        'vehicle_type' => 'suv',
        'vin' => '2T3BFREV0LW123456',
        'license_plate' => 'XYZ789',
        'mileage' => 28000,
        'color' => 'Blue',
        'package_type' => 'premium',
        'price' => 299.00,
        'appointment_date' => now()->addDays(5),
        'appointment_time' => '14:00',
        'status' => 'pending',
        'customer_notes' => 'Pre-purchase inspection. Looking to buy this vehicle.'
    ],
    [
        'appointment_number' => 'APPT-2025-003',
        'customer_id' => 3,
        'location_id' => 1,
        'inspector_id' => 1,
        'vehicle_make' => 'Ford',
        'vehicle_model' => 'F-150',
        'vehicle_year' => 2019,
        'vehicle_type' => 'truck',
        'vin' => '1FTEW1EP9KFA12345',
        'license_plate' => 'TRK456',
        'mileage' => 62000,
        'color' => 'Black',
        'package_type' => 'complete',
        'price' => 199.00,
        'appointment_date' => now()->subDays(3),
        'appointment_time' => '09:00',
        'status' => 'completed',
        'customer_notes' => 'Regular maintenance inspection.',
        'confirmed_at' => now()->subDays(5),
        'started_at' => now()->subDays(3)->addHours(9),
        'completed_at' => now()->subDays(3)->addHours(11)
    ],
    [
        'appointment_number' => 'APPT-2025-004',
        'customer_id' => 1,
        'location_id' => 3,
        'inspector_id' => null,
        'vehicle_make' => 'BMW',
        'vehicle_model' => '320i',
        'vehicle_year' => 2017,
        'vehicle_type' => 'sedan',
        'mileage' => 78000,
        'color' => 'White',
        'package_type' => 'basic',
        'price' => 99.00,
        'appointment_date' => now()->addDays(7),
        'appointment_time' => '11:30',
        'status' => 'pending',
        'customer_notes' => 'Quick inspection before selling the car.'
    ],
    [
        'appointment_number' => 'APPT-2025-005',
        'customer_id' => 2,
        'location_id' => 4, // Mobile service
        'inspector_id' => 2,
        'vehicle_make' => 'Tesla',
        'vehicle_model' => 'Model 3',
        'vehicle_year' => 2021,
        'vehicle_type' => 'sedan',
        'vin' => '5YJ3E1EA1MF123456',
        'mileage' => 15000,
        'color' => 'Red',
        'package_type' => 'premium',
        'price' => 299.00,
        'appointment_date' => now()->addDays(1),
        'appointment_time' => '13:00',
        'status' => 'confirmed',
        'customer_notes' => 'Electric vehicle inspection. Please come to my home address.',
        'confirmed_at' => now()->subHours(2)
    ]
];


        foreach ($appointments as $appointmentData) {
            Appointment::create($appointmentData);
        }

        // Create a sample completed inspection for the completed appointment
        if ($completedAppointment = Appointment::where('status', 'completed')->first()) {
            \App\Models\Inspection::create([
                'inspection_number' => 'INS-2025-001',
                'appointment_id' => $completedAppointment->id,
                'inspector_id' => $completedAppointment->inspector_id,
                'overall_score' => 78.5,
                'overall_condition' => 'good',
                'recommendation' => 'buy',
                'engine_transmission_score' => 85.0,
                'brakes_score' => 70.0,
                'suspension_steering_score' => 80.0,
                'interior_score' => 90.0,
                'ac_heater_score' => 75.0,
                'electrical_score' => 85.0,
                'exterior_body_score' => 65.0,
                'tyres_score' => 60.0,
                'frame_score' => 95.0,
                'test_drive_score' => 80.0,
                'immediate_repairs_cost' => 450.00,
                'future_maintenance_cost' => 1200.00,
                'estimated_value' => 18500.00,
                'summary' => 'Overall good condition vehicle with minor maintenance items needed.',
                'major_issues' => 'Brake pads need replacement within 2000 miles. Tires showing wear.',
                'minor_issues' => 'Minor paint scratches on rear bumper. Air filter needs replacement.',
                'recommendations' => 'Replace brake pads and tires soon. Regular maintenance up to date.',
                'inspector_notes' => 'Vehicle well maintained. Owner has service records.',
                'test_drive_performed' => true,
                'test_drive_distance' => 5,
                'test_drive_notes' => 'Engine runs smooth, transmission shifts properly, no unusual noises.',
                'status' => 'completed',
                'started_at' => $completedAppointment->started_at,
                'completed_at' => $completedAppointment->completed_at
            ]);
        }

        $this->command->info('Database seeded successfully!');
        $this->command->info('Admin Login: admin@proinspect.com / password123');
        $this->command->info('Inspector Login: john.smith@proinspect.com / password123');
        $this->command->info('Inspector Login: sarah.johnson@proinspect.com / password123');
    }
}