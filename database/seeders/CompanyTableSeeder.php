<?php

namespace Database\Seeders;

use App\Models\CompanyType;
use App\Models\Company;
use App\Models\User;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Database\Seeder;
use Illuminate\Support\Collection;
use Spatie\Activitylog\Facades\CauserResolver;

use function fake;

class CompanyTableSeeder extends Seeder
{
    /**
     * Populates the `companies` table with data fetched from the Rick and Morty API.
     *
     * This method fetches episode data from the API and uses episode names as company names.
     * Each company is assigned a random user as the creator, and the created_at timestamp
     * is randomly set between when the user was created and 1 month ago.
     *
     * @throws GuzzleException
     */
    public function run() : void
    {
        $users = User::all();

        if ($users->isEmpty()) {
            $this->command->error('No users found. Please seed users first.');
            return;
        }

        echo "\nFetching episodes from Rick and Morty API...\n";

        $episodes = $this->getEpisodes();

        if ($episodes->isEmpty()) {
            $this->command->error('No episodes fetched from API.');
            return;
        }

        echo "\nCreating Companies\n";

        $episodes->each(function ($episode) use ($users) {
            $random_user = User::inRandomOrder()
                ->first();

            // Set the causer resolver for activity logging
            CauserResolver::setCauser($random_user);

            // Calculate random created_at date between user creation and 1 month ago
            $user_created_at = $random_user->created_at->copy();
            $one_month_ago = now()->subMonth();

            // Start date should be when user was created
            // End date should be 1 month ago (or user creation if user is newer than 1 month)
            $start_date = $user_created_at;
            $end_date = $user_created_at->lt($one_month_ago) ? $one_month_ago : $user_created_at->copy();

            $created_at = fake()->dateTimeBetween($start_date, $end_date);

            $company = Company::create([
                'company_type_id'          => CompanyType::inRandomOrder()->first()->id,
                'name'          => FilterData::censor($episode['name']),
                'notes'         => fake()
                    ->optional(0.3)
                    ->sentence(),
                'created_by_id' => $random_user->id,
                'updated_by_id' => $random_user->id,
                'created_at'    => $created_at,
                'updated_at'    => $created_at,
            ]);

            activity()
                ->performedOn($company)
                ->useLog('database')
                ->log('Created');

            echo '.';
        });

        echo "\n";
    }

    /**
     * Fetches all episodes from the Rick and Morty API.
     *
     * @return Collection
     * @throws GuzzleException
     */
    private function getEpisodes() : Collection
    {
        $client = new Client();
        $episodes = collect();
        $page = 1;
        $has_more = true;

        while ($has_more) {
            try {
                $response = $client->get("https://rickandmortyapi.com/api/episode?page={$page}");
                $data = json_decode($response->getBody(), true);

                $episodes = $episodes->merge($data['results'] ?? []);

                // Check if there's a next page
                $has_more = isset($data['info']['next']);
                $page++;

                // Limit to reasonable number of episodes (e.g., first 3 pages = ~60 episodes)
                if ($page > 3) {
                    $has_more = false;
                }
            } catch (GuzzleException $e) {
                $this->command->error("Error fetching episodes: ".$e->getMessage());
                $has_more = false;
            }
        }

        return $episodes->shuffle();
    }
}

