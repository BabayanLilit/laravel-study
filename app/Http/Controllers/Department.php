<?php

namespace App\Http\Controllers;

use App\Department as DepartmentModel;
use App\Employee;
use DB;
use Gate;
use Illuminate\Http\Request;

use App\Http\Requests;
use Validator;

class Department extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $departments = DepartmentModel::orderBy('created_at', 'desc')
            ->withCount(['employees'])
            ->with('employees')
            ->get();

        $maxPays = DB::table('departments as d')
            ->join('department_employee as de', 'de.department_id', '=', 'd.id')
            ->join('employees as e', 'e.id', '=', 'de.employee_id')
            ->groupBy('d.id')
            ->select([
                'd.id',
                DB::raw('max(e.pay) as max_pay')
            ])
            ->get()
            ->toArray();

        $resultPays = [];

        foreach ($maxPays as $maxPay) {
            $resultPays[$maxPay->id] = $maxPay->max_pay;
        }

        return view('departments.index', [
            'departments' => $departments,
            'maxPays' => $resultPays
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function grid()
    {
        $employees = Employee::orderBy('created_at', 'desc')
            ->with('departments')
            ->paginate(5);

        $departments = DepartmentModel::orderBy('name')->get();

        return view('grid', [
            'employees' => $employees,
            'departments' => $departments
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('departments.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (!Gate::allows('add', DepartmentModel::class)) {
            return response()->json([
                'success' => false,
                'message' => 'Нет доступа для добавления отдела'
            ]);
        }

        $validator = Validator::make(
            $request->all(),
            [
                'name' => 'required|max:255'
            ],
            [
                'name.required' => 'Название отдела не заполнено'
            ]
        );

        if ($validator->fails()) {
            return response()
                ->json([
                    'errors' => $this->formatValidationErrors($validator),
                    'success' => false,
                ]);

        }

        $department = DepartmentModel::create($request->all());

        if (!$department->save()) {
            return response()
                ->json([
                    'success' => false,
                    'message' => 'Не удалось выполнить операцию.  Попробуйте позже'
                ]);
        }

        return response()
            ->json([
                'success' => true,
                'message' => 'Отдел успешно добавлен',
                'redirect' =>  route('department.index')
            ]);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param DepartmentModel $department
     * @return \Illuminate\Http\Response
     */
    public function edit(DepartmentModel $department)
    {
        return view('departments.edit', [
            'department' => $department,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param DepartmentModel $department
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, DepartmentModel $department)
    {
        if (!Gate::check('edit', $department)) {
            return response()->json([
                'success' => false,
                'message' => 'Нет доступа для редактирования отдела'
            ]);
        }

        $validator = Validator::make(
            $request->all(),
            [
                'name' => 'required|max:255'
            ],
            [
                'name.required' => 'Название отдела не заполнено'
            ]
        );

        if ($validator->fails()) {
            return response()
                ->json([
                    'errors' => $this->formatValidationErrors($validator),
                    'success' => false,
                ]);

        }

        $department->fill($request->all());

        if (!$department->save()) {
            return response()
                ->json([
                    'success' => false,
                    'message' => 'Не удалось выполнить операцию.  Попробуйте позже'
                ]);
        }

        return response()
            ->json(['success' => true, 'message' => 'Отдел успешно изменен']);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $departments = DepartmentModel::whereId($id)
            ->withCount(['employees'])
            ->get();

        /** @var DepartmentModel $department */
        $department = $departments->find($id);

        if (!Gate::allows('destroy', $department)) {
            return response()->json([
                'success' => false,
                'message' => 'Нет доступа для удаления отдела'
            ]);
        }

        if ($department->employees_count) {
            return response()->json([
                'success' => false,
                'message' => 'Нельзя удалить отдел в котором есть сотрудники'
            ]);
        }

        if ($department->delete()) {
            return response()->json([
                'success' => true,
                'message' => 'Отдел успешно удален'
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'К сожалению не удалось выполнить операцию. Попробуйте позже'
        ]);
    }
}
