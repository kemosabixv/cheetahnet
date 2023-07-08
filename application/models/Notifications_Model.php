<?php

class Notifications_Model extends CI_Model
{
    public function storeNotification($notificationdata)
    {
        $this->db->insert("tbl_notifications", $notificationdata);
    }
    public function get_all_client_notifications($client)
    {
        $this->db->select(
            "id,device_name, model_short, ip_address, connection_status, date_created"
        );
        $this->db->from("tbl_notifications");
        $this->db->where("mastid", $client);
        $this->db->order_by("date_created", "DESC");
        $query = $this->db->get();
        $result = $query->result();
        return $result;
    }
    public function get_all_nonclient_notifications($client)
    {
        $this->db->select(
            "id, device_name, model_short, ip_address, connection_status, date_created, seen"
        );
        $this->db->from("tbl_notifications");
        $this->db->where("mastid !=", $client); // Use "!=" operator to exclude rows with mastid equal to $client
        $this->db->order_by("date_created", "DESC");
        $query = $this->db->get();
        $result = $query->result();
        return $result;
    }
    public function get_notifications_list($client)
    {
        $this->db->select("*");
        $this->db->from("tbl_notifications");
        $this->db->where("seen", 0);
        $this->db->where("mastid !=", $client);
        $this->db->order_by("date_created", "DESC");
        $this->db->limit(5);
        $query = $this->db->get();
        $result = $query->result();
        return $result;
    }
}
