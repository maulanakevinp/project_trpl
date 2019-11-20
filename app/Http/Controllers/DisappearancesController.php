<?php

namespace App\Http\Controllers;

use App\Disappearance;
use DataTables;
use Alert;
use App\Letter;
use App\Rules\BirthDate;
use App\User;
use PDF;
use File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;

class DisappearancesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = 'Pengajuan Surat';
        $subtitle = 'Data Pengajuan Surat Keterangan Kehilangan';
        return view('disappearances.index', compact('title', 'subtitle'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = 'Pengajuan Surat';
        $subtitle = 'Form Pengajuan Surat Keterangan Kehilangan';
        return view('disappearances.create', compact('title', 'subtitle'));
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
            'kehilangan'            => ['required','max:60'],
            'tanggal_kehilangan'    => ['required','date', new BirthDate],
            'tempat_kehilangan'     => ['required','max:60'],
            'surat_pengantar'       => ['required','image','mimes:jpeg,png','max:2048']
        ]);
        Disappearance::create([
            'name'      => $request->kehilangan,
            'date'      => $request->tanggal_kehilangan,
            'place'     => $request->tempat_kehilangan,
            'user_id'   => auth()->user()->id,
            'file'      => $this->setImageUpload($request->surat_pengantar,'img/surat_pengantar')
        ]);
        Alert::success('Pengajuan surat keterangan kehilangan berhasil ditambahkan', 'berhasil');
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Disappearance  $disappearance
     * @return \Illuminate\Http\Response
     */
    public function show(Disappearance $disappearance)
    {
        $kepala = User::find(1);
        if ($disappearance->letter->verify1 == 1 && $disappearance->letter->verify2 == 1) {
            if ($disappearance->user_id == auth()->user()->id || auth()->user()->role_id == 2 || auth()->user()->role_id == 3) {
                $pdf = PDF::loadview('disappearances.show', compact('disappearance', 'kepala'));
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
     * @param  \App\Disappearance  $disappearance
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Disappearance $disappearance)
    {
        $request->validate([
            'kehilangan'            => ['required','max:60'],
            'tanggal_kehilangan'    => ['required', new BirthDate],
            'tempat_kehilangan'     => ['required','max:60'],
            'surat_pengantar'       => ['image','mimes:jpeg,png','max:2048']
        ]);

        $disappearance->name    = $request->kehilangan;
        $disappearance->date    = $request->tanggal_kehilangan;
        $disappearance->place   = $request->tempat_kehilangan;
        if ($request->surat_pengantar) {
            $disappearance->file = $this->setImageUpload($request->surat_pengantar,'img/surat_pengantar',$disappearance->file);
        }
        $disappearance->save();
        Alert::success('Pengajuan surat keterangan kehilangan berhasil diperbarui', 'berhasil');
        return redirect()->back();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Disappearance  $disappearance
     * @return \Illuminate\Http\Response
     */
    public function verify1(Request $request, Disappearance $disappearance)
    {
        if ($request->update) {
            $letter = Letter::findOrFail($disappearance->letter_id);
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
            File::delete(public_path('img/surat_pengantar'. '/' . $disappearance->file));
        } else {
            $letter->verify1 = 1;
            $letter->verify2 = null;
            $letter->reason2 = null;
        }
        
        $letter->save();

        $disappearance->letter_id = $letter->id;
        $disappearance->save();
        Alert::success('Pengajuan surat keterangan kehilangan berhasil diverifikasi', 'berhasil');
        return redirect()->back();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Disappearance  $disappearance
     * @return \Illuminate\Http\Response
     */
    public function verify2(Request $request, Disappearance $disappearance)
    {
        $letter = Letter::findOrFail($disappearance->letter_id);
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
        Alert::success('Pengajuan surat keterangan kehilangan berhasil diverifikasi', 'berhasil');
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Disappearance  $disappearance
     * @return \Illuminate\Http\Response
     */
    public function destroy(Disappearance $disappearance)
    {
        File::delete(public_path('img/surat_pengantar'. '/' . $disappearance->file));
        $disappearance->delete();
        Alert::success('Pengajuan surat keterangan kehilangan berhasil dihapus', 'berhasil');
        return redirect()->back();
    }
    
    public function getEditDisappearances(Request $request)
    {
        $disappearance = Disappearance::findOrFail($request->id);
        echo json_encode($disappearance);
    }

    public function getDisappearances()
    {
        $disappearances = Disappearance::with('letter', 'user')->whereUserId(auth()->user()->id)->select('disappearances.*');
        return DataTables::eloquent($disappearances)
            ->addColumn('tanggal_pengajuan', function ($disappearance) {
                return $disappearance->created_at->format('d M Y - H:i:s');
            })
            ->addColumn('tanggal_disetujui', function ($disappearance) {
                if ($disappearance->letter_id != null) {
                    if ($disappearance->letter->verify1 == 1 && $disappearance->letter->verify2 == 1) {
                        return $disappearance->letter->updated_at->format('d M Y - H:i:s');
                    } else {
                        return '-';
                    }
                } else {
                    return '-';
                }
            })
            ->addColumn('status', function ($disappearance) {
                if ($disappearance->letter_id != null) {
                    if ($disappearance->letter->verify1 == 1 && $disappearance->letter->verify2 == 1) {
                        return Lang::get('letter.approved');
                    } elseif ($disappearance->letter->verify1 == 1 && $disappearance->letter->verify2 == null || $disappearance->letter->verify2 == -1) {
                        return Lang::get('letter.inprocessed');
                    } elseif ($disappearance->letter->verify1 == -1 && $disappearance->letter->verify2 == null || $disappearance->letter->verify2 == -1) {
                        return '<span class="font-weight-bold">' . Lang::get('letter.declined') . '</span> <br>(' . $disappearance->letter->reason1 . ')';
                    }
                } else {
                    return Lang::get('letter.unprocessed');
                }
            })
            ->addColumn('action', function ($disappearance) {
                if ($disappearance->letter_id != null) {
                    if ($disappearance->letter->verify1 == 1 && $disappearance->letter->verify2 == 1) {
                        return '<a target="_blank" class="d-inline-block btn btn-success btn-sm btn-circle" data-toggle="tooltip" data-placement="top" title="Unduh" href="' . route('disappearances.download', $disappearance->id) . '">
                                    <i class="fas fa-download"></i>
                                </a>';
                    } elseif ($disappearance->letter->verify1 == 1 && $disappearance->letter->verify2 == null || $disappearance->letter->verify2 == -1) {
                        return '-';
                    } elseif ($disappearance->letter->verify1 == -1 && $disappearance->letter->verify2 == null || $disappearance->letter->verify2 == -1) {
                        return '-';
                    }
                } else {
                    return '<button class="editSubmission btn-circle btn-warning btn-sm btn" data-toggle="modal" data-target="#modalEditDisappearance" data-toggle="tooltip" data-placement="top" title="Ubah"  onclick="editModal(' . $disappearance->id . ')"><i class="fas fa-edit"></i></button>
                            <form class="d-inline-block" action="' . route('disappearances.destroy', $disappearance->id) . '" method="POST">
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
        $disappearances = Disappearance::with('user', 'letter')->whereLetterId(null)->select('disappearances.*');
        return DataTables::eloquent($disappearances)
            ->addColumn('nik', function ($disappearance) {
                return '<a onclick="viewDetail(' . $disappearance->user_id . ')" href="" data-toggle="modal" data-target="#userDetailModal" data-toggle="tooltip" data-placement="top" title="Lihat detail pengguna" >' . $disappearance->user->nik . '</a>';
            })
            ->addColumn('tanggal_pengajuan', function ($disappearance) {
                return $disappearance->created_at->format('d M Y - H:i:s');
            })
            ->addColumn('action', function ($disappearance) {
                return '<button class="btn-circle btn-warning btn-sm btn" data-toggle="modal" data-target="#modalVerification" data-toggle="tooltip" data-placement="top" title="Verifikasi" onclick="modalVerification(' . $disappearance->id . ')"><i class="fas fa-check"></i></button>
                        <button class="btn-circle btn-primary btn-sm btn" data-toggle="modal" data-target="#modalDetailSP" data-toggle="tooltip" data-placement="top" title="Detail Surat Pengantar" onclick="modalVerification(`' . $disappearance->id . '`)"><i class="fas fa-eye"></i></button>'
                ;
            })
            ->rawColumns(['nik','tanggal_pengajuan', 'action'])
            ->toJson();
    }

    public function getUnprocessed2()
    {
        $disappearances = Disappearance::with('user', 'letter')->whereHas('letter', function ($s) {
            $s->whereVerify1(1)->whereVerify2(null);
        })->select('disappearances.*');
        return DataTables::eloquent($disappearances)
            ->addColumn('nik', function ($disappearance) {
                return '<a onclick="viewDetail(' . $disappearance->user_id . ')" href="" data-toggle="modal" data-target="#userDetailModal" data-toggle="tooltip" data-placement="top" title="Lihat detail pengguna" >' . $disappearance->user->nik . '</a>';
            })
            ->addColumn('tanggal_pengajuan', function ($disappearance) {
                return $disappearance->created_at->format('d M Y - H:i:s');
            })
            ->addColumn('action', function ($disappearance) {
                return '<button class="btn-circle btn-warning btn-sm btn" data-toggle="modal" data-target="#modalVerification" data-toggle="tooltip" data-placement="top" title="Verifikasi" onclick="modalVerification(' . $disappearance->id . ')"><i class="fas fa-check"></i></button>
                        <button class="btn-circle btn-primary btn-sm btn" data-toggle="modal" data-target="#modalDetailSP" data-toggle="tooltip" data-placement="top" title="Detail Surat Pengantar" onclick="modalVerification(`' . $disappearance->id . '`)"><i class="fas fa-eye"></i></button>'
                ;
            })
            ->rawColumns(['nik','tanggal_pengajuan','action'])
            ->toJson();
    }

    public function getVerified1()
    {
        $disappearances = Disappearance::with('user', 'letter')->whereHas('letter', function ($s) { $s->whereVerify1(1); })->select('disappearances.*');
        return DataTables::eloquent($disappearances)
            ->addColumn('nik', function ($disappearance) {
                return '<a onclick="viewDetail(' . $disappearance->user_id . ')" href="" data-toggle="modal" data-target="#userDetailModal" data-toggle="tooltip" data-placement="top" title="Lihat detail pengguna" >' . $disappearance->user->nik . '</a>';
            })
            ->addColumn('tanggal_pengajuan', function ($disappearance) {
                return $disappearance->created_at->format('d M Y - H:i:s');
            })
            ->addColumn('tanggal_disetujui', function ($disappearance) {
                return $disappearance->letter->updated_at->format('d M Y - H:i:s');
            })
            ->addColumn('status', function ($disappearance) {
                if ($disappearance->letter->verify1 == 1 && $disappearance->letter->verify2 == 1) {
                    return Lang::get('letter.approved');
                } elseif ($disappearance->letter->verify1 == 1 && $disappearance->letter->verify2 == null) {
                    return 'Belum di proses';
                } elseif ($disappearance->letter->verify1 == 1 && $disappearance->letter->verify2 == -1) {
                    return '<span class="font-weight-bold">' . Lang::get('letter.declined') . '</span> <br>(' . $disappearance->letter->reason2 . ')';
                }
            })
            ->addColumn('action', function ($disappearance) {
                if ($disappearance->letter->verify1 == 1 && $disappearance->letter->verify2 == 1) {
                    return '<a target="_blank" class="d-inline-block btn btn-success btn-sm btn-circle" data-toggle="tooltip" data-placement="top" title="Unduh" href="' . route('disappearances.download', $disappearance->id) . '">
                                <i class="fas fa-download"></i>
                            </a>
                            <button class="btn-circle btn-primary btn-sm btn" data-toggle="modal" data-target="#modalDetailSP" data-toggle="tooltip" data-placement="top" title="Detail Surat Pengantar" onclick="modalVerification(`' . $disappearance->id . '`)"><i class="fas fa-eye"></i></button>';
                } elseif ($disappearance->letter->verify1 == 1 && $disappearance->letter->verify2 == null || $disappearance->letter->verify2 == -1) {
                    return '<button class="btn-circle btn-warning btn-sm btn" data-toggle="modal" data-target="#modalVerification" data-toggle="tooltip" data-placement="top" title="Ubah Verifikasi" onclick="modalVerification(' . $disappearance->id . ',true)"><i class="fas fa-edit"></i></button>
                            <button class="btn-circle btn-primary btn-sm btn" data-toggle="modal" data-target="#modalDetailSP" data-toggle="tooltip" data-placement="top" title="Detail Surat Pengantar" onclick="modalVerification(`' . $disappearance->id . '`)"><i class="fas fa-eye"></i></button>'
                    ;
                }
            })
            ->rawColumns(['nik', 'tanggal_pengajuan', 'tanggal_disetujui', 'status', 'action'])
            ->toJson();
    }

    public function getVerified2()
    {
        $disappearances = Disappearance::with('user', 'letter')->whereHas('letter', function ($s) {
            $s->whereVerify2(1)->whereVerify1(1);
        })->select('disappearances.*');
        return DataTables::eloquent($disappearances)
            ->addColumn('nik', function ($disappearance) {
                return '<a onclick="viewDetail(' . $disappearance->user_id . ')" href="" data-toggle="modal" data-target="#userDetailModal" data-toggle="tooltip" data-placement="top" title="Lihat detail pengguna" >' . $disappearance->user->nik . '</a>';
            })
            ->addColumn('tanggal_pengajuan', function ($disappearance) {
                return $disappearance->created_at->format('d M Y - H:i:s');
            })
            ->addColumn('tanggal_disetujui', function ($disappearance) {
                return $disappearance->letter->updated_at->format('d M Y - H:i:s');
            })
            ->addColumn('status', function ($disappearance) {
                return Lang::get('letter.approved');
            })
            ->addColumn('action', function ($disappearance) {
                return '<a target="_blank" class="d-inline-block btn btn-success btn-sm btn-circle" data-toggle="tooltip" data-placement="top" title="Unduh" href="' . route('disappearances.download', $disappearance->id) . '">
                            <i class="fas fa-download"></i>
                        </a>
                        <button class="btn-circle btn-primary btn-sm btn" data-toggle="modal" data-target="#modalDetailSP" data-toggle="tooltip" data-placement="top" title="Detail Surat Pengantar" onclick="modalVerification(`' . $disappearance->id . '`)"><i class="fas fa-eye"></i></button>'
                ;
            })
            ->rawColumns(['nik', 'tanggal_pengajuan', 'tanggal_disetujui', 'status', 'action'])
            ->toJson();
    }

    public function getDeclined1()
    {
        $disappearances = Disappearance::with('user', 'letter')->whereHas('letter', function ($s) { $s->whereVerify1(-1); })->select('disappearances.*');
        return DataTables::eloquent($disappearances)
            ->addColumn('nik', function ($disappearance) {
                return '<a onclick="viewDetail(' . $disappearance->user_id . ')" href="" data-toggle="modal" data-target="#userDetailModal" data-toggle="tooltip" data-placement="top" title="Lihat detail pengguna" >' . $disappearance->user->nik . '</a>';
            })
            ->addColumn('tanggal_pengajuan', function ($disappearance) {
                return $disappearance->created_at->format('d M Y - H:i:s');
            })
            ->addColumn('tanggal_penolakan', function ($disappearance) {
                return $disappearance->letter->updated_at->format('d M Y - H:i:s');
            })
            ->rawColumns(['nik', 'tanggal_pengajuan', 'tanggal_penolakan'])
            ->toJson();
    }

    public function getDeclined2()
    {
        $disappearances = Disappearance::with('user', 'letter')->whereHas('letter', function ($s) {
            $s->whereVerify2(-1);
        })->select('disappearances.*');
        return DataTables::eloquent($disappearances)
            ->addColumn('nik', function ($disappearance) {
                return '<a onclick="viewDetail(' . $disappearance->user_id . ')" href="" data-toggle="modal" data-target="#userDetailModal" data-toggle="tooltip" data-placement="top" title="Lihat detail pengguna" >' . $disappearance->user->nik . '</a>';
            })
            ->addColumn('tanggal_pengajuan', function ($disappearance) {
                return $disappearance->created_at->format('d M Y - H:i:s');
            })
            ->addColumn('tanggal_penolakan', function ($disappearance) {
                return $disappearance->letter->updated_at->format('d M Y - H:i:s');
            })
            ->addColumn('action', function ($disappearance) {
                return '<form class="d-inline-block" action="' . route('disappearances.verify2', $disappearance) . '" method="POST">
                            <input type="hidden" name="_token" value="' . csrf_token() . '">
                            <input type="hidden" name="_method" value="put">
                            <input type="hidden" name="verifikasi" value="1">
                            <button type="submit" class="btn btn-success btn-circle btn-sm" data-toggle="tooltip" data-placement="top" title="Ubah Jadi Setujui" onclick="return confirm(`Apakah anda yakin ingin menyetujui pengajuan surat ini ?`);">
                                <i class="fas fa-check"></i>
                            </button>
                        </form>
                        <button class="btn-circle btn-primary btn-sm btn" data-toggle="modal" data-target="#modalDetailSP" data-toggle="tooltip" data-placement="top" title="Detail Surat Pengantar" onclick="modalVerification(`' . $disappearance->id . '`)"><i class="fas fa-eye"></i></button>'
                ;
            })
            ->rawColumns(['nik','tanggal_pengajuan', 'tanggal_penolakan', 'action'])
            ->toJson();
    }
}
