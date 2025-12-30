<?php

namespace Database\Seeders;

use App\Models\CompanyType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CompanyTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run() : void
    {
        foreach (
            [
                'Private',
                'Public',
                'Prospect',
                'Vendor'
            ] as $name) {
            CompanyType::firstOrCreate(['name' => $name]);
        }
    }
}
