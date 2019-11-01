<?php

namespace App\Http\Controllers;

use App\Letter;
use App\Incapable;
use App\User;
use PDF;
use Alert;
use DataTables;
use Illuminate\Support\Facades\Lang;
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
        return view('incapable.index', compact('title', 'subtitle'));
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
        return view('incapable.unprocessed1', compact('title', 'subtitle'));
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
        return view('incapable.verified1', compact('title', 'subtitle'));
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
        return view('incapable.declined1', compact('title', 'subtitle'));
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
        return view('incapable.unprocessed2', compact('title', 'subtitle'));
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
        return view('incapable.verified2', compact('title', 'subtitle'));
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
        return view('incapable.declined2', compact('title', 'subtitle'));
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

    public function getEditIncapable(Request $request)
    {
        $incapable = Incapable::findOrFail($request->id);
        echo json_encode($incapable);
    }

    public function getIncapable()
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
                        return Lang::get('incapable.approved');
                    } elseif ($incapable->letter->verify1 == 1 && $incapable->letter->verify2 == null || $incapable->letter->verify2 == -1) {
                        return 'Sedang diproses';
                    } elseif ($incapable->letter->verify1 == -1 && $incapable->letter->verify2 == null || $incapable->letter->verify2 == -1) {
                        return '<span class="font-weight-bold">' . Lang::get('incapable.declined') . '</span> <br>(' . $incapable->letter->reason1 . ')';
                    }
                } else {
                    return 'Belum diproses';
                }
            })
            ->addColumn('action', function ($incapable) {
                if ($incapable->letter_id != null) {
                    if ($incapable->letter->verify1 == 1 && $incapable->letter->verify2 == 1) {
                        return '<a target="_blank" class="d-inline-block btn btn-success btn-sm btn-circle" data-toggle="tooltip" data-placement="top" title="Unduh" href="' . route('incapable.download', $incapable->id) . '">
                                    <i class="fas fa-download"></i>
                                </a>';
                    } elseif ($incapable->letter->verify1 == 1 && $incapable->letter->verify2 == null || $incapable->letter->verify2 == -1) {
                        return '-';
                    } elseif ($incapable->letter->verify1 == -1 && $incapable->letter->verify2 == null || $incapable->letter->verify2 == -1) {
                        return '-';
                    }
                } else {
                    return '<button class="editSubmission btn-circle btn-warning btn-sm btn" data-toggle="modal" data-target="#modalEditIncapable" data-toggle="tooltip" data-placement="top" title="Ubah"  onclick="editModal(' . $incapable->id . ')"><i class="fas fa-edit"></i></button>
                                <form class="d-inline-block" action="' . route('incapable.destroy', $incapable->id) . '" method="POST">
                                    <input type="hidden" name="_token" value="' . csrf_token() . '">
                                    <input type="hidden" name="_method" value="delete">
                                    <button type="submit" class="btn btn-danger btn-circle btn-sm" data-toggle="tooltip" data-placement="top" title="Hapus" onclick="return confirm(`' . Lang::get('incapable.delete_confirm') . '`);">
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
            ->addColumn('tanggal_pengajuan', function ($incapable) {
                return $incapable->created_at->format('d M Y - H:i:s');
            })
            ->addColumn('action', function ($incapable) {
                return '<a class="d-inline-block btn btn-warning btn-sm btn-circle" data-toggle="tooltip" data-placement="top" title="Verifikasi" href="' . route('incapable.edit-unprocessed1', $incapable->id) . '">
                            <i class="fas fa-check"></i>
                        </a>';
            })
            ->rawColumns(['tanggal_pengajuan', 'action'])
            ->toJson();
    }

    public function getUnprocessed2()
    {
        $incapables = Incapable::with('user', 'letter')->whereHas('letter', function ($s) {
            $s->whereVerify1(1)->whereVerify2(null);
        })->select('incapables.*');
        return DataTables::eloquent($incapables)
            ->addColumn('tanggal_pengajuan', function ($incapable) {
                return $incapable->created_at->format('d M Y - H:i:s');
            })
            ->addColumn('action', function ($incapable) {
                return '<a class="d-inline-block btn btn-warning btn-sm btn-circle" data-toggle="tooltip" data-placement="top" title="Verifikasi" href="' . route('incapable.edit-unprocessed2', $incapable->id) . '">
                            <i class="fas fa-check"></i>
                        </a>';
            })
            ->rawColumns(['tanggal_pengajuan','action'])
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
                    return Lang::get('incapable.approved');
                } elseif ($incapable->letter->verify1 == 1 && $incapable->letter->verify2 == null) {
                    return 'Belum di proses';
                } elseif ($incapable->letter->verify1 == 1 && $incapable->letter->verify2 == -1) {
                    return '<span class="font-weight-bold">' . Lang::get('incapable.declined') . '</span> <br>(' . $incapable->letter->reason2 . ')';
                }
            })
            ->addColumn('action', function ($incapable) {
                if ($incapable->letter->verify1 == 1 && $incapable->letter->verify2 == 1) {
                    return '<a target="_blank" class="d-inline-block btn btn-success btn-sm btn-circle" data-toggle="tooltip" data-placement="top" title="Unduh" href="' . route('incapable.download', $incapable->id) . '">
                                <i class="fas fa-download"></i>
                            </a>';
                } elseif ($incapable->letter->verify1 == 1 && $incapable->letter->verify2 == null || $incapable->letter->verify2 == -1) {
                    return '<a class="editSubmission btn-circle btn-warning btn-sm btn" href="' . route('incapable.edit-verified1', $incapable->id) . '" data-toggle="tooltip" data-placement="top" title="Ubah" ><i class="fas fa-edit"></i></a>';
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
                return Lang::get('incapable.approved');
            })
            ->addColumn('action', function ($incapable) {
                return '<a target="_blank" class="d-inline-block btn btn-success btn-sm btn-circle" data-toggle="tooltip" data-placement="top" title="Unduh" href="' . route('incapable.download', $incapable->id) . '">
                            <i class="fas fa-download"></i>
                        </a>';
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
            ->addColumn('tanggal_ditolak', function ($incapable) {
                return $incapable->letter->updated_at->format('d M Y - H:i:s');
            })
            ->rawColumns(['nik', 'tanggal_pengajuan', 'tanggal_ditolak'])
            ->toJson();
    }

    public function getDeclined2()
    {
        $incapables = Incapable::with('user', 'letter')->whereHas('letter', function ($s) {
            $s->whereVerify2(-1);
        })->select('incapables.*');
        return DataTables::eloquent($incapables)
            ->addColumn('tanggal_pengajuan', function ($incapable) {
                return $incapable->created_at->format('d M Y - H:i:s');
            })
            ->addColumn('tanggal_penolakan', function ($incapable) {
                return $incapable->letter->updated_at->format('d M Y - H:i:s');
            })
            ->addColumn('action', function ($incapable) {
                return '<a class="d-inline-block btn btn-warning btn-sm btn-circle" data-toggle="tooltip" data-placement="top" title="Verifikasi" href="' . route('incapable.edit-declined2', $incapable->id) . '">
                            <i class="fas fa-edit"></i>
                        </a>';
            })
            ->rawColumns(['tanggal_pengajuan', 'tanggal_penolakan', 'action'])
            ->toJson();
    }
}
