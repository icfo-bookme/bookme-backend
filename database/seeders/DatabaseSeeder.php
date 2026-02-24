<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Permission;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
public function run()
{
    // Hotel module
    Permission::create(['name' => 'hotel.create', 'module' => 'hotel', 'label' => 'Add Hotel']);
    Permission::create(['name' => 'hotel.edit', 'module' => 'hotel', 'label' => 'Edit Hotel']);
    Permission::create(['name' => 'hotel.delete', 'module' => 'hotel', 'label' => 'Delete Hotel']);
    Permission::create(['name' => 'hotel.view', 'module' => 'hotel', 'label' => 'View Hotel']);

    // Flight module
    Permission::create(['name' => 'flight.create', 'module' => 'flight', 'label' => 'Add Flight']);
    Permission::create(['name' => 'flight.view', 'module' => 'flight', 'label' => 'View Flight']);
}
}
