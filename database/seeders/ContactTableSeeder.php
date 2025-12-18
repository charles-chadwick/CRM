<?php

namespace Database\Seeders;

use App\Enums\ContactType;
use App\Models\Company;
use App\Models\Contact;
use App\Models\Customer;
use Illuminate\Database\Seeder;
use function fake;
use function preg_split;

class ContactTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run() : void
    {
        $customers = Customer::all();
        $contact_types = ContactType::cases();
        Contact::truncate();
        foreach ($customers as $customer) {
            $contactCount = rand(1, 3);

            for ($i = 0 ; $i < $contactCount ; $i++) {

                $street_address = preg_split('/Suite|Apt/', fake()->streetAddress());

                Contact::create([
                    'on_id'       => $customer->id,
                    'on_type'     => Customer::class,
                    'type'        => $contact_types[array_rand($contact_types)]->value,
                    'is_primary'  => $i === 0,
                    'address_1'   => $street_address[0],
                    'address_2'   => fake()->buildingNumber(),
                    'city'        => fake()->city(),
                    'state'       => fake()->randomElement([
                        'OR',
                        'WA',
                        'CA',
                        'TX'
                    ]),
                    'postal_code' => fake()->postcode(),
                    'country'     => 'US',
                    'phone'       => fake()->phoneNumber(),
                    'fax'         => fake()->phoneNumber(),
                    'notes'       => rand(0, 1) ? fake()->sentence() : null,
                ]);
            }
        }
        $companies = Company::all();
        $contact_types = ContactType::cases();

        foreach ($companies as $company) {
            $contactCount = rand(1, 3);



            for ($i = 0 ; $i < $contactCount ; $i++) {
                $street_address = preg_split('/Suite|Apt/', fake()->streetAddress());
                Contact::create([
                    'on_id'       => $company->id,
                    'on_type'     => Company::class,
                    'type'        => $contact_types[array_rand($contact_types)]->value,
                    'is_primary'  => $i === 0,
                    'address_1'   => $street_address[0],
                    'address_2'   => fake()->buildingNumber(),
                    'city'        => fake()->city(),
                    'state'       => fake()->randomElement([
                        'OR',
                        'WA',
                        'CA',
                        'TX'
                    ]),
                    'postal_code' => fake()->postcode(),
                    'country'     => 'US',
                    'notes'       => rand(0, 1) ? fake()->sentence() : null,
                    'phone'       => fake()->phoneNumber(),
                    'fax'         => fake()->phoneNumber(),

                ]);
            }
        }
    }
}
