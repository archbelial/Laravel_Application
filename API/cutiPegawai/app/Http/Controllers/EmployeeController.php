<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\PaidLeave;
use App\Http\Requests\StoreEmployeeRequest;
use App\Http\Requests\UpdateEmployeeRequest;
use Illuminate\Support\Facades\DB;
use App\Helpers\ApiFormatter;


class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $employees = Employee::where('STATUS', 'HOLD')->get();

        if ($employees) {
            return ApiFormatter::createApi(200, 'Success', $employees);
        } else {
            return ApiFormatter::createApi(400, 'Failed');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreEmployeeRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreEmployeeRequest $request)
    {
        try {
            $validatedData = $request->validate([
                'code'           => 'required|numeric',
                'name'           => 'required|min:3',
                'gender'         => 'required',
                'position'       => 'required',
                'level'          => 'required',
                'leave_days'     => 'required',
            ]);

            $insertedEmployee = Employee::create($validatedData);

            $getDataSaved = Employee::where('id', $insertedEmployee->id)->first();

            if ($getDataSaved) {
                return ApiFormatter::createApi(200, 'Success', $getDataSaved);
            } else {
                return ApiFormatter::createApi(400, 'Failed');
            }
        } catch (\Throwable $th) {
            return ApiFormatter::createApi(400, 'Failed', $th->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function show(Employee $employee, $id)
    {
        try {
            $employee = Employee::find($id);
            if ($employee) {
                return ApiFormatter::createApi(200, 'Success', $employee);
            } else {
                return ApiFormatter::createApi(400, 'Failed');
            }
        } catch (\Throwable $th) {
            return ApiFormatter::createApi(400, 'Failed', $th->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function edit(Employee $employee)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateEmployeeRequest  $request
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateEmployeeRequest $request, Employee $employee, $id)
    {
        try {
            $validatedData = $request->validate([
                'code'      => 'required|numeric',
                'name'      => 'required|min:3',
                'position'  => 'required',
                'level'     => 'required',
            ]);
            
            $employee = Employee::find($id);

            if (!$employee) {
                return ApiFormatter::createApi(404, 'Employee not found');
            }
            
            $employee->update($validatedData);

            if ($employee) {
                $updatedEmployeeData = Employee::find($id);
                return ApiFormatter::createApi(200, 'Success', $updatedEmployeeData);
            } else {
                return ApiFormatter::createApi(400, 'Failed');
            }
        } catch (\Throwable $th) {
            return ApiFormatter::createApi(400, 'Failed', $th->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function destroy(Employee $employee, $id)
    {
        try {
            $deletedEmploye = Employee::destroy($id);
            if ($deletedEmploye) {
                return ApiFormatter::createApi(200, 'Success', 'Employee has been deleted successfully.');
            } else {
                return ApiFormatter::createApi(400, 'Failed', 'Employee deletion failed. Employee not found.');
            }
        } catch (\Throwable $th) {
            return ApiFormatter::createApi(400, 'Failed', 'An error occurred while deleting the employee: ' . $th->getMessage());
        }
    }

    public function proceed(PaidLeave $paidLeave, $id)
    {
        try {

            $proceedEmployee = db::select('exec xsp_employees_proceed_to_paid_leaves @p_id = ?',[$id]);

            if ($proceedEmployee) {
                return ApiFormatter::createApi(200, 'Success', 'Employee data has been proceeded to paid leaves.');
            } else {
                return ApiFormatter::createApi(400, 'Failed', 'Failed to proceed employee data to paid leaves.');
            }
        } catch (\Throwable $th) {
            return ApiFormatter::createApi(400, 'Failed',  'An error occurred while processing the request: ' . $th->getMessage());
        }
    }
}
