<?php

namespace App\Http\Controllers;

use App\UserMenu;
use Alert;
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
        Alert::success('Menu berhasil ditambahkan', 'berhasil');
        return redirect('/menu');
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
        Alert::success('Menu berhasil diubah', 'berhasil');
        return redirect('/menu');
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
        Alert::success('Menu berhasil dihapus', 'berhasil');
        return redirect('/menu');
    }

    public function getMenu(Request $request)
    {
        $menu = UserMenu::find($request->id);
        echo json_encode($menu);
    }
}
