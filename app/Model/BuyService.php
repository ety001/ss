<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class BuyService extends Model
{
    protected $table = 'ss_buyservice';
    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;
    protected $primaryKey = 'buyservice_id';

    public function service() {
        return $this->hasOne('App\Model\Services', 'service_id', 'service_id');
    }
}
