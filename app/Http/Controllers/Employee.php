<?php

namespace App\Http\Controllers;

use App\Department;
use App\Employee as EmployeeModel;
use App\Repositories\EmployeeRepository;
use DB;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Validation\Rule;
use Validator;

class Employee extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $employees = EmployeeModel::orderBy('created_at', 'desc')
            ->with('departments')
            ->paginate(2);

        return view('employees.index', ['employees' => $employees]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $departments = Department::orderBy('name')->get();

        return view('employees.add', [
            'departments' => $departments,
        ]);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            $this->getValidateRulesForAddEdit(),
            $this->getValidateMessagesForAddEdit()
        );

        if ($validator->fails()) {
            return response()
                ->json([
                    'errors' => $this->formatValidationErrors($validator),
                    'success' => false,
                ]);

        }

        $employee = EmployeeModel::create($request->all());

        if ($request->departments) {
            $employee->departments()->attach($request->departments);
        }

        if (!$employee->save()) {
            return response()
                ->json([
                    'success' => false,
                    'message' => 'Не удалось выполнить операцию.  Попробуйте позже'
                ]);
        }

        return response()
            ->json([
                'success' => true,
                'message' => 'Сотрудник успешно добавлен',
                'redirect' =>  route('employee.index')
            ]);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param EmployeeModel $employee
     * @return \Illuminate\Http\Response
     */
    public function edit(EmployeeModel $employee)
    {
        $departments = Department::orderBy('name')->get();

        return view('employees.edit', [
            'employee' => $employee,
            'departments' => $departments,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param EmployeeModel $employee
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, EmployeeModel $employee)
    {
        $validator = Validator::make(
            $request->all(),
            $this->getValidateRulesForAddEdit(),
            $this->getValidateMessagesForAddEdit()
        );

        if ($validator->fails()) {
            return response()
                ->json([
                    'errors' => $this->formatValidationErrors($validator),
                    'success' => false,
                ]);

        }

        $employee->fill($request->all());

        if ($newDepartments = array_diff($request->departments, $employee->departments->pluck('id')->toArray())) {
            $employee->departments()->attach($newDepartments);
        }

        if ($deleteDepartments = array_diff($employee->departments->pluck('id')->toArray(), $request->departments)) {
            $employee->departments()->detach($deleteDepartments);
        }

        if (!$employee->save()) {
            return response()
                ->json([
                    'success' => false,
                    'message' => 'Не удалось выполнить операцию.  Попробуйте позже'
                ]);
        }

        return response()
            ->json(['success' => true, 'message' => 'Сотрудник успешно изменен']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

    }

    private function getValidateRulesForAddEdit()
    {
        return [
            'name' => 'required|max:255',
            'lastname' => 'required|max:255',
            'departments' => 'required|array|exists:departments,id',
            'pay' => 'integer',
        ];
    }

    private function getValidateMessagesForAddEdit()
    {
        return [
            'name.required' => 'На заполнено имя',
            'lastname.required' => 'Не заполнена фамилия',
            'departments.required' => 'Необходимо указать отдел',
            'pay.integer' => 'Заработная плата должна быть целым числом',
            'departments.exists' => 'Указанные отделы не существуют. Попробуйте позже',
        ];
    }
}
