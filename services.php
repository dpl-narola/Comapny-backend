<?php
/**
 * @uses This file is managing for iform builder apis
 * @author DPL
 */

header('Access-Control-Allow-Origin: ' . $_SERVER['HTTP_ORIGIN']);
header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
header('Access-Control-Max-Age: 1000');
header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');
include 'genral.php';
/**
 * @name retrieve_list_of_records
 * @uses This method is using for retriving records
 * @return json array
 * @author DPL
 */
if($_GET['type']=='retrieve_list_of_records'){
    try {

            $curl = curl_init();
            $url = 'https://app.iformbuilder.com/exzact/api/v60/profiles/502813/pages/3838090/records?fields=company_name,category,register_date,annual_trunover&limit=100&offset=0&subform_order=desc';
        $token = '';
        if (generate_new_token() != false) {
            $token = generate_new_token();
        } else {
        }
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
                    CURLOPT_CUSTOMREQUEST => 'GET',
                    CURLOPT_HTTPHEADER => array('Authorization: Bearer ' . $token)
                )
        );
        $data=array();
       $response = curl_exec($curl);
        curl_close($curl);
        $result=json_decode($response,true);
       $data['response'] = $result;
        echo json_encode($data,true);die();
    } catch (Exception $e) {
        print_r($e->getMessage());
    }
}
/**
 * @name add_new_records
 * @uses This method is using for adding records
 * @return json array
 * @author DPL
 */
else if($_GET['type']=='add_new_records'){
    $request_body = file_get_contents('php://input');

    try {
        $curl = curl_init();
        $url = 'https://app.iformbuilder.com/exzact/api/v60/profiles/self/pages/3838090/records';
        $token = '';
        if (generate_new_token() != false) {
            $token = generate_new_token();
        } else {
            return response()->json(compact('token invalid'), 500);
        }
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
                    CURLOPT_HTTPHEADER => array('Authorization: Bearer ' . $token),
                    CURLOPT_POST => true,
                    CURLOPT_POSTFIELDS => $request_body,
                )
        );

        $response = curl_exec($curl);
        curl_close($curl);
        $result=json_decode($response,true);
       $data['response'] = $result;

        echo json_encode($data,true);die();
    } catch (Exception $e) {
        print_r($e->getMessage());
    }
}

    ?>