		
<!DOCTYPE HTML>
<html>
<head lang="zh-CN">
<meta charset="UTF-8">
    <title>微信连Wi-Fi</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="viewport" content="initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="format-detection" content="telephone=no">
    
    
	<script type="text/javascript">
		/* 微信连Wi-Fi协议3.1供运营商portal呼起微信浏览器使用
		----开发认证流程所需参数----
			门店名称 : 坤腾
			ssid : @test
			shopId : 7083014
			appId : wx9050637956444ec2
			secretKey : 23e279e7ea8d851a0956e750b2c9d416
		----复用demo代码说明----
			若认证Portal页直接使用此Demo源代码，请注意填写代码中的以下参数（由您的网络环境动态获取）：
			extend
			timestamp
			authUrl
			mac
			bssid
			sign
			其中sign签名请在后台完成，例如：
			var toSign = appId + extend + timestamp + shopId + authUrl + mac + ssid + bssid + secretKey;
			var sign= md5(toSign);
		----参考文档----
			http://mp.weixin.qq.com/wiki/11/fdad7d19ee3fff555cf4bf215c1e50bb.html
		*/
		var loadIframe = null;
		var noResponse = null;
		var callUpTimestamp = 0;
		 
		function putNoResponse(ev){
			 clearTimeout(noResponse);
		}	
		
		 function errorJump()
		 {
			 var now = new Date().getTime();
			 if((now - callUpTimestamp) > 4*1000){
				 return;
			 }
			 alert('该浏览器不支持自动跳转微信请手动打开微信\n如果已跳转请忽略此提示');
		 }
		 
		 myHandler = function(error) {
			 errorJump();
		 };
		 
		 function createIframe(){
			 var iframe = document.createElement("iframe");
		     iframe.style.cssText = "display:none;width:0px;height:0px;";
		     document.body.appendChild(iframe);
		     loadIframe = iframe;
		 }
		//注册回调函数
		function jsonpCallback(result){  
			if(result && result.success){
			    alert('WeChat will call up : ' + result.success + '  data:' + result.data);			    
			    var ua=navigator.userAgent;              
				if (ua.indexOf("iPhone") != -1 ||ua.indexOf("iPod")!=-1||ua.indexOf("iPad") != -1) {   //iPhone             
					document.location = result.data;
				}else{			
				    createIframe();
				    callUpTimestamp = new Date().getTime();
				    loadIframe.src=result.data;
					noResponse = setTimeout(function(){
						errorJump();
			      	},3000);
				}			    
			}else if(result && !result.success){
				alert(result.data);
			}
		}
		function Wechat_GotoRedirect(appId, extend, timestamp, sign, shopId, authUrl, mac, ssid, bssid){
			//将回调函数名称带到服务器端
			var url = "https://wifi.weixin.qq.com/operator/callWechatBrowser.xhtml?appId=" + appId 
								+ "&extend=" + extend 
								+ "&timestamp=" + timestamp 
								+ "&sign=" + sign;	
			
			//如果sign后面的参数有值，则是新3.1发起的流程
			if(authUrl && shopId){
				url = "https://wifi.weixin.qq.com/operator/callWechat.xhtml?appId=" + appId 
								+ "&extend=" + extend 
								+ "&timestamp=" + timestamp 
								+ "&sign=" + sign
								+ "&shopId=" + shopId
								+ "&authUrl=" + encodeURIComponent(authUrl)
								+ "&mac=" + mac
								+ "&ssid=" + ssid
								+ "&bssid=" + bssid;
				
			}			
			
			//通过dom操作创建script节点实现异步请求  
			var script = document.createElement('script');  
			script.setAttribute('src', url);  
			document.getElementsByTagName('head')[0].appendChild(script);
		}
	</script>
	
	
<link rel="stylesheet" href="https://wifi.weixin.qq.com/resources/css/style-simple-follow.css"/>
</head>
<body class="mod-simple-follow">
<div class="mod-simple-follow-page">
    <div class="mod-simple-follow-page__banner">
        <img class="mod-simple-follow-page__banner-bg" src="https://wifi.weixin.qq.com/resources/images/background.jpg" alt=""/>
        <div class="mod-simple-follow-page__img-shadow"></div>
        <div class="mod-simple-follow-page__logo">
            <img class="mod-simple-follow-page__logo-img" src="https://wifi.weixin.qq.com/resources/images/t.weixin.logo.png" alt=""/>
            <p class="mod-simple-follow-page__logo-name"></p>
            <p class="mod-simple-follow-page__logo-welcome">欢迎您</p>
        </div>
    </div>
    <div class="mod-simple-follow-page__attention">
        <p class="mod-simple-follow-page__attention-txt">欢迎使用微信连Wi-Fi</p>
        <a class="mod-simple-follow-page__attention-btn" onclick="callWechatBrowser()">一键打开微信连Wi-Fi</a>
    </div>
</div>
</body>


<script type="text/javascript">
  var  appId ='wx9050637956444ec2';
  var  entend = 'domeName'; 
  var  timestamp = (new Date()).valueof();
  var  shopId = '7083014';
  var  authUrl = 'http://121.';
  var  mac = 'f0:25:b7:ef:7c:6c';
  var  ssid = '@test';
  var  secretKey = '23e279e7ea8d851a0956e750b2c9d416';
  var  bssid = '<?php echo $called;?>';
  var  toSign = appId + extend + timestamp + shopId + authUrl + mac + ssid + bssid + secretKey;
  var  sign= md5(toSign);
  function callWechatBrowser()
  {
  	  alert(toSign);
	  Wechat_GotoRedirect('wx9050637956444ec2', 'extend', 'timestamp', 'sign', '7083014', 'authUrl', 'mac', '@test', 'bssid');
  }
</script>


<script type="text/javascript">
	document.addEventListener('visibilitychange', putNoResponse, false);
</script>


</html>
	
	
