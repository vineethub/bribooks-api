<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Book;
use Illuminate\Database\Eloquent\Factories\Factory;

class BookFactory extends Factory
{
    protected $model = Book::class;

    public function definition(): array
    {
        return [
            'author_id' => User::factory(),
            'title' => fake()->sentence(),
            'description' => fake()->paragraph(),
            'status' => 'draft',
        ];
    }
}