<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Recipe;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Laravel\Sanctum\Sanctum;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;


class RecipeTest extends TestCase
{
    use RefreshDatabase, WithFaker;
    
    public function test_index(): void
    {
        Sanctum::actingAs(User::factory()->create());

        Category::factory()->create();

        Recipe::factory(2)->create();

        $response = $this->getJson('/api/recipes');
        $response->assertStatus(Response::HTTP_OK)
            ->assertJsonCount(2, 'data')
            ->assertJsonStructure([
                'data' => [
                    [
                        'id',
                        'type',
                        'attributes' => ['title', 'description'], // resto de campos
                       
                    ]
                ]
            ]);
    }

    public function test_store(): void
    {
        
        Sanctum::actingAs(User::factory()->create());

        $category = Category::factory()->create();
        $tag = Tag::factory()->create();

        $data = [
            'category_id'   => $category->id,
            'title'         => $this->faker->sentence,
            'description'   => $this->faker->paragraph,
            'ingredients'   => $this->faker->text,
            'instructions'  => $this->faker->text,
            'tags'          => $tag->id,
            'image'         => UploadedFile::fake()->image('recipe.png')
        ];
        

        $response = $this->postJson('/api/recipes/', $data);
        $response->assertStatus(Response::HTTP_CREATED);
    }

    public function test_show(): void
    {
        Sanctum::actingAs(User::factory()->create());

        Category::factory()->create();

        $recipe = Recipe::factory()->create();

        $response = $this->getJson('/api/recipes/' . $recipe->id);
        $response->assertStatus(Response::HTTP_OK) // 200
            ->assertJsonStructure([
                'data' => [
                        'id',
                        'type',
                        'attributes' => ['title', 'description'], // resto de campos
                ]
            ]);
    }

    public function test_destroy(): void
    {
        Sanctum::actingAs(User::factory()->create());

        Category::factory()->create();

        $recipe = Recipe::factory()->create();

        $response = $this->deleteJson('/api/recipes/' . $recipe->id);
        $response->assertStatus(Response::HTTP_NO_CONTENT); // 200 
    }
}
