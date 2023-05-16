<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class SidebarController extends CI_Controller {





public function monitor_status()
    {
        $url = "http://localhost:8080/cheetahnet-api/rpc/pingstatus";
        $data = file_get_contents($url);
        $is_running = json_decode($data, true)['isrunning'];
        return $is_running ? 'on' : 'off';
    }

        


    public function monitor_on($phoneNumber) 
    { 
        $phone_number = $this->session->userdata('phone');
        // Construct the URL with the phone number parameter
        $url = "http://localhost:8080/cheetahnet-api/rpc/start-ping/{$phoneNumber}";
    
        // Use cURL to make a GET request to the URL
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, false);
        $response = curl_exec($ch);
        curl_close($ch);
    
        // No need to return anything, the success callback in the AJAX request will be triggered
    }
        
        public function monitor_off() 
    {
        // Construct the URL to stop the ping
        $url = "http://localhost:8080/cheetahnet-api/rpc/stop-ping";
    
        // Use cURL to make a GET request to the URL
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, false);
        $response = curl_exec($ch);
        curl_close($ch);
    
        // No need to return anything, the success callback in the AJAX request will be triggered
        
    }


}

