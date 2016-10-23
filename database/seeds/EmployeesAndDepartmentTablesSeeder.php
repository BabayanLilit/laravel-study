<?php

use Illuminate\Database\Seeder;

class EmployeesAndDepartmentTablesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //не заморачивалась, потому что данных мало, а так по хорошему нужно сделать множественный insert

        $departments = [];
        $departments[] = $this->createDepartment('Отдел закупок');
        $departments[] = $this->createDepartment('Отдел продаж');
        $departments[] = $this->createDepartment('PR-отдел');

        $employees = $this->getEmployeeData();
        foreach ($employees as $employeeData) {
            $this->createEmployee($employeeData, $this->randDepartments($departments));
        }
    }

    private function getEmployeeData()
    {
        return [
            [
                'name' => 'Иван',
                'lastname' => 'Йода',
                'gender' => 'm',
                'pay' => 500,
            ],
            [
                'name' => 'Петр',
                'lastname' => 'Вейдер',
                'gender' => 'm',
                'pay' => 600,
            ],
            [
                'name' => 'Ольга',
                'lastname' => 'Кеноби',
                'gender' => 'w',
                'pay' => 700,
            ]
        ];
    }

    private function createDepartment($name)
    {
        return DB::table('departments')->insertGetId([
            'name' => $name,
        ]);
    }

    private function createEmployee($data, $departments)
    {
        $emId = DB::table('employees')->insertGetId($data);

        foreach ($departments as $department) {
            DB::table('department_employee')->insertGetId([
                'department_id' => $department,
                'employee_id' => $emId,
            ]);
        }

        return $emId;
    }

    private function randDepartments($departments)
    {
        $keys = array_rand($departments, rand(1, count($departments)));
        $result = [];

        foreach ($keys as $key) {
            $result[] = $departments[$key];
        }

        return $result;
    }

}
