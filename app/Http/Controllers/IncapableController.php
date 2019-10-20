<?php

namespace App\Http\Controllers;

use App\Letter;
use App\Incapable;
use App\User;
use PDF;
use Alert;
use App\Http\Requests\IncapableRequest;
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
    public function store(IncapableRequest $request)
    {
        if (auth()->user()->nik_file == null || auth()->user()->kk == null || auth()->user()->kk_file == null) {
            Alert::error('Harap melengkapi profil anda', 'Gagal')->persistent('tutup');
            return redirect('/edit-profile');
        }
        $request->validated();
        Incapable::create($this->dataIncapable('store',$request));
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
    public function update(IncapableRequest $request, $id)
    {
        $request->validated();
        Incapable::where('id', $id)->update($this->dataIncapable('update',$request));
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
        $request->validate(['verifikasi' => 'required', 'alasan_pengajuan' => 'required']);
        $time = now()->format('Y-m-d H:i:s');
        $create = [
            'verify1'       =>  $request->verifikasi,
            'created_at'    =>  $time,
            'updated_at'    =>  $time
        ];
        $incapable = Incapable::findOrFail($id);
        $reason1 = null;
        if ($request->verifikasi == -1) {
            $request->validate(['alasan_penolakan' => 'required']);
            $reason1 = $request->alasan_penolakan;
            $create['reason1'] = $request->alasan_penolakan;
        }
        if ($request->update == 1) {
            Incapable::where('id', $id)->update(['reason' => $request->alasan_pengajuan]);
            $dataVerify = ['verify1' => $request->verifikasi, 'reason1' => $reason1];
            if ($incapable->letter->verify2 == -1) {
                $dataVerify['verify2'] = null;
                $dataVerify['reason2'] = null;
            }
            Letter::where('id', $incapable->letter_id)->update($dataVerify);
            Alert::success('Pengajuan surat keterangan tidak mampu berhasil diperbarui', 'berhasil');
            return redirect('/incapable/verified1');
        } else {
            Letter::create($create);
            $letter = Letter::where('created_at', $time)->first();
            Incapable::where('id', $id)->update(['letter_id' => $letter->id, 'reason' => $request->alasan_pengajuan]);
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

        Letter::where('id', $incapable->letter_id)->update([
            'number'    => $number,
            'reason2'   => $reason
        ]);

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

    private function dataIncapable($method, $request){
        $data = [
            'name'          =>  $request->nama,
            'birth_place'   =>  $request->tempat_lahir,
            'birth_date'    =>  $request->tanggal_lahir,
            'job'           =>  $request->pekerjaan,
            'address'       =>  $request->alamat,
            'reason'        =>  $request->alasan_pengajuan,
            'as'            =>  $request->merupakan
        ];

        if ($method == 'store') {
            $data['user_id'] = auth()->user()->id;
        }

        return $data;
    }
}
