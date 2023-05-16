<?php
defined('BASEPATH') OR exit('No direct script access allowed');




class SidebarController extends CI_Controller {
    
    
    public function monitor_status()
    {
        $url = "http://localhost:8080/cheetahnet-api/rpc/ping-status";
    
        // Initialize cURL
        $ch = curl_init($url);
    
        // Set cURL options
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    
        // Execute the cURL request
        $response = curl_exec($ch);
    
        // Close the cURL session
        curl_close($ch);
    
        // Output the raw response
        
    
        // Decode the JSON response into an object
        $data = json_decode($response, true);
        
        $is_running = var_export($data['isRunning']);
        
        
    
        // Return the value of $is_running
        return $is_running;
    }
    

    
    




    public function monitor_on() { 
    $phone_number = $this->session->userdata('uphone');
    // Construct the URL with the phone number parameter
    $url = "http://localhost:8080/cheetahnet-api/rpc/start-ping/$phone_number";

    // Use cURL to make a GET request to the URL
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HEADER, false);
    $response = curl_exec($ch);
    curl_close($ch);

    
    echo $response;
    return $response;
    }

        
    public function monitor_off() {
    // Construct the URL to stop the ping
    $url = "http://localhost:8080/cheetahnet-api/rpc/stop-ping";

    // Use cURL to make a GET request to the URL
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HEADER, false);
    $response = curl_exec($ch);
    curl_close($ch);
    echo $response;
    return $response;
    }


}

