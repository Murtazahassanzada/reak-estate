<?php

namespace App\Policies;

use App\Models\Property;
use App\Models\User;

class PropertyPolicy
{
    public function update(User $user, Property $property)
    {
        return $user->id === $property->user_id;
    }

    public function delete(User $user, Property $property)
    {
        return $user->id === $property->user_id;
    }

    public function create(User $user): bool
    {
        return true;
    }
}