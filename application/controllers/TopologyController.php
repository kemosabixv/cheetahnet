<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class TopologyController extends CI_Controller {


public function __construct()
{
    parent::__construct();
    if($this->session->userdata('logged_in') !== TRUE){
      redirect('welcome');
    }
    $this->load->model('Devices_Model','devices_model');
    $this->load->model('Topology_Model','topology_model');
    
}






public function index(){
    $page = 'topology';
        $this->load->view('includes/header');
        $this->load->view('includes/topbar');
        $this->load->view('includes/sidebar');
        $this->load->view('pages/'.$page);
        $this->load->view('includes/footer');
        $this->load->view('includes/js/topology_script');
        
    }


    public function getTopology(){

        $masts  = $this->topology_model->getAllMasts();
        
    
        $topologyData = [
            "nodes" => [],
            "links" => [],
            
        ];
    
    
         foreach ($masts as $mast => $value) {
    
            array_push($topologyData["nodes"], [
    
                "id" => (int)$mast,
                "name" => $value->mast_name." (".$value->connection_via.")",
                "color" =>  $this->getMastDevices($value->mastid)
            ]);
    
    
            array_push($topologyData["links"], [
                "source" => (int)$value->connected_from-1,
                "target" => (int)$mast,
                "color" => ($value->connection_via === "Fibre") ? "#f32121" : "#2196f3"
            ]);
           
    
        }

        
    
    
        header('Content-Type: application/json');
        echo json_encode($topologyData);
    
    }

    public function getMastDevices($mastID){

        $mastdevices  = $this->devices_model->getMastDevices($mastID);

        $statuses = array();
        foreach ($mastdevices as $device) {
            $statuses[] = $device;
        }
    
        $unique_statuses = array_unique($statuses);
        $num_unique_statuses = count($unique_statuses);
    
        if ($num_unique_statuses == 1 && $unique_statuses[0] == 'Online') {
            // All devices are online
            return '#00ff00'; // Green RGB code
        } elseif ($num_unique_statuses == 1 && $unique_statuses[0] == 'Offline') {
            // All devices are offline
            return '#ff0000'; // Red RGB code
        } else {
            // Some devices are offline
            return '#FFA500'; // Yellow RGB code
        }
    }
    
    
        

}