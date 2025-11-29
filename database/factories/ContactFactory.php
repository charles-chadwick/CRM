<?php

namespace Database\Factories;

use App\Models\Contact;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class ContactFactory extends Factory
{
    protected $model = Contact::class;

    public function definition() : array
    {
        return [

            'type'        => $this->faker->word(),
            'phone'       => $this->faker->phoneNumber(),
            'fax'         => $this->faker->word(),
            'email'       => $this->faker->unique()
                ->safeEmail(),
            'address_1'   => $this->faker->address(),
            'address_2'   => $this->faker->address(),
            'city'        => $this->faker->city(),
            'state'       => $this->faker->word(),
            'postal_code' => $this->faker->postcode(),
            'country'     => $this->faker->country(),
            'notes'       => $this->faker->word(),
            'created_at'  => Carbon::now(),
            'updated_at'  => Carbon::now(),
            'created_by_id' => User::inRandomOrder()->first()->id,
        ];
    }
}
