<?php
/**
 * @name generate_new_token
 * @return json array
 * @author DPL
 */
function generate_new_token() {

    $curl = curl_init();
    $url = 'https://app.iformbuilder.com/exzact/api/oauth/token';
    $iat = time();
    $exp = time() + 300;
    // Create token header as a JSON string
    $header = json_encode(['typ' => 'JWT', 'alg' => 'HS256']);
    $base64UrlHeader = base64_encode($header);
    // Create token payload as a JSON string
    $payload_arr = [
        "iss" => "d0998459cf1c861e6ec1a5f92b08bf3bf0a2697b",
        "aud" => "https://app.iformbuilder.com/exzact/api/oauth/token",
        "exp" => $exp,
        "iat" => $iat
    ];
    $payload = json_encode($payload_arr);
    $base64UrlPayload = base64_encode($payload);

    $secret = '4f1d71d6b32bd592fe86a19533ab8c7bb5d678c5';

    $sig = hash_hmac('sha256', $base64UrlHeader . "." . $base64UrlPayload, $secret, true);
    $base64UrlSignature = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($sig));

    $assertion = $base64UrlHeader . "." . $base64UrlPayload . "." . $base64UrlSignature;

    curl_setopt_array($curl,
            array(
                CURLOPT_URL => $url,
                CURLOPT_RETURNTRANSFER => TRUE,
                CURLOPT_SSL_VERIFYPEER => FALSE,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => TRUE,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_HTTPHEADER => array(
                    'Content-Type: application/x-www-form-urlencoded',
                    'Cookie: PHPSESSID=6so4jr4slq0t87cck4uo74evd1; X-Mapping-fjhppofk=DA61AAF658741B5A573C938E93162983'
                ),
                CURLOPT_POST => true,
                CURLOPT_POSTFIELDS => 'assertion=' . $assertion . '&grant_type=urn%3Aietf%3Aparams%3Aoauth%3Agrant-type%3Ajwt-bearer',
            )
    );

    $response = curl_exec($curl);
    curl_close($curl);
    $response = json_decode($response);
    if (!empty($response)) {
        if (isset($response->access_token)) {
            return $response->access_token;
        }
    }
    return false;
}?>