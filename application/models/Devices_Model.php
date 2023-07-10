<?php

class Devices_Model extends CI_Model
{
    //TODO: add logic to use history tables
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
        $this->db->where("mastid", $mast_data["mastid"]);
        $q = $this->db->get("tbl_masts");

        if ($q->num_rows() > 0) {
            $this->db->where("mastid", $mast_data["mastid"]);
            $this->db->update("tbl_masts", $mast_data);

            return true;
        } else {
            $this->db->insert("tbl_masts", $mast_data);

            return true;
        }
    }

    public function deleteMast($mast_data)
    {
        $this->db->where("mastid", $mast_data["mastid"]);
        $this->db->delete("tbl_masts");
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
        // $this->db->select(
        //     "deviceid, device_name, mastid, ip_address, connection_status, wireless_mode, connected_from"
        // );
        // $query = $this->db->get("tbl_devices");
        // return $query;
        return $this->db->get("tbl_devices");
    }
    public function getAllDevices2()
    {
       
        
    }

    public function insertDeviceData($device_data)
    {
        $this->db->select("deviceid", "device_name", "mastid", "ip_address", "wireless_mode", "connected_from", "dateCreated");
        $this->db->where("deviceid", $device_data["deviceid"]);
        $query = $this->db->get("tbl_devices");
        
        if ($query->num_rows() > 0) {
            $this->db->where("deviceid", $device_data["deviceid"]);
            $this->db->update("tbl_devices", $device_data);
            return true;
        } else {
            $this->db->insert("tbl_devices", $device_data);
            return true;
        }
    }

    public function editDeviceData($device_data)
    {
        $this->db->select("deviceid", "device_name", "mastid", "ip_address", "wireless_mode", "connected_from");
        $this->db->where("deviceid", $device_data["deviceid"]);
        $query = $this->db->get("tbl_devices");
        
        if ($query->num_rows() > 0) {
            $this->db->where("deviceid", $device_data["deviceid"]);
            $this->db->update("tbl_devices", $device_data);
            return true;
        } else {
            $this->db->insert("tbl_devices", $device_data);
            return true;
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
        $this->db->where("deviceid", $device_data["device_id"]);
        $this->db->delete("tbl_devices");
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
