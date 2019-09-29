<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class UserSubmenu extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'user_submenu';

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['menu_id', 'title', 'url', 'icon', 'is_active'];

    public static function getSubmenuByMenu($menu_id)
    {
        return DB::table('user_submenu')
            ->join('user_menu', 'user_menu.id', '=', 'user_submenu.menu_id')
            ->where([
                'user_submenu.menu_id' => $menu_id,
                'is_active' => 1
            ])->get();
    }

    public static function getSubmenu()
    {
        return DB::table('user_submenu')
            ->select(
                'user_submenu.id as id',
                'user_menu.menu as menu',
                'user_submenu.title as title',
                'user_submenu.url as url',
                'user_submenu.icon as icon',
                'user_submenu.is_active as is_active',
            )
            ->join('user_menu', 'user_menu.id', '=', 'user_submenu.menu_id')
            ->get();
    }

    public function menu()
    {
        return $this->belongsTo('App\UserMenu');
    }
}
