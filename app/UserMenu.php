<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class UserMenu extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'user_menu';

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
    protected $fillable = ['menu'];

    public static function getMenuByRole($role_id)
    {
        return DB::table('user_menu')
            ->select('user_menu.id as id', 'user_menu.menu as menu')
            ->join('user_access_menu', 'user_access_menu.menu_id', '=', 'user_menu.id')
            ->where('user_access_menu.role_id', $role_id)
            ->orderBy('user_access_menu.menu_id', 'asc')->get();
    }

    public function submenu()
    {
        return $this->hasMany('App\UserSubmenu');
    }
}
