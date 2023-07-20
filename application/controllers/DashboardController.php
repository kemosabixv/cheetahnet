<?php
defined("BASEPATH") or exit("No direct script access allowed");

class DashboardController extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        // if ($this->session->userdata("logged_in") !== true) {
        //     redirect("welcome");
        // }
        $this->load->model("Devices_Model", "devices_model");
        $this->load->model("Dashboard_Model", "dashboard_model");
        $this->load->library("africastalking");
    }
    public function index()
    {
        //$pagedata['all_receivers'] = $this->devices_model->get_all_receivers();
        $page = "dashboard";
        $pagedata = [];
        $this->load->view("includes/header");
        $this->load->view("includes/topbar");
        $this->load->view("includes/sidebar");
        $this->load->view("pages/" . $page, $pagedata); //$pagedata,
        $this->load->view("includes/footer");
        $this->load->view("includes/js/dashboard_script");
    }
    public function error()
    {
        $page = "error";
        $this->load->view("pages/" . $page); //$pagedata,
    }
    public function getmastdevicescount()
    {
        $all_masts = $this->dashboard_model->getmastdevicescount();
        $data = ["data" => $all_masts];
        return $this->output
            ->set_content_type("application/json")
            ->set_output(json_encode($data));
    }
    public function getallstations()
    {
        $all_stations = $this->dashboard_model->getallstations();
        // echo $all_stations;
        $data = ["data" => $all_stations];
        return $this->output
            ->set_content_type("application/json")
            ->set_output(json_encode($data));
    }
    public function getallAPs()
    {
        $all_aps = $this->dashboard_model->getallAPs();
        $data = ["data" => $all_aps];
        return $this->output
            ->set_content_type("application/json")
            ->set_output(json_encode($data));
    }
    public function getalldevices()
    {
        $all_devices = $this->dashboard_model->getalldevices();
        $data = ["data" => $all_devices];
        return $this->output
            ->set_content_type("application/json")
            ->set_output(json_encode($data));
    }
    public function get_recent_disconnections()
    {
        $recent_disconnections = $this->dashboard_model->get_recent_disconnections();
        $data = [];
        $current_status = "";
        foreach ($recent_disconnections as $row) {
            $sub_array = [];
            $sub_array["device_name"] = $row->device_name;
            $sub_array["ip"] = $row->ip_address;
            $sub_array["model"] = $row->model_short;
            $sub_array["date"] = $row->date_created;
            $current_status = $this->get_current_connection_status($row->device_name);
            $sub_array["current_status"] = $current_status;
            $data[] = $sub_array;
        }
        $output = [
            "data" => $data,
        ];
        header("Content-Type: application/json");
        // var_dump($output);
        echo json_encode($output);
    }

    public function get_connections_per_ap()
    {
        $connections_per_ap = $this->dashboard_model->get_connections_per_ap();
        header("Content-Type: application/json");
        echo json_encode($connections_per_ap);
    }

    public function get_current_connection_status($devicename)
    {
        // echo $devicename;
        // var_dump($devicename);
        $current_status = $this->dashboard_model->get_current_connection_status($devicename);
        return $current_status[0]->connection_status;
    }

    public function get_recent_activity_items()
    {
        $recent_activity_items = $this->dashboard_model->get_recent_activity_items();
        return $recent_activity_items;
    }
    public function get_connection_status_history()
    {
        $connection_status_history = $this->dashboard_model->get_connection_status_history();
        return $this->output
        ->set_content_type("application/json")
        ->set_output(json_encode($connection_status_history));
    }
}
