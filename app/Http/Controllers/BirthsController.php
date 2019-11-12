<?php

namespace App\Http\Controllers;

use App\Birth;
use DataTables;
use Alert;
use App\Http\Requests\BirthRequest;
use App\Letter;
use App\User;
use PDF;
use File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;

class BirthsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = 'Pengajuan Surat';
        $subtitle = 'Data Pengajuan Surat Keterangan Kelahiran';
        return view('births.index', compact('title', 'subtitle'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = 'Pengajuan Surat';
        $subtitle = 'Form Pengajuan Surat Keterangan Kelahiran';
        return view('births.create', compact('title', 'subtitle'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\BirthRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BirthRequest $request)
    {
        if (auth()->user()->nik_file == null || auth()->user()->kk == null || auth()->user()->kk_file == null) {
            Alert::error('Harap melengkapi profil anda', 'Gagal')->persistent('tutup');
            return redirect('/edit-profile');
        }

        $request->validated();

        $birth = new Birth;

        $birth->name            = $request->nama;
        $birth->gender          = $request->jenis_kelamin;
        $birth->birth_place     = $request->tempat_lahir;
        $birth->birth_date      = $request->tanggal_lahir;
        $birth->religion        = $request->agama;
        $birth->address         = $request->alamat;
        $birth->order           = $request->anak_ke;
        $birth->name_parent     = $request->nama_orangtua;
        $birth->age             = $request->usia_orangtua;
        if (auth()->user()->gender->gender == "Laki-laki") {
            $birth->gender_parent   = 'Perempuan';
        } elseif(auth()->user()->gender->gender == "Perempuan") {
            $birth->gender_parent   = 'Laki-laki';
        }
        $birth->job             = $request->pekerjaan_orangtua;
        $birth->address_parent  = $request->alamat_orangtua;
        $birth->user_id         = auth()->user()->id;
        $birth->file            = $this->setImageUpload($request->surat_pengantar,'img/surat_pengantar');
        $birth->save();

        Alert::success('Pengajuan surat keterangan kelahiran berhasil ditambahkan', 'berhasil');
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Birth  $birth
     * @return \Illuminate\Http\Response
     */
    public function show(Birth $birth)
    {
        $kepala = User::find(1);
        if ($birth->letter->verify1 == 1 && $birth->letter->verify2 == 1) {
            if ($birth->user_id == auth()->user()->id || auth()->user()->role_id == 2 || auth()->user()->role_id == 3) {
                $pdf = PDF::loadview('births.show', compact('birth', 'kepala'));
                return $pdf->stream();
            } else {
                return abort(403, 'Anda tidak memiliki hak akses');
            }
        } else {
            return abort(404);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\BirthRequest  $request
     * @param  \App\Birth  $birth
     * @return \Illuminate\Http\Response
     */
    public function update(BirthRequest $request, Birth $birth)
    {
        $request->validated();

        $birth->name            = $request->nama;
        $birth->gender          = $request->jenis_kelamin;
        $birth->birth_place     = $request->tempat_lahir;
        $birth->birth_date      = $request->tanggal_lahir;
        $birth->religion        = $request->agama;
        $birth->address         = $request->alamat;
        $birth->order           = $request->anak_ke;
        $birth->name_parent     = $request->nama_orangtua;
        $birth->age             = $request->usia_orangtua;
        if (auth()->user()->gender->gender == "Laki-laki") {
            $birth->gender_parent   = 'Perempuan';
        } elseif(auth()->user()->gender->gender == "Perempuan") {
            $birth->gender_parent   = 'Laki-laki';
        }
        $birth->job             = $request->pekerjaan_orangtua;
        $birth->address_parent  = $request->alamat_orangtua;
        if ($request->surat_pengantar) {
            $birth->file = $this->setImageUpload($request->surat_pengantar,'img/surat_pengantar',$birth->file);
        }
        $birth->save();

        Alert::success('Pengajuan surat keterangan kelahiran berhasil diperbarui', 'berhasil');
        return redirect()->back();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Birth  $birth
     * @return \Illuminate\Http\Response
     */
    public function verify1(Request $request, Birth $birth)
    {
        if ($request->update) {
            $letter = Letter::findOrFail($birth->letter_id);
        } else {
            $letter = new Letter;
        }
        $request->validate([
            'verifikasi'    => ['required']
        ]);
        if($request->verifikasi == -1){
            $request->validate([
                'alasan_penolakan' => ['required']
            ]);
            $letter->verify1 = -1;
            $letter->reason1 = $request->alasan_penolakan;
            File::delete(public_path('img/surat_pengantar'. '/' . $birth->file));
        } else {
            $letter->verify1 = 1;
            $letter->verify2 = null;
            $letter->reason2 = null;
        }
        
        $letter->save();
        
        $birth->letter_id = $letter->id;
        $birth->save();
        Alert::success('Pengajuan surat keterangan kelahiran berhasil diverifikasi', 'berhasil');
        return redirect()->back();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Birth  $birth
     * @return \Illuminate\Http\Response
     */
    public function verify2(Request $request, Birth $birth)
    {
        $letter = Letter::findOrFail($birth->letter_id);
        $cop = Letter::where('verify1', 1)->where('verify2', 1)->orderBy('number', 'desc')->first();
        $request->validate([
            'verifikasi' => ['required']
        ]);
        if ($cop == null) {
            $letter->number = 1;
        } else {
            $letter->number = $cop->number + 1;
        }

        if($request->verifikasi == -1){
            $request->validate([
                'alasan_penolakan' => ['required']
            ]);
            $letter->verify2 = -1;
            $letter->reason2 = $request->alasan_penolakan;
        } else {
            $letter->verify2 = 1;
            $letter->reason2 = null;
        }
        
        $letter->save();
        Alert::success('Pengajuan surat keterangan kelahiran berhasil diverifikasi', 'berhasil');
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Birth  $birth
     * @return \Illuminate\Http\Response
     */
    public function destroy(Birth $birth)
    {
        File::delete(public_path('img/surat_pengantar'. '/' . $birth->file));
        $birth->delete();
        Alert::success('Pengajuan surat keterangan kelahiran berhasil dihapus', 'berhasil');
        return redirect()->back();
    }
    
    public function getEditBirths(Request $request)
    {
        $birth = Birth::findOrFail($request->id);
        echo json_encode($birth);
    }

    public function getBirths()
    {
        $births = Birth::with('letter', 'user')->whereUserId(auth()->user()->id)->select('births.*');
        return DataTables::eloquent($births)
            ->addColumn('tanggal_pengajuan', function ($birth) {
                return $birth->created_at->format('d M Y - H:i:s');
            })
            ->addColumn('tanggal_disetujui', function ($birth) {
                if ($birth->letter_id != null) {
                    if ($birth->letter->verify1 == 1 && $birth->letter->verify2 == 1) {
                        return $birth->letter->updated_at->format('d M Y - H:i:s');
                    } else {
                        return '-';
                    }
                } else {
                    return '-';
                }
            })
            ->addColumn('status', function ($birth) {
                if ($birth->letter_id != null) {
                    if ($birth->letter->verify1 == 1 && $birth->letter->verify2 == 1) {
                        return Lang::get('letter.approved');
                    } elseif ($birth->letter->verify1 == 1 && $birth->letter->verify2 == null || $birth->letter->verify2 == -1) {
                        return Lang::get('letter.inprocessed');
                    } elseif ($birth->letter->verify1 == -1 && $birth->letter->verify2 == null || $birth->letter->verify2 == -1) {
                        return '<span class="font-weight-bold">' . Lang::get('letter.declined') . '</span> <br>(' . $birth->letter->reason1 . ')';
                    }
                } else {
                    return Lang::get('letter.unprocessed');
                }
            })
            ->addColumn('action', function ($birth) {
                if ($birth->letter_id != null) {
                    if ($birth->letter->verify1 == 1 && $birth->letter->verify2 == 1) {
                        return '<a target="_blank" class="d-inline-block btn btn-success btn-sm btn-circle" data-toggle="tooltip" data-placement="top" title="Unduh" href="' . route('births.download', $birth->id) . '">
                                    <i class="fas fa-download"></i>
                                </a>';
                    } elseif ($birth->letter->verify1 == 1 && $birth->letter->verify2 == null || $birth->letter->verify2 == -1) {
                        return '-';
                    } elseif ($birth->letter->verify1 == -1 && $birth->letter->verify2 == null || $birth->letter->verify2 == -1) {
                        return '-';
                    }
                } else {
                    return '<button class="editSubmission btn-circle btn-warning btn-sm btn" data-toggle="modal" data-target="#modalEditBirth" data-toggle="tooltip" data-placement="top" title="Ubah"  onclick="editModal(' . $birth->id . ')"><i class="fas fa-edit"></i></button>
                            <form class="d-inline-block" action="' . route('births.destroy', $birth->id) . '" method="POST">
                                <input type="hidden" name="_token" value="' . csrf_token() . '">
                                <input type="hidden" name="_method" value="delete">
                                <button type="submit" class="btn btn-danger btn-circle btn-sm" data-toggle="tooltip" data-placement="top" title="Hapus" onclick="return confirm(`' . Lang::get('letter.delete_confirm') . '`);">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>';
                }
            })
            ->rawColumns(['tanggal_pengajuan', 'tanggal_disetujui', 'status', 'action'])
            ->toJson();
    }
    public function getUnprocessed1()
    {
        $births = Birth::with('user', 'letter')->whereLetterId(null)->select('births.*');
        return DataTables::eloquent($births)
            ->addColumn('nik', function ($birth) {
                return '<a onclick="viewDetail(' . $birth->user_id . ')" href="" data-toggle="modal" data-target="#userDetailModal" data-toggle="tooltip" data-placement="top" title="Lihat detail pengguna" >' . $birth->user->nik . '</a>';
            })
            ->addColumn('tanggal_pengajuan', function ($birth) {
                return $birth->created_at->format('d M Y - H:i:s');
            })
            ->addColumn('action', function ($birth) {
                return '<button class="btn-circle btn-warning btn-sm btn" data-toggle="modal" data-target="#modalVerification" data-toggle="tooltip" data-placement="top" title="Verifikasi" onclick="modalVerification(' . $birth->id . ')"><i class="fas fa-check"></i></button>
                        <button class="btn-circle btn-primary btn-sm btn" data-toggle="modal" data-target="#modalDetailSP" data-toggle="tooltip" data-placement="top" title="Detail Surat Pengantar" onclick="modalVerification(`' . $birth->id . '`)"><i class="fas fa-eye"></i></button>'
                ;
            })
            ->rawColumns(['nik','tanggal_pengajuan', 'action'])
            ->toJson();
    }

    public function getUnprocessed2()
    {
        $births = Birth::with('user', 'letter')->whereHas('letter', function ($s) {
            $s->whereVerify1(1)->whereVerify2(null);
        })->select('births.*');
        return DataTables::eloquent($births)
            ->addColumn('nik', function ($birth) {
                return '<a onclick="viewDetail(' . $birth->user_id . ')" href="" data-toggle="modal" data-target="#userDetailModal" data-toggle="tooltip" data-placement="top" title="Lihat detail pengguna" >' . $birth->user->nik . '</a>';
            })
            ->addColumn('tanggal_pengajuan', function ($birth) {
                return $birth->created_at->format('d M Y - H:i:s');
            })
            ->addColumn('action', function ($birth) {
                return '<button class="btn-circle btn-warning btn-sm btn" data-toggle="modal" data-target="#modalVerification" data-toggle="tooltip" data-placement="top" title="Verifikasi" onclick="modalVerification(' . $birth->id . ')"><i class="fas fa-check"></i></button>
                        <button class="btn-circle btn-primary btn-sm btn" data-toggle="modal" data-target="#modalDetailSP" data-toggle="tooltip" data-placement="top" title="Detail Surat Pengantar" onclick="modalVerification(`' . $birth->id . '`)"><i class="fas fa-eye"></i></button>'
                ;
            })
            ->rawColumns(['nik','tanggal_pengajuan','action'])
            ->toJson();
    }

    public function getVerified1()
    {
        $births = Birth::with('user', 'letter')->whereHas('letter', function ($s) { $s->whereVerify1(1); })->select('births.*');
        return DataTables::eloquent($births)
            ->addColumn('nik', function ($birth) {
                return '<a onclick="viewDetail(' . $birth->user_id . ')" href="" data-toggle="modal" data-target="#userDetailModal" data-toggle="tooltip" data-placement="top" title="Lihat detail pengguna" >' . $birth->user->nik . '</a>';
            })
            ->addColumn('tanggal_pengajuan', function ($birth) {
                return $birth->created_at->format('d M Y - H:i:s');
            })
            ->addColumn('tanggal_disetujui', function ($birth) {
                return $birth->letter->updated_at->format('d M Y - H:i:s');
            })
            ->addColumn('status', function ($birth) {
                if ($birth->letter->verify1 == 1 && $birth->letter->verify2 == 1) {
                    return Lang::get('letter.approved');
                } elseif ($birth->letter->verify1 == 1 && $birth->letter->verify2 == null) {
                    return 'Belum di proses';
                } elseif ($birth->letter->verify1 == 1 && $birth->letter->verify2 == -1) {
                    return '<span class="font-weight-bold">' . Lang::get('letter.declined') . '</span> <br>(' . $birth->letter->reason2 . ')';
                }
            })
            ->addColumn('action', function ($birth) {
                if ($birth->letter->verify1 == 1 && $birth->letter->verify2 == 1) {
                    return '<a target="_blank" class="d-inline-block btn btn-success btn-sm btn-circle" data-toggle="tooltip" data-placement="top" title="Unduh" href="' . route('births.download', $birth->id) . '">
                                <i class="fas fa-download"></i>
                            </a>
                            <button class="btn-circle btn-primary btn-sm btn" data-toggle="modal" data-target="#modalDetailSP" data-toggle="tooltip" data-placement="top" title="Detail Surat Pengantar" onclick="modalVerification(`' . $birth->id . '`)"><i class="fas fa-eye"></i></button>';
                } elseif ($birth->letter->verify1 == 1 && $birth->letter->verify2 == null || $birth->letter->verify2 == -1) {
                    return '<button class="btn-circle btn-warning btn-sm btn" data-toggle="modal" data-target="#modalVerification" data-toggle="tooltip" data-placement="top" title="Ubah Verifikasi" onclick="modalVerification(' . $birth->id . ',true)"><i class="fas fa-edit"></i></button>
                            <button class="btn-circle btn-primary btn-sm btn" data-toggle="modal" data-target="#modalDetailSP" data-toggle="tooltip" data-placement="top" title="Detail Surat Pengantar" onclick="modalVerification(`' . $birth->id . '`)"><i class="fas fa-eye"></i></button>'
                    ;
                }
            })
            ->rawColumns(['nik', 'tanggal_pengajuan', 'tanggal_disetujui', 'status', 'action'])
            ->toJson();
    }

    public function getVerified2()
    {
        $births = Birth::with('user', 'letter')->whereHas('letter', function ($s) {
            $s->whereVerify2(1)->whereVerify1(1);
        })->select('births.*');
        return DataTables::eloquent($births)
            ->addColumn('nik', function ($birth) {
                return '<a onclick="viewDetail(' . $birth->user_id . ')" href="" data-toggle="modal" data-target="#userDetailModal" data-toggle="tooltip" data-placement="top" title="Lihat detail pengguna" >' . $birth->user->nik . '</a>';
            })
            ->addColumn('tanggal_pengajuan', function ($birth) {
                return $birth->created_at->format('d M Y - H:i:s');
            })
            ->addColumn('tanggal_disetujui', function ($birth) {
                return $birth->letter->updated_at->format('d M Y - H:i:s');
            })
            ->addColumn('status', function ($birth) {
                return Lang::get('letter.approved');
            })
            ->addColumn('action', function ($birth) {
                return '<a target="_blank" class="d-inline-block btn btn-success btn-sm btn-circle" data-toggle="tooltip" data-placement="top" title="Unduh" href="' . route('births.download', $birth->id) . '">
                            <i class="fas fa-download"></i>
                        </a>
                        <button class="btn-circle btn-primary btn-sm btn" data-toggle="modal" data-target="#modalDetailSP" data-toggle="tooltip" data-placement="top" title="Detail Surat Pengantar" onclick="modalVerification(`' . $birth->id . '`)"><i class="fas fa-eye"></i></button>'
                ;
            })
            ->rawColumns(['nik', 'tanggal_pengajuan', 'tanggal_disetujui', 'status', 'action'])
            ->toJson();
    }

    public function getDeclined1()
    {
        $births = Birth::with('user', 'letter')->whereHas('letter', function ($s) { $s->whereVerify1(-1); })->select('births.*');
        return DataTables::eloquent($births)
            ->addColumn('nik', function ($birth) {
                return '<a onclick="viewDetail(' . $birth->user_id . ')" href="" data-toggle="modal" data-target="#userDetailModal" data-toggle="tooltip" data-placement="top" title="Lihat detail pengguna" >' . $birth->user->nik . '</a>';
            })
            ->addColumn('tanggal_pengajuan', function ($birth) {
                return $birth->created_at->format('d M Y - H:i:s');
            })
            ->addColumn('tanggal_penolakan', function ($birth) {
                return $birth->letter->updated_at->format('d M Y - H:i:s');
            })
            ->rawColumns(['nik', 'tanggal_pengajuan', 'tanggal_penolakan'])
            ->toJson();
    }

    public function getDeclined2()
    {
        $births = Birth::with('user', 'letter')->whereHas('letter', function ($s) {
            $s->whereVerify2(-1);
        })->select('births.*');
        return DataTables::eloquent($births)
            ->addColumn('nik', function ($birth) {
                return '<a onclick="viewDetail(' . $birth->user_id . ')" href="" data-toggle="modal" data-target="#userDetailModal" data-toggle="tooltip" data-placement="top" title="Lihat detail pengguna" >' . $birth->user->nik . '</a>';
            })
            ->addColumn('tanggal_pengajuan', function ($birth) {
                return $birth->created_at->format('d M Y - H:i:s');
            })
            ->addColumn('tanggal_penolakan', function ($birth) {
                return $birth->letter->updated_at->format('d M Y - H:i:s');
            })
            ->addColumn('action', function ($birth) {
                return '<form class="d-inline-block" action="' . route('births.verify2', $birth) . '" method="POST">
                            <input type="hidden" name="_token" value="' . csrf_token() . '">
                            <input type="hidden" name="_method" value="put">
                            <input type="hidden" name="verifikasi" value="1">
                            <button type="submit" class="btn btn-success btn-circle btn-sm" data-toggle="tooltip" data-placement="top" title="Ubah Jadi Setujui" onclick="return confirm(`Apakah anda yakin ingin menyetujui pengajuan surat ini ?`);">
                                <i class="fas fa-check"></i>
                            </button>
                        </form>
                        <button class="btn-circle btn-primary btn-sm btn" data-toggle="modal" data-target="#modalDetailSP" data-toggle="tooltip" data-placement="top" title="Detail Surat Pengantar" onclick="modalVerification(`' . $birth->id . '`)"><i class="fas fa-eye"></i></button>'
                ;
            })
            ->rawColumns(['nik','tanggal_pengajuan', 'tanggal_penolakan', 'action'])
            ->toJson();
    }
}
