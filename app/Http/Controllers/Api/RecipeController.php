<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreRecipeRequest;
use App\Http\Requests\UpdateRecipeRequest;
use App\Http\Resources\RecipeResource;
use App\Models\Recipe;
use App\Models\Tag;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;


class RecipeController extends Controller
{
    public function index()
    {
        $recipes = Recipe::with('category', 'tags', 'user')->get();

        return RecipeResource::collection($recipes);
    }

    public function store(StoreRecipeRequest $request, Tag $tags) 
    {
        $recipe = $request->user()->recipes()->create($request->all());

        // $recipe = Recipe::create($request->all());
        $recipe->tags()->attach(json_decode($request->tags));

        return response()->json(new RecipeResource($recipe), Response::HTTP_CREATED); // HTTP 201
    }

    public function show(Recipe $recipe)
    {
        $recipe = $recipe->load('category', 'tags', 'user');

        return new RecipeResource($recipe);
    }

    public function update(UpdateRecipeRequest $request, Recipe $recipe) 
    {
        $this->authorize('update', $recipe);

        $recipe->update($request->all());

        if ($tags = json_decode($request->tags)) {
            $recipe->tags()->sync($tags);
        }

        return response()->json(new RecipeResource($recipe, Response::HTTP_OK)); // HTTP 200
    }

    public function destroy(Recipe $recipe) 
    {
        $this->authorize('delete', $recipe);
        
        $recipe->delete();

        return response()->json(null, Response::HTTP_NO_CONTENT); // 204
    }
}
