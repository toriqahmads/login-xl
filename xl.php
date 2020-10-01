<?php
error_reporting(E_ALL);
ini_set('display_errors', 0);
ini_set('max_execution_time', 300000000);

function getCookie($socks = null)
{
	$fp = fopen(dirname(__FILE__) . "/cookies.txt", "w");
	$link = "https://my.xl.co.id/pre/index1.html#/";

	$c = curl_init($link);
	curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($c, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 6.1; WOW64; rv:54.0) Gecko/20100101 Firefox/54.0");
	curl_setopt($c, CURLOPT_ENCODING, "gzip, deflate, br");
	curl_setopt($c, CURLOPT_HEADER, 1);
	curl_setopt($c, CURLOPT_FOLLOWLOCATION, 1);
	curl_setopt($c, CURLOPT_COOKIEJAR, dirname(__FILE__). "/cookies.txt");
	curl_setopt($c, CURLOPT_COOKIEFILE, dirname(__FILE__). "/cookies.txt");
	if($socks)
	{
		curl_setopt($c, CURLOPT_PROXY, $socks);
		curl_setopt($c, CURLOPT_PROXYTYPE, CURLPROXY_SOCKS5);
	}
	$response = curl_exec($c);
	$httpcode = curl_getinfo($c);

}

function login($no, $pass, $socks = 0)
{
	$link = "https://my.xl.co.id/pre/LoginSendOTPRq";

	$no = urldecode($no);
	$pass = urldecode($pass);

	$header[] = "Host: my.xl.co.id";
	$header[] = "User-Agent: Mozilla/5.0 (Windows NT 6.1; WOW64; rv:56.0) Gecko/20100101 Firefox/56.0";
	$header[] = "Accept: application/json, text/plain, */*";
	$header[] = "Accept-Language: en-US,en;q=0.5";
	$header[] = "Content-Type: application/json";
	$header[] = "Access-Control-Allow-Origin: True";
	$header[] = "Referer: https://my.xl.co.id/pre/index1.html";
	$header[] = "Connection: keep-alive";

	$datas ='{"Header":null,"Body":{"Header":{"ReqID":"20201001184949"},"LoginSendOTPRq":{"msisdn":"62877384758574"}},"sessionId":null,"onNet":"False","platform":"04","serviceId":"","packageAmt":"","reloadType":"","reloadAmt":"","packageRegUnreg":"","appVersion":"3.9.10","sourceName":"Others","sourceVersion":"","screenName":"login.enterLoginNumber"}';

	$c = curl_init($link);
	curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($c, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 6.1; WOW64; rv:54.0) Gecko/20100101 Firefox/54.0");
	curl_setopt($c, CURLOPT_ENCODING, "gzip, deflate, br");
	curl_setopt($c, CURLOPT_HEADER, 1);
	curl_setopt($c, CURLOPT_NOBODY, false);
	curl_setopt($c, CURLOPT_HTTPHEADER, $header);
	curl_setopt($c, CURLOPT_POSTFIELDS, $datas);
	curl_setopt($c, CURLOPT_POST, 1);
	curl_setopt($c, CURLOPT_REFERER, "https://my.xl.co.id/pre/index1.html");
	curl_setopt($c, CURLOPT_FOLLOWLOCATION, 1);
	curl_setopt($c, CURLOPT_COOKIEJAR, dirname(__FILE__). "/cookies.txt");
	curl_setopt($c, CURLOPT_COOKIEFILE, dirname(__FILE__). "/cookies.txt");
	if($socks)
	{
		curl_setopt($c, CURLOPT_PROXY, $socks);
		curl_setopt($c, CURLOPT_PROXYTYPE, CURLPROXY_SOCKS5);
	}
	$response = curl_exec($c);
	$httpcode = curl_getinfo($c);
    
    if(!$httpcode) return false; 
    else
    {
        $header = substr($response, 0, curl_getinfo($c, CURLINFO_HEADER_SIZE));
        $body = substr($response, curl_getinfo($c, CURLINFO_HEADER_SIZE));
    }

    $json = json_decode($body);

    if($json->responseCode == "00" && $json->message == "SUCCESS Login")
    {
    	$result['status'] = "logged in";
    	$result['no'] = $no;
    	$result['sessId'] = $json->sessionId;
    	$result['gaUser'] = $json->gaUser;
    }
    elseif($json->responseCode == "01")
    {
    	$result['status'] = "failed";
    	$result['no'] = $no;
    	$result['reason'] = "no atau password salah";
    }
    else
    {
    	$result['status'] = "failed";
    	$result['no'] = $no;
    	$result['reason'] = "something went wrong. WDK";
    }

    return json_encode($result);
}

$no = @$_POST['no'];
$pass = @$_POST['pass'];
$socks = @$_POST['socks'];

$a = getCookie();
$b = login($no, $pass, $socks);

print_r($b);
?>
