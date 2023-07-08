<?php
defined("BASEPATH") or exit("No direct script access allowed");

class SingleDeviceController extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if ($this->session->userdata("logged_in") !== true) {
            redirect("welcome");
        }
        $this->load->model("SingleDevice_Model", "singledevicemodel");
        $this->load->model("Devices_Model", "devicesmodel");
    }

    public function index($ipaddress)
    {
        $pagedata = $this->getdevicedata($ipaddress);
        $mastid = $pagedata["mastid"];
        $pagedata["mastid"] = $this->devicesmodel->getMastName($mastid);
        // var_dump($pagedata);
        $page = "single_device";
        $this->load->view("includes/header");
        $this->load->view("includes/topbar");
        $this->load->view("includes/sidebar");
        $this->load->view("pages/" . $page, $pagedata);
        $this->load->view("includes/footer");
        $this->load->view("includes/js/singledevice_script", $pagedata);
    }

    //get data from database using ip address adding to $pagedata array
    public function getdevicedata($ipaddress)
    {
        $data = $this->singledevicemodel->getdevicedata($ipaddress);
        return $data;
    }

    public function getconnectionstatus($ipaddress)
    {
        $data = $this->singledevicemodel->getdeviceconnectionstatus($ipaddress);
        header("Content-Type: application/json");
        echo json_encode($data);
    }

    public function snmpgetruntimedevicedata($ipaddress)
    {
        // Initialize cURL
        $curl = curl_init();

        // Set the cURL options
        curl_setopt(
            $curl,
            CURLOPT_URL,
            "http://localhost:8081/rpc/snmpgetruntimedevicedata/" . $ipaddress
        );
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        // Execute the cURL request
        $response = curl_exec($curl);

        // Check for cURL errors
        if (curl_errno($curl)) {
            $error = curl_error($curl);
            // Handle the error
            // For example, you can log or display the error message
            echo "cURL Error: " . $error;
        } else {
            header("Content-Type: application/json");
            echo $response;
        }
        // Close cURL
        curl_close($curl);
    }

    public function snmpgetrecurringdevicedata($ipaddress)
    {
        // Initialize cURL
        $curl = curl_init();

        // Set the cURL options
        curl_setopt(
            $curl,
            CURLOPT_URL,
            "http://localhost:8081/rpc/snmpgetrecurringdevicedata/" . $ipaddress
        );
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        // Execute the cURL request
        $response = curl_exec($curl);

        // Check for cURL errors
        if (curl_errno($curl)) {
            $error = curl_error($curl);
            // Handle the error
            // For example, you can log or display the error message
            echo "cURL Error: " . $error;
        } else {
            // Decode the JSON response
            $jsonData = json_decode($response, true);

            header("Content-Type: application/json");
            echo json_encode($jsonData);
        }
        // Close cURL
        curl_close($curl);
    }
}
