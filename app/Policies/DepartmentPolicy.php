<?php

namespace App\Policies;

use App\User;
use Auth;
use Illuminate\Auth\Access\HandlesAuthorization;

class DepartmentPolicy
{

    /**
     * @return bool
     */
    public function destroy()
    {
        return Auth::check();
    }

    /**
     * @return bool
     */
    public function edit()
    {
        return Auth::check();
    }

    /**
     * @return bool
     */
    public function add()
    {
        return Auth::check();
    }
}
