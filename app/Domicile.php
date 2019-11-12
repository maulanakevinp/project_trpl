<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Domicile extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['purpose', 'user_id', 'letter_id','file'];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function letter()
    {
        return $this->belongsTo('App\Letter');
    }
}
