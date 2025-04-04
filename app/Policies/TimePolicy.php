<?php

namespace App\Policies;

use App\Models\Time;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class TimePolicy
{
    use HandlesAuthorization;

    public function view(User $user, Time $Time)
    {
        return $user->id === $Time->user_id;
    }

    public function update(User $user, Time $Time)
    {
        return $user->id === $Time->user_id;
    }

    public function delete(User $user, Time $Time)
    {
        return $user->id === $Time->user_id;
    }
}