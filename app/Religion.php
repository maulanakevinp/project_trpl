<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Religion extends Model
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
    protected $fillable = ['religion'];

    public function users()
    {
        return $this->hasMany('App\User');
    }
}
