<?php

namespace App\Http\Controllers;

use App\Salary;
use Illuminate\Http\Request;

class SalaryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = 'Pengajuan Surat';
        $subtitle = 'Form Pengajuan Surat Keterangan Penghasilan';
        $salaries = Salary::where('user_id', auth()->user()->id)->get();
        return view('salary.create', compact('title', 'subtitle', 'salaries'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'penghasilan'       => 'required|numeric',
            'alasan_pengajuan'  => 'required',
        ]);

        Salary::create([
            'user_id'   => auth()->user()->id,
            'salary'    => $request->penghasilan,
            'reason'    => $request->alasan_pengajuan
        ]);
        return redirect('/salary/create')->with('success', 'Pengajuan surat keterangan penghasilan berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        $request->validate([
            'penghasilan'       => 'required|numeric',
            'alasan_pengajuan'  => 'required',
        ]);

        Salary::where('id', $id)->update([
            'user_id'   => auth()->user()->id,
            'salary'    => $request->penghasilan,
            'reason'    => $request->alasan_pengajuan
        ]);
        return redirect('/salary/create')->with('success', 'Pengajuan surat keterangan penghasilan berhasil diperbarui');
    }

    /**
     * Verify1 the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function verify1(Request $request, $id)
    {
        //
    }

    /**
     * Verify2 the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function verify2(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Salary::destroy($id);
        return redirect('/salary/create')->with('success', 'Pengajuan surat keterangan penghasilan berhasil dihapus');
    }
}
