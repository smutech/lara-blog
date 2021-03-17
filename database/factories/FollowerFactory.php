<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Follower;
use Illuminate\Support\Arr;
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
        $all_users = User::select('id')->get();
        $users = [];

        foreach ($all_users as $key => $user) {
            array_push($users, $user->id);
        }

        $follower_id = Arr::random($users);
        $user_id = Arr::random($users);

        $follower_exists = Follower::where(['follower_id' => $follower_id, 'user_id' => $user_id])->first();

        if (($follower_id != $user_id) && empty($follower_exists)) {
            return [
                'follower_id' => $follower_id,
                'user_id' => $user_id,
            ];
        }
        else { die; }
    }
}
