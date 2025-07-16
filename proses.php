<?php
date_default_timezone_set('Asia/Jakarta');

$ReqID = date('Ymd');
$imei = 1588165532;

if ($_POST['aksi'] == 'otp') {
    $msisdn = $_POST['msisdn'];
    mintaotp($msisdn, $ReqID, $imei);
    exit;
}

if ($_POST['aksi'] == 'beli') {
    $msisdn = $_POST['msisdn'];
    $otp = $_POST['otp'];
    $serviceid = $_POST['serviceid'];
    $sessionid = login($msisdn, $otp, $ReqID, $imei);
    beli($msisdn, $sessionid, $serviceid, $imei, $ReqID);
    exit;
}

function mintaotp($msisdn,$ReqID,$imei){
    $bod = array( 
        "Header"=>null,
        "Body"=>[
            "Header"=>[
                "ReqID"=>"$ReqID054410",
                "IMEI"=>"$imei"],
            "LoginSendOTPRq"=>[
                "msisdn"=>"$msisdn"]],
        "sessionId"=>null,
        "onNet"=>"True",
        "platform"=>"02",
        "serviceId"=>"",
        "packageAmt"=>"",
        "reloadType"=>"",
        "reloadAmt"=>"",
        "packageRegUnreg"=>"",
        "appVersion"=>"3.8.2",
        "sourceName"=>"Others",
        "sourceVersion"=>"",
        "screenName"=>"login.enterLoginNumber");
    $body = json_encode($bod);
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'https://my.xl.co.id/pre/LoginSendOTPRq');
    $header = array('Content-Type: application/json', 'Keep-Alive: true');
    curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_COOKIEJAR, 'cookie.txt');
    curl_setopt($ch, CURLOPT_COOKIEFILE, 'cookie.txt');
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($ch, CURLOPT_POSTFIELDS, $body);
    $hasil = curl_exec($ch);
    echo $hasil;
}

function login($msisdn,$otp,$ReqID,$imei){
    $bod1 = array(
        "Header"=>null,
        "Body"=>[
            "Header"=>[
                "ReqID"=>"$ReqID054636",
                "IMEI"=>"$imei"],
            "LoginValidateOTPRq"=>[
                "headerRq"=>[
                    "requestDate"=>"20190625",
                    "requestId"=>"$ReqID054636",
                    "channel"=>"MYXLPRELOGIN"],
                "msisdn"=>"$msisdn",
                "otp"=>"$otp"]],
        "sessionId"=>null,
        "platform"=>"02",
        "msisdn_Type"=>"P",
        "serviceId"=>"",
        "packageAmt"=>"",
        "reloadType"=>"",
        "reloadAmt"=>"",
        "packageRegUnreg"=>"",
        "appVersion"=>"3.8.2",
        "sourceName"=>"Others",
        "sourceVersion"=>"",
        "screenName"=>"login.enterLoginOTP",
        "mbb_category"=>"");
    $body1 = json_encode($bod1);
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'https://my.xl.co.id/pre/LoginValidateOTPRq');
    $header = array('Content-Type: application/json', 'Keep-Alive: true');
    curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_COOKIEJAR, 'cookie.txt');
    curl_setopt($ch, CURLOPT_COOKIEFILE, 'cookie.txt');
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($ch, CURLOPT_POSTFIELDS, $body1);
    $hasil = curl_exec($ch);
    $hasil1 = json_decode($hasil);
    return $hasil1->sessionId;
}

function beli($msisdn,$sessionid,$serviceid,$imei,$ReqID){
    $bod2 = array(
        "Header"=>null,
        "Body"=>[
            "HeaderRequest"=>[
                "applicationID"=>"3",
                "applicationSubID"=>"1",
                "touchpoint"=>"MYXL",
                "requestID"=>"$ReqID132245",
                "msisdn"=>"$msisdn",
                "serviceID"=>"$serviceid"],
            "opPurchase"=>[
                "msisdn"=>"$msisdn",
                "serviceid"=>"$serviceid"],
            "XBOXRequest"=>[
                "requestName"=>"GetSubscriberMenuId",
                "Subscriber_Number"=>"1301235663",
                "Source"=>"mapps",
                "Trans_ID"=>"119520832111",
                "Home_POC"=>"BJ0",
                "PRICE_PLAN"=>"513738114",
                "PayCat"=>"PRE-PAID",
                "Active_End"=>"20190615",
                "Grace_End"=>"20190715",
                "Rembal"=>"0",
                "IMSI"=>"510120032177230",
                "IMEI"=>"$imei",
                "Shortcode"=>"mapps"],
            "Header"=>[
                "IMEI"=>"$imei",
                "ReqID"=>"$ReqID132245"]],
        "sessionId"=>"$sessionid",
        "serviceId"=>"$serviceid",
        "packageRegUnreg"=>"Reg",
        "reloadType"=>"",
        "reloadAmt"=>"",
        "packageAmt"=>"99.000",
        "platform"=>"02",
        "appVersion"=>"3.8.2",
        "sourceName"=>"Others",
        "sourceVersion"=>"",
        "msisdn_Type"=>"P",
        "screenName"=>"home.storeFrontReviewConfirm",
        "mbb_category"=>"");
    $body2 = json_encode($bod2);
    $ch = curl_init();
    $header = array(
        'Content-Type: application/json',
        'Referer: https://my.xl.co.id/pre/index1.html',
        'Accept-Encoding: gzip, deflate, br',
        'Accept-Language: id-ID,id;q=0.9,en-US;q=0.8,en;q=0.7'
    );
    curl_setopt($ch, CURLOPT_URL, 'https://my.xl.co.id/pre/opPurchase');
    curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_COOKIEJAR, 'cookie.txt');
    curl_setopt($ch, CURLOPT_COOKIEFILE, 'cookie.txt');
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($ch, CURLOPT_POSTFIELDS, $body2);
    $hasil = curl_exec($ch);
    echo $hasil;
}
?>
