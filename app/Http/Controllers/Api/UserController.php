<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Validator;
use Exception;
use DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

use App\Model\ReginKey;
use App\Model\User;
use App\Model\PortPool;

class UserController extends Controller
{
    public function Regin(Request $request) {
        $input = $request->all();
        $rules = [
            'regin' => 'required',
            'username' => 'required|unique:ss_user|min:4|max:100',
            'password' => 'required|min:6',
            'password_confirmation' => 'required|same:password|min:6',
            'email' => 'required|email|unique:ss_user|max:255',
            'sspass' => 'required'
        ];
        $messages = [
            'regin.required' => '邀请码是必填项',

            'username.required' => '用户名是必填项',
            'username.unique' => '用户名已存在',
            'username.min' => '用户名长度需要大于:min个字符',
            'username.max' => '用户名长度需要小于:max个字符',

            'password.required' => '密码是必填项',
            'password.min' => '密码长度需要大于:min个字符',

            'password_confirmation.required' => '重复密码是必填项',
            'password_confirmation.min' => '重复密码长度需要大于:min个字符',
            'password_confirmation.same' => '两次密码必须相同',

            'email.required' => 'Email是必填项',
            'email.max' => 'Email最长255个字',
            'email.email' => 'Email格式不对',
            'email.unique' => 'Email已存在',

            'sspass.required' => 'Shadowsocks密码是必填项',
        ];
        $v = Validator::make($input, $rules, $messages);
        if ($v->fails()) {
            $errors_info = $v->errors()->all();
            $result = ['status'=>false, 'data'=>[], 'msg'=>$errors_info];
            return $result;
        }

        //Auth Regin Key
        $regin_key_obj = ReginKey::where(['regin_key'=>$input['regin'], 'status'=>0])->first();
        if ($regin_key_obj===null) {
            $result = ['status'=>false, 'data'=>[], 'msg'=>['邀请码不存在或已被使用']];
            return $result;
        }

        //Get A Free Port
        $port_pool = new PortPool;
        $port_obj = $port_pool->getFirstFreePort();
        $port = $port_obj->port;

        DB::beginTransaction();

        //Create a new User
        try {
            $user_info = [
                'username' => $input['username'],
                'password' => bcrypt($input['password']),
                'email' => $input['email'],
                'ssport' => $port,
                'sspass' => $input['sspass'],
                'create_time' => time()
            ];
            $user_obj = User::create($user_info);
        } catch (Exception $e) {
            Log::error('create_user_exception:' . $e->getMessage());
            DB::rollback();
            $result = ['status'=>false, 'data'=>[], 'msg'=>['创建用户异常']];
            return $result;
        }

        //Update ReginKey
        try {
            $regin_key_obj->status = 1;
            $regin_key_obj->user_id = $user_obj->user_id;
            $regin_key_obj->usetime = time();
            $regin_key_obj->save();
        } catch (Exception $e) {
            Log::error('regin_update_exception:' . $e->getMessage());
            DB::rollback();
            $result = ['status'=>false, 'data'=>[], 'msg'=>['更新邀请码异常']];
            return $result;
        }

        //Update PortPool
        try {
            PortPool::where('port', $port)->update(['status'=>1]);
        } catch (Exception $e) {
            Log::error('portpool_update_exception:' . $e->getMessage());
            DB::rollback();
            $result = ['status'=>false, 'data'=>[], 'msg'=>['更新端口池异常']];
            return $result;
        }

        DB::commit();
        Log::info('Create A New User:'.$user_obj->id);

        //ToDo: Send Email


        //Return
        $result = ['status'=>true, 'data'=>[], 'msg'=>['注册成功, 正在跳转...']];
        return $result;
    }

    public function Login(Request $request) {
        $input = $request->all();
        $rules = [
            'username' => 'required',
            'password' => 'required'
        ];
        $messages = [
            'username.required' => '用户名是必填项',
            'password.required' => '密码是必填项'
        ];
        $v = Validator::make($input, $rules, $messages);
        if ($v->fails()) {
            $errors_info = $v->errors()->all();
            $result = ['status'=>false, 'data'=>[], 'msg'=>$errors_info];
            return $result;
        }
        if (Auth::attempt(['username' => $input['username'], 'password' => $input['password']])) {
            // Authentication passed
            $token = $this->create_token( Auth::user() );
            $result = ['status'=>true, 'data'=>['token'=>$token], 'msg'=>['登录成功，正在跳转中...']];
        } else {
            $user_lib = User::where('username', $input['username'])->first();
            if( $user_lib && ($user_lib->password === md5($input['password'])) ) {
                // Authentication passed and change md5 hash to the bcrypt hash
                $user_lib->password = bcrypt($input['password']);
                $user_lib->save();
                $token = $this->create_token( Auth::user() );
                $result = ['status'=>true, 'data'=>['token'=>$token], 'msg'=>['登录成功，正在跳转中...']];
            } else {
                $result = ['status'=>false, 'data'=>[], 'msg'=>['用户名或密码错误']];
            }
        }

        if($result['status']===true) {

        }

        return $result;
    }

    private function create_token($user)
    {
        $user->api_token = str_random(60);
        $user->expired_time = time() + config('auth.guards.api.expire');
        $user->save();
        return ['val'=>$user->api_token, 'expired'=>$user->expired_time];
    }
}
