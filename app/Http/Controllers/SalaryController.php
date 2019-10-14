<?php

namespace App\Http\Controllers;

use App\Salary;
use App\User;
use PDF;
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
        $title = 'Pengajuan Surat';
        $subtitle = 'Form Pengajuan Surat Keterangan Penghasilan';
        $salaries = Salary::where('user_id', auth()->user()->id)->get();
        return view('salary.index', compact('title', 'subtitle', 'salaries'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function unprocessed1()
    {
        $title = 'Pengajuan Surat';
        $subtitle = 'Data Pengajuan Surat Keterangan Penghasilan';
        $salaries = Salary::where('verify1', null)->get();
        return view('salary.unprocessed1', compact('title', 'subtitle', 'salaries'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function verified1()
    {
        $title = 'Pengajuan Surat';
        $subtitle = 'Data Pengajuan Surat Keterangan Penghasilan';
        $salaries = Salary::where('verify1', 1)->get();
        return view('salary.verified1', compact('title', 'subtitle', 'salaries'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function declined1()
    {
        $title = 'Pengajuan Surat';
        $subtitle = 'Data Pengajuan Surat Keterangan Penghasilan';
        $salaries = Salary::where('verify1', -1)->get();
        return view('salary.declined1', compact('title', 'subtitle', 'salaries'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function unprocessed2()
    {
        $title = 'Pengajuan Surat';
        $subtitle = 'Data Pengajuan Surat Keterangan Penghasilan';
        $salaries = Salary::where('verify2', null)->where('verify1', 1)->get();
        return view('salary.unprocessed2', compact('title', 'subtitle', 'salaries'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function verified2()
    {
        $title = 'Pengajuan Surat';
        $subtitle = 'Data Pengajuan Surat Keterangan Penghasilan';
        $salaries = Salary::where('verify2', 1)->where('verify1', 1)->get();
        return view('salary.verified2', compact('title', 'subtitle', 'salaries'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function declined2()
    {
        $title = 'Pengajuan Surat';
        $subtitle = 'Data Pengajuan Surat Keterangan Penghasilan';
        $salaries = Salary::where('verify2', -1)->where('verify1', 1)->get();
        return view('salary.declined2', compact('title', 'subtitle', 'salaries'));
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
        return redirect('/salary')->with('success', 'Pengajuan surat keterangan penghasilan berhasil ditambahkan');
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
        return redirect('/salary')->with('success', 'Pengajuan surat keterangan penghasilan berhasil diperbarui');
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
        $request->validate([
            'verifikasi'   => 'required',
        ]);

        Salary::where('id', $id)->update([
            'verify1'       => $request->verifikasi
        ]);
        if ($request->update == 1) {
            return redirect('/salary/verified1')->with('success', 'Pengajuan surat keterangan penghasilan berhasil diperbarui');
        } else {
            return redirect('/salary/unprocessed1')->with('success', 'Pengajuan surat keterangan penghasilan berhasil diverifikasi');
        }
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
        $request->validate([
            'verifikasi'   => 'required'
        ]);

        Salary::where('id', $id)->update([
            'verify2'       => $request->verifikasi
        ]);

        if ($request->update == 1) {
            return redirect('/salary/verified2')->with('success', 'Pengajuan surat keterangan penghasilan berhasil diperbarui');
        } else {
            return redirect('/salary/unprocessed2')->with('success', 'Pengajuan surat keterangan penghasilan berhasil diverifikasi');
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
        Salary::destroy($id);
        return redirect('/salary')->with('success', 'Pengajuan surat keterangan penghasilan berhasil dihapus');
    }

    public function download($id)
    {
        $salary = Salary::findOrFail($id);
        $kepala = User::find(1);

        if ($salary->user_id == auth()->user()->id || $salary->user->role_id == 2 || $salary->user->role_id == 3) {
            $pdf = PDF::loadview('salary.download', compact('salary', 'kepala'));
            return $pdf->stream();
        } else {
            return abort(403, 'Anda tidak memiliki hak akses');
        }
    }
}
