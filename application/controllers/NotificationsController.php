<?php
defined("BASEPATH") or exit("No direct script access allowed");

class NotificationsController extends CI_Controller

    {
        public function __construct()
        {
            parent::__construct();
            // if ($this->session->userdata("logged_in") !== true) {
            //     redirect("welcome");
            // }
            $this->load->model("Notifications_Model", "notifications_model");      
            $this->load->model("Devices_Model", "devices_model");  
        }
        public function index()
        {
            $page = "notifications";
            $pagedata = [];
            $this->load->view("includes/header");
            $this->load->view("includes/topbar");
            $this->load->view("includes/sidebar");
            $this->load->view("pages/" . $page, $pagedata); //$pagedata,
            $this->load->view("includes/footer");
            $this->load->view("includes/js/notification_script");
        }
        public function get_all_client_notifications()
        {
            $client = $this->getmastid("Client");
            $all_client_notifications = $this->notifications_model->get_all_client_notifications($client);
            $data = [];
            foreach ($all_client_notifications as $row) {
                $sub_array = [];
                $sub_array["id"] = $row->id;
                $sub_array["device_name"] = $row->device_name;
                $sub_array["model"] = $row->model_short;
                $sub_array["ip"] = $row->ip_address;
                $sub_array["notice"] = $row->connection_status;
                $sub_array["date"] = $row->date_created;
                $data[] = $sub_array;
            }
            $output = [
                "data" => $data,
            ];
            header("Content-Type: application/json");
            // var_dump($output);
            echo json_encode($output);
        }
        public function get_all_nonclient_notifications()
        {
            $client = $this->getmastid("Client");
            $all_nonclient_notifications = $this->notifications_model->get_all_nonclient_notifications($client);
            $data = [];
            foreach ($all_nonclient_notifications as $row) {
                $sub_array = [];
                $sub_array["id"] = $row->id;
                $sub_array["device_name"] = $row->device_name;
                $sub_array["model"] = $row->model_short;
                $sub_array["ip"] = $row->ip_address;
                $sub_array["notice"] = $row->connection_status;
                $sub_array["date"] = $row->date_created;
                $sub_array["seen"] = $row->seen;
                $data[] = $sub_array;
            }
            $output = [
                "data" => $data,
            ];
            header("Content-Type: application/json");
            // var_dump($output);
            echo json_encode($output);
        }

        public function update_seen()
        {
            $rows = $this->input->post("rows");
            // var_dump($rows);

            $selectedRows = [];
            foreach ($rows as $row) {
                $selectedRows[] = $row["id"];
            }
            // var_dump($selectedRows);
            $response=$this->notifications_model->update_seen($selectedRows);
            header("Content-Type: application/json");
            echo json_encode($response);
        }

        public function getNotificationList()
        {
            $client = $this->getmastid("Client");
            $NotificationList = $this->notifications_model->get_notifications_list($client);
            header("Content-Type: application/json");
            $output = [
                "data" => $NotificationList,
            ];
            echo json_encode($output);
        }

        public function getmastid($mastname){
            $mastid = $this->devices_model->getMastId($mastname);
            return $mastid;
        }
       
    
    }
        
