<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Services extends Model
{
    protected $table = 'ss_service';
    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;
    protected $primaryKey = 'service_id';
}
