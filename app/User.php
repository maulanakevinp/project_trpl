<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'role_id', 'nik', 'nik_file', 'kk', 'kk_file', 'name', 'image', 'gender_id', 'religion_id', 'marital_id', 'phone_number', 'address', 'birth_place', 'birth_date', 'job', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $dates = ['deleted_at'];

    public function role()
    {
        return $this->belongsTo('App\UserRole');
    }

    public function gender()
    {
        return $this->belongsTo('App\Gender');
    }

    public function religion()
    {
        return $this->belongsTo('App\Religion');
    }

    public function marital()
    {
        return $this->belongsTo('App\Marital');
    }

    public function salaries()
    {
        return $this->hasMany('App\Salary');
    }

    public function domiciles()
    {
        return $this->hasMany('App\Domicile');
    }

    public function enterprises()
    {
        return $this->hasMany('App\Enterprise');
    }

    public function incapables()
    {
        return $this->hasMany('App\Incapable');
    }

    public function disappearances()
    {
        return $this->hasMany('App\Disappearance');
    }

    public function births()
    {
        return $this->hasMany('App\Birth');
    }

    public function hasRole($roles)
    {
        $this->have_role = $this->getUserRole();

        if (is_array($roles)) {
            foreach ($roles as $need_role) {
                if ($this->cekUserRole($need_role)) {
                    return true;
                }
            }
        } else {
            return $this->cekUserRole($roles);
        }
        return false;
    }
    private function getUserRole()
    {
        return $this->role()->getResults();
    }

    private function cekUserRole($role)
    {
        return (strtolower($role) == strtolower($this->have_role->role)) ? true : false;
    }
}
