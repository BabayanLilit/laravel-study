<?php

namespace App\Policies;

use App\Http\Controllers\Employee;
use App\User;
use Auth;
use Illuminate\Auth\Access\HandlesAuthorization;

class EmployeePolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function destroy()
    {
        return Auth::check();
    }

    public function edit()
    {
        return Auth::check();
    }

    public function add()
    {
        return Auth::check();
    }
}
