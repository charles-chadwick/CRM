<?php

namespace Database\Factories;

use App\Enums\CompanyType;
use App\Models\Company;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class CompanyFactory extends Factory
{
    protected $model = Company::class;

    public function definition() : array
    {
        return [
            'type'          => $this->faker->randomElement(CompanyType::cases()),
            'name'          => $this->faker->company(),
            'notes'         => $this->faker->word(),
            'created_by_id' => User::inRandomOrder()->first()->id,
            'created_at'    => Carbon::now(),
            'updated_at'    => Carbon::now(),
        ];
    }
}
