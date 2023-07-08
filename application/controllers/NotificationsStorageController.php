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
        $devicedata[] = $this->notifications_model->getDeviceData($ipaddress);
        $devicename = $devicedata[0]["device_name"];
        $mastid = $devicedata[0]["mastid"];
        $model_short = $devicedata[0]["model_short"];
        $connection_status = $this->getconnectionstatus($messagecode);
        $seen = 0;
        $date = date("Y-m-d H:i:s");

        $rowdata = [
            "device_name" => $devicename,
            "ip_address" => $ipaddress,
            "mastid" => $mastid,
            "model_short" => $model_short,
            "connection_status" => $connection_status,
            "seen" => $seen,
            "date_created" => $date,
        ];

        $this->notifications_model->storeNotification($rowdata);

        header("Content-Type: application/json");
        // echo json_encode($notificationbuffer);
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
