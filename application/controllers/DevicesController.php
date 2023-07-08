<?php
defined("BASEPATH") or exit("No direct script access allowed");

class DevicesController extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if ($this->session->userdata("logged_in") !== true) {
            redirect("welcome");
        }
        $this->load->model("Devices_Model", "devices_model");
        $this->load->library("africastalking");
    }

    public function masts()
    {
        //$pagedata['all_receivers'] = $this->devices_model->get_all_receivers();
        $page = "masts";
        $pagedata["all_masts"] = $this->devices_model->getAllMasts();
        $this->load->view("includes/header");
        $this->load->view("includes/topbar");
        $this->load->view("includes/sidebar");
        $this->load->view("pages/" . $page, $pagedata); //$pagedata,
        $this->load->view("includes/footer");
        $this->load->view("includes/js/masts_script");
    }

    public function devices()
    {
        $pagedata["all_masts"] = $this->devices_model->getAllMasts();
        $pagedata["all_devices"] = $this->devices_model->get_all_ap();
        $page = "devices";
        $this->load->view("includes/header");
        $this->load->view("includes/topbar");
        $this->load->view("includes/sidebar");
        $this->load->view("pages/" . $page, $pagedata);
        $this->load->view("includes/footer");
        $this->load->view("includes/js/devices_script");
    }

    public function mastdevices()
    {
        $page = "mastdevices";
        $this->load->view("includes/header");
        $this->load->view("includes/topbar");
        $this->load->view("includes/sidebar");
        $this->load->view("pages/" . $page);
        $this->load->view("includes/footer");
        $this->load->view("includes/js/mastdevices_script");
    }

    public function getAllMasts()
    {
        // Datatables Variables
        $draw = intval($this->input->get("draw"));
        $start = intval($this->input->get("start"));
        $length = intval($this->input->get("length"));

        $all_users = $this->devices_model->getAll_Masts();

        $data = [];

        foreach ($all_users->result() as $r) {
            $data[] = [
                $r->mastid,
                $r->mast_name,
                $r->location,
                $r->connection_via,
                $this->getMastName($r->connected_from),
                date("d-m-Y", strtotime($r->dateCreated)),
            ];
        }

        $output = [
            "draw" => $draw,
            "recordsTotal" => $all_users->num_rows(),
            "recordsFiltered" => $all_users->num_rows(),
            "data" => $data,
        ];
        echo json_encode($output);
        exit();
    }

    public function insertMastData()
    {
        $mast_data["mastid"] = $this->input->post("mastid", true);
        $mast_data["mast_name"] = $this->input->post("mast_name", true);
        $mast_data["location"] = $this->input->post("mast_location", true);

        $mast_data["connection_via"] = $this->input->post(
            "mast_connected_via",
            true
        );
        $mast_data["connected_from"] = $this->input->post(
            "mast_connected_from",
            true
        );

        $mast_data["dateCreated"] = date("Y-m-d H:i:s");

        $mastData = $this->devices_model->insertMastData($mast_data);
        if ($mastData) {
            $response = [
                "error" => 0,
                "message" => "Saved Succcessfully!!",
            ];
        } else {
            $response = [
                "status" => 1,
                "message" => "Failed! Please try again!",
            ];
        }

        header("Content-Type: application/json");
        echo json_encode($response);
    }

    public function deleteMast()
    {
        $mast_data["mastid"] = $this->input->post("mastid", true);

        $deviceData = $this->devices_model->deleteMast($mast_data);
        if ($deviceData) {
            $response = [
                "error" => 0,
                "message" => "Mast Deleted Succcessfully!!",
            ];
        } else {
            $response = [
                "status" => 1,
                "message" => "Failed! Please try again!",
            ];
        }

        header("Content-Type: application/json");
        echo json_encode($response);
    }

    public function getAllDevices()
    {
        // Datatables Variables
        $draw = intval($this->input->get("draw"));
        $start = intval($this->input->get("start"));
        $length = intval($this->input->get("length"));

        $all_devices = $this->devices_model->getAllDevices();
        // echo ("all_devices");
        // header("Content-Type: application/json");
        // var_dump($all_devices->result());

        $data = [];

        foreach ($all_devices->result() as $r) {
            $data[] = [
                $r->deviceid,
                $r->device_name,
                $this->getMastName($r->mastid),
                $r->wireless_mode,
                $r->ip_address,
                $this->getDeviceName($r->connected_from),
                $r->connection_status,
            ];
        }
        // echo("data dump");
        // print_r($data);
        $output = [
            "draw" => $draw,
            "recordsTotal" => $all_devices->num_rows(),
            "recordsFiltered" => $all_devices->num_rows(),
            "data" => $data,
        ];
        header("Content-Type: application/json");
        echo json_encode($output);
    }

    public function update_radiomode_connectedfrom()
    {
        //curl request to update radio mode and connected from
        // Initialize cURL
        $curl = curl_init();

        // Set the cURL options
        curl_setopt(
            $curl,
            CURLOPT_URL,
            "http://localhost:8081/rpc/update_radiomode_connectedfrom"
        );
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        // Execute the cURL request
        $response = curl_exec($curl);

        // Check for cURL errors
        if (curl_errno($curl)) {
            $error = curl_error($curl);
            // Handle the error
            // For example, you can log or display the error message
            echo json_encode([
                "error" => 1,
                "message" => "cURL Error: " . $error,
            ]);
        } else {
            // Decode the JSON response
            $jsonData = json_decode($response);

            // Check if decoding was successful
            if ($jsonData === null) {
                // Handle the error
                // For example, you can log or display an error message
                echo json_encode([
                    "error" => 1,
                    "message" => "Error decoding JSON response",
                ]);
            } else {
                // Add the "error" field to the JSON response
                $jsonData[] = [
                    "error" => 0,
                    "message" => "Success",
                ];

                // Encode the updated JSON response
                $jsonData = json_encode($jsonData);

                // Set the response header to indicate JSON content
                header("Content-Type: application/json");
                echo $jsonData;
            }
        }
        // Close cURL
        curl_close($curl);
    }

    public function insertDeviceData()
    {
        $device_data["deviceid"] = $this->input->post("device_id", true);
        $device_data["device_name"] = $this->input->post("device_name", true);
        $device_data["mastid"] = $this->input->post("mast_name", true);
        $device_data["wireless_mode"] = $this->input->post(
            "wireless_mode",
            true
        );
        $device_data["ip_address"] = $this->input->post("ip_address", true);
        $device_data["connected_from"] = $this->input->post(
            "connected_from",
            true
        );
        $device_data["dateCreated"] = date("Y-m-d H:i:s");
        if ($device_data["connected_from"] == null) {
            $device_data["connected_from"] = "0";
        }

        $device_data = $this->devices_model->insertDeviceData($device_data);
        if ($device_data) {
            $response = [
                "error" => 0,
                "message" => "Saved Succcessfully!!",
            ];
        } else {
            $response = [
                "status" => 1,
                "message" => "Failed! Please try again!",
            ];
        }

        header("Content-Type: application/json");
        echo json_encode($response);
    }

    public function editDeviceData()
    {
        $device_data["deviceid"] = $this->input->post("device_id", true);
        $device_data["device_name"] = $this->input->post("device_name", true);
        $device_data["mastid"] = $this->input->post("mast_name", true);
        $device_data["wireless_mode"] = $this->input->post(
            "wireless_mode",
            true
        );
        $device_data["ip_address"] = $this->input->post("ip_address", true);
        $device_data["connected_from"] = $this->input->post(
            "connected_from",
            true
        );
        if ($device_data["connected_from"] == null) {
            $device_data["connected_from"] = "0";
        }

        $device_data = $this->devices_model->editDeviceData($device_data);
        if ($device_data) {
            $response = [
                "error" => 0,
                "message" => "Saved Succcessfully!!",
            ];
        } else {
            $response = [
                "status" => 1,
                "message" => "Failed! Please try again!",
            ];
        }

        header("Content-Type: application/json");
        echo json_encode($response);
    }

    public function getMastName($mastid)
    {
        $mast_name = $this->devices_model->getMastName($mastid);

        return $mast_name;
    }

    public function getMastId()
    {
        $mastname = $this->input->post("mastname", true);
        $mast_id = $this->devices_model->getMastId($mastname);

        $response = [
            "error" => 0,
            "mast_id" => $mast_id,
        ];

        header("Content-Type: application/json");
        echo json_encode($response);
    }

    public function getDeviceName($connected_from)
    {
        $device_name = $this->devices_model->getDeviceName($connected_from);
        return $device_name;
    }

    public function deleteDevice()
    {
        $device_data["device_id"] = $this->input->post("device_id", true);

        $device_data = $this->devices_model->deleteDevice($device_data);
        if ($device_data) {
            $response = [
                "error" => 0,
                "message" => "Device Deleted Succcessfully!!",
            ];
        } else {
            $response = [
                "status" => 1,
                "message" => "Failed! Please try again!",
            ];
        }

        header("Content-Type: application/json");
        echo json_encode($response);
    }

    public function getConnectedFrom()
    {
        $connectedfrom = $this->input->post("connectedfrom", true);
        if ($connectedfrom == "----") {
            $response = [
                "error" => 0,
                "device_id" => "0",
            ];
        } else {
            $device_id = $this->devices_model->getConnectedFrom($connectedfrom);

            $response = [
                "error" => 0,
                "device_id" => $device_id,
            ];
        }
        header("Content-Type: application/json");
        echo json_encode($response);
    }

    
}
