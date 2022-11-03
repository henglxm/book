<?php
namespace App\Services\Gateway;
use App\Services\View;
use App\Services\Auth;
use App\Services\Config;
use App\Models\Paylist;
use App\Services\MalioConfig;
class Paymethods{
  var $srequest;
  //构建完的参数
  var $md5sign;
  //sign值
  var $payurl;
  //支付链接    
  
    //构建请求参数
    public function query($arry1){
        $arry1 = array_filter($arry1);
        ksort($arry1);
        $this->srequest = http_build_query($arry1);
        $this->srequest = urldecode($this->srequest);
        
     }
     //对参数进行加密
    public function signit($key){
       $this->md5sign = md5($this->srequest.$key);
    }
    public function echosign(){
    
    return $this->md5sign;
    }
    
    public function geturl($api,$signtype){
    $signt = "&sign=".$this->md5sign."&sign_type=".$signtype;
    $this->payurl = $api.$this->srequest.$signt;
    $tturl = $this->payurl;
    return $tturl;
    }
    
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
    
}

class CustomPay extends AbstractPayment
{

    public function purchase($request, $response, $args)
    {
        $type = $request->getParam('type');
        $price = $request->getParam('price');
        
        if($price <= 0){
            return json_encode(['errcode'=>-1,'errmsg'=>"非法的金额."]);
        }
        
        $user = Auth::getUser();
        
        $pidb = Config::get("jshipid");
        $keyb = Config::get("jshikey");
        $api = Config::get("jshiapi");
        $name = Config::get("jshiname");
        $sitename = Config::get("sitename");
        
        $pl = new Paylist();
        $pl->userid = $user->id;
        $pl->total = $price;
        $pl->tradeno = self::generateGuid();
		$pl->save();
		
		$signtype2 = "MD5";


        $paygc = new Paymethods();
        $httpxx = ($paygc->isHTTPS() ? 'https://' : 'http://') . $_SERVER['HTTP_HOST'];
        
		$notify_url = $httpxx."/Jshi_notify/";
		$return_url = $httpxx."/Jshi_return";
		
		$data = [
            'pid' => $pidb,
            'type' => $type,
            'out_trade_no' => $pl->tradeno,
            'notify_url' => $notify_url,
            'return_url' => $return_url,
            'name' => $name,
            'money' => $price,
            'sitename' => $sitename
         ];
         

//支付过程
        $paygc->query($data);
        $paygc->signit($keyb);
        $url = $paygc->geturl($api,$signtype2);

		$result = "<script language='javascript' type='text/javascript'>window.location.href='".$url."';</script>";
 $result = json_encode(array('code'=>$result,'errcode'=>0,'pid' =>$pl->id));
 return $result;
	}
	
	public function purchase_maliopay($type, $price)
    {
		if($price <= 0){
            return json_encode(['errcode'=>-1,'errmsg'=>"非法的金额."]);
        }
       $user = Auth::getUser();
        
        $pidb = Config::get("jshipid");
        $keyb = Config::get("jshikey");
        $api = Config::get("jshiapi");
        $name = Config::get("jshiname");
        $sitename = Config::get("sitename");
        
        $pl = new Paylist();
        $pl->userid = $user->id;
        $pl->total = $price;
        $pl->tradeno = self::generateGuid();
		$pl->save();
		
		$notify_url = "";
		$return_url = "";
		$signtype2 = "MD5";
		
        $paygc = new Paymethods();
        $httpxx = ($paygc->isHTTPS() ? 'https://' : 'http://') . $_SERVER['HTTP_HOST'];
        
		$notify_url = $httpxx."/Jshi_notify/";
		$return_url = $httpxx."/Jshi_return";
		
		$data = [
            'pid' => $pidb,
            'type' => $type,
            'out_trade_no' => $pl->tradeno,
            'notify_url' => $notify_url,
            'return_url' => $return_url,
            'name' => $name,
            'money' => $price,
            'sitename' => $sitename
         ];
         

//支付过程
$paygc->query($data);
$paygc->signit($keyb);
$url = $paygc->geturl($api,$signtype2);
$result = "<script language='javascript' type='text/javascript'>window.location.href='".$url."';</script>";
 $result = json_encode(array('code'=>$result,'errcode'=>0,'pid' =>$pl->id));
 return $result;
}
    
    public function notify($request, $response, $args)
    {

$key = Config::get("jshikey");
$clientsign = $_REQUEST['sign'];
unset($_REQUEST['sign']);
unset($_REQUEST['signtype']);

$paywc = new Paymethods();
$paywc->query($_REQUEST);
$paywc->signit($key);
$newsign = $paywc->echosign();

if($newsign == $clientsign&&$_REQUEST['trade_status'] == 'TRADE_SUCCESS'){
			 
			 $p = Paylist::where('tradeno', '=', $_REQUEST['out_trade_no'])->first();
			 $money = $p->total;
			 if ($p->status != 1) {
                  $this->postPayment($_REQUEST['out_trade_no'], "久世支付系统");
                    echo 'success';
                } else {
                    echo 'error';
                }
       
			

        }else{
           echo 'error';
        }
    }
    public function getPurchaseHTML()
    {
        return '
                    <div class="card-inner">
										<p class="card-heading">充值</p>
										<h5>支付方式:</h5>
										<nav class="tab-nav margin-top-no">
											<ul class="nav nav-list">
											
													<li>
														<a class="waves-attach waves-effect type active" data-toggle="tab" data-pay="wxpay">微信支付</a>
													</li>
											
								
													<li>
														<a class="waves-attach waves-effect type" data-toggle="tab" data-pay="alipay">支付宝</a>
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
											<button class="btn btn-flat waves-attach" id="code-update" ><span class="icon">check</span>&nbsp;充值</NOtton>
										</div>
									</div>
                        <script>
		var type = "wxpay";
			var type = "alipay";
	var pid = 0;
	$(".type").click(function(){
		type = $(this).data("pay");
	});
	$("#code-update").click(function(){
		var price = parseFloat($("#amount").val());
		console.log("将要使用"+type+"方法充值"+price+"元")
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
					if(type=="wxpay"){
						$("#result").modal();
						$("#msg").html("正在跳转到微信..."+data.code);
					}else if(type=="alipay"){
						$("#result").modal();
						$("#msg").html("正在跳转到支付宝..."+data.code);
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
$key = Config::get("jshikey");

$clientsign = $_REQUEST['sign'];
 $outtradeno = $_REQUEST['out_trade_no'];
 
unset($_REQUEST['sign']);
unset($_REQUEST['signtype']);

        $p = Paylist::where('tradeno', '=', $outtradeno)->first();
        $money = $p->total;
        if ($p->status == 1) {
            $success = 1;
        } else {


$paywc2 = new Paymethods();
$paywc2->query($_REQUEST);
$paywc2->signit($key);
$newsign = $paywc2->echosign();

if($newsign == $clientsign){

                if ($_REQUEST['trade_status'] == 'TRADE_SUCCESS') {
                    $this->postPayment($_REQUEST['out_trade_no'], "久世支付系统");
                    $success = 1;
                }
                else {
                    $success = 0;
                }

            }
            else {
                $success = 0;
            }
        }
        return View::getSmarty()->assign('money', $money)->assign('success', $success)->fetch('user/pay_success.tpl');





    }
    public function getStatus($request, $response, $args)
    {
        // TODO: Implement getStatus() method.
    }
}
