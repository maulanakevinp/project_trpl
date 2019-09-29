<?php

namespace App\Http\Controllers;

use App\UserAccessMenu;
use App\UserMenu;
use App\UserRole;
use Session;
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
        $title = 'Role Management';
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
            'role' => 'required'
        ]);

        UserRole::create($request->all());

        return redirect('/role')->with('success', 'Role has been created');
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
        $title = 'Role Management';
        $subtitle = 'Role Access';
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
            'role' => 'required'
        ]);

        UserRole::where('id', $id)->update([
            'role' => $request->role
        ]);

        return redirect('/role')->with('success', 'Role has been updated');
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
        return redirect('/role')->with('success', 'Role has been deleted');
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
        Session::flash('success', 'Access has been changed!');
    }
}
