<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

use App\Model\User;
use App\Model\Services;

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

    protected $fillable = ['service_id', 'user_id', 'buy_time', 'end_time', 'status'];

    public function service()
    {
        return $this->belongsTo('App\Model\Services', 'service_id', 'service_id');
    }

    public function user() {
        return $this->hasOne('App\Model\User', 'user_id', 'user_id');
    }

    public function get_current_service() {
        return $this->user()
                    ->where(['user_id'=>$user->id, 'status'=>1])
                    ->first();
    }

    /**
     * 保存购买的服务，并扣费
     */
    public function save_service($arr){
        if($arr){
            if(!$arr['user_dao'])return false;
            $user_dao       = $arr['user_dao'];
            $service_dao   = Services::where('service_id', $arr['service_id'])->first();
            if($service_dao->service_type==2){//按时长
                $arr['end_time'] = $arr['buy_time'] + 24*3600*$service_dao->service_val;
            }
            $arr['status'] = 1;
            if($this->create($arr)){
                return $user_dao->change_money(-1*$service_dao->service_money);
            }
        } else {
            return false;
        }
    }

    public function chk_service(User $user){
        $conditions     = array(
            'user_id'   => $user ? $user->user_id : 0,
            'status'    => 1
        );
        return $this->where($conditions)->count();
    }

    /**
     * 超过服务器上限判断
     */
    public function chk_service_limit(){
        $service_num     = $this->where(['status'=>1])->count();
        if(env('SERVICE_LIMIT', 50)<$service_num){
            return false;
        } else {
            return true;
        }
    }
}
