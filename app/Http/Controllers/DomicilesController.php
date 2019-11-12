<?php

namespace App\Http\Controllers;

use App\Domicile;
use DataTables;
use Alert;
use App\Letter;
use App\User;
use PDF;
use File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;

class DomicilesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = 'Pengajuan Surat';
        $subtitle = 'Data Pengajuan Surat Keterangan Domisili';
        return view('domiciles.index', compact('title', 'subtitle'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = 'Pengajuan Surat';
        $subtitle = 'Form Pengajuan Surat Keterangan Domisili';
        return view('domiciles.create', compact('title', 'subtitle'));
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
            'tujuan' => ['required'],
            'surat_pengantar' => ['required','image','mimes:jpeg,png','max:2048']
        ]);
        Domicile::create([
            'purpose' => $request->tujuan,
            'user_id' => auth()->user()->id,
            'file'    => $this->setImageUpload($request->surat_pengantar,'img/surat_pengantar')
        ]);
        Alert::success('Pengajuan surat keterangan domisili berhasil ditambahkan', 'berhasil');
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Domicile  $domicile
     * @return \Illuminate\Http\Response
     */
    public function show(Domicile $domicile)
    {
        $kepala = User::find(1);
        if ($domicile->letter->verify1 == 1 && $domicile->letter->verify2 == 1) {
            if ($domicile->user_id == auth()->user()->id || auth()->user()->role_id == 2 || auth()->user()->role_id == 3) {
                $pdf = PDF::loadview('domiciles.show', compact('domicile', 'kepala'));
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
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Domicile  $domicile
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Domicile $domicile)
    {
        $request->validate([
            'tujuan' => ['required'],
            'surat_pengantar' => ['image','mimes:jpeg,png','max:2048']
        ]);

        if ($request->surat_pengantar) {
            $domicile->file = $this->setImageUpload($request->surat_pengantar,'img/surat_pengantar',$domicile->file);
        }

        $domicile->purpose = $request->tujuan;
        $domicile->save();
        Alert::success('Pengajuan surat keterangan domisili berhasil diperbarui', 'berhasil');
        return redirect()->back();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Domicile  $domicile
     * @return \Illuminate\Http\Response
     */
    public function verify1(Request $request, Domicile $domicile)
    {
        if ($request->update) {
            $letter = Letter::findOrFail($domicile->letter_id);
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
            File::delete(public_path('img/surat_pengantar'. '/' . $domicile->file));
        } else {
            $letter->verify1 = 1;
            $letter->verify2 = null;
            $letter->reason2 = null;
        }
        
        $letter->save();

        $domicile->letter_id = $letter->id;
        $domicile->purpose = $request->tujuan;
        $domicile->save();
        Alert::success('Pengajuan surat keterangan domisili berhasil diverifikasi', 'berhasil');
        return redirect()->back();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Domicile  $domicile
     * @return \Illuminate\Http\Response
     */
    public function verify2(Request $request, Domicile $domicile)
    {
        $letter = Letter::findOrFail($domicile->letter_id);
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
        Alert::success('Pengajuan surat keterangan domisili berhasil diverifikasi', 'berhasil');
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Domicile  $domicile
     * @return \Illuminate\Http\Response
     */
    public function destroy(Domicile $domicile)
    {
        File::delete(public_path('img/surat_pengantar'. '/' . $domicile->file));
        $domicile->delete();
        Alert::success('Pengajuan surat keterangan domisili berhasil dihapus', 'berhasil');
        return redirect()->back();
    }
    
    public function getEditDomiciles(Request $request)
    {
        $domicile = Domicile::findOrFail($request->id);
        echo json_encode($domicile);
    }

    public function getDomiciles()
    {
        $domiciles = Domicile::with('letter', 'user')->whereUserId(auth()->user()->id)->select('domiciles.*');
        return DataTables::eloquent($domiciles)
            ->addColumn('tanggal_pengajuan', function ($domicile) {
                return $domicile->created_at->format('d M Y - H:i:s');
            })
            ->addColumn('tanggal_disetujui', function ($domicile) {
                if ($domicile->letter_id != null) {
                    if ($domicile->letter->verify1 == 1 && $domicile->letter->verify2 == 1) {
                        return $domicile->letter->updated_at->format('d M Y - H:i:s');
                    } else {
                        return '-';
                    }
                } else {
                    return '-';
                }
            })
            ->addColumn('status', function ($domicile) {
                if ($domicile->letter_id != null) {
                    if ($domicile->letter->verify1 == 1 && $domicile->letter->verify2 == 1) {
                        return Lang::get('letter.approved');
                    } elseif ($domicile->letter->verify1 == 1 && $domicile->letter->verify2 == null || $domicile->letter->verify2 == -1) {
                        return Lang::get('letter.inprocessed');
                    } elseif ($domicile->letter->verify1 == -1 && $domicile->letter->verify2 == null || $domicile->letter->verify2 == -1) {
                        return '<span class="font-weight-bold">' . Lang::get('letter.declined') . '</span> <br>(' . $domicile->letter->reason1 . ')';
                    }
                } else {
                    return Lang::get('letter.unprocessed');
                }
            })
            ->addColumn('action', function ($domicile) {
                if ($domicile->letter_id != null) {
                    if ($domicile->letter->verify1 == 1 && $domicile->letter->verify2 == 1) {
                        return '<a target="_blank" class="d-inline-block btn btn-success btn-sm btn-circle" data-toggle="tooltip" data-placement="top" title="Unduh" href="' . route('domiciles.download', $domicile->id) . '">
                                    <i class="fas fa-download"></i>
                                </a>';
                    } elseif ($domicile->letter->verify1 == 1 && $domicile->letter->verify2 == null || $domicile->letter->verify2 == -1) {
                        return '-';
                    } elseif ($domicile->letter->verify1 == -1 && $domicile->letter->verify2 == null || $domicile->letter->verify2 == -1) {
                        return '-';
                    }
                } else {
                    return '<button class="editSubmission btn-circle btn-warning btn-sm btn" data-toggle="modal" data-target="#modalEditDomicile" data-toggle="tooltip" data-placement="top" title="Ubah"  onclick="editModal(' . $domicile->id . ')"><i class="fas fa-edit"></i></button>
                            <form class="d-inline-block" action="' . route('domiciles.destroy', $domicile->id) . '" method="POST">
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
        $domiciles = Domicile::with('user', 'letter')->whereLetterId(null)->select('domiciles.*');
        return DataTables::eloquent($domiciles)
            ->addColumn('nik', function ($domicile) {
                return '<a onclick="viewDetail(' . $domicile->user_id . ')" href="" data-toggle="modal" data-target="#userDetailModal" data-toggle="tooltip" data-placement="top" title="Lihat detail pengguna" >' . $domicile->user->nik . '</a>';
            })
            ->addColumn('tanggal_pengajuan', function ($domicile) {
                return $domicile->created_at->format('d M Y - H:i:s');
            })
            ->addColumn('action', function ($domicile) {
                return '<button class="btn-circle btn-warning btn-sm btn" data-toggle="modal" data-target="#modalVerification" data-toggle="tooltip" data-placement="top" title="Verifikasi" onclick="modalVerification(' . $domicile->id . ')"><i class="fas fa-check"></i></button>
                        <button class="btn-circle btn-primary btn-sm btn" data-toggle="modal" data-target="#modalDetailSP" data-toggle="tooltip" data-placement="top" title="Detail Surat Pengantar" onclick="modalVerification(`' . $domicile->id . '`)"><i class="fas fa-eye"></i></button>'
                ;
            })
            ->rawColumns(['nik','tanggal_pengajuan', 'action'])
            ->toJson();
    }

    public function getUnprocessed2()
    {
        $domiciles = Domicile::with('user', 'letter')->whereHas('letter', function ($s) {
            $s->whereVerify1(1)->whereVerify2(null);
        })->select('domiciles.*');
        return DataTables::eloquent($domiciles)
            ->addColumn('nik', function ($domicile) {
                return '<a onclick="viewDetail(' . $domicile->user_id . ')" href="" data-toggle="modal" data-target="#userDetailModal" data-toggle="tooltip" data-placement="top" title="Lihat detail pengguna" >' . $domicile->user->nik . '</a>';
            })
            ->addColumn('tanggal_pengajuan', function ($domicile) {
                return $domicile->created_at->format('d M Y - H:i:s');
            })
            ->addColumn('action', function ($domicile) {
                return '<button class="btn-circle btn-warning btn-sm btn" data-toggle="modal" data-target="#modalVerification" data-toggle="tooltip" data-placement="top" title="Verifikasi" onclick="modalVerification(' . $domicile->id . ')"><i class="fas fa-check"></i></button>
                        <button class="btn-circle btn-primary btn-sm btn" data-toggle="modal" data-target="#modalDetailSP" data-toggle="tooltip" data-placement="top" title="Detail Surat Pengantar" onclick="modalVerification(`' . $domicile->id . '`)"><i class="fas fa-eye"></i></button>'
                ;
            })
            ->rawColumns(['nik','tanggal_pengajuan','action'])
            ->toJson();
    }

    public function getVerified1()
    {
        $domiciles = Domicile::with('user', 'letter')->whereHas('letter', function ($s) { $s->whereVerify1(1); })->select('domiciles.*');
        return DataTables::eloquent($domiciles)
            ->addColumn('nik', function ($domicile) {
                return '<a onclick="viewDetail(' . $domicile->user_id . ')" href="" data-toggle="modal" data-target="#userDetailModal" data-toggle="tooltip" data-placement="top" title="Lihat detail pengguna" >' . $domicile->user->nik . '</a>';
            })
            ->addColumn('tanggal_pengajuan', function ($domicile) {
                return $domicile->created_at->format('d M Y - H:i:s');
            })
            ->addColumn('tanggal_disetujui', function ($domicile) {
                return $domicile->letter->updated_at->format('d M Y - H:i:s');
            })
            ->addColumn('status', function ($domicile) {
                if ($domicile->letter->verify1 == 1 && $domicile->letter->verify2 == 1) {
                    return Lang::get('letter.approved');
                } elseif ($domicile->letter->verify1 == 1 && $domicile->letter->verify2 == null) {
                    return 'Belum di proses';
                } elseif ($domicile->letter->verify1 == 1 && $domicile->letter->verify2 == -1) {
                    return '<span class="font-weight-bold">' . Lang::get('letter.declined') . '</span> <br>(' . $domicile->letter->reason2 . ')';
                }
            })
            ->addColumn('action', function ($domicile) {
                if ($domicile->letter->verify1 == 1 && $domicile->letter->verify2 == 1) {
                    return '<a target="_blank" class="d-inline-block btn btn-success btn-sm btn-circle" data-toggle="tooltip" data-placement="top" title="Unduh" href="' . route('domiciles.download', $domicile->id) . '">
                                <i class="fas fa-download"></i>
                            </a>
                            <button class="btn-circle btn-primary btn-sm btn" data-toggle="modal" data-target="#modalDetailSP" data-toggle="tooltip" data-placement="top" title="Detail Surat Pengantar" onclick="modalVerification(`' . $domicile->id . '`)"><i class="fas fa-eye"></i></button>';
                } elseif ($domicile->letter->verify1 == 1 && $domicile->letter->verify2 == null || $domicile->letter->verify2 == -1) {
                    return '<button class="btn-circle btn-warning btn-sm btn" data-toggle="modal" data-target="#modalVerification" data-toggle="tooltip" data-placement="top" title="Ubah Verifikasi" onclick="modalVerification(' . $domicile->id . ',true)"><i class="fas fa-edit"></i></button>
                            <button class="btn-circle btn-primary btn-sm btn" data-toggle="modal" data-target="#modalDetailSP" data-toggle="tooltip" data-placement="top" title="Detail Surat Pengantar" onclick="modalVerification(`' . $domicile->id . '`)"><i class="fas fa-eye"></i></button>'
                    ;
                }
            })
            ->rawColumns(['nik', 'tanggal_pengajuan', 'tanggal_disetujui', 'status', 'action'])
            ->toJson();
    }

    public function getVerified2()
    {
        $domiciles = Domicile::with('user', 'letter')->whereHas('letter', function ($s) {
            $s->whereVerify2(1)->whereVerify1(1);
        })->select('domiciles.*');
        return DataTables::eloquent($domiciles)
            ->addColumn('nik', function ($domicile) {
                return '<a onclick="viewDetail(' . $domicile->user_id . ')" href="" data-toggle="modal" data-target="#userDetailModal" data-toggle="tooltip" data-placement="top" title="Lihat detail pengguna" >' . $domicile->user->nik . '</a>';
            })
            ->addColumn('tanggal_pengajuan', function ($domicile) {
                return $domicile->created_at->format('d M Y - H:i:s');
            })
            ->addColumn('tanggal_disetujui', function ($domicile) {
                return $domicile->letter->updated_at->format('d M Y - H:i:s');
            })
            ->addColumn('status', function ($domicile) {
                return Lang::get('letter.approved');
            })
            ->addColumn('action', function ($domicile) {
                return '<a target="_blank" class="d-inline-block btn btn-success btn-sm btn-circle" data-toggle="tooltip" data-placement="top" title="Unduh" href="' . route('domiciles.download', $domicile->id) . '">
                            <i class="fas fa-download"></i>
                        </a>
                        <button class="btn-circle btn-primary btn-sm btn" data-toggle="modal" data-target="#modalDetailSP" data-toggle="tooltip" data-placement="top" title="Detail Surat Pengantar" onclick="modalVerification(`' . $domicile->id . '`)"><i class="fas fa-eye"></i></button>'
                ;
            })
            ->rawColumns(['nik', 'tanggal_pengajuan', 'tanggal_disetujui', 'status', 'action'])
            ->toJson();
    }

    public function getDeclined1()
    {
        $domiciles = Domicile::with('user', 'letter')->whereHas('letter', function ($s) { $s->whereVerify1(-1); })->select('domiciles.*');
        return DataTables::eloquent($domiciles)
            ->addColumn('nik', function ($domicile) {
                return '<a onclick="viewDetail(' . $domicile->user_id . ')" href="" data-toggle="modal" data-target="#userDetailModal" data-toggle="tooltip" data-placement="top" title="Lihat detail pengguna" >' . $domicile->user->nik . '</a>';
            })
            ->addColumn('tanggal_pengajuan', function ($domicile) {
                return $domicile->created_at->format('d M Y - H:i:s');
            })
            ->addColumn('tanggal_penolakan', function ($domicile) {
                return $domicile->letter->updated_at->format('d M Y - H:i:s');
            })
            ->rawColumns(['nik', 'tanggal_pengajuan', 'tanggal_penolakan'])
            ->toJson();
    }

    public function getDeclined2()
    {
        $domiciles = Domicile::with('user', 'letter')->whereHas('letter', function ($s) {
            $s->whereVerify2(-1);
        })->select('domiciles.*');
        return DataTables::eloquent($domiciles)
            ->addColumn('nik', function ($domicile) {
                return '<a onclick="viewDetail(' . $domicile->user_id . ')" href="" data-toggle="modal" data-target="#userDetailModal" data-toggle="tooltip" data-placement="top" title="Lihat detail pengguna" >' . $domicile->user->nik . '</a>';
            })
            ->addColumn('tanggal_pengajuan', function ($domicile) {
                return $domicile->created_at->format('d M Y - H:i:s');
            })
            ->addColumn('tanggal_penolakan', function ($domicile) {
                return $domicile->letter->updated_at->format('d M Y - H:i:s');
            })
            ->addColumn('action', function ($domicile) {
                return '<form class="d-inline-block" action="' . route('domiciles.verify2', $domicile) . '" method="POST">
                            <input type="hidden" name="_token" value="' . csrf_token() . '">
                            <input type="hidden" name="_method" value="put">
                            <input type="hidden" name="verifikasi" value="1">
                            <button type="submit" class="btn btn-success btn-circle btn-sm" data-toggle="tooltip" data-placement="top" title="Ubah Jadi Setujui" onclick="return confirm(`Apakah anda yakin ingin menyetujui pengajuan surat ini ?`);">
                                <i class="fas fa-check"></i>
                            </button>
                        </form>
                        <button class="btn-circle btn-primary btn-sm btn" data-toggle="modal" data-target="#modalDetailSP" data-toggle="tooltip" data-placement="top" title="Detail Surat Pengantar" onclick="modalVerification(`' . $domicile->id . '`)"><i class="fas fa-eye"></i></button>'
                ;
            })
            ->rawColumns(['nik','tanggal_pengajuan', 'tanggal_penolakan', 'action'])
            ->toJson();
    }
}
