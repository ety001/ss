<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class PortPool extends Model
{
    protected $table = 'ss_port_pool';
    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    public function getFirstFreePort() {
        return $this->where('status', '=', 0)->first();
    }
}
