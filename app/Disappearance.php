<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Disappearance extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name','date','place', 'user_id', 'letter_id','file'];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function letter()
    {
        return $this->belongsTo('App\Letter');
    }
}
