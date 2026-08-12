<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Department;
use App\Models\Employee;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $user = User::firstOrCreate(['email' => 'test@example.com'], [
            'name' => 'Test User',
            'password' => 'password',
        ]);

        $departments = collect([
            ['name' => 'Engineering', 'description' => 'Product engineering and quality.', 'status' => 'active'],
            ['name' => 'Human Resources', 'description' => 'People operations and recruitment.', 'status' => 'active'],
            ['name' => 'Finance', 'description' => 'Planning and accounting.', 'status' => 'active'],
            ['name' => 'Sales', 'description' => 'Customer acquisition and retention.', 'status' => 'active'],
            ['name' => 'Operations', 'description' => 'Business operations and delivery.', 'status' => 'inactive'],
        ])->map(fn (array $department) => $user->departments()->firstOrCreate(['name' => $department['name']], $department));

        foreach (range(1, 50) as $number) {
            $user->employees()->firstOrCreate(['email' => "employee{$number}@example.com"], [
                'name' => fake()->name(),
                'phone' => fake()->phoneNumber(),
                'salary' => fake()->numberBetween(30000, 150000),
                'joining_date' => fake()->dateTimeBetween('-5 years', 'today')->format('Y-m-d'),
                'department_id' => $departments->random()->id,
                'status' => $number % 6 === 0 ? 'inactive' : 'active',
            ]);
        }
    }
}
