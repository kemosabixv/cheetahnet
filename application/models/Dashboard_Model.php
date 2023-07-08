
<?php class Dashboard_Model extends CI_Model
{
    public function getmastdevicescount()
    {
        $this->db->select("mastid, mast_name");
        $this->db->from("tbl_masts");
        $query = $this->db->get();
        // echo json_encode($query->result());
        $data = []; // Initialize the data array outside the loop
        foreach ($query->result() as $r) {
            $mastid = $r->mastid;
            $mast_name = $r->mast_name;
            $this->db->from("tbl_devices");
            $this->db->where("mastid", $mastid);
            $query = $this->db->get();
            $data[] = [
                "mast_name" => $mast_name,
                "count" => $query->num_rows(),
            ];
        }

        return $data;
    }
    public function getallstations()
    {
        $wireless_mode = "Station";
        $this->db->where("wireless_mode", $wireless_mode);
        $this->db->from("tbl_devices");
        $query = $this->db->get();
        $total = $query->num_rows();
        return $total;
    }

    public function getallAPs()
    {
        $wireless_mode = "AP";
        $this->db->where("wireless_mode", $wireless_mode);
        $this->db->from("tbl_devices");
        $query = $this->db->get();
        $total = $query->num_rows();
        return $total;
    }

    public function getalldevices()
    {
        $this->db->from("tbl_devices");
        $query = $this->db->get();
        $total = $query->num_rows();
        return $total;
    }

    public function get_recent_disconnections()
    {
        $connection_status = "Offline";
        $this->db->select("*");
        $this->db->from("tbl_notifications");
        $this->db->where("connection_status", $connection_status);
        $this->db->order_by("date_created", "DESC");
        $query = $this->db->get();
        $result = $query->result();
        return $result;
    }

    public function get_current_connection_status($device_name)
    {
        $this->db->select("connection_status");
        $this->db->from("tbl_devices");
        $this->db->where("device_name", $device_name);
        $query = $this->db->get();
        $result = $query->result();
        return $result;
    }

    public function get_connections_per_ap()
    {
        $wireless_mode = "AP";
        $this->db->select("deviceid, device_name,ip_address, model_short");
        $this->db->from("tbl_devices");
        $this->db->where("wireless_mode", $wireless_mode);
        $devices = $this->db->get();
        foreach ($devices->result() as $row) {
            $sub_array = [];
            $sub_array["img"] = null;
            $sub_array["device_name"] = $row->device_name;
            $sub_array["ipaddress"] = $row->ip_address;
            $sub_array["model"] = $row->model_short;
            $sub_array["connection_count"] = $this->get_AP_connection_count(
                $row->deviceid
            );
            $data[] = $sub_array;
        }
        $output = [
            "data" => $data,
        ];

        return $output;
    }

    public function get_AP_connection_count($deviceid)
    {
        $this->db->select("connected_from");
        $this->db->from("tbl_devices");
        $this->db->where("connected_from", $deviceid);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->num_rows();
        } else {
            return 0;
        }
    }

    public function get_recent_activity_items()
    {
        $this->db->select("device_name, operation, timestamp");
        $this->db->from("tbl_devices_history");
        $this->db->order_by("timestamp", "DESC");
        $this->db->limit(5);
        $devicesquery = $this->db->get();
        $this->db->select("mast_name, operation, timestamp");
        $this->db->from("tbl_masts_history");
        $this->db->order_by("timestamp", "DESC");
        $this->db->limit(5);
        $mastsquery = $this->db->get();
        $data = [];
        foreach ($devicesquery->result() as $row) {
            $sub_array = [];
            $sub_array["type"] = "Device";
            $sub_array["device_name"] = $row->device_name;
            $sub_array["operation"] = $row->operation;
            $sub_array["timestamp"] = $row->timestamp;
            $data[] = $sub_array;
        }
        foreach ($mastsquery->result() as $row) {
            $sub_array = [];
            $sub_array["type"] = "Mast";
            $sub_array["mast_name"] = $row->mast_name;
            $sub_array["operation"] = $row->operation;
            $sub_array["timestamp"] = $row->timestamp;
            $data[] = $sub_array;
        }
        //order data by timestamp
        usort($data, function ($a, $b) {
            return $b["timestamp"] <=> $a["timestamp"];
        });

        $output = [
            "data" => $data,
        ];

        header("Content-Type: application/json");
        // var_dump($output);
        echo json_encode($output);
    }
}
