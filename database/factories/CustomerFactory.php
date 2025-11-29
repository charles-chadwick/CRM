<?php

namespace Database\Factories;

use App\Models\Company;
use App\Models\Customer;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class CustomerFactory extends Factory
{
    protected $model = Customer::class;

    public function definition() : array
    {
        return [
            'title'             => $this->faker->word(),

            'prefix'            => $this->faker->word(),
            'first_name'        => $this->faker->firstName(),
            'last_name'         => $this->faker->lastName(),
            'suffix'            => $this->faker->word(),
            'email'             => $this->faker->unique()
                ->safeEmail(),

            'email_verified_at' => Carbon::now(),
            'password'          => bcrypt($this->faker->password()),
            'remember_token'    => Str::random(10),
            'created_by_id'     => $this->faker->randomNumber(),
            'updated_by_id'     => $this->faker->randomNumber(),
            'created_at'        => Carbon::now(),
            'updated_at'        => Carbon::now(),
        ];
    }
}
