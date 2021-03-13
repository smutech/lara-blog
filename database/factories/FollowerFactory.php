<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Follower;
use Illuminate\Database\Eloquent\Factories\Factory;

class FollowerFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Follower::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'follower_id' => $follower_id,
            'user_id' => $user->id,
        ];
    }
}
