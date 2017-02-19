<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

use App\Model\ReginKey;
use App\Model\User;
use App\Model\PortPool;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('test', function(Request $request) {
    Log::info('test_api');
    return 'hello world';
});

Route::get('user', function (Request $request) {
    return $request->user();
})->middleware('auth:api');

Route::post('regin', function(Request $request) {
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

    //Create a new User
    $user_info = [
        'username' => $input['username'],
        'password' => bcrypt($input['password']),
        'email' => $input['email'],
        'ssport' => $port,
        'sspass' => $input['sspass'],
        'create_time' => time()
    ];
    $user = User::create($user_info);

    //Update ReginKey
    $regin_key_obj->status = 1;
    $regin_key_obj->user_id = $user->id;
    $regin_key_obj->usetime = time();
    $regin_key_obj->save();

    //Update PortPool
    $port_obj->status = 1;
    $port_obj->save();

    //ToDo: Send Email

    Log::info('Create A New User:'.$user->id, __METHOD__);
    //Return
    $result = ['status'=>true, 'data'=>[], 'msg'=>['注册成功, 正在登录...']];
    return $result;
});
