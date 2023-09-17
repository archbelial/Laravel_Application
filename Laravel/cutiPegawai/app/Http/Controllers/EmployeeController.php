<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
class EmployeeController extends Controller
{
    private $ApiUrl = "http://127.0.0.1:8000/api/employees";
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $response = Http::get($this->ApiUrl);
        $employees = $response->json();
        // dd($employees);
        return view('employees.index', compact('employees'))->with('i', (request()->input('page', 1) - 1) * 5);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('employees.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'code'           => 'required|numeric',
            'name'           => 'required|min:3',
            'gender'         => 'required',
            'position'       => 'required',
            'level'          => 'required',
            'leave_days'     => 'required',

        ]);

        $response = Http::post($this->ApiUrl."/store", $data);

        if ($response->successful()) {
            return redirect('/employees/' . $response->json('id'))->with('Success', 'Berhasil Menyimpan !');
        } else {
            return redirect('/employees/')->with('Failed', 'Gagal Menyimpan !');
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
        $response = Http::get("$this->ApiUrl/$id");
        $employee = $response->json();

        return view('employees.edit', compact('employee'));
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
        $employee = $response->json();
        
        return view('employees.edit', compact('employee'));
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
        // Validate and prepare data
        $data = $request->validate([
            'code'      => 'required|numeric',
            'name'      => 'required|min:3',
            'position'  => 'required',
            'level'     => 'required',
        ]);

        // Make a PATCH request to update
        $response = Http::patch("$this->ApiUrl/update/$id", $data);

        if ($response->successful()) {
            return redirect('/employees/'.$id)->with('Success', 'Berhasil Update !');
        } else {
            return redirect('/employees')->with('Failed', 'Gagal Update !');
        }
        
        // Redirect to the employee page
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
        Http::delete("$this->ApiUrl/delete/$id");

        // Redirect to the list of employee
        return redirect('/employees')->with('Success', 'Berhasil Hapus !');
    }

    public function proceed($id) {
        $data = http::post("$this->ApiUrl/proceed/$id");
        $reponse = $data->json();

        // dd($reponse);
        if ($reponse) {
            return redirect('/employees')->with('Success', 'Data Proceeded !');
        } else {
            return redirect('/employees/'.$id."/edit")->with('Failed', 'Failed To Proceeded !');
        }
        
    }
}
