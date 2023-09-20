<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class PaidLeaveController extends Controller
{
    private $ApiUrl = "http://127.0.0.1:8000/api/paidleaves";

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $response = Http::get($this->ApiUrl);
        $paidLeavesData = $response->json();
        return view('paidleaves.index', compact('paidLeavesData'))->with('i', (request()->input('page', 1) - 1) * 5);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('paidleaves.create');
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
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
        
        $response = Http::post("$this->ApiUrl/store/$validatedData");

        if ($response->successful()) {
            return redirect('/paidleaves/')->with('Success', 'Berhasil Menyimpan !');
        } else {
            return redirect('/paidleaves/')->with('Failed', 'Gagal Menyimpan !');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $response = Http::get("$this->ApiUrl/$id");
        $paidLeave = $response->json();
        $startDate = date('Y-m-d', strtotime($paidLeave['data']['PAID_LEAVE_START']));
        $endDate = date('Y-m-d', strtotime($paidLeave['data']['PAID_LEAVE_END']));
        
        return view('paidleaves.edit', compact('paidLeave', 'startDate', 'endDate'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'code'              => 'required|numeric',
            'name'              => 'required|min:3',
            'position'          => 'required',
            'level'             => 'required',
            'paid_leave_start'  => 'required',
            'paid_leave_end'    => 'required',
            'remark'            => 'required',
        ]);
        
        $response = Http::patch("$this->ApiUrl/update/$id", $validatedData);
        if ($response->successful()) {
            return redirect('/paidleaves/'.$id.'/edit')->with('Success', 'Berhasil Update !');
        } else {
            return redirect('/paidleaves')->with('Failed', 'Gagal Update !');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Make a DELETE request to remove data
        $delete = Http::get("$this->ApiUrl/delete/$id");

        // Redirect to the list of employee
        return redirect('/paidleaves')->with('Success', 'Berhasil Hapus !');
    }

    public function proceed($id) {
        $data = http::post("$this->ApiUrl/proceed/$id");
        $reponse = $data->json();

        
        if ($reponse) {
            return redirect('/paidleaves')->with('Success', 'Data Proceeded !');
        } else {
            return redirect('/paidleaves/'.$id."/edit")->with('Failed', 'Failed To Proceeded !');
        }
        
    }
}
