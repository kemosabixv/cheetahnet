<?php
//TODO: add logic to use history tables
class Discovery_Model extends CI_Model
{
    
    // public function insertInterfaceData($interface_data)
    // {
    //     $this->db->where("id", 1);
    //     $query = $this->db->get("tbl_interfaces");

    //     if ($query->num_rows() > 0) {
    //         $this->db->where("id", 1);
    //         $this->db->update("tbl_interfaces", $interface_data);
    //     } else {
    //         $interface_data["id"] = 1;
    //         $this->db->insert("tbl_interfaces", $interface_data);
    //     }

    //     if ($this->db->affected_rows() >= 0) {
    //         return true;
    //     } else {
    //         $error_message = $this->db->error()["message"];
    //         $response = [
    //             "error" => 1,
    //             "message" => "Database Error: $error_message",
    //         ];
    //         header("Content-Type: application/json");
    //         echo json_encode($response);
    //         return false;
    //     }
    // }

    // public function get_interface()
    // {
    //     $this->getinterfaceinfo();
    //     $query = $this->db->get("tbl_interfaces");
    //     return $query->result();
    // }

    // public function getinterfaceinfo()
    // {
    //     $url = "http://localhost:8081/rpc/return-interfaces";
    //     // Initialize cURL
    //     $ch = curl_init($url);
    //     // Set cURL options
    //     curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    //     // Execute the cURL request
    //     $apiresponse = curl_exec($ch);
    //     // Close the cURL session
    //     curl_close($ch);
    // }
    
    public function getDiscoveryData()
    {
        $this->db->select(
            "device_name, ip_address, device_model, firmware_version"
        );
        $query = $this->db->get("tbl_discovery");
        return $query->result();
    }

    public function getDiscoveryDataForInsertion($rowData)
    {
        // Access the properties of $rowData
        $deviceName = $rowData["device_name"];
        $ipAddress = $rowData["ip_address"];

        $query = $this->db
            ->where("device_name", $deviceName)
            ->where("ip_address", $ipAddress)
            ->get("tbl_discovery");

        // Return the retrieved rows
        return $query->result_array();
    }

    public function insertDiscoveryData($discovery_data)
    {
        // Delete all rows from tbl_discovery
        $this->db->empty_table("tbl_discovery");
        //reset auto increment
        $this->db->query("ALTER TABLE tbl_discovery AUTO_INCREMENT = 1");

        // Prepare the data for batch insertion
        $batch_data = [];
        foreach ($discovery_data as $item) {
            $row_data = [
                "device_name" => $item["name"],
                "ip_address" => $item["ip"],
                "mac" => $item["mac"],
                "device_model" => $item["model"],
                "model_short" => $item["model_short"],
                "ssid" => $item["ssid"],
                "firmware_version" => $item["firmware"],
            ];
            $batch_data[] = $row_data;
        }

        // Insert the prepared batch data into tbl_discovery
        $this->db->insert_batch("tbl_discovery", $batch_data);

        if ($this->db->affected_rows() >= 0) {
            return true;
        } else {
            $error_message = $this->db->error()["message"];
            $response = [
                "error" => 1,
                "message" => "Database Error: $error_message",
            ];
            header("Content-Type: application/json");
            echo json_encode($response);
            return false;
        }
    }

