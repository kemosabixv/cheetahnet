
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
        $this->db->select('station_count, date_created');
        $this->db->from('tbl_device_count_history');
        $this->db->order_by('date_created', 'DESC');
        $station_history = $this->db->get();
        
        $station_current_count = 0;
        $wireless_mode = 'Station';
        $this->db->select('wireless_mode');
        $this->db->from('tbl_devices');
        $this->db->where('wireless_mode', $wireless_mode);
        $query = $this->db->get();
        $station_current_count = $query->num_rows();
    
        $data = [
            "station_history" => [],
            "current_station_count" => []
        ];
        
        foreach ($station_history->result() as $row) {
            $sub_array = [];
            $sub_array['station_count'] = $row->station_count;
            $sub_array['date_created'] = $row->date_created;
            $data['station_history'][] = $sub_array;
        }
        $data['current_station_count'][] =
        ['station_count' => $station_current_count]
        ;
        return $data;
    }
    

    public function getallAPs()
    {
        $this->db->select('ap_count, date_created');
        $this->db->from('tbl_device_count_history');
        $this->db->order_by('date_created', 'DESC');
        $ap_history = $this->db->get();
        
        $ap_current_count = 0;
        $wireless_mode = 'AP';
        $this->db->select('wireless_mode');
        $this->db->from('tbl_devices');
        $this->db->where('wireless_mode', $wireless_mode);
        $query = $this->db->get();
        $ap_current_count = $query->num_rows();
    
        $data = [
            "ap_history" => [],
            "current_ap_count" => []
        ];
        
        foreach ($ap_history->result() as $row) {
            $sub_array = [];
            $sub_array['ap_count'] = $row->ap_count;
            $sub_array['date_created'] = $row->date_created;
            $data['ap_history'][] = $sub_array;
        }
        $data['current_ap_count'][] =
        ['ap_count' => $ap_current_count]
        ;
        return $data;
    }

    public function getalldevices()
    {
        $this->db->select('total_count, date_created');
        $this->db->from('tbl_device_count_history');
        $this->db->order_by('date_created', 'DESC');
        $total_count_history = $this->db->get();
        
        $total_current_count = 0;
        $query = $this->db->get('tbl_devices');
        $total_current_count = $query->num_rows();

        $data = [
            "total_count_history" => [],
            "total_current_count" => []
        ];
        
        foreach ($total_count_history->result() as $row) {
            $sub_array = [];
            $sub_array['total_count'] = $row->total_count;
            $sub_array['date_created'] = $row->date_created;
            $data['total_count_history'][] = $sub_array;
        }
        $data['total_current_count'][] =
        ['total_count' => $total_current_count]
        ;
        return $data;
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
    public function get_connection_status_history()
    {
        $this->db->from("tbl_connection_status_history");
        $this->db->order_by("date_created", "DESC");
        $this->db->limit(46);
        $query = $this->db->get();
        $data = [];

        foreach($query->result() as $row){
            $sub_array = [];
            $sub_array["offline_count"] = $row->offline_count;
            $sub_array["online_count"] = $row->online_count;
            $sub_array["date_created"] = $row->date_created;
            // $sub_array["id"] = $row->id;
            $data[] = $sub_array;
        }

        $output = [
            "data" => $data,
        ];

        header("Content-Type: application/json");
        return $output;
    }
}
