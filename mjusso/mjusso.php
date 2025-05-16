<?php
// $clientId = 'ad5dce0fa9134fa082bd87258c2e9a6b';
$url_signin = 'https://sso.mju.ac.th/signin.aspx?cid=';
$url_signout = 'https://sso.mju.ac.th/signout.aspx?cid=';

$ac = (isset($_GET["ac"]) && strlen($_GET["ac"]) === 32) ? $_GET["ac"] : null;
$userInfo = ($ac && $clientId) ? getApiData($clientId, $ac) : false;

function getApiData($clientId, $ac)
{
    $curl = curl_init();
    curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://sso.mju.ac.th/token.aspx',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_SSL_VERIFYHOST => false,
        CURLOPT_SSL_VERIFYPEER => false,
        // CURLOPT_ENCODING => '',
        // CURLOPT_MAXREDIRS => 10,
        // CURLOPT_TIMEOUT => 4000,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => '{"clientID":"' . $clientId . '","code":"' . $ac . '"}',
        CURLOPT_HTTPHEADER => array(
            'Content-Type: application/json'
        ),
    ));

    $response = curl_exec($curl);
    curl_close($curl);
    return json_decode($response, true);
}

// if ($ac && $clientId && $userInfo) {
//     print_r($userInfo);
// }

// create sso
// https://erp.mju.ac.th/ssoClientList.aspx?goID=14
// sign in
// https://sso.mju.ac.th/signin.aspx?cid=
// verify toke
// https://sso.mju.ac.th/token.aspx
// sign out
// https://sso.mju.ac.th/signout.aspx?cid=