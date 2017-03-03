<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ReginKey extends Model
{
    protected $table = 'ss_regin_key';
    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * Get the user record.
     */
    public function user()
    {
        return $this->hasOne('App\Model\User', 'user_id', 'user_id');
    }
}
