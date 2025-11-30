<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\Contact;
use App\Models\Customer;
use Illuminate\Database\Seeder;

class ContactTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run() : void
    {
        Contact::truncate();
        foreach (Customer::all() as $company) {

            Contact::factory()
                ->count(rand(1, 5))
                ->create(['on_id' => $company->id, 'on' => Customer::class]);

        }

        foreach (Customer::all() as $customer) {

            Contact::factory()
                ->create(['on_id' => $customer->id, 'on' => Customer::class]);

        }
    }
}
