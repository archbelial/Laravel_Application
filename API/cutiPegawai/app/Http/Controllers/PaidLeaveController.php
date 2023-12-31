<?php

namespace App\Http\Controllers;

use App\Models\PaidLeave;
use App\Http\Requests\StorePaidLeaveRequest;
use App\Http\Requests\UpdatePaidLeaveRequest;
use App\Helpers\ApiFormatter;
use Illuminate\Support\Facades\DB;

class PaidLeaveController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $paidLeavesData = PaidLeave::all();

        if ($paidLeavesData) {
            return ApiFormatter::createApi(200, 'Success', $paidLeavesData);
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
     * @param  \App\Http\Requests\StorePaidLeaveRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePaidLeaveRequest $request)
    {
        try {
            $validatedData = $request->validate([
                'code'              => 'required|numeric',
                'name'              => 'required|min:3',
                'gender'            => 'required',
                'position'          => 'required',
                'level'             => 'required',
                'remark'            => 'required',
                'paid_leave_start'  => 'required',
                'paid_leave_end'    => 'required',
            ]);

            $insertedPaidLeaves = PaidLeave::create($validatedData);

            $getDataSaved = PaidLeave::where('id', $insertedPaidLeaves->id)->first();

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
     * @param  \App\Models\PaidLeave  $paidLeave
     * @return \Illuminate\Http\Response
     */
    public function show(PaidLeave $paidLeave, $id)
    {
        try {
            $employee = PaidLeave::find($id);
            if ($employee) {
                return ApiFormatter::createApi(200, 'Success', $employee);
            } else {
                return ApiFormatter::createApi(404, 'Failed', 'Data Not Found');
            }
        } catch (\Throwable $th) {
            return ApiFormatter::createApi(400, 'Failed', $th->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PaidLeave  $paidLeave
     * @return \Illuminate\Http\Response
     */
    public function edit(PaidLeave $paidLeave)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatePaidLeaveRequest  $request
     * @param  \App\Models\PaidLeave  $paidLeave
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePaidLeaveRequest $request, PaidLeave $paidLeave, $id)
    {
        try {
            $validatedData = $request->validate([
                'code'              => 'required|numeric',
                'name'              => 'required|min:3',
                'position'          => 'required',
                'level'             => 'required',
                'paid_leave_start'  => 'required',
                'paid_leave_end'    => 'required',
                'remark'            => 'required',
            ]);
            
            $paidLeave = PaidLeave::find($id);

            if (!$paidLeave) {
                return ApiFormatter::createApi(404, 'Employee not found');
            }
            
            $paidLeave->update($validatedData);

            if ($paidLeave) {
                $updatedPaidLeavesData = PaidLeave::find($id);
                return ApiFormatter::createApi(200, 'Success', $updatedPaidLeavesData);
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
     * @param  \App\Models\PaidLeave  $paidLeave
     * @return \Illuminate\Http\Response
     */
    public function destroy(PaidLeave $paidLeave, $id)
    {
        try {
            $paidLeave = PaidLeave::destroy($id);
            if ($paidLeave) {
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

            $proceedEmployee = db::select('exec xsp_paid_leaves_proceed @p_id = ?',[$id]);

            if ($proceedEmployee) {
                return ApiFormatter::createApi(200, 'Success', 'Employee data has been proceeded.');
            } else {
                return ApiFormatter::createApi(400, 'Failed', 'Failed to proceed employee data.');
            }
        } catch (\Throwable $th) {
            return ApiFormatter::createApi(400, 'Failed',  'An error occurred while processing the request: ' . $th->getMessage());
        }
    }
}
