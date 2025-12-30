<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\Customer;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Spatie\Activitylog\Facades\CauserResolver;

use function fake;

class CustomerTableSeeder extends Seeder
{
    /**
     * Populates the `customers` table with data using Simpsons character names.
     *
     * This method assigns 1-10 customers to each company using character names
     * from The Simpsons seasons 1-10 (loaded from cache file).
     * Each customer is assigned a random user as the creator, and the created_at timestamp
     * is randomly set between when the company was created and 1 month ago.
     */
    public function run(): void
    {
        $users = User::all();
        $companies = Company::all();

        if ($users->isEmpty()) {
            $this->command->error('No users found. Please seed users first.');
            return;
        }

        if ($companies->isEmpty()) {
            $this->command->error('No companies found. Please seed companies first.');
            return;
        }

        echo "\nLoading Simpsons character names from cache...\n";

        $cache_file = database_path('src/simpsons_characters.json');

        if (!file_exists($cache_file)) {
            $this->command->error('Simpsons characters cache file not found.');
            return;
        }

        $character_names = json_decode(file_get_contents($cache_file), true);

        if (empty($character_names)) {
            $this->command->error('No character names loaded from cache file.');
            return;
        }

        echo "\nCreating Customers\n";

        // Shuffle character names for randomness
        shuffle($character_names);
        $name_index = 0;

        $companies->each(function ($company) use ($users, &$character_names, &$name_index) {
            // Randomly assign 1-10 customers per company
            $customer_count = rand(1, 10);

            for ($i = 0; $i < $customer_count; $i++) {
                // Reset index if we run out of names
                if ($name_index >= count($character_names)) {
                    $name_index = 0;
                    shuffle($character_names);
                }

                $random_user = User::inRandomOrder()->first();

                // Set the causer resolver for activity logging
                CauserResolver::setCauser($random_user);
                $company = Company::inRandomOrder()->first();
                // Calculate random created_at date between company creation and 1 month ago
                $company_created_at = $company->created_at->copy();
                $one_month_ago = now()->subMonth();

                $start_date = $company_created_at;
                $end_date = $company_created_at->lt($one_month_ago) ? $one_month_ago : $company_created_at->copy();

                $created_at = fake()->dateTimeBetween($start_date, $end_date);

                // Parse full name into parts
                $full_name = $character_names[$name_index];
                $name_parts = explode(' ', $full_name);

                $first_name = $name_parts[0] ?? '';
                $last_name = isset($name_parts[1]) ? implode(' ', array_slice($name_parts, 1)) : '';

                $customer = Customer::create([
                    'company_id'        => $company->id,
                    'title'             => fake()->optional(0.3)->jobTitle(),
                    'prefix'            => fake()->optional(0.2)->randomElement(['Mr.', 'Mrs.', 'Ms.', 'Dr.', 'Prof.']),
                    'first_name'        => $first_name,
                    'last_name'         => $last_name,
                    'suffix'            => fake()->optional(0.1)->randomElement(['Jr.', 'Sr.', 'II', 'III', 'IV']),
                    'email'             => strtolower("$first_name.$last_name".rand(1,300)."@example.com"),
                    'password'          => Hash::make('password'),
                    'email_verified_at' => fake()->optional(0.7)->dateTimeBetween($created_at, 'now'),
                    'created_by_id'     => $random_user->id,
                    'updated_by_id'     => $random_user->id,
                    'created_at'        => $created_at,
                    'updated_at'        => $created_at,
                ]);

                activity()
                    ->performedOn($customer)
                    ->useLog('Database')
                    ->log('Created');

                $name_index++;
                echo '.';
            }
        });

        echo "\n";
    }
}
