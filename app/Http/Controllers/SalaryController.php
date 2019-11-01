<?php

namespace App\Http\Controllers;

use App\Letter;
use App\Salary;
use App\User;
use PDF;
use Alert;
use DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;

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
        return view('salary.index', compact('title', 'subtitle'));
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
        return view('salary.unprocessed1', compact('title', 'subtitle'));
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
        return view('salary.verified1', compact('title', 'subtitle'));
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
        return view('salary.declined1', compact('title', 'subtitle'));
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
        return view('salary.unprocessed2', compact('title', 'subtitle'));
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
        return view('salary.verified2', compact('title', 'subtitle'));
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

    public function getEditSalary(Request $request)
    {
        $salary = Salary::findOrFail($request->id);
        echo json_encode($salary);
    }

    public function getSalary()
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
                        return Lang::get('salary.approved');
                    } elseif ($salary->letter->verify1 == 1 && $salary->letter->verify2 == null || $salary->letter->verify2 == -1) {
                        return 'Sedang diproses';
                    } elseif ($salary->letter->verify1 == -1 && $salary->letter->verify2 == null || $salary->letter->verify2 == -1) {
                        return '<span class="font-weight-bold">' . Lang::get('salary.declined') . '</span> <br>(' . $salary->letter->reason1 . ')';
                    }
                } else {
                    return 'Belum diproses';
                }
            })
            ->addColumn('action', function ($salary) {
                if ($salary->letter_id != null) {
                    if ($salary->letter->verify1 == 1 && $salary->letter->verify2 == 1) {
                        return '<a target="_blank" class="d-inline-block btn btn-success btn-sm btn-circle" data-toggle="tooltip" data-placement="top" title="Unduh" href="' . route('salary.download', $salary->id) . '">
                                    <i class="fas fa-download"></i>
                                </a>';
                    } elseif ($salary->letter->verify1 == 1 && $salary->letter->verify2 == null || $salary->letter->verify2 == -1) {
                        return '-';
                    } elseif ($salary->letter->verify1 == -1 && $salary->letter->verify2 == null || $salary->letter->verify2 == -1) {
                        return '-';
                    }
                } else {
                    return '<button class="editSubmission btn-circle btn-warning btn-sm btn" data-toggle="modal" data-target="#editSubmissionModal" onclick="editModal(' . $salary->id . ')" data-toggle="tooltip" data-placement="top" title="Ubah" ><i class="fas fa-edit"></i></button>
                                <form class="d-inline-block" action="' . route('salary.destroy', $salary->id) . '" method="POST">
                                    <input type="hidden" name="_token" value="' . csrf_token() . '">
                                    <input type="hidden" name="_method" value="delete">
                                    <button type="submit" class="btn btn-danger btn-circle btn-sm" data-toggle="tooltip" data-placement="top" title="Hapus" onclick="return confirm(`' . Lang::get('salary.delete_confirm') . '`);">
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
            ->addColumn('tanggal_pengajuan', function ($salary) {
                return $salary->created_at->format('d M Y - H:i:s');
            })
            ->addColumn('action', function ($salary) {
                return '<a class="d-inline-block btn btn-warning btn-sm btn-circle" data-toggle="tooltip" data-placement="top" title="Verifikasi" href="' . route('salary.edit-unprocessed1', $salary->id) . '">
                            <i class="fas fa-check"></i>
                        </a>';
            })
            ->addColumn('penghasilan', function ($salary) {
                return 'Rp.' . number_format($salary->salary, 2, ',', '.');
            })
            ->rawColumns(['tanggal_pengajuan','penghasilan', 'action'])
            ->toJson();
    }

    public function getUnprocessed2()
    {
        $salaries = Salary::with('user', 'letter')->whereHas('letter',function($s){$s->whereVerify1(1)->whereVerify2(null);})->select('salaries.*');
        return DataTables::eloquent($salaries)
            ->addColumn('tanggal_pengajuan', function ($salary) {
                return $salary->created_at->format('d M Y - H:i:s');
            })
            ->addColumn('penghasilan', function ($salary) {
                return 'Rp.' . number_format($salary->salary, 2, ',', '.');
            })
            ->addColumn('action', function ($salary) {
                return '<a class="d-inline-block btn btn-warning btn-sm btn-circle" data-toggle="tooltip" data-placement="top" title="Verifikasi" href="' . route('salary.edit-unprocessed2', $salary->id) . '">
                            <i class="fas fa-check"></i>
                        </a>';
            })
            ->rawColumns(['tanggal_pengajuan','penghasilan', 'action'])
            ->toJson();
    }

    public function getVerified1()
    {
        $salaries = Salary::with('user', 'letter')->whereHas('letter', function ($s) {
            $s->whereVerify1(1);
        })->select('salaries.*');
        return DataTables::eloquent($salaries)
            ->addColumn('nik', function ($salary) {
                return '<a onclick="viewDetail(' . $salary->user_id . ')" href="" data-toggle="modal" data-target="#userDetailModal" data-toggle="tooltip" data-placement="top" title="Lihat detail pengguna" >'.$salary->user->nik.'</a>';
            })
            ->addColumn('penghasilan', function ($salary) {
                return 'Rp.'.number_format($salary->salary, 2, ',', '.');
            })
            ->addColumn('tanggal_pengajuan', function ($salary) {
                return $salary->created_at->format('d M Y - H:i:s');
            })
            ->addColumn('tanggal_disetujui', function ($salary) {
                return $salary->letter->updated_at->format('d M Y - H:i:s');
            })
            ->addColumn('status', function ($salary) {
                if ($salary->letter->verify1 == 1 && $salary->letter->verify2 == 1) {
                    return Lang::get('salary.approved');
                } elseif ($salary->letter->verify1 == 1 && $salary->letter->verify2 == null) {
                    return 'Belum di proses';
                } elseif ($salary->letter->verify1 == 1 && $salary->letter->verify2 == -1) {
                    return '<span class="font-weight-bold">' . Lang::get('salary.declined') . '</span> <br>(' . $salary->letter->reason2 . ')';
                }
            })
            ->addColumn('action', function ($salary) {
                if ($salary->letter->verify1 == 1 && $salary->letter->verify2 == 1) {
                    return '<a target="_blank" class="d-inline-block btn btn-success btn-sm btn-circle" data-toggle="tooltip" data-placement="top" title="Unduh" href="' . route('salary.download', $salary->id) . '">
                                <i class="fas fa-download"></i>
                            </a>';
                } elseif ($salary->letter->verify1 == 1 && $salary->letter->verify2 == null || $salary->letter->verify2 == -1) {
                    return '<a class="editSubmission btn-circle btn-warning btn-sm btn" href="'.route('salary.edit-verified1',$salary->id).'" data-toggle="tooltip" data-placement="top" title="Ubah" ><i class="fas fa-edit"></i></a>';
                }
            })
            ->rawColumns(['nik','penghasilan','tanggal_pengajuan', 'tanggal_disetujui', 'status', 'action'])
            ->toJson();
    }

    public function getVerified2()
    {
        $salaries = Salary::with('user', 'letter')->whereHas('letter', function ($s) {
            $s->whereVerify2(1)->whereVerify1(1);
        })->select('salaries.*');
        return DataTables::eloquent($salaries)
            ->addColumn('nik', function ($salary) {
                return '<a onclick="viewDetail(' . $salary->user_id . ')" href="" data-toggle="modal" data-target="#userDetailModal" data-toggle="tooltip" data-placement="top" title="Lihat detail pengguna" >'.$salary->user->nik.'</a>';
            })
            ->addColumn('penghasilan', function ($salary) {
                return 'Rp.'.number_format($salary->salary, 2, ',', '.');
            })
            ->addColumn('tanggal_pengajuan', function ($salary) {
                return $salary->created_at->format('d M Y - H:i:s');
            })
            ->addColumn('tanggal_disetujui', function ($salary) {
                return $salary->letter->updated_at->format('d M Y - H:i:s');
            })
            ->addColumn('status', function ($salary) {
                return Lang::get('salary.approved');
            })
            ->addColumn('action', function ($salary) {
                return '<a target="_blank" class="d-inline-block btn btn-success btn-sm btn-circle" data-toggle="tooltip" data-placement="top" title="Unduh" href="' . route('salary.download', $salary->id) . '">
                            <i class="fas fa-download"></i>
                        </a>';
            })
            ->rawColumns(['nik','penghasilan','tanggal_pengajuan', 'tanggal_disetujui', 'status', 'action'])
            ->toJson();
    }

    public function getDeclined1()
    {
        $salaries = Salary::with('user', 'letter')->whereHas('letter', function ($s) {
            $s->whereVerify1(-1);
        })->select('salaries.*');
        return DataTables::eloquent($salaries)
            ->addColumn('nik', function ($salary) {
                return '<a onclick="viewDetail(' . $salary->user_id . ')" href="" data-toggle="modal" data-target="#userDetailModal" data-toggle="tooltip" data-placement="top" title="Lihat detail pengguna" >'.$salary->user->nik.'</a>';
            })
            ->addColumn('penghasilan', function ($salary) {
                return 'Rp.'.number_format($salary->salary, 2, ',', '.');
            })
            ->addColumn('tanggal_pengajuan', function ($salary) {
                return $salary->created_at->format('d M Y - H:i:s');
            })
            ->addColumn('tanggal_ditolak', function ($salary) {
                return $salary->letter->updated_at->format('d M Y - H:i:s');
            })
            ->rawColumns(['nik','penghasilan','tanggal_pengajuan', 'tanggal_ditolak'])
            ->toJson();
    }

    public function getDeclined2()
    {
        $salaries = Salary::with('user', 'letter')->whereHas('letter',function($s){$s->whereVerify2(-1);})->select('salaries.*');
        return DataTables::eloquent($salaries)
            ->addColumn('tanggal_pengajuan', function ($salary) {
                return $salary->created_at->format('d M Y - H:i:s');
            })
            ->addColumn('penghasilan', function ($salary) {
                return 'Rp.' . number_format($salary->salary, 2, ',', '.');
            })
            ->addColumn('tanggal_penolakan', function ($salary) {
                return $salary->letter->updated_at->format('d M Y - H:i:s');
            })
            ->addColumn('action', function ($salary) {
                return '<a class="d-inline-block btn btn-warning btn-sm btn-circle" data-toggle="tooltip" data-placement="top" title="Verifikasi" href="' . route('salary.edit-declined2', $salary->id) . '">
                            <i class="fas fa-edit"></i>
                        </a>';
            })
            ->rawColumns(['tanggal_pengajuan','tanggal_penolakan','penghasilan', 'action'])
            ->toJson();
    }
}
