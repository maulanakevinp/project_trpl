<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Incapable extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'letter_id', 'name', 'birth_place', 'birth_date', 'job', 'address', 'reason', 'as'
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function letter()
    {
        return $this->belongsTo('App\Letter');
    }
}
