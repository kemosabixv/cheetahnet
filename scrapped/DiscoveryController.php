<?php
defined("BASEPATH") or exit("No direct script access allowed");

class DiscoveryController extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if ($this->session->userdata("logged_in") !== true) {
            redirect("welcome");
        }
        $this->load->model("Discovery_Model", "discovery_model");
        $this->load->model("Devices_Model", "devices_model");
    }

    public function index()
    {
        $interfaces = $this->discovery_model->get_interface();
        $pagedata["interfaces"] = $interfaces;
        $pagedata["all_masts"] = $this->devices_model->getAllMasts();
        $page = "discovery";

        $this->load->view("includes/header");
        $this->load->view("includes/topbar");
        $this->load->view("includes/sidebar");
        $this->load->view("pages/" . $page, $pagedata);
        $this->load->view("includes/footer");
        $this->load->view("includes/js/discovery_script");
    }

    // public function addinterface()
    // {
    //     $interface_data["id"] = 1;
    //     $interface_data["interfacedisplayname"] = $this->input->post(
    //         "interface_name",
    //         true
    //     );

    //     // Call the model to insert the interface data
    //     $result = $this->discovery_model->insertInterfaceData($interface_data);

    //     // Prepare the response data
    //     $response = [];
    //     if ($result) {
    //         $response["error"] = 0;
    //         $response["message"] = "Interface data inserted successfully";
    //     } else {
    //         $response["error"] = 1;
    //         $response["message"] = "Failed to insert interface data";
    //     }

    //     // Send the response as JSON
    //     header("Content-Type: application/json");
    //     echo json_encode($response);
    // }



    public function getdiscoverydata()
    {
        $discovery_data = $this->discovery_model->getDiscoveryData();
        $data = [];
        foreach ($discovery_data as $row) {
            $sub_array = [];
            $sub_array["select"] = "";
            $sub_array["device_name"] = $row->device_name;
            $sub_array["ip_address"] = $row->ip_address;
            $sub_array["model"] = $row->device_model;
            $sub_array["firmware_version"] = $row->firmware_version;
            $data[] = $sub_array;
        }
        $output = [
            "data" => $data,
        ];
        header("Content-Type: application/json");
        // var_dump($output);
        echo json_encode($output);
    }

    public function updatediscoverydata()
    {
        // Initialize cURL
        $curl = curl_init();

        // Set the cURL options
        curl_setopt(
            $curl,
            CURLOPT_URL,
            "http://localhost:8081/rpc/discover-radios"
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
                // Set the response header to indicate JSON content
                header("Content-Type: application/json");

                // Convert json object to PHP associative array
                $data = json_decode($response, true);
                $discovery_data = $data;

                // Check if there is data returned
                if (!empty($discovery_data)) {
                    // Call the insertDiscoveryData method to insert the data
                    $this->discovery_model->insertDiscoveryData(
                        $discovery_data
                    );
                

                    // Return a success response
                    echo json_encode([
                        "error" => 0,
                        "message" => "Scan Complete",
                    ]);
                } else {
                    // Return an error response if no data is available
                    echo json_encode([
                        "error" => 1,
                        "message" => "Scan Error",
                    ]);
                }
            
            }
        }

        // Close cURL
        curl_close($curl);
    }

    //clear discovery data
    public function cleardiscoverydata()
    {
        // Call the model to clear the discovery data
        $result = $this->discovery_model->clearDiscoveryData();
        // Prepare the response data
        $response = [];
        if ($result) {
            $response["error"] = 0;
            $response["message"] = "Discovery data cleared successfully";
        } else {
            $response["error"] = 1;
            $response["message"] = "Failed to clear discovery data";
        }
    }

    //addDiscoveryDevices
    public function addDiscoveryDevices()
    {
        // Get the data from the form data
        $rowData = json_decode($this->input->post("rowData"), true);
        
        // Get the row data from the database
        $dbdevicedata = $this->discovery_model->getDiscoveryDataForInsertion($rowData);
        
        // Add mast ID from $rowData to each element in $dbdevicedata
        foreach ($dbdevicedata as &$device) {
            $device['mastid'] = $rowData['mastid'];
            $device['wireless_mode']='';
            $device['connected_from']='0';
            $device['dateCreated']=date("Y-m-d H:i:s");
            
        }
        
        // var_dump($dbdevicedata);
        $result = $this->discovery_model->insertDiscoveryDeviceData($dbdevicedata);
        // Return response as JSON from model
        header("Content-Type: application/json");
        // var_dump($result);
        echo json_encode($result);
    }
    

}
