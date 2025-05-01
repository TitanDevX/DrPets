<?php

namespace App\Policies;

use App\Models\Chat;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ChatPolicy
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
    public function view(User $user, Chat $chat): bool
    {
        if($user->provider()->exists() && $chat->provider_id == $user->provider->id){
                return true;
        }
        return $chat->user_id == $user->id || $user->hasPermissionTo('chats.reterive');
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
    public function update(User $user, Chat $chat): bool
    {
        if($user->provider()->exists() && $chat->provider_id == $user->provider->id){
            return true;
    }
         return $chat->user_id == $user->id || $user->hasPermissionTo('chats.update');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Chat $chat): bool
    {
       
        if($user->provider()->exists() && $chat->provider_id == $user->provider->id){
            return true;
        }
        return $chat->user_id == $user->id || $user->hasPermissionTo('chats.delete');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Chat $chat): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Chat $chat): bool
    {
        return false;
    }
}
