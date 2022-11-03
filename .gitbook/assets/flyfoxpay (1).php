<?php

namespace App\Services\Gateway;
use App\Services\View;
use App\Services\Auth;
use App\Services\Config;
use App\Models\Paylist;

class Pays
{
    private $pid;
    private $key;

    public function __construct($pid, $key)
    {
        $this->pid = $pid;
        $this->key = $key;
    }

//初始变量
       
    public function submit($type, $out_trade_no, $notify_url, $return_url, $name, $money, $sitename)
    {
        $data = [
            'pid' => $this->pid,
            'type' => $type,
            'out_trade_no' => $out_trade_no,
            'notify_url' => $notify_url,
            'return_url' => $return_url,
            'name' => $name,
            'money' => $money,
            'sitename' => $sitename
        ];
        $string = http_build_query($data);
        $sign = $this->getsign($data);
        return 'https://fps.cloudfament.co/submit.php?' . $string . '&sign=' . $sign . '&sign_type=MD5';
    }

    public function verify($data)
    {
        if (!isset($data['sign']) || !$data['sign']) {
            return false;
        }
        $sign = $data['sign'];
        unset($data['sign']);
        unset($data['sign_type']);
        $sign3 = $this->getSign($data, $this->key);
        if ($sign != $sign3) {
            return false;
        }
        return true;
    }

    private function getSign($data)
    {
        $data = array_filter($data);
        ksort($data);
        $str1 = '';
        foreach ($data as $k => $v) {
            $str1 .= '&' . $k . "=" . $v;
        }
        $str = $str1 . $this->key;
        $str = trim($str, '&');
        $sign = md5($str);
        return $sign;
    }
}
          
class flyfoxpay extends AbstractPayment
{

     public function isHTTPS()
    {
        define('HTTPS', false);
        if (defined('HTTPS') && HTTPS) {
            return true;
        }
        if (!isset($_SERVER)) {
            return false;
        }
        if (!isset($_SERVER['HTTPS'])) {
            return false;
        }
        if ($_SERVER['HTTPS'] === 1) {  //Apache
            return true;
        }

        if ($_SERVER['HTTPS'] === 'on') { //IIS
            return true;
        }

        if ($_SERVER['SERVER_PORT'] == 443) { //其他
            return true;
        }
        return false;
    }


    public function purchase($request, $response, $args)
    {
        $price = $request->getParam('price');
        
        if($price <= 0){
            return json_encode(['errcode'=>-1,'errmsg'=>"非法的金额."]);
        }else if($price > 0 && $price < 1){
            return json_encode(['errcode'=>-1,'errmsg'=>"低于最低金额一元."]);
        }
        $user = Auth::getUser(); 
        $type = $request->getParam('type');   
        $settings = Config::get("flyfoxpay")['config'];
        
        $pl = new Paylist();
        $pl->userid = $user->id;
        $pl->total = $price;
        $pl->tradeno = self::generateGuid();
        $pl->save();
        $url = ($this->isHTTPS() ? 'https://' : 'http://') . $_SERVER['HTTP_HOST'];

		$return=$url.'/flyfoxpay_back/'.$type;	
		$pay = new Pays($settings['hid'], $settings['key']);

//支付方式
$type = 'alipay';

$out_trade_no = $pl->tradeno;
$notify_url = $return;
$return_url = $return;
$name = $settings['name'];
$money = $price;
$sitename = $settings['sitename'];

//发起支付
$url = $pay->submit($type, $out_trade_no, $notify_url, $return_url, $name, $money, $sitename);
      
		$result = "<script language='javascript' type='text/javascript'>window.location.href='".$url."';</script>";
        $result = json_encode(array('code'=>$url,'errcode'=>0,'pid' =>$pl->id));
        return $result;
    }
    
    public function notify($request, $response, $args)
    {
		$type = $args['type'];
		$settings = Config::get("flyfoxpay")['config'];
		
        $security['orderid'] = $_REQUEST['out_trade_no'];
        
      if($security['orderid']=='' OR $security['orderid']==null){header("Location: /user/code");}else{
		  
$pay = new Pays($settings['hid'], $settings['key']);
$data = $_REQUEST;
$out_trade_no = $data['out_trade_no'];

if ($pay->verify($data)) {
    //验证支付状态
    if ($data['trade_status'] == 'TRADE_SUCCESS') {
    
        $this->postPayment($data['out_trade_no'], "kfcpay");
		header("Location: /user/code");
        echo "success";
    }
} else {
    echo 'error';
}
    }}
    public function getPurchaseHTML()
    {
        return '
                    <div class="card-inner">
										<p class="card-heading">充值</p>
										<h5>支付方式:</h5>
										<nav class="tab-nav margin-top-no">
											<ul class="nav nav-list">
											
													<li>
														<a class="waves-attach waves-effect type active" data-toggle="tab" data-pay="wxpay">聚合支付</a>
													</li>
											
											
				
											</ul>
											<div class="tab-nav-indicator"></div>
										</nav>
										<div class="form-group form-group-label">
											<label class="floating-label" for="amount">金额</label>
											<input class="form-control" id="amount" type="text">
										</div>
									</div>
                                    <div class="card-action">
										<div class="card-action-btn pull-left">
											<button class="btn btn-flat waves-attach" id="code-updates" ><span class="icon">check</span>&nbsp;充值</button>
										</div>
									</div>
                        <script>
		var type = "alipay";
	var pid = 0;
	$(".type").click(function(){
		type = $(this).data("pay");
	});
	$("#code-updates").click(function(){
		var price = parseFloat($("#amount").val());
		console.log("tony将要使用"+type+"方法充值"+price+"元")
		if(isNaN(price)){
			$("#result").modal();
			$("#msg").html("非法的金额!");
		}
		$.ajax({
			\'url\':"/user/payment/purchase",
			\'data\':{
				\'price\':price,
				\'type\':type,
			},
			\'dataType\':\'json\',
			\'type\':"POST",
			success:function(data){
				console.log(data);
				if(data.errcode==-1){
					$("#result").modal();
					$("#msg").html(data.errmsg);
				}
				if(data.errcode==0){
					pid = data.pid;
					if(type=="alipay"){
						$("#result").modal();
						$("#msg").html("正在跳转到支付系統..."+data.code);
					}
				}
			}
		});
		setTimeout(f, 1000);
	});
</script>
';
    }
    public function getReturnHTML($request, $response, $args)
    {

    }
    public function getStatus($request, $response, $args)
    {
        // TODO: Implement getStatus() method.
    }
}