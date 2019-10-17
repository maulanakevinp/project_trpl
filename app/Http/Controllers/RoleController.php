<?php

namespace App\Http\Controllers;

use App\UserAccessMenu;
use App\UserMenu;
use App\UserRole;
use Alert;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = 'Manajemen Peran';
        $user_role = UserRole::all();
        return view('role.index', compact('title', 'user_role'));
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
            'peran' => 'required'
        ]);

        UserRole::create([
            'role' => $request->peran
        ]);
        Alert::success('Peran berhasil ditambahkan', 'Berhasil');
        return redirect('/role');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $menu = UserMenu::where('id', '!=', 1)
            ->orderBy('id', 'asc')
            ->get();
        $title = 'Manajemen Peran';
        $subtitle = 'Hak Akses';
        $role = UserRole::find($id);
        return view('role.edit', compact('menu', 'title', 'subtitle', 'role'));
    }

    public function getRole($id)
    {
        $role = UserRole::find($id);
        echo json_encode($role);
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
            'peran' => 'required'
        ]);

        UserRole::where('id', $id)->update([
            'role' => $request->peran
        ]);
        Alert::success('Peran berhasil diperbarui', 'Berhasil');
        return redirect('/role');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        UserRole::destroy($id);
        Alert::success('Peran berhasil dihapus', 'Berhasil');
        return redirect('/role');
    }

    public function changeAccess(Request $request)
    {
        $access = UserAccessMenu::getAccessByRoleAndMenu($request->roleId, $request->menuId);
        if ($access < 1) {
            UserAccessMenu::create([
                'role_id' => $request->roleId,
                'menu_id' => $request->menuId
            ]);
        } else {
            UserAccessMenu::where('role_id', $request->roleId)
                ->where('menu_id', $request->menuId)
                ->delete();
        }
        Alert::success('Hak akses berhasil diubah', 'Berhasil');
    }
}
