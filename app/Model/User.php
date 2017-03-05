<?php

namespace App\Model;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    protected $primaryKey = 'user_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username', 'email', 'password', 'ssport', 'sspass', 'create_time'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $table = 'ss_user';

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    public function user_type_str() {
        $txt = [
            1 => '普通',
            2 => 'VIP'
        ];
        return $txt[$this->user_type];
    }

    /**
     * Get current_service for the user.
     */
    public function service()
    {
        return $this->hasOne('App\Model\Services', 'service_id', 'service_id');
    }

    /**
     * Get all of the buyservice for the user.
     */
    public function buyservices()
    {
        return $this->hasMany('App\Model\BuyService', 'user_id', 'user_id');
    }
}
