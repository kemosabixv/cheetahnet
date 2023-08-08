<?php
defined("BASEPATH") or exit("No direct script access allowed");

class NotificationsStorageController extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model("Notifications_Model", "notifications_model");
    }

    public function storenotification($ipaddress, $messagecode)
    {
        $devicedata = $this->notifications_model->getDeviceData($ipaddress);
        $data=[];
        $connection_status = $this->getconnectionstatus($messagecode);
        $seen = 0;
        // var_dump($devicedata);
        foreach ($devicedata as $row){
            $data = [];
            $data["mastid"] = $row->mastid;
            $data["device_name"] = $row->device_name;
            $data["model_short"] = $row->model_short;
            $data["ip_address"] = $ipaddress;
            $data["connection_status"] = $connection_status;
            $data["date_created"] = date("Y-m-d H:i:s");
            $data["seen"] = $seen;

        }

        // $devicename = $data["device_name"];

        // var_dump($devicename);
        
        // var_dump($data);

        // $rowdata = [
        //     "device_name" => $devicename,
        //     "ip_address" => $ipaddress,
        //     "mastid" => $mastid,
        //     "model_short" => $model_short,
        //     "connection_status" => $connection_status,
        //     "seen" => $seen,
        //     "date_created" => $date,
        // ];

        $this->notifications_model->storeNotification($data);

        header("Content-Type: application/json");
        //return 200 response code
        http_response_code(200);
    }

    public function getconnectionstatus($messagecode)
    {
        if ($messagecode == 0) {
            return "Online";
        } else {
            return "Offline";
        }
    }
}
