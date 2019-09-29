<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class UserAccessMenu extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'user_access_menu';

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
    protected $fillable = ['role_id', 'menu_id'];

    public static function checkAccess($role_id, $menu_id)
    {
        $access = DB::table('user_access_menu')
            ->where('role_id', $role_id)
            ->where('menu_id', $menu_id)
            ->count();
        if ($access > 0) {
            return "checked = 'checked'";
        }
    }

    public static function getAccessByRoleAndMenu($role_id, $menu_id)
    {
        return DB::table('user_access_menu')
            ->select('user_menu.menu as menu', 'user_menu.id as id')
            ->join('user_menu', 'user_menu.id', '=', 'user_access_menu.menu_id')
            ->where('user_access_menu.role_id', $role_id)
            ->where('user_access_menu.menu_id', $menu_id)
            ->count();
    }
}
