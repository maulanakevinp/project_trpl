<?php

namespace App\Http\Controllers;

use App\Salary;
use DataTables;
use Alert;
use App\Letter;
use App\User;
use PDF;
use File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;

class SalariesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = 'Pengajuan Surat';
        $subtitle = 'Data Pengajuan Surat Keterangan Penghasilan';
        return view('salaries.index', compact('title', 'subtitle'));
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
        return view('salaries.create', compact('title', 'subtitle'));
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
            'penghasilan'       => ['required','numeric','min:0','max:2000000'],
            'tujuan'            => ['required'],
            'surat_pengantar'   => ['required','image','mimes:jpeg,png','max:2048']
        ]);
        Salary::create([
            'salary'  => $request->penghasilan,
            'purpose' => $request->tujuan,
            'user_id' => auth()->user()->id,
            'file'    => $this->setImageUpload($request->surat_pengantar,'img/surat_pengantar')
        ]);
        Alert::success('Pengajuan surat keterangan penghasilan berhasil ditambahkan', 'berhasil');
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Salary  $salary
     * @return \Illuminate\Http\Response
     */
    public function show(Salary $salary)
    {
        $kepala = User::find(1);
        if ($salary->letter->verify1 == 1 && $salary->letter->verify2 == 1) {
            if ($salary->user_id == auth()->user()->id || auth()->user()->role_id == 2 || auth()->user()->role_id == 3) {
                $pdf = PDF::loadview('salaries.show', compact('domicile', 'kepala'));
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
     * @param  \App\Salary  $salary
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Salary $salary)
    {
        $request->validate([
            'penghasilan'       => ['required','numeric','min:0','max:2000000'],
            'tujuan'            => ['required'],
            'surat_pengantar'   => ['image','mimes:jpeg,png','max:2048']
        ]);

        if ($request->surat_pengantar) {
            $salary->file = $this->setImageUpload($request->surat_pengantar,'img/surat_pengantar',$salary->file);
        }

        $salary->salary = $request->penghasilan;
        $salary->purpose = $request->tujuan;
        $salary->save();
        Alert::success('Pengajuan surat keterangan penghasilan berhasil diperbarui', 'berhasil');
        return redirect()->back();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Salary  $salary
     * @return \Illuminate\Http\Response
     */
    public function verify1(Request $request, Salary $salary)
    {
        if ($request->update) {
            $letter = Letter::findOrFail($salary->letter_id);
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
            File::delete(public_path('img/surat_pengantar'. '/' . $salary->file));
        } else {
            $letter->verify1 = 1;
            $letter->verify2 = null;
            $letter->reason2 = null;
        }
        
        $letter->save();

        $salary->letter_id = $letter->id;
        $salary->purpose = $request->tujuan;
        $salary->save();
        Alert::success('Pengajuan surat keterangan penghasilan berhasil diverifikasi', 'berhasil');
        return redirect()->back();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Salary  $salary
     * @return \Illuminate\Http\Response
     */
    public function verify2(Request $request, Salary $salary)
    {
        $letter = Letter::findOrFail($salary->letter_id);
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
        Alert::success('Pengajuan surat keterangan penghasilan berhasil diverifikasi', 'berhasil');
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Salary  $salary
     * @return \Illuminate\Http\Response
     */
    public function destroy(Salary $salary)
    {
        File::delete(public_path('img/surat_pengantar'. '/' . $salary->file));
        $salary->delete();
        Alert::success('Pengajuan surat keterangan penghasilan berhasil dihapus', 'berhasil');
        return redirect()->back();
    }
    
    public function getEditSalaries(Request $request)
    {
        $salary = Salary::findOrFail($request->id);
        echo json_encode($salary);
    }

    public function getSalaries()
    {
        $salaries = Salary::with('letter', 'user')->whereUserId(auth()->user()->id)->select('salaries.*');
        return DataTables::eloquent($salaries)
            ->addColumn('tanggal_pengajuan', function ($salary) {
                return $salary->created_at->format('d M Y - H:i:s');
            })
            ->addColumn('tanggal_disetujui', function ($salary) {
                if ($salary->letter_id != null) {
                    if ($salary->letter->verify1 == 1 && $salary->letter->verify2 == 1) {
                        return $salary->letter->updated_at->format('d M Y - H:i:s');
                    } else {
                        return '-';
                    }
                } else {
                    return '-';
                }
            })
            ->addColumn('status', function ($salary) {
                if ($salary->letter_id != null) {
                    if ($salary->letter->verify1 == 1 && $salary->letter->verify2 == 1) {
                        return Lang::get('letter.approved');
                    } elseif ($salary->letter->verify1 == 1 && $salary->letter->verify2 == null || $salary->letter->verify2 == -1) {
                        return Lang::get('letter.inprocessed');
                    } elseif ($salary->letter->verify1 == -1 && $salary->letter->verify2 == null || $salary->letter->verify2 == -1) {
                        return '<span class="font-weight-bold">' . Lang::get('letter.declined') . '</span> <br>(' . $salary->letter->reason1 . ')';
                    }
                } else {
                    return Lang::get('letter.unprocessed');
                }
            })
            ->addColumn('action', function ($salary) {
                if ($salary->letter_id != null) {
                    if ($salary->letter->verify1 == 1 && $salary->letter->verify2 == 1) {
                        return '<a target="_blank" class="d-inline-block btn btn-success btn-sm btn-circle" data-toggle="tooltip" data-placement="top" title="Unduh" href="' . route('salaries.download', $salary->id) . '">
                                    <i class="fas fa-download"></i>
                                </a>';
                    } elseif ($salary->letter->verify1 == 1 && $salary->letter->verify2 == null || $salary->letter->verify2 == -1) {
                        return '-';
                    } elseif ($salary->letter->verify1 == -1 && $salary->letter->verify2 == null || $salary->letter->verify2 == -1) {
                        return '-';
                    }
                } else {
                    return '<button class="editSubmission btn-circle btn-warning btn-sm btn" data-toggle="modal" data-target="#modalEditSalary" data-toggle="tooltip" data-placement="top" title="Ubah"  onclick="editModal(' . $salary->id . ')"><i class="fas fa-edit"></i></button>
                            <form class="d-inline-block" action="' . route('salaries.destroy', $salary->id) . '" method="POST">
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
        $salaries = Salary::with('user', 'letter')->whereLetterId(null)->select('salaries.*');
        return DataTables::eloquent($salaries)
            ->addColumn('nik', function ($salary) {
                return '<a onclick="viewDetail(' . $salary->user_id . ')" href="" data-toggle="modal" data-target="#userDetailModal" data-toggle="tooltip" data-placement="top" title="Lihat detail pengguna" >' . $salary->user->nik . '</a>';
            })
            ->addColumn('tanggal_pengajuan', function ($salary) {
                return $salary->created_at->format('d M Y - H:i:s');
            })
            ->addColumn('action', function ($salary) {
                return '<button class="btn-circle btn-warning btn-sm btn" data-toggle="modal" data-target="#modalVerification" data-toggle="tooltip" data-placement="top" title="Verifikasi" onclick="modalVerification(' . $salary->id . ')"><i class="fas fa-check"></i></button>
                        <button class="btn-circle btn-primary btn-sm btn" data-toggle="modal" data-target="#modalDetailSP" data-toggle="tooltip" data-placement="top" title="Detail Surat Pengantar" onclick="modalVerification(`' . $salary->id . '`)"><i class="fas fa-eye"></i></button>'
                ;
            })
            ->rawColumns(['nik','tanggal_pengajuan', 'action'])
            ->toJson();
    }

    public function getUnprocessed2()
    {
        $salaries = Salary::with('user', 'letter')->whereHas('letter', function ($s) {
            $s->whereVerify1(1)->whereVerify2(null);
        })->select('salaries.*');
        return DataTables::eloquent($salaries)
            ->addColumn('nik', function ($salary) {
                return '<a onclick="viewDetail(' . $salary->user_id . ')" href="" data-toggle="modal" data-target="#userDetailModal" data-toggle="tooltip" data-placement="top" title="Lihat detail pengguna" >' . $salary->user->nik . '</a>';
            })
            ->addColumn('tanggal_pengajuan', function ($salary) {
                return $salary->created_at->format('d M Y - H:i:s');
            })
            ->addColumn('action', function ($salary) {
                return '<button class="btn-circle btn-warning btn-sm btn" data-toggle="modal" data-target="#modalVerification" data-toggle="tooltip" data-placement="top" title="Verifikasi" onclick="modalVerification(' . $salary->id . ')"><i class="fas fa-check"></i></button>
                        <button class="btn-circle btn-primary btn-sm btn" data-toggle="modal" data-target="#modalDetailSP" data-toggle="tooltip" data-placement="top" title="Detail Surat Pengantar" onclick="modalVerification(`' . $salary->id . '`)"><i class="fas fa-eye"></i></button>'
                ;
            })
            ->rawColumns(['nik','tanggal_pengajuan','action'])
            ->toJson();
    }

    public function getVerified1()
    {
        $salaries = Salary::with('user', 'letter')->whereHas('letter', function ($s) { $s->whereVerify1(1); })->select('salaries.*');
        return DataTables::eloquent($salaries)
            ->addColumn('nik', function ($salary) {
                return '<a onclick="viewDetail(' . $salary->user_id . ')" href="" data-toggle="modal" data-target="#userDetailModal" data-toggle="tooltip" data-placement="top" title="Lihat detail pengguna" >' . $salary->user->nik . '</a>';
            })
            ->addColumn('tanggal_pengajuan', function ($salary) {
                return $salary->created_at->format('d M Y - H:i:s');
            })
            ->addColumn('tanggal_disetujui', function ($salary) {
                return $salary->letter->updated_at->format('d M Y - H:i:s');
            })
            ->addColumn('status', function ($salary) {
                if ($salary->letter->verify1 == 1 && $salary->letter->verify2 == 1) {
                    return Lang::get('letter.approved');
                } elseif ($salary->letter->verify1 == 1 && $salary->letter->verify2 == null) {
                    return 'Belum di proses';
                } elseif ($salary->letter->verify1 == 1 && $salary->letter->verify2 == -1) {
                    return '<span class="font-weight-bold">' . Lang::get('letter.declined') . '</span> <br>(' . $salary->letter->reason2 . ')';
                }
            })
            ->addColumn('action', function ($salary) {
                if ($salary->letter->verify1 == 1 && $salary->letter->verify2 == 1) {
                    return '<a target="_blank" class="d-inline-block btn btn-success btn-sm btn-circle" data-toggle="tooltip" data-placement="top" title="Unduh" href="' . route('salaries.download', $salary->id) . '">
                                <i class="fas fa-download"></i>
                            </a>
                            <button class="btn-circle btn-primary btn-sm btn" data-toggle="modal" data-target="#modalDetailSP" data-toggle="tooltip" data-placement="top" title="Detail Surat Pengantar" onclick="modalVerification(`' . $salary->id . '`)"><i class="fas fa-eye"></i></button>';
                } elseif ($salary->letter->verify1 == 1 && $salary->letter->verify2 == null || $salary->letter->verify2 == -1) {
                    return '<button class="btn-circle btn-warning btn-sm btn" data-toggle="modal" data-target="#modalVerification" data-toggle="tooltip" data-placement="top" title="Ubah Verifikasi" onclick="modalVerification(' . $salary->id . ',true)"><i class="fas fa-edit"></i></button>
                            <button class="btn-circle btn-primary btn-sm btn" data-toggle="modal" data-target="#modalDetailSP" data-toggle="tooltip" data-placement="top" title="Detail Surat Pengantar" onclick="modalVerification(`' . $salary->id . '`)"><i class="fas fa-eye"></i></button>'
                    ;
                }
            })
            ->rawColumns(['nik', 'tanggal_pengajuan', 'tanggal_disetujui', 'status', 'action'])
            ->toJson();
    }

    public function getVerified2()
    {
        $salaries = Salary::with('user', 'letter')->whereHas('letter', function ($s) {
            $s->whereVerify2(1)->whereVerify1(1);
        })->select('salaries.*');
        return DataTables::eloquent($salaries)
            ->addColumn('nik', function ($salary) {
                return '<a onclick="viewDetail(' . $salary->user_id . ')" href="" data-toggle="modal" data-target="#userDetailModal" data-toggle="tooltip" data-placement="top" title="Lihat detail pengguna" >' . $salary->user->nik . '</a>';
            })
            ->addColumn('tanggal_pengajuan', function ($salary) {
                return $salary->created_at->format('d M Y - H:i:s');
            })
            ->addColumn('tanggal_disetujui', function ($salary) {
                return $salary->letter->updated_at->format('d M Y - H:i:s');
            })
            ->addColumn('status', function ($salary) {
                return Lang::get('letter.approved');
            })
            ->addColumn('action', function ($salary) {
                return '<a target="_blank" class="d-inline-block btn btn-success btn-sm btn-circle" data-toggle="tooltip" data-placement="top" title="Unduh" href="' . route('salaries.download', $salary->id) . '">
                            <i class="fas fa-download"></i>
                        </a>
                        <button class="btn-circle btn-primary btn-sm btn" data-toggle="modal" data-target="#modalDetailSP" data-toggle="tooltip" data-placement="top" title="Detail Surat Pengantar" onclick="modalVerification(`' . $salary->id . '`)"><i class="fas fa-eye"></i></button>';
            })
            ->rawColumns(['nik', 'tanggal_pengajuan', 'tanggal_disetujui', 'status', 'action'])
            ->toJson();
    }

    public function getDeclined1()
    {
        $salaries = Salary::with('user', 'letter')->whereHas('letter', function ($s) { $s->whereVerify1(-1); })->select('salaries.*');
        return DataTables::eloquent($salaries)
            ->addColumn('nik', function ($salary) {
                return '<a onclick="viewDetail(' . $salary->user_id . ')" href="" data-toggle="modal" data-target="#userDetailModal" data-toggle="tooltip" data-placement="top" title="Lihat detail pengguna" >' . $salary->user->nik . '</a>';
            })
            ->addColumn('tanggal_pengajuan', function ($salary) {
                return $salary->created_at->format('d M Y - H:i:s');
            })
            ->addColumn('tanggal_penolakan', function ($salary) {
                return $salary->letter->updated_at->format('d M Y - H:i:s');
            })
            ->rawColumns(['nik', 'tanggal_pengajuan', 'tanggal_penolakan'])
            ->toJson();
    }

    public function getDeclined2()
    {
        $salaries = Salary::with('user', 'letter')->whereHas('letter', function ($s) {
            $s->whereVerify2(-1);
        })->select('salaries.*');
        return DataTables::eloquent($salaries)
            ->addColumn('nik', function ($salary) {
                return '<a onclick="viewDetail(' . $salary->user_id . ')" href="" data-toggle="modal" data-target="#userDetailModal" data-toggle="tooltip" data-placement="top" title="Lihat detail pengguna" >' . $salary->user->nik . '</a>';
            })
            ->addColumn('tanggal_pengajuan', function ($salary) {
                return $salary->created_at->format('d M Y - H:i:s');
            })
            ->addColumn('tanggal_penolakan', function ($salary) {
                return $salary->letter->updated_at->format('d M Y - H:i:s');
            })
            ->addColumn('action', function ($salary) {
                return '<form class="d-inline-block" action="' . route('salaries.verify2', $salary) . '" method="POST">
                            <input type="hidden" name="_token" value="' . csrf_token() . '">
                            <input type="hidden" name="_method" value="put">
                            <input type="hidden" name="verifikasi" value="1">
                            <button type="submit" class="btn btn-success btn-circle btn-sm" data-toggle="tooltip" data-placement="top" title="Ubah Jadi Setujui" onclick="return confirm(`Apakah anda yakin ingin menyetujui pengajuan surat ini ?`);">
                                <i class="fas fa-check"></i>
                            </button>
                        </form>
                        <button class="btn-circle btn-primary btn-sm btn" data-toggle="modal" data-target="#modalDetailSP" data-toggle="tooltip" data-placement="top" title="Detail Surat Pengantar" onclick="modalVerification(`' . $salary->id . '`)"><i class="fas fa-eye"></i></button>'
                ;
            })
            ->rawColumns(['nik','tanggal_pengajuan', 'tanggal_penolakan', 'action'])
            ->toJson();
    }
}
