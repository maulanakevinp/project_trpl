<?php

namespace App\Http\Controllers;

use App\UserMenu;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = 'Manajemen Menu';
        $user_menu = UserMenu::where('id', '!=', 1)->orderBy('id', 'asc')->get();
        return view('menu.index', compact('title', 'user_menu'));
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
            'menu' => 'required'
        ]);

        UserMenu::create($request->all());
        return redirect('/menu')->with('success', 'Menu berhasil ditambahkan');
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
            'menu' => 'required'
        ]);

        UserMenu::where('id', $id)->update([
            'menu' => $request->menu
        ]);

        return redirect('/menu')->with('success', 'Menu berhasil diubah');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        UserMenu::destroy($id);
        return redirect('/menu')->with('success', 'Menu berhasil dihapus');
    }

    public function getMenu(Request $request)
    {
        $menu = UserMenu::find($request->id);
        echo json_encode($menu);
    }
}
