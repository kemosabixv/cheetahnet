<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class DiscoveryController extends CI_Controller {



public function __construct()
{
    parent::__construct();
    if($this->session->userdata('logged_in') !== TRUE){
      redirect('welcome');
    }
    $this->load->model('Discovery_Model','discovery_model');
    
    
   
}

public function index(){

    $interfaces = $this->discovery_model->get_interface();
    $pagedata['interfaces'] = $interfaces;
    $page = 'discovery';
    
    $this->load->view('includes/header');
    $this->load->view('includes/topbar');
    $this->load->view('includes/sidebar');
    $this->load->view('pages/'.$page,$pagedata); 
    $this->load->view('includes/footer');
    $this->load->view('includes/js/discovery_script');
        
}


public function addinterface()
{
  $interface_data['id'] = 1;
  $interface_data['interfacename'] = $this->input->post('interface_name', TRUE);

  // Call the model to insert the interface data
  $result = $this->discovery_model->insertInterfaceData($interface_data);

  // Prepare the response data
  $response = array();
  if ($result) {
    $response['error'] = 0;
    $response['message'] = "Interface data inserted successfully";
  } else {
    $response['error'] = 1;
    $response['message'] = "Failed to insert interface data";
  }

  // Send the response as JSON
  header('Content-Type: application/json');
  echo json_encode($response);
}





}