<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Gender extends Model
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
    protected $fillable = ['gender'];

    public function users()
    {
        return $this->hasMany('App\User');
    }
}
