<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Invite extends Model
{
    protected $table = 'ss_invite';
    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;
    protected $primaryKey = 'invite_id';
}
