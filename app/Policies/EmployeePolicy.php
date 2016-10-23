<?php

namespace App\Policies;

use App\Employee as EmployeeModel;
use App\Http\Controllers\Employee;
use App\User;
use Auth;
use Illuminate\Auth\Access\HandlesAuthorization;

/**
 * Class EmployeePolicy
 * @package App\Policies
 */
class EmployeePolicy
{
    use HandlesAuthorization;

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
