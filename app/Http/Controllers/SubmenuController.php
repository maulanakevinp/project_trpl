<?php

namespace App\Http\Controllers;

use App\UserMenu;
use App\UserSubmenu;
use Illuminate\Http\Request;

class SubmenuController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = 'Submenu Management';
        $user_menu = UserMenu::all();
        $user_submenu = UserSubmenu::all();
        return view('menu.submenu', compact('title', 'user_submenu', 'user_menu'));
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
            'menu_id' => 'required|numeric',
            'title' => 'required',
            'url' => 'required',
            'icon' => 'required',
        ]);
        $is_active = $request->is_active;
        if ($is_active == null) {
            $is_active = 0;
        }

        UserSubmenu::create([
            'menu_id' => $request->menu_id,
            'title' => $request->title,
            'url' => $request->url,
            'icon' => $request->icon,
            'is_active' => $is_active
        ]);
        return redirect('/submenu')->with('success', 'Submenu has been created');
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
            'menu_id' => 'required|numeric',
            'title' => 'required',
            'url' => 'required',
            'icon' => 'required',
        ]);

        $is_active = $request->is_active;
        if ($is_active == null) {
            $is_active = 0;
        }

        UserSubmenu::where('id', $id)->update([
            'menu_id' => $request->menu_id,
            'title' => $request->title,
            'url' => $request->url,
            'icon' => $request->icon,
            'is_active' => $is_active
        ]);

        return redirect('/submenu')->with('success', 'Submenu has been updated');
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
        return redirect('/submenu')->with('success', 'Submenu has been deleted');
    }

    public function getSubmenu(Request $request)
    {
        $submenu = UserSubmenu::find($request->id);
        echo json_encode($submenu);
    }
}
