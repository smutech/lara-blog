<?php

namespace Database\Factories;

use App\Models\Blog;
use App\Models\User;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class BlogFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Blog::class;

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

        $user_id = Arr::random($users);

        $title = $this->faker->sentence(10);
        
        return [
            'slug' => Str::slug($title),
            'title' => $title,
            'body' => $this->faker->paragraph(75),
            'user_id' => $user_id,
        ];
    }
}
