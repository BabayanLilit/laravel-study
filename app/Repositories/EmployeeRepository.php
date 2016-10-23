<?php

namespace App\Repositories;



use App\Employee;

class EmployeeRepository
{

    public function getList($countOnPage)
    {
        return Employee::orderBy('created_at', 'asc')
            ->paginate($countOnPage);
    }
}