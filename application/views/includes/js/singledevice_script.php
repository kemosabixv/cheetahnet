<script>
  
  $(document).ready(function() {
  var ip = document.getElementById("ipaddress").textContent;
  console.log(ip); 
  var ChanWidth;
  var Frequency; 
  var ssid;
  var RadioTxPower; 
  var RadioAntenna; 
  var ChannelCode; 
  
  var ccq;
  var uptime;
  var airmaxquality;
  var stationcount;
  var signal;
  var airmaxcapacity;



    // AJAX request for snmpgetruntimedevicedata data
  $.ajax({
         url: "<?php echo base_url('snmpgetruntimedevicedata') ?>/" + ip,
          type: 'POST',
          
          cache: false,

          success: function (data) {
            if (data[0] != null){
              console.log(data[0]);
              ChanWidth = data[0].ChanWidth;
              Frequency = data[0].Frequency;
              ssid = data[0].SSID;
              RadioTxPower = data[0].RadioTxPower;
              RadioAntenna = data[0].RadioAntenna;
              ChannelCode = data[0].ChannelCode;
              lan = data[0].lan;
              console.log("SSID: " + ssid);
              console.log("Channel Frequency: " + Frequency);
              console.log("Channel Width: " + ChanWidth);
              console.log("TX Power: " + RadioTxPower);
              console.log("Channel Code: " + ChannelCode);
              console.log("Radio Antenna: " + RadioAntenna);
              console.log("lan: " + lan);


              $('#ssid').text(ssid);
              $('#channelFrequency').text(Frequency);
              $('#channelWidth').text(ChanWidth);
              $('#txPower').text(RadioTxPower);
              $('#ChannelCode').text(ChannelCode);
              $('#RadioAntenna').text(RadioAntenna);
              $('#lan').text(lan);



            }else{
            $('#ssid').text("-");
            $('#channelFrequency').text("-");
            $('#channelWidth').text("-");
            $('#txPower').text("-");
            $('#ChannelCode').text("-");
            $('#RadioAntenna').text("-");
            $('#lan').text("-");
            }
          }
        });


    // AJAX request for connection status
    setInterval(() => {
    $.ajax({
          url: "<?php echo base_url('getconnectionstatus')?>/" + ip,
          type: 'POST',
          success: function (data) {
            console.log(data);
            var connectionStatus = data.connection_status;
            $('#connectionStatusBadge').empty();
            $('#connectionStatusBadge').removeClass('bg-success');
            $('#connectionStatusBadge').removeClass('bg-danger');
            
            if (connectionStatus === 'Online') {
              $('#connectionStatusBadge').addClass('bg-success');
              $('#connectionStatusBadge').append('<h7>Online</h7>');
            }
            else {
              $('#connectionStatusBadge').addClass('bg-danger');
              $('#connectionStatusBadge').append('<h7>Offline</h7>');
            }
            
          }
        });
      }, interval = 5000);
    
   // AJAX request for snmpgetrecurringdevicedata data 

   setInterval(() => {
    $.ajax({
         url: "<?php echo base_url('snmpgetrecurringdevicedata') ?>/" + ip,
          type: 'POST',
          
          cache: false,

          success: function (data) {
            if (data[0] != null){
              console.log(data[0]);
              ccq = data[0].CCQ;
              uptime = data[0].SysUptime;
              airmaxquality = data[0].AirMaxQuality;
              stationcount = data[0].StationCount;
              signal = data[0].signal;
              airmaxcapacity = data[0].AirMaxCapacity;
              console.log("CCQ: " + ccq);
              console.log("SysUptime: " + uptime);
              console.log("AirMaxQuality: " + airmaxquality);
              console.log("StationCount: " + stationcount);
              console.log("Signal: " + signal);
              console.log("AirMaxCapacity: " + airmaxcapacity);
              
              $('#signal').text(signal);
              $('#ccq').text(ccq);
              $('#uptime').text(uptime);
              $('#connections').text(stationcount);
              $('#airmaxQualityProgressBar').attr('aria-valuenow', airmaxquality);
              $('#airmaxQualityProgressBar').css('width', airmaxquality + '%');
              $('#airmaxqualityvalue').text(airmaxquality);
              $('#airmaxCapacityProgressBar').attr('aria-valuenow', airmaxcapacity);
              $('#airmaxCapacityProgressBar').css('width', airmaxcapacity + '%');
              $('#airmaxcapacityvalue').text(airmaxcapacity);    
            }else{
              console.log("no response");
              $('#signal').text("-");
              $('#ccq').text("-");
              $('#uptime').text("-");
              $('#connections').text("-");
              $('#airmaxQualityProgressBar').attr('aria-valuenow', 0);
              $('#airmaxQualityProgressBar').css('width', 0 + '%');
              $('#airmaxqualityvalue').text(0);
              $('#airmaxCapacityProgressBar').attr('aria-valuenow', 0);
              $('#airmaxCapacityProgressBar').css('width', 0 + '%');
              $('#airmaxcapacityvalue').text(0)
            }
          }
        });
   }, interval = 5000);

   //update button
   $("#update_button").on('click', function() {
    showLoadingSweetAlert("Updating Device...");
    $.ajax({
      url: "<?php echo base_url('update_device')?>/" + ip,
      type: 'POST',
      success: function (data) {
        console.log(data);
        if (data.error === 0) {
          swal.close();
          showResultSweetAlert(data.message, "<?php echo base_url();?>assets/img/successful_anim.gif");
        } else {
          swal.close();
          showResultSweetAlert(data.message, "<?php echo base_url();?>assets/img/error_anim.gif");
        }
      }
    });
  });
  
  
  
 

  });

    


</script>
