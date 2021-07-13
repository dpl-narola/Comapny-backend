<?php
/**
 * @uses This file is managing for iform builder apis
 * @author DPL
 */
if (isset($_SERVER['HTTP_ORIGIN']) && $_SERVER['HTTP_ORIGIN'] != ''){
    header('Access-Control-Allow-Origin: ' . $_SERVER['HTTP_ORIGIN']);
    header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
    header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');
}
include 'genral.php';
$token=generate_new_token();
if (isset($_GET['type'])){
    // This method is using for retriving records
    if ($_GET['type'] == 'retrieve_list_of_records') {
        try {
            $url = API_URL.''.VERSION.'/profiles/'.PROFILE_ID.'/pages/'.PAGE_ID.'/records?fields=company_name,category,register_date,annual_trunover&limit=100&offset=0&subform_order=desc';
            $param_arr=array(
                        CURLOPT_HTTPHEADER => array('Authorization: Bearer ' . $token)
                    );
             $data['response']= api_call($url,'GET',$param_arr);
             echo json_encode($data, true);
        } catch (Exception $e) {
            print_r($e->getMessage());
        }
    }
    //This method is using for adding records
    else if ($_GET['type'] == 'add_new_records') {
        $request_body = file_get_contents('php://input');

        try {
            $url = API_URL.''.VERSION.'/profiles/self/pages/'.PAGE_ID.'/records';
            $param_arr=array(
                        CURLOPT_HTTPHEADER => array('Authorization: Bearer ' . $token),
                        CURLOPT_POST => true,
                        CURLOPT_POSTFIELDS => $request_body,
                    );
            $data['response']= api_call($url,'POST',$param_arr);
            echo json_encode($data, true);
        } catch (Exception $e) {
            print_r($e->getMessage());
        }
    }
}?>