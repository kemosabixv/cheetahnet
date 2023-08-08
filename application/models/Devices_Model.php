<?php

class Devices_Model extends CI_Model
{
    public function insertInterfaceData($interface_data)
    {
        $this->db->where("id", 1);
        $query = $this->db->get("tbl_interfaces");

        if ($query->num_rows() > 0) {
            $this->db->where("id", 1);
            $this->db->update("tbl_interfaces", $interface_data);
        } else {
            $interface_data["id"] = 1;
            $this->db->insert("tbl_interfaces", $interface_data);
        }

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

    public function get_interface()
    {
        $this->getinterfaceinfo();
        $query = $this->db->get("tbl_interfaces");
        return $query->result();
    }

    public function getinterfaceinfo()
    {
        $url = "http://localhost:8081/rpc/return-interfaces";
        // Initialize cURL
        $ch = curl_init($url);
        // Set cURL options
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        // Execute the cURL request
        $apiresponse = curl_exec($ch);
        // Close the cURL session
        curl_close($ch);
    }


    public function getAllMasts()
    {
        $query = $this->db->get("tbl_masts");
        return $query->result();
    }
    public function getAll_Masts()
    {
        return $this->db->get("tbl_masts");
    }

    public function insertMastData($mast_data)
    {
        $this->db->insert("tbl_masts", $mast_data);
        if ($this->db->affected_rows() > 0) {
            unset($mast_data["dateCreated"]);
            $mast_data["operation"] = "insert";
            $mast_data["timestamp"] = date("Y-m-d H:i:s");
            $mastid = "";
            $this->db->select("mastid");
            $this->db->where("mast_name", $mast_data["mast_name"]);
            $query = $this->db->get("tbl_masts");
            if ($query->num_rows() > 0) {
                $mast_id = $query->result()[0]->mastid;
            }
            $mast_data["mastid"] = $mast_id;
            $this->db->where("mastid", $mast_data["mastid"]);
            $q = $this->db->get("tbl_masts_history");
            if ($q->num_rows() > 0) {
                $this->db->where("mastid", $mast_data["mastid"]);
                $this->db->update("tbl_masts_history", $mast_data);
                return true;
            } else {
                $this->db->insert("tbl_masts_history", $mast_data);
                return true;
            }
        } else {

            return false;
        } 
    }

    public function editMastData($mast_data)
    {

        // $this->db->select("mastid", "mast_name", "location", "height", "connection_via", "connected_from");
        $this->db->where("mastid", $mast_data["mastid"]);
        $query = $this->db->get("tbl_masts");
        
        if ($query->num_rows() > 0) {
            $this->db->where("mastid", $mast_data["mastid"]);
            $q = $this->db->get("tbl_masts_history");
            if ($q->num_rows() > 0) {
                $history_data=[];            
                $history_data["mastid"] = $q->result()[0]->mastid;
                $history_data["mast_name"] = $q->result()[0]->mast_name;
                $history_data["location"] = $q->result()[0]->location;
                $history_data["connection_via"] = $q->result()[0]->connection_via;
                $history_data["connected_from"] = $q->result()[0]->connected_from;
                $history_data["operation"] = "update";
                $history_data["timestamp"] = date("Y-m-d H:i:s");
                $this->db->where("mastid", $mast_data["mastid"]);
                $this->db->update("tbl_masts_history", $history_data);
                $this->db->where("mastid", $mast_data["mastid"]);
                $this->db->update("tbl_masts", $mast_data); 
            }
            else{
                $history_data=[];            
                $history_data["mastid"] = $mast_data["mastid"];
                $history_data["mast_name"] = $mast_data["mast_name"];
                $history_data["location"] = $mast_data["location"];
                $history_data["connection_via"] = $mast_data["connection_via"];
                $history_data["connected_from"] = $mast_data["connected_from"];
                $history_data["operation"] = "update";
                $history_data["timestamp"] = date("Y-m-d H:i:s");
                $this->db->where("mastid", $mast_data["mastid"]);
                $this->db->insert("tbl_masts_history", $history_data);
            }
            $this->db->where("mastid", $mast_data["mastid"]);
            $this->db->update("tbl_masts", $mast_data); 
            return true;
        } else {
            return false;
        }
    }

    public function deleteMast($mast_data)
    {
        
        $this->db->where("mastid", $mast_data["mastid"]);
        $this->db->delete("tbl_masts");
        $this->db->where("mastid", $mast_data["mastid"]);
        $this->db->delete("tbl_devices");

        
        
        $this->db->select("operation", "timestamp", "mast_name");
        $this->db->where("mastid", $mast_data["mastid"]);
        $q = $this->db->get("tbl_masts_history");
        if ($q->num_rows() > 0) {
            $history_data=[]; 
            $history_data["operation"] = "delete";
            $history_data["timestamp"] = date("Y-m-d H:i:s");
            $history_data["mast_name"] = $mast_data["mast_name"];
            $this->db->update("tbl_masts_history", $history_data);
        }else{
            $history_data=[];            
                $history_data["mastid"] = $mast_data["mastid"];
                $history_data["mast_name"] = $mast_data["mast_name"];
                $history_data["location"] = $mast_data["location"];
                $history_data["connection_via"] = $mast_data["connection_via"];
                $history_data["connected_from"] = $mast_data["connected_from"];
                $history_data["operation"] = "delete";
                $history_data["timestamp"] = date("Y-m-d H:i:s");
                $this->db->where("mastid", $mast_data["mastid"]);
                $this->db->insert("tbl_masts_history", $history_data);
        }
        
        $query = $this->db->query(
            "SELECT MAX(mastid) AS max_id FROM tbl_masts"
        );
        $result = $query->row();
        $max_id = $result->max_id;

        if ($this->db->error()["message"]) {
            return false;
        } elseif (!$this->db->affected_rows()) {
            return false;
        } else {
            // reset auto increment
            $this->db->query(
                "ALTER TABLE tbl_masts AUTO_INCREMENT = " . ($max_id + 1)
            );
            return true;
        }
    }

    public function getAllDevices()
    {
        return $this->db->get("tbl_devices");
    }
   

    public function insertDeviceData($device_data)
    {   
        
        $exists = 0;
        $this->db->select("ip_address");
        $this->db->where("ip_address", $device_data["ip_address"]);
        $query = $this->db->get("tbl_devices");
        // echo $query->num_rows();
        if ($query->num_rows() > 0) {
            $exists = 1;
            // echo "num_rows";
            // var_dump($exists);
        }
        if ($exists > 0){
            // echo "not null";
            return $response = [
                "error" => 1,
                "message" => "Device IP already exists"
            ];
        } else {
            $this->db->select("deviceid", "device_name", "mastid", "ip_address", "wireless_mode", "connected_from", "dateCreated");
            $this->db->insert("tbl_devices", $device_data);
        }
        unset($device_data["dateCreated"]);
        $device_data["operation"] = "insert";
        $device_data["timestamp"] = date("Y-m-d H:i:s");
        
        $deviceid = "";
        $this->db->select("deviceid");
        $this->db->where("ip_address", $device_data["ip_address"]);
        $query = $this->db->get("tbl_devices");
        if ($query->num_rows() > 0) {
            $deviceid = $query->result()[0]->deviceid;
        }
        $device_data["deviceid"] = $deviceid;
        // echo ("model method");
        // var_dump($device_data);
        $this->db->select("deviceid", "device_name", "mastid", "ip_address", "wireless_mode", "connected_from", "operation", "timestamp");
        $this->db->where("deviceid", $device_data["deviceid"]);
        $query = $this->db->get("tbl_devices_history");
        if ($query->num_rows() > 0) {
            $this->db->select("device_name", "mastid", "ip_address", "wireless_mode", "connected_from", "operation", "timestamp");
            $this->db->where("deviceid", $device_data["deviceid"]);
                $this->db->update("tbl_devices_history", $device_data);
                return $response = [
                    "error" => 0,
                    "message" => "Device added successfully"
                ];
            } else {
                $this->db->insert("tbl_devices_history", $device_data);
                return $response = [
                    "error" => 0,
                    "message" => "Device added successfully"
                ];
            }        
        }
       
    

    public function editDeviceData($device_data)
    {

        // $this->db->select("deviceid", "device_name", "mastid", "ip_address", "wireless_mode", "connected_from");
        $this->db->where("deviceid", $device_data["deviceid"]);
        $query = $this->db->get("tbl_devices");
        
        if ($query->num_rows() > 0) {
            $this->db->where("deviceid", $device_data["deviceid"]);
            $q = $this->db->get("tbl_devices_history");
            $history_data=[];
            $history_data["deviceid"] = $q->result()[0]->deviceid;
            $history_data["device_name"] = $q->result()[0]->device_name;
            $history_data["mastid"] = $q->result()[0]->mastid;
            $history_data["wireless_mode"] = $q->result()[0]->wireless_mode;
            $history_data["ip_address"] = $q->result()[0]->ip_address;
            $history_data["connected_from"] = $q->result()[0]->connected_from;
            $history_data["connection_status"] = $q->result()[0]->connection_status;
            $history_data["mac"] = $q->result()[0]->mac;
            $history_data["ssid"] = $q->result()[0]->ssid;
            $history_data["device_model"] = $q->result()[0]->device_model;
            $history_data["model_short"] = $q->result()[0]->model_short;
            $history_data["firmware_version"] = $q->result()[0]->firmware_version;
            $history_data["operation"] = "update";
            $history_data["timestamp"] = date("Y-m-d H:i:s");
            $this->db->where("deviceid", $device_data["deviceid"]);
            $this->db->update("tbl_devices_history", $history_data);
            $this->db->where("deviceid", $device_data["deviceid"]);
            $this->db->update("tbl_devices", $device_data);  
            return true;
        } else {
            return false;
        }
    }

    public function get_all_ap()
    {
        $this->db->where("wireless_mode", "AP");
        $query = $this->db->get("tbl_devices");
        return $query->result();
    }

    public function getMastName($mastid)
    {
        $this->db->where("mastid", $mastid);
        $mast_name = $this->db->get("tbl_masts")->result();

        if (count($mast_name) <= 0) {
            return "----";
        } else {
            return $mast_name[0]->mast_name;
        }
    }

    public function getMastId($mastname)
    {
        $this->db->where("mast_name", $mastname);
        $mast_name = $this->db->get("tbl_masts")->result();

        if (count($mast_name) <= 0) {
            return count($mast_name);
        } else {
            return $mast_name[0]->mastid;
        }
    }

    public function getDeviceName($connected_from)
    {
        if ($connected_from === "0") {
            return "----";
        } else {
            $value= intval($connected_from);
            // var_dump($value);
            $this->db->select("device_name");
            $this->db->where("deviceid", $value);
            $deviceName = $this->db->get("tbl_devices")->result();
            // echo $deviceName;
            // var_dump($deviceName);
            return $deviceName[0]->device_name;    
        }
    }

    public function update_status($deviceid, $status)
    {
        $data = [
            "connection_status" => $status,
        ];

        $this->db->where("deviceid", $deviceid);
        $this->db->update("tbl_devices", $data);
    }

    public function deleteDevice($device_data)
    {
        $history_data["operation"] = "delete";
        $history_data["timestamp"] = date("Y-m-d H:i:s");
        $history_data["device_name"] = $device_data["device_name"];
        $this->db->where("deviceid", $device_data["device_id"]);
        $this->db->delete("tbl_devices");
        
        $this->db->select("operation", "timestamp", "device_name");
        $this->db->where("deviceid", $device_data["device_id"]);
        $this->db->update("tbl_devices_history", $history_data);
        $query = $this->db->query(
            "SELECT MAX(deviceid) AS max_id FROM tbl_devices"
        );
        $result = $query->row();
        $max_id = $result->max_id;

        if ($this->db->error()["message"]) {
            return false;
        } elseif (!$this->db->affected_rows()) {
            return false;
        } else {
            // reset auto increment
            $this->db->query(
                "ALTER TABLE tbl_devices AUTO_INCREMENT = " . ($max_id + 1)
            );
            return true;
        }
    }

    public function getConnectedFrom($connectedfrom)
    {
        $this->db->where("deviceid", $connectedfrom);
        $connected_from = $this->db->get("tbl_devices")->result();

        if (count($connected_from) <= 0) {
            return count($connected_from);
        } else {
            return $connected_from[0]->deviceid;
        }
    }

    public function getMastConnectionStatus($mastid)
    {
        $this->db->where("mastid", $mastid);
        $this->db->order_by("dateCreated", "desc");
        $connected_status = $this->db->get("tbl_devices")->result();

        if (count($connected_status) <= 0) {
            return count($connected_status);
        } else {
            return $connected_status[0]->connection_status;
        }
    }

    public function getMastDevices($mastID)
    {
        $this->db->select("connection_status");
        $this->db->where("mastid", $mastID);
        $q = $this->db->get("tbl_devices");

        $connected_status = [];
        foreach ($q->result() as $row) {
            array_push($connected_status, $row->connection_status);
        }

        $connected_status = array_map("strval", $connected_status);

        return $connected_status;
    }
}