    //clear discovery table
    public function clearDiscoveryData()
    {
        $this->db->empty_table("tbl_discovery");
        //reset auto increment
        $this->db->query("ALTER TABLE tbl_discovery AUTO_INCREMENT = 1");
        $response = [
            "error" => 0,
            "message" => "Discovery data cleared successfully",
        ];
        header("Content-Type: application/json");
        echo json_encode($response);
    }
    //insertdiscoverydevicedata
    public function insertDiscoveryDeviceData($discovery_device_data)
    {
        // set auto increment to last device id + 1
        $query = $this->db->query(
            "SELECT MAX(deviceid) AS max_id FROM tbl_devices"
        );
        $result = $query->row();
        $max_id = $result->max_id;
        $this->db->query(
            "ALTER TABLE tbl_devices AUTO_INCREMENT = " . ($max_id + 1)
        );
        $existing_devices = 0;
        foreach ($discovery_device_data as $device) {
            //get rows from tbl_devices where ip_address = $device['ip_address']
            $this->db->where("ip_address", $device["ip_address"]);
            $query = $this->db->get("tbl_devices");
            if ($query->num_rows() > 0) {
                $existing_devices++;
            }
        }
        if ($existing_devices > 0) {
            $response = [
                "error" => 1,
                "message" =>
                    "Device with IP Address " .
                    $discovery_device_data["ip_address"] .
                    " already exists",
            ];
            return $response;
        }
        //insert data into tbl_devices
        $batch_data = [];

        foreach ($discovery_device_data as $device) {
            $row_data = [
                "device_name" => $device["device_name"],
                "ip_address" => $device["ip_address"],
                "mac" => $device["mac"],
                "device_model" => $device["device_model"],
                "model_short" => $device["model_short"],
                "ssid" => $device["ssid"],
                "firmware_version" => $device["firmware_version"],
                "mastid" => $device["mastid"],
                "wireless_mode" => $device["wireless_mode"],
                "connected_from" => $device["connected_from"],
                "dateCreated" => date("Y-m-d H:i:s")
            ];
            $batch_data1[] = $row_data;
            }
            // Insert the prepared batch data into tbl_discovery
            $this->db->insert_batch("tbl_devices", $batch_data1);
            if ($this->db->affected_rows() > 0) {
                foreach ($discovery_device_data as $device) {
                $row_data = [
                    "deviceid"=> $this->getDeviceId($device["device_name"]),
                    "device_name" => $device["device_name"],
                    "ip_address" => $device["ip_address"],
                    "mac" => $device["mac"],
                    "device_model" => $device["device_model"],
                    "model_short" => $device["model_short"],
                    "ssid" => $device["ssid"],
                    "firmware_version" => $device["firmware_version"],
                    "mastid" => $device["mastid"],
                    "wireless_mode" => $device["wireless_mode"],
                    "connected_from" => $device["connected_from"],
                    "operation" => "insert",
                    "timestamp" => date("Y-m-d H:i:s")
                ];
                $batch_data2[] = $row_data;
                }
                // var_dump($batch_data2);
                $existing_deviceid= 0;
                foreach($batch_data2 as $device){
                    $this->db->where("deviceid", $device["deviceid"]);
                    $query = $this->db->get("tbl_devices_history");
                    if ($query->num_rows() > 0) {
                        $existing_deviceid++;
                    }
                }
                if ($existing_deviceid > 0) {
                   foreach($batch_data2 as $device){
                    $this->db->select(
                    "device_name",
                    "mastid", 
                    "wireless_mode", 
                    "ip_address", 
                    "connected_from", 
                    "mac", 
                    "ssid", 
                    "device_model", 
                    "model_short", 
                    "firmware_version", 
                    "operation", 
                    "timestamp");
                    $this->db->where("deviceid", $device["deviceid"]);
                    $this->db->update("tbl_devices_history", $device);
                   }
                }else{
                $this->db->insert_batch("tbl_devices_history", $batch_data2);
                if($this->db->affected_rows() > 0) {
                        $response = [
                        "error" => 0,
                        "message" => "Device data inserted successfully",
                    ];
                    return $response;

                } else {
                    $error_message = $this->db->error()["message"];
                    $response = [
                        "error" => 1,
                        "message" => "Database Error: $error_message",
                    ];
                    return $response;
                } 
            }
            } else {   
                $error_message = $this->db->error()["message"];
                $response = [
                    "error" => 1,
                    "message" => "Database Error: $error_message",
                ];
                return $response;
            }
        }
        
    

    public function getDeviceId($devicename)
    {
        $this->db->select("deviceid");
        $this->db->from("tbl_devices");
        $this->db->where("device_name", $devicename);
        $query = $this->db->get();
        $response= $query->result();
        // var_dump($response[0]->deviceid);
        return $response[0]->deviceid;
    }
}
