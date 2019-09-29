<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Marital extends Model
{
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
    protected $fillable = ['marital'];

    public function users()
    {
        return $this->hasMany('App\User');
    }
}
