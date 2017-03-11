<?php
use Illuminate\Support\Facades\Cache;
// Provider is Providers/HelperServiceProvider.php
function test_custom_helper() {
    var_dump(111);die();
}
function get_weidian_access_token() {
    global $spConfig;
    $key = env('WEIDIAN_KEY');
    $secret = env('WEIDIAN_SECRET');
    //Cache::flush();
    if(Cache::has('weidian_access_token')) {
        return Cache::get('weidian_access_token');
    } else {
        $result = file_get_contents('https://api.vdian.com/token?grant_type=client_credential&appkey='.$key.'&secret='.$secret);
        $r = json_decode($result, true);
        $access_token = $r['result']['access_token'];
        Cache::put('weidian_access_token', $access_token, $r['result']['expire_in']/60);
        return $access_token;
    }
}
//获取订单信息
function get_weidian_order_info($order_id) {
    $access_token = get_weidian_access_token();

    $param = array("order_id"=>$order_id);
    $param = json_encode($param);
    $public = array(
        "method"=>"vdian.order.get",
        "access_token"=>$access_token,
        "version"=>"1.0",
        "format"=>"json"
    );
    $public = json_encode($public);
    $url = 'http://api.vdian.com/api?param='.$param.'&public='.$public;

    $output = file_get_contents($url);

    return json_decode($output, true);
}
//发货
function send_weidian_order($order_id) {
    $access_token = get_weidian_access_token();

    $param = array(
        "order_id"=>$order_id,
        "express_type"=>"999"
    );
    $param = json_encode($param);
    $public = array(
        "method"=>"vdian.order.deliver",
        "access_token"=>$access_token,
        "version"=>"1.0",
        "format"=>"json"
    );
    $public = json_encode($public);
    $url = 'http://api.vdian.com/api?param='.$param.'&public='.$public;

    $output = json_decode( file_get_contents($url), true);

    return $output;
}
