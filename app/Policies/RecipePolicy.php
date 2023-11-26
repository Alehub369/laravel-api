<?php

namespace App\Policies;

use App\Models\Recipe;
use App\Models\User;

class RecipePolicy
{
    /**
     * Create a new policy instance.
     */
    public function update(User $user, Recipe $recipe): bool
    {
        return $user->id === $recipe->user_id; // true or false.
    }

    public function delete(User $user, Recipe $recipe): bool
    {
        return $user->id === $recipe->user_id; // true or false.
    }
}
