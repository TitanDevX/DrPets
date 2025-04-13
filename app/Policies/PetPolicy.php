<?php

namespace App\Policies;

use App\Models\Pet;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class PetPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Pet $pet)
    {

        
      
        return ($pet->user_id == $user->id || $user->hasPermissionTo('pet.reterive'))
         ? Response::allow() : Response::denyAsNotFound();
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Pet $pet)
    {
        return ($pet->user_id == $user->id || $user->hasPermissionTo('pet.update'))
        ? Response::allow() : Response::denyWithStatus(401,'This pet does not belong to this user and they doesnt have the required permission to update others pets.');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Pet $pet)
    {
        return  ($pet->user_id == $user->id || $user->hasPermissionTo('pet.delete'))
        ? Response::allow() : Response::denyWithStatus(401,'This pet does not belong to this user and 
        they doesnt have the required permission to delete others pets.');
   
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Pet $pet): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Pet $pet): bool
    {
        return false;
    }
}
