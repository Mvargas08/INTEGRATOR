<?php
/**
 * Created by PhpStorm.
 * User: hakum
 * Date: 11/26/18
 * Time: 9:33 PM
 */

include_once('vendor/autoload.php');

header('X-Magento-Service-Bus: *');
//header('Access-Control-Request-Headers: Authorization');
header('User-Agent: Service-Bus/1.0 ');
$data = null;
Kint::$enabled_mode = Kint::$mode_default_cli;
if($data = json_decode(file_get_contents('php://input'))){
    file_put_contents('GENERAL.log', @Kint::dump($data).PHP_EOL , FILE_APPEND | LOCK_EX);
    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_URL => "https://api.integrator.io/v1/exports/5be08424e6c09c59d706290b/undefined/data",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => json_encode($data),
        CURLOPT_HTTPHEADER => array(
            "Authorization: Basic VEVTVDpURVNU",
            "Content-Type: application/json",
            "cache-control: no-cache"
        ),
    ));

    $response = curl_exec($curl);
    $err = curl_error($curl);

    curl_close($curl);

    if ($err) {
        echo "cURL Error #:" . $err;
    } else {
        echo $response;
    }
}else{
    file_put_contents('GENERAL.log', @Kint::dump($data).PHP_EOL , FILE_APPEND | LOCK_EX);
}

die();