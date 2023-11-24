<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Category;
use App\Models\Recipe;
use App\Models\Tag;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        \App\Models\User::factory(29)->create();

            \App\Models\User::factory()->create([
                'name' => 'Ale',
                'email' => 'ale123456789@app.com',
            ]);

        Category::factory(12)->create();
        Recipe::factory(100)->create();
        Tag::factory(40)->create();

        // Many to many
        $recipes = Recipe::all();
        $tags = Tag::all();
        
        foreach($recipes as $recipe) {
            $recipe->tags()->attach($tags->random(rand(2, 4)));
        }
    }
}
