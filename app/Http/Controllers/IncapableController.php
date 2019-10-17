<?php

namespace App\Http\Controllers;

use App\Letter;
use App\Incapable;
use App\User;
use PDF;
use Alert;
use Illuminate\Http\Request;

class IncapableController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = 'Pengajuan Surat';
        $subtitle = 'Form Pengajuan Surat Keterangan Tidak Mampu';
        $incapables = Incapable::where('user_id', auth()->user()->id)->get();
        return view('incapable.index', compact('title', 'subtitle', 'incapables'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function unprocessed1()
    {
        $title = 'Pengajuan Surat';
        $subtitle = 'Data Pengajuan Surat Keterangan Tidak Mampu';
        $incapables = Incapable::where('letter_id', null)->get();
        return view('incapable.unprocessed1', compact('title', 'subtitle', 'incapables'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function verified1()
    {
        $title = 'Pengajuan Surat';
        $subtitle = 'Data Pengajuan Surat Keterangan Tidak Mampu';
        $incapables = Incapable::whereHas('letter', function ($letter) {
            $letter->where('verify1', 1);
        })->get();
        return view('incapable.verified1', compact('title', 'subtitle', 'incapables'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function declined1()
    {
        $title = 'Pengajuan Surat';
        $subtitle = 'Data Pengajuan Surat Keterangan Tidak Mampu';
        $incapables = Incapable::whereHas('letter', function ($letter) {
            $letter->where('verify1', -1);
        })->get();
        return view('incapable.declined1', compact('title', 'subtitle', 'incapables'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function unprocessed2()
    {
        $title = 'Pengajuan Surat';
        $subtitle = 'Data Pengajuan Surat Keterangan Tidak Mampu';
        $incapables = Incapable::whereHas('letter', function ($letter) {
            $letter->where('verify2', null)->where('verify1', 1);
        })->get();
        return view('incapable.unprocessed2', compact('title', 'subtitle', 'incapables'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function verified2()
    {
        $title = 'Pengajuan Surat';
        $subtitle = 'Data Pengajuan Surat Keterangan Tidak Mampu';
        $incapables = Incapable::whereHas('letter', function ($letter) {
            $letter->where('verify2', 1)->where('verify1', 1);
        })->get();
        return view('incapable.verified2', compact('title', 'subtitle', 'incapables'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function declined2()
    {
        $title = 'Pengajuan Surat';
        $subtitle = 'Data Pengajuan Surat Keterangan Tidak Mampu';
        $incapables = Incapable::whereHas('letter', function ($letter) {
            $letter->where('verify2', -1)->where('verify1', 1);
        })->get();
        return view('incapable.declined2', compact('title', 'subtitle', 'incapables'));
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
            'nama'              => 'required',
            'tempat_lahir'      => 'required',
            'tanggal_lahir'     => 'required|date',
            'pekerjaan'         => 'required',
            'alamat'            => 'required',
            'alasan_pengajuan'  => 'required',
            'merupakan'         => 'required',
        ]);
        Incapable::create([
            'user_id'       =>  auth()->user()->id,
            'name'          =>  $request->nama,
            'birth_place'   =>  $request->tempat_lahir,
            'birth_date'    =>  $request->tanggal_lahir,
            'job'           =>  $request->pekerjaan,
            'address'       =>  $request->alamat,
            'reason'        =>  $request->alasan_pengajuan,
            'as'            =>  $request->merupakan
        ]);
        Alert::success('Pengajuan surat keterangan tidak mampu berhasil ditambahkan', 'berhasil');
        return redirect('/incapable');
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
            'nama'              => 'required',
            'tempat_lahir'      => 'required',
            'tanggal_lahir'     => 'required|date',
            'pekerjaan'         => 'required',
            'alamat'            => 'required',
            'alasan_pengajuan'  => 'required',
            'merupakan'         => 'required',
        ]);

        Incapable::where('id', $id)->update([
            'name'          =>  $request->nama,
            'birth_place'   =>  $request->tempat_lahir,
            'birth_date'    =>  $request->tanggal_lahir,
            'job'           =>  $request->pekerjaan,
            'address'       =>  $request->alamat,
            'reason'        =>  $request->alasan_pengajuan,
            'as'            =>  $request->merupakan
        ]);
        Alert::success('Pengajuan surat keterangan tidak mampu berhasil diperbarui', 'berhasil');
        return redirect('/incapable');
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
            'verifikasi'        => 'required',
            'alasan_pengajuan'  => 'required',
        ]);

        if ($request->update == 1) {
            Letter::where('id', $id)->update([
                'verify1'       => $request->verifikasi
            ]);
            Alert::success('Pengajuan surat keterangan tidak mampu berhasil diperbarui', 'berhasil');
            return redirect('/incapable/verified1');
        } else {
            $time = now()->format('Y-m-d H:i:s');
            Letter::create([
                'verify1'       => $request->verifikasi,
                'created_at'    =>  $time,
                'updated_at'    =>  $time
            ]);

            $letter = Letter::where('created_at', $time)->first();
            Incapable::where('id', $id)->update([
                'letter_id' => $letter->id,
                'reason'    => $request->alasan_pengajuan,
            ]);
            Alert::success('Pengajuan surat keterangan tidak mampu berhasil diverifikasi', 'berhasil');
            return redirect('/incapable/unprocessed1');
        }
    }

    public function editVerified1(Request $request, $id)
    {
        $incapable = Incapable::findOrFail($id);
        $title = 'Pengajuan Surat';
        return view('incapable.edit-verified1', compact('title', 'incapable'));
    }

    public function editUnprocessed1(Request $request, $id)
    {
        $incapable = Incapable::findOrFail($id);
        $title = 'Pengajuan Surat';
        return view('incapable.edit-unprocessed1', compact('title', 'incapable'));
    }

    public function editUnprocessed2(Request $request, $id)
    {
        $incapable = Incapable::findOrFail($id);
        $title = 'Pengajuan Surat';
        return view('incapable.edit-unprocessed2', compact('title', 'incapable'));
    }

    public function editDeclined2(Request $request, $id)
    {
        $incapable = Incapable::findOrFail($id);
        $title = 'Pengajuan Surat';
        return view('incapable.edit-declined2', compact('title', 'incapable'));
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

        $incapable = Incapable::findOrFail($id);
        $letter = Letter::where('verify1', 1)->where('verify2', 1)->orderBy('number', 'desc')->first();

        Letter::where('id', $incapable->letter_id)->update([
            'verify2'   => $request->verifikasi
        ]);

        if ($request->verifikasi == 1) {
            if ($letter == null) {
                Letter::where('id', $incapable->letter_id)->update([
                    'number'    => 1,
                ]);
            } else {
                Letter::where('id', $incapable->letter_id)->update([
                    'number'    => $letter->number + 1,
                ]);
            }
        } else {
            Letter::where('id', $incapable->letter_id)->update([
                'number'    => null,
            ]);
        }

        if ($request->update == 1) {
            Alert::success('Pengajuan surat keterangan tidak mampu berhasil diperbarui', 'berhasil');
            return redirect('/incapable/verified2');
        } else {
            Alert::success('Pengajuan surat keterangan tidak mampu berhasil diverifikasi', 'berhasil');
            return redirect('/incapable/unprocessed2');
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
        Incapable::destroy($id);
        Alert::success('Pengajuan surat keterangan tidak mampu berhasil dihapus', 'berhasil');
        return redirect('/incapable');
    }

    public function download($id)
    {
        $incapable = Incapable::findOrFail($id);
        $kepala = User::find(1);
        if ($incapable->letter->verify1 == 1 && $incapable->letter->verify2 == 1) {
            if ($incapable->user_id == auth()->user()->id || auth()->user()->role_id == 2 || auth()->user()->role_id == 3) {
                $pdf = PDF::loadview('incapable.download', compact('incapable', 'kepala'));
                return $pdf->stream();
            } else {
                return abort(403, 'Anda tidak memiliki hak akses');
            }
        } else {
            return abort(404);
        }
    }
}
