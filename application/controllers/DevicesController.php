<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class DevicesController extends CI_Controller {



public function __construct()
{
    parent::__construct();
    if($this->session->userdata('logged_in') !== TRUE){
      redirect('welcome');
    }
    $this->load->model('Devices_Model','devices_model');
    $this->load->library('africastalking');
   
}

public function masts(){

    
    //$pagedata['all_receivers'] = $this->devices_model->get_all_receivers();
    $page = 'masts';
    $pagedata['all_masts'] = $this->devices_model->getAllMasts();
    $this->load->view('includes/header');
    $this->load->view('includes/topbar');
    $this->load->view('includes/sidebar');
    $this->load->view('pages/'.$page,$pagedata); //$pagedata,
    $this->load->view('includes/footer');
    $this->load->view('includes/js/masts_script');
        
}


public function devices(){
    $pagedata['all_masts'] = $this->devices_model->getAllMasts();
    $pagedata['all_devices'] = $this->devices_model->get_all_ap();
    $page = 'devices';
    $this->load->view('includes/header');
    $this->load->view('includes/topbar');
    $this->load->view('includes/sidebar');
    $this->load->view('pages/'.$page,$pagedata);
    $this->load->view('includes/footer');
    $this->load->view('includes/js/devices_script');
        
}

public function mastdevices(){
    
    $page = 'mastdevices';
    $this->load->view('includes/header');
    $this->load->view('includes/topbar');
    $this->load->view('includes/sidebar');
    $this->load->view('pages/'.$page);
    $this->load->view('includes/footer');
    $this->load->view('includes/js/mastdevices_script');
        
}

public function getAllMasts(){
        // Datatables Variables
        $draw = intval($this->input->get("draw"));
        $start = intval($this->input->get("start"));
        $length = intval($this->input->get("length"));


        $all_users = $this->devices_model->getAll_Masts();

        $data = array();

        foreach($all_users->result() as $r) {

            $data[] = array(

                $r->mastid,
                $r->mast_name,
                $r->location,
                $r->connection_via,
                $this->getMastName($r->connected_from),
                date( 'd-m-Y', strtotime($r->dateCreated))
                

            );
        }

        $output = array(
            "draw" => $draw,
            "recordsTotal" => $all_users->num_rows(),
            "recordsFiltered" => $all_users->num_rows(),
            "data" => $data
        );
        echo json_encode($output);
        exit();
}

public function insertMastData(){

    $mast_data['mastid'] = $this->input->post('mastid',TRUE);
    $mast_data['mast_name'] = $this->input->post('mast_name',TRUE);
    $mast_data['location'] = $this->input->post('mast_location',TRUE);
    
    $mast_data['connection_via'] = $this->input->post('mast_connected_via',TRUE);
    $mast_data['connected_from'] = $this->input->post('mast_connected_from',TRUE);
    
    $mast_data['dateCreated']  = date('Y-m-d H:i:s');

    $mastData = $this->devices_model->insertMastData($mast_data);
    if ($mastData){

        $response=array(
            'error'=>0,
            'message' => "Saved Succcessfully!!"
        );
        
    }
    else{

        $response=array(
            'status'=>1,
            'message' => "Failed! Please try again!"
        );
    }

    header('Content-Type: application/json');
    echo json_encode($response);
}


public function deleteMast(){

    $mast_data['mastid'] = $this->input->post('mastid',TRUE);

    $deviceData = $this->devices_model->deleteMast($mast_data);
    if ($deviceData){

        $response=array(
            'error'=>0,
            'message' => "Mast Deleted Succcessfully!!"
        );        

        
    }
    else{

        $response=array(
            'status'=>1,
            'message' => "Failed! Please try again!"
        );
    }

    header('Content-Type: application/json');
    echo json_encode($response);
}



public function getAllDevices(){
        // Datatables Variables
        $draw = intval($this->input->get("draw"));
        $start = intval($this->input->get("start"));
        $length = intval($this->input->get("length"));


        $all_users = $this->devices_model->getAllDevices();

        $data = array();

        foreach($all_users->result() as $r) {

            $data[] = array(
                
                $r->deviceid,
                $r->device_name,
                $this->getMastName($r->mastid),
                $r->wireless_mode,
                $r->ip_address,
                $this->getDeviceName($r->connected_from),
                $r->connection_status,
                $r->dateCreated

            );


            // // Ping the device
            // $status = $this->ping($r->ip_address);

            // // Update the device's status in the database
            // $this->devices_model->update_status($r->deviceid, $status);
        }

        $output = array(
            "draw" => $draw,
            "recordsTotal" => $all_users->num_rows(),
            "recordsFiltered" => $all_users->num_rows(),
            "data" => $data
        );
        echo json_encode($output);
        exit();
}


// public function checkDeviceConnectionState() {

//     $all_devices = $this->devices_model->getAllDevices();


//     foreach($all_devices->result() as $r) {

//         // Ping the device
//         $status = $this->ping($r->ip_address,$r->device_name,$r->connection_status);

//         // Update the device's status in the database
//         $this->devices_model->update_status($r->deviceid, $status);
//     }
    
// }


// public function ping($ip_address,$device_name,$connection_status){
//  //Use exec() function to run the ping command
//     exec("ping -n 1 " .$ip_address, $output, $status);
//     if($status == 0) {
//         return "Online";
//     } 
//     else {

//         if($status!=0 && $connection_status==="Offline"){
//             return "Offline";
//         }
//         else{
//             $testResult = $this->africastalking->sendMessage(
//                 $this->session->userdata('uphone'), 
//                 "Device: ".$device_name." is Currently Offline "."Pinged IP: ".$ip_address);

//             if($testResult[0]->statusCode==101)
//             {
//                 return "Offline";
//             }
//             else{
//                 return "Offline";
//             }
//         }
//     }
// }



public function insertDeviceData(){

    $device_data['deviceid'] = $this->input->post('device_id',TRUE);
    $device_data['device_name'] = $this->input->post('device_name',TRUE);
    $device_data['mastid'] = $this->input->post('mast_name',TRUE);
    $device_data['wireless_mode'] = $this->input->post('wireless_mode',TRUE);
    $device_data['ip_address'] = $this->input->post('ip_address',TRUE);
    $device_data['connected_from'] = $this->input->post('connected_from',TRUE);
    $device_data['dateCreated']  = date('Y-m-d H:i:s');

    $device_data = $this->devices_model->insertDeviceData($device_data);
    if ($device_data){

        $response=array(
            'error'=>0,
            'message' => "Saved Succcessfully!!"
        );
        
    }
    else{

        $response=array(
            'status'=>1,
            'message' => "Failed! Please try again!"
        );
    }

    header('Content-Type: application/json');
    echo json_encode($response);
}

public function getMastName($mastid){

    $mast_name = $this->devices_model->getMastName($mastid);


    return $mast_name;

}

public function getMastId(){


    $mastname  = $this->input->post('mastname',TRUE);
    $mast_id = $this->devices_model->getMastId($mastname);


      $response=array(
            'error'=>0,
            'mast_id' => $mast_id
        );

    header('Content-Type: application/json');
    echo json_encode($response);

}

public function getDeviceName($connected_from){

    $device_name = $this->devices_model->getDeviceName($connected_from);
    
    return $device_name;

}


public function deleteDevice(){

    $device_data['device_id'] = $this->input->post('device_id',TRUE);

    $device_data = $this->devices_model->deleteDevice($device_data);
    if ($device_data){

        $response=array(
            'error'=>0,
            'message' => "Device Deleted Succcessfully!!"
        );
        
    }
    else{

        $response=array(
            'status'=>1,
            'message' => "Failed! Please try again!"
        );
    }

    header('Content-Type: application/json');
    echo json_encode($response);
}

public function getConnectedFrom(){


    $connectedfrom  = $this->input->post('connectedfrom',TRUE);
    if ($connectedfrom =="----"){

        $response=array(
            'error'=>0,
            'device_id' => "0"
        );

    }
    else{

    $device_id = $this->devices_model->getConnectedFrom($connectedfrom);


       $response=array(
            'error'=>0,
            'device_id' => $device_id
        );

    
    }
    header('Content-Type: application/json');
    echo json_encode($response);
}


// public function send_notification(){

//     $message = $this->input->post("message");
//     $user_id = $this->input->post("user_id");
    
//     $content = array(
//         "en" => "$message"
//     );

//     $fields = array(
//         'app_id' => "3ef24238-3102-4f4b-955d-b18b27dbd1a5",
//         'filters' => array(array("field" => "tag", "key" => "user_id", "relation" => "=", "value" => "$user_id")),
//         'contents' => $content
//     );

//     $fields = json_encode($fields);
//     print("\nJSON sent:\n");
//     print($fields);

//     $ch = curl_init();
//     curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
//     curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json; charset=utf-8',
//         'Authorization: Basic NGM0Mzk5YjMtNTQzMi00OTkwLTkyY2EtMTI1MzNhODBmZjgz'));
//     curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
//     curl_setopt($ch, CURLOPT_HEADER, FALSE);
//     curl_setopt($ch, CURLOPT_POST, TRUE);
//     curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
//     curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);

//     $response = curl_exec($ch);
//     curl_close($ch);
//     return $response;
// }





}