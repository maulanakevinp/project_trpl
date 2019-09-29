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

    public function menu()
    {
        return $this->belongsTo('App\UserMenu');
    }
}
