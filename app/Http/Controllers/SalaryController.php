<?php

namespace App\Http\Controllers;

use App\Letter;
use App\Salary;
use App\User;
use PDF;
use Alert;
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
        $salaries = Salary::where('letter_id', null)->get();
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
        $salaries = Salary::whereHas('letter', function ($letter) {
            $letter->where('verify1', 1);
        })->get();
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
        $salaries = Salary::whereHas('letter', function ($letter) {
            $letter->where('verify1', -1);
        })->get();
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
        $salaries = Salary::whereHas('letter', function ($letter) {
            $letter->where('verify2', null)->where('verify1', 1);
        })->get();
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
        $salaries = Salary::whereHas('letter', function ($letter) {
            $letter->where('verify2', 1)->where('verify1', 1);
        })->get();
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
        $salaries = Salary::whereHas('letter', function ($letter) {
            $letter->where('verify2', -1)->where('verify1', 1);
        })->get();
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
        if (auth()->user()->nik_file == null || auth()->user()->kk == null || auth()->user()->kk_file == null) {
            Alert::error('Harap melengkapi profil anda', 'Gagal')->persistent('tutup');
            return redirect('/edit-profile');
        }
        $request->validate([
            'penghasilan'       => 'required|numeric|min:0|max:2000000',
            'alasan_pengajuan'  => 'required',
        ]);
        Salary::create([
            'user_id'       =>  auth()->user()->id,
            'salary'        =>  $request->penghasilan,
            'reason'        =>  $request->alasan_pengajuan
        ]);
        Alert::success('Pengajuan surat keterangan penghasilan berhasil ditambahkan', 'berhasil');
        return redirect('/salary');
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
            'penghasilan'       => 'required|numeric|min:0|max:2000000',
            'alasan_pengajuan'  => 'required',
        ]);

        Salary::where('id', $id)->update([
            'salary'    => $request->penghasilan,
            'reason'    => $request->alasan_pengajuan
        ]);
        Alert::success('Pengajuan surat keterangan penghasilan berhasil diperbarui', 'berhasil');
        return redirect('/salary');
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
        $request->validate(['verifikasi' => 'required']);
        $time = now()->format('Y-m-d H:i:s');
        $create = [
            'verify1'       =>  $request->verifikasi,
            'created_at'    =>  $time,
            'updated_at'    =>  $time
        ];
        $salary = Salary::findOrFail($id);
        $reason1 = null;
        if ($request->verifikasi == -1) {
            $request->validate(['alasan_penolakan' => 'required']);
            $reason1 = $request->alasan_penolakan;
            $create['reason1'] = $request->alasan_penolakan;
        }

        if ($request->update == 1) {
            Letter::where('id', $salary->letter_id)->update(['verify1' => $request->verifikasi, 'reason1' => $reason1]);
            Alert::success('Pengajuan surat keterangan penghasilan berhasil diperbarui', 'berhasil');
            return redirect('/salary/verified1');
        } else {
            Letter::create($create);
            $letter = Letter::where('created_at', $time)->first();
            Salary::where('id', $id)->update(['letter_id' => $letter->id]);
            Alert::success('Pengajuan surat keterangan penghasilan berhasil diverifikasi', 'berhasil');
            return redirect('/salary/unprocessed1');
        }
    }

    public function editVerified1(Request $request, $id)
    {
        $salary = Salary::findOrFail($id);
        $title = 'Pengajuan Surat';
        return view('salary.edit-verified1', compact('title', 'salary'));
    }

    public function editUnprocessed1(Request $request, $id)
    {
        $salary = Salary::findOrFail($id);
        $title = 'Pengajuan Surat';
        return view('salary.edit-unprocessed1', compact('title', 'salary'));
    }

    public function editUnprocessed2(Request $request, $id)
    {
        $salary = Salary::findOrFail($id);
        $title = 'Pengajuan Surat';
        return view('salary.edit-unprocessed2', compact('title', 'salary'));
    }

    public function editDeclined2(Request $request, $id)
    {
        $salary = Salary::findOrFail($id);
        $title = 'Pengajuan Surat';
        return view('salary.edit-declined2', compact('title', 'salary'));
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

        $salary = Salary::findOrFail($id);
        $letter = Letter::where('verify1', 1)->where('verify2', 1)->orderBy('number', 'desc')->first();

        Letter::where('id', $salary->letter_id)->update([
            'verify2'   => $request->verifikasi
        ]);

        $reason = null;

        if ($letter == null) {
            $number = 1;
        } else {
            $number = $letter->number + 1;

        }

        if ($request->verifikasi == -1) {
            $request->validate(['alasan_penolakan' => 'required']);
            $number = null;
            $reason = $request->alasan_penolakan;
        }

        Letter::where('id', $salary->letter_id)->update([
            'number'    => $number,
            'reason2'   => $reason
        ]);

        if ($request->update == 1) {
            Alert::success('Pengajuan surat keterangan penghasilan berhasil diperbarui', 'berhasil');
            return redirect('/salary/verified2');
        } else {
            Alert::success('Pengajuan surat keterangan penghasilan berhasil diverifikasi', 'berhasil');
            return redirect('/salary/unprocessed2');
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
        Alert::success('Pengajuan surat keterangan penghasilan berhasil dihapus', 'berhasil');
        return redirect('/salary');
    }

    public function download($id)
    {
        $salary = Salary::findOrFail($id);
        $kepala = User::find(1);
        if ($salary->letter->verify1 == 1 && $salary->letter->verify2 == 1) {
            if ($salary->user_id == auth()->user()->id || auth()->user()->role_id == 2 || auth()->user()->role_id == 3) {
                $pdf = PDF::loadview('salary.download', compact('salary', 'kepala'));
                return $pdf->stream();
            } else {
                return abort(403, 'Anda tidak memiliki hak akses');
            }
        } else {
            return abort(404);
        }
    }
}
