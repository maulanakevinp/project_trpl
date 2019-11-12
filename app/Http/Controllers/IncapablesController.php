<?php

namespace App\Http\Controllers;

use App\Incapable;
use DataTables;
use Alert;
use App\Letter;
use App\User;
use PDF;
use File;
use App\Http\Requests\IncapableRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;

class IncapablesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = 'Pengajuan Surat';
        $subtitle = 'Data Pengajuan Surat Keterangan Tidak Mampu';
        return view('incapables.index', compact('title', 'subtitle'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = 'Pengajuan Surat';
        $subtitle = 'Form Pengajuan Surat Keterangan Tidak Mampu';
        return view('incapables.create', compact('title', 'subtitle'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\IncapableRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(IncapableRequest $request)
    {
        if (auth()->user()->nik_file == null || auth()->user()->kk == null || auth()->user()->kk_file == null) {
            Alert::error('Harap melengkapi profil anda', 'Gagal')->persistent('tutup');
            return redirect('/edit-profile');
        }
        $request->validated();
        Incapable::create([
            'name'          =>  $request->nama,
            'birth_place'   =>  $request->tempat_lahir,
            'birth_date'    =>  $request->tanggal_lahir,
            'job'           =>  $request->pekerjaan,
            'address'       =>  $request->alamat,
            'as'            =>  $request->merupakan,
            'purpose'       =>  $request->tujuan,
            'user_id'       =>  auth()->user()->id,
            'file'          =>  $this->setImageUpload($request->surat_pengantar,'img/surat_pengantar')
        ]);
        Alert::success('Pengajuan surat keterangan tidak mampu berhasil ditambahkan', 'berhasil');
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Incapable  $incapable
     * @return \Illuminate\Http\Response
     */
    public function show(Incapable $incapable)
    {
        $kepala = User::find(1);
        if ($incapable->letter->verify1 == 1 && $incapable->letter->verify2 == 1) {
            if ($incapable->user_id == auth()->user()->id || auth()->user()->role_id == 2 || auth()->user()->role_id == 3) {
                $pdf = PDF::loadview('incapables.show', compact('incapable', 'kepala'));
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
     * @param  \App\Http\Requests\IncapableRequest  $request
     * @param  \App\Incapable  $incapable
     * @return \Illuminate\Http\Response
     */
    public function update(IncapableRequest $request, Incapable $incapable)
    {
        $request->validated();

        if ($request->surat_pengantar) {
            $incapable->file = $this->setImageUpload($request->surat_pengantar,'img/surat_pengantar',$incapable->file);
        }

        $incapable->name          =  $request->nama;
        $incapable->birth_place   =  $request->tempat_lahir;
        $incapable->birth_date    =  $request->tanggal_lahir;
        $incapable->job           =  $request->pekerjaan;
        $incapable->address       =  $request->alamat;
        $incapable->as            =  $request->merupakan;
        $incapable->purpose       =  $request->tujuan;
        $incapable->save();
        Alert::success('Pengajuan surat keterangan tidak mampu berhasil diperbarui', 'berhasil');
        return redirect()->back();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Incapable  $incapable
     * @return \Illuminate\Http\Response
     */
    public function verify1(Request $request, Incapable $incapable)
    {
        if ($request->update) {
            $letter = Letter::findOrFail($incapable->letter_id);
        } else {
            $letter = new Letter;
        }
        $request->validate([
            'tujuan'        => ['required'],
            'verifikasi'    => ['required']
        ]);
        if($request->verifikasi == -1){
            $request->validate([
                'alasan_penolakan' => ['required']
            ]);
            $letter->verify1 = -1;
            $letter->reason1 = $request->alasan_penolakan;
            File::delete(public_path('img/surat_pengantar'. '/' . $incapable->file));
        } else {
            $letter->verify1 = 1;
            $letter->verify2 = null;
            $letter->reason2 = null;
        }
        
        $letter->save();

        $incapable->letter_id = $letter->id;
        $incapable->purpose = $request->tujuan;
        $incapable->save();
        Alert::success('Pengajuan surat keterangan tidak mampu berhasil diverifikasi', 'berhasil');
        return redirect()->back();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Incapable  $incapable
     * @return \Illuminate\Http\Response
     */
    public function verify2(Request $request, Incapable $incapable)
    {
        $letter = Letter::findOrFail($incapable->letter_id);
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
        Alert::success('Pengajuan surat keterangan tidak mampu berhasil diverifikasi', 'berhasil');
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Incapable  $incapable
     * @return \Illuminate\Http\Response
     */
    public function destroy(Incapable $incapable)
    {
        File::delete(public_path('img/surat_pengantar'. '/' . $incapable->file));
        $incapable->delete();
        Alert::success('Pengajuan surat keterangan tidak mampu berhasil dihapus', 'berhasil');
        return redirect()->back();
    }
    
    public function getEditIncapables(Request $request)
    {
        $incapable = Incapable::findOrFail($request->id);
        echo json_encode($incapable);
    }

    public function getIncapables()
    {
        $incapables = Incapable::with('letter', 'user')->whereUserId(auth()->user()->id)->select('incapables.*');
        return DataTables::eloquent($incapables)
            ->addColumn('tanggal_pengajuan', function ($incapable) {
                return $incapable->created_at->format('d M Y - H:i:s');
            })
            ->addColumn('tanggal_disetujui', function ($incapable) {
                if ($incapable->letter_id != null) {
                    if ($incapable->letter->verify1 == 1 && $incapable->letter->verify2 == 1) {
                        return $incapable->letter->updated_at->format('d M Y - H:i:s');
                    } else {
                        return '-';
                    }
                } else {
                    return '-';
                }
            })
            ->addColumn('status', function ($incapable) {
                if ($incapable->letter_id != null) {
                    if ($incapable->letter->verify1 == 1 && $incapable->letter->verify2 == 1) {
                        return Lang::get('letter.approved');
                    } elseif ($incapable->letter->verify1 == 1 && $incapable->letter->verify2 == null || $incapable->letter->verify2 == -1) {
                        return Lang::get('letter.inprocessed');
                    } elseif ($incapable->letter->verify1 == -1 && $incapable->letter->verify2 == null || $incapable->letter->verify2 == -1) {
                        return '<span class="font-weight-bold">' . Lang::get('letter.declined') . '</span> <br>(' . $incapable->letter->reason1 . ')';
                    }
                } else {
                    return Lang::get('letter.unprocessed');
                }
            })
            ->addColumn('action', function ($incapable) {
                if ($incapable->letter_id != null) {
                    if ($incapable->letter->verify1 == 1 && $incapable->letter->verify2 == 1) {
                        return '<a target="_blank" class="d-inline-block btn btn-success btn-sm btn-circle" data-toggle="tooltip" data-placement="top" title="Unduh" href="' . route('incapables.download', $incapable->id) . '">
                                    <i class="fas fa-download"></i>
                                </a>';
                    } elseif ($incapable->letter->verify1 == 1 && $incapable->letter->verify2 == null || $incapable->letter->verify2 == -1) {
                        return '-';
                    } elseif ($incapable->letter->verify1 == -1 && $incapable->letter->verify2 == null || $incapable->letter->verify2 == -1) {
                        return '-';
                    }
                } else {
                    return '<button class="editSubmission btn-circle btn-warning btn-sm btn" data-toggle="modal" data-target="#modalEditIncapable" data-toggle="tooltip" data-placement="top" title="Ubah"  onclick="editModal(' . $incapable->id . ')"><i class="fas fa-edit"></i></button>
                            <form class="d-inline-block" action="' . route('incapables.destroy', $incapable->id) . '" method="POST">
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
        $incapables = Incapable::with('user', 'letter')->whereLetterId(null)->select('incapables.*');
        return DataTables::eloquent($incapables)
            ->addColumn('nik', function ($incapable) {
                return '<a onclick="viewDetail(' . $incapable->user_id . ')" href="" data-toggle="modal" data-target="#userDetailModal" data-toggle="tooltip" data-placement="top" title="Lihat detail pengguna" >' . $incapable->user->nik . '</a>';
            })
            ->addColumn('tanggal_pengajuan', function ($incapable) {
                return $incapable->created_at->format('d M Y - H:i:s');
            })
            ->addColumn('action', function ($incapable) {
                return '<button class="btn-circle btn-warning btn-sm btn" data-toggle="modal" data-target="#modalVerification" data-toggle="tooltip" data-placement="top" title="Verifikasi" onclick="modalVerification(' . $incapable->id . ')"><i class="fas fa-check"></i></button>
                        <button class="btn-circle btn-primary btn-sm btn" data-toggle="modal" data-target="#modalDetailSP" data-toggle="tooltip" data-placement="top" title="Detail Surat Pengantar" onclick="modalVerification(`' . $incapable->id . '`)"><i class="fas fa-eye"></i></button>'
                ;
            })
            ->rawColumns(['nik','tanggal_pengajuan', 'action'])
            ->toJson();
    }

    public function getUnprocessed2()
    {
        $incapables = Incapable::with('user', 'letter')->whereHas('letter', function ($s) {
            $s->whereVerify1(1)->whereVerify2(null);
        })->select('incapables.*');
        return DataTables::eloquent($incapables)
            ->addColumn('nik', function ($incapable) {
                return '<a onclick="viewDetail(' . $incapable->user_id . ')" href="" data-toggle="modal" data-target="#userDetailModal" data-toggle="tooltip" data-placement="top" title="Lihat detail pengguna" >' . $incapable->user->nik . '</a>';
            })
            ->addColumn('tanggal_pengajuan', function ($incapable) {
                return $incapable->created_at->format('d M Y - H:i:s');
            })
            ->addColumn('action', function ($incapable) {
                return '<button class="btn-circle btn-warning btn-sm btn" data-toggle="modal" data-target="#modalVerification" data-toggle="tooltip" data-placement="top" title="Verifikasi" onclick="modalVerification(' . $incapable->id . ')"><i class="fas fa-check"></i></button>
                        <button class="btn-circle btn-primary btn-sm btn" data-toggle="modal" data-target="#modalDetailSP" data-toggle="tooltip" data-placement="top" title="Detail Surat Pengantar" onclick="modalVerification(`' . $incapable->id . '`)"><i class="fas fa-eye"></i></button>'
                ;
            })
            ->rawColumns(['nik','tanggal_pengajuan','action'])
            ->toJson();
    }

    public function getVerified1()
    {
        $incapables = Incapable::with('user', 'letter')->whereHas('letter', function ($s) { $s->whereVerify1(1); })->select('incapables.*');
        return DataTables::eloquent($incapables)
            ->addColumn('nik', function ($incapable) {
                return '<a onclick="viewDetail(' . $incapable->user_id . ')" href="" data-toggle="modal" data-target="#userDetailModal" data-toggle="tooltip" data-placement="top" title="Lihat detail pengguna" >' . $incapable->user->nik . '</a>';
            })
            ->addColumn('tanggal_pengajuan', function ($incapable) {
                return $incapable->created_at->format('d M Y - H:i:s');
            })
            ->addColumn('tanggal_disetujui', function ($incapable) {
                return $incapable->letter->updated_at->format('d M Y - H:i:s');
            })
            ->addColumn('status', function ($incapable) {
                if ($incapable->letter->verify1 == 1 && $incapable->letter->verify2 == 1) {
                    return Lang::get('letter.approved');
                } elseif ($incapable->letter->verify1 == 1 && $incapable->letter->verify2 == null) {
                    return 'Belum di proses';
                } elseif ($incapable->letter->verify1 == 1 && $incapable->letter->verify2 == -1) {
                    return '<span class="font-weight-bold">' . Lang::get('letter.declined') . '</span> <br>(' . $incapable->letter->reason2 . ')';
                }
            })
            ->addColumn('action', function ($incapable) {
                if ($incapable->letter->verify1 == 1 && $incapable->letter->verify2 == 1) {
                    return '<a target="_blank" class="d-inline-block btn btn-success btn-sm btn-circle" data-toggle="tooltip" data-placement="top" title="Unduh" href="' . route('incapables.download', $incapable->id) . '">
                                <i class="fas fa-download"></i>
                            </a>
                            <button class="btn-circle btn-primary btn-sm btn" data-toggle="modal" data-target="#modalDetailSP" data-toggle="tooltip" data-placement="top" title="Detail Surat Pengantar" onclick="modalVerification(`' . $incapable->id . '`)"><i class="fas fa-eye"></i></button>';
                } elseif ($incapable->letter->verify1 == 1 && $incapable->letter->verify2 == null || $incapable->letter->verify2 == -1) {
                    return '<button class="btn-circle btn-warning btn-sm btn" data-toggle="modal" data-target="#modalVerification" data-toggle="tooltip" data-placement="top" title="Ubah Verifikasi" onclick="modalVerification(' . $incapable->id . ',true)"><i class="fas fa-edit"></i></button>
                            <button class="btn-circle btn-primary btn-sm btn" data-toggle="modal" data-target="#modalDetailSP" data-toggle="tooltip" data-placement="top" title="Detail Surat Pengantar" onclick="modalVerification(`' . $incapable->id . '`)"><i class="fas fa-eye"></i></button>'
                    ;
                }
            })
            ->rawColumns(['nik', 'tanggal_pengajuan', 'tanggal_disetujui', 'status', 'action'])
            ->toJson();
    }

    public function getVerified2()
    {
        $incapables = Incapable::with('user', 'letter')->whereHas('letter', function ($s) {
            $s->whereVerify2(1)->whereVerify1(1);
        })->select('incapables.*');
        return DataTables::eloquent($incapables)
            ->addColumn('nik', function ($incapable) {
                return '<a onclick="viewDetail(' . $incapable->user_id . ')" href="" data-toggle="modal" data-target="#userDetailModal" data-toggle="tooltip" data-placement="top" title="Lihat detail pengguna" >' . $incapable->user->nik . '</a>';
            })
            ->addColumn('tanggal_pengajuan', function ($incapable) {
                return $incapable->created_at->format('d M Y - H:i:s');
            })
            ->addColumn('tanggal_disetujui', function ($incapable) {
                return $incapable->letter->updated_at->format('d M Y - H:i:s');
            })
            ->addColumn('status', function ($incapable) {
                return Lang::get('letter.approved');
            })
            ->addColumn('action', function ($incapable) {
                return '<a target="_blank" class="d-inline-block btn btn-success btn-sm btn-circle" data-toggle="tooltip" data-placement="top" title="Unduh" href="' . route('incapables.download', $incapable->id) . '">
                            <i class="fas fa-download"></i>
                        </a>
                        <button class="btn-circle btn-primary btn-sm btn" data-toggle="modal" data-target="#modalDetailSP" data-toggle="tooltip" data-placement="top" title="Detail Surat Pengantar" onclick="modalVerification(`' . $incapable->id . '`)"><i class="fas fa-eye"></i></button>';
            })
            ->rawColumns(['nik', 'tanggal_pengajuan', 'tanggal_disetujui', 'status', 'action'])
            ->toJson();
    }

    public function getDeclined1()
    {
        $incapables = Incapable::with('user', 'letter')->whereHas('letter', function ($s) { $s->whereVerify1(-1); })->select('incapables.*');
        return DataTables::eloquent($incapables)
            ->addColumn('nik', function ($incapable) {
                return '<a onclick="viewDetail(' . $incapable->user_id . ')" href="" data-toggle="modal" data-target="#userDetailModal" data-toggle="tooltip" data-placement="top" title="Lihat detail pengguna" >' . $incapable->user->nik . '</a>';
            })
            ->addColumn('tanggal_pengajuan', function ($incapable) {
                return $incapable->created_at->format('d M Y - H:i:s');
            })
            ->addColumn('tanggal_penolakan', function ($incapable) {
                return $incapable->letter->updated_at->format('d M Y - H:i:s');
            })
            ->rawColumns(['nik', 'tanggal_pengajuan', 'tanggal_penolakan'])
            ->toJson();
    }

    public function getDeclined2()
    {
        $incapables = Incapable::with('user', 'letter')->whereHas('letter', function ($s) {
            $s->whereVerify2(-1);
        })->select('incapables.*');
        return DataTables::eloquent($incapables)
            ->addColumn('nik', function ($incapable) {
                return '<a onclick="viewDetail(' . $incapable->user_id . ')" href="" data-toggle="modal" data-target="#userDetailModal" data-toggle="tooltip" data-placement="top" title="Lihat detail pengguna" >' . $incapable->user->nik . '</a>';
            })
            ->addColumn('tanggal_pengajuan', function ($incapable) {
                return $incapable->created_at->format('d M Y - H:i:s');
            })
            ->addColumn('tanggal_penolakan', function ($incapable) {
                return $incapable->letter->updated_at->format('d M Y - H:i:s');
            })
            ->addColumn('action', function ($incapable) {
                return '<form class="d-inline-block" action="' . route('incapables.verify2', $incapable) . '" method="POST">
                            <input type="hidden" name="_token" value="' . csrf_token() . '">
                            <input type="hidden" name="_method" value="put">
                            <input type="hidden" name="verifikasi" value="1">
                            <button type="submit" class="btn btn-success btn-circle btn-sm" data-toggle="tooltip" data-placement="top" title="Ubah Jadi Setujui" onclick="return confirm(`Apakah anda yakin ingin menyetujui pengajuan surat ini ?`);">
                                <i class="fas fa-check"></i>
                            </button>
                        </form>
                        <button class="btn-circle btn-primary btn-sm btn" data-toggle="modal" data-target="#modalDetailSP" data-toggle="tooltip" data-placement="top" title="Detail Surat Pengantar" onclick="modalVerification(`' . $incapable->id . '`)"><i class="fas fa-eye"></i></button>'
                ;
            })
            ->rawColumns(['nik','tanggal_pengajuan', 'tanggal_penolakan', 'action'])
            ->toJson();
    }
}
