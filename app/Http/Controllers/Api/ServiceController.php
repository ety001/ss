<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

use Exception;
use DB;

use App\Model\User as UserModel;
use App\Model\Services as ServicesModel;
use App\Model\BuyService as BuyServiceModel;

use App\Libs\Cli;

class ServiceController extends Controller
{
    public function Status(Request $request, $sid = null) {
        if($sid) {

        } else {
            $user = Auth::user()->service;
            dump($user);
        }
    }

    public function buy(Request $request, $sid) {
        $buyservice_dao = new BuyServiceModel;
        if(!$buyservice_dao->chk_service_limit()){
            return ['status'=>false, 'data'=>[], 'msg'=>['服务已售光，请等待扩容 :( ']];
        }
        $user_dao   = Auth::user();
        if($user_dao->email_chk==0){
            return ['status'=>false, 'data'=>[], 'msg'=>['邮箱还未验证 :( ']];
        }
        //获取服务详情
        $service_dao    = ServicesModel::where('service_id', $sid)->first();
        $chk            = $user_dao->chk_money($service_dao->service_money);
        if(!$chk&&$user_dao->user_type!=2){
            return ['status'=>false, 'data'=>[], 'msg'=>['余额不足，请先充值 :( ']];
        }
        //检查指定用户是否已有服务正在使用, ToDo:可以在服务未结束的时候，进行付费
        $chk_service        = $buyservice_dao->chk_service($user_dao);
        if($chk_service){
            return [
                'status'=>false,
                'data'=>[],
                'msg'=>['有正在使用的服务，请等服务到期后再购买。']
            ];
        }
        DB::beginTransaction();
        try {
            //增加购买记录
            $arr    = array(
                'service_id'    => $sid,
                'user_dao'       => $user_dao,
                'user_id'       => $user_dao->user_id,
                'buy_time'      => time()
            );
            $buyservice_dao->save_service($arr);
            $user_dao->service_id = $sid;
            $user_dao->save();
        } catch (Exception $e) {
            Log::error(__METHOD__.',buy_service_exception:' . $e->getMessage().', user_id:'.$user_dao->user_id);
            DB::rollback();
            $result = ['status'=>false, 'data'=>[], 'msg'=>['购买服务异常, '.$e->getMessage()]];
            return $result;
        }

        DB::commit();

        try {
            $cli = new Cli();
            $cli->run($user_dao->ssport, $user_dao->sspass);
        } catch (Exception $e) {
            Log::error(__METHOD__.',start_service_exception:' . $e->getMessage().', user_id:'.$user_dao->user_id);
            $result = ['status'=>false, 'data'=>[], 'msg'=>['启动服务异常, '.$e->getMessage()]];
            return $result;
        }

        return [
            'status'=>true,
            'data'=>[],
            'msg'=>['购买成功']
        ];
    }
}
