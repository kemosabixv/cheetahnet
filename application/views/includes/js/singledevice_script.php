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
              console.log("SSID: " + ssid);
              console.log("Channel Frequency: " + Frequency);
              console.log("Channel Width: " + ChanWidth);
              console.log("TX Power: " + RadioTxPower);
              console.log("Channel Code: " + ChannelCode);
              console.log("Radio Antenna: " + RadioAntenna);

              $('#ssid').text(ssid);
              $('#channelFrequency').text(Frequency);
              $('#channelWidth').text(ChanWidth);
              $('#txPower').text(RadioTxPower);
              $('#ChannelCode').text(ChannelCode);
              $('#RadioAntenna').text(RadioAntenna);
            }else{
              console.log("success");
            $('#ssid').text("-");
            $('#channelFrequency').text("-");
            $('#channelWidth').text("-");
            $('#txPower').text("-");
            $('#ChannelCode').text("-");
            $('#RadioAntenna').text("-");
            $
            }
          }
        });


    // AJAX request for connection status
    $.ajax({
          url: "<?php echo base_url('getconnectionstatus')?>/" + ip,
          type: 'POST',
          success: function (data) {
            console.log(data);
            var connectionStatus = data.connection_status;
            var $connectionStatusElement = $('<li class="nav-item" style="margin-left: 3px;"></li>');
            var $badgeElement = $('<span class="badge rounded-pill"></span>');
            if (connectionStatus === 'online') {
              $badgeElement.addClass('bg-success');
              $badgeElement.append('<h7>Online</h7>');
            }
            else {
              $badgeElement.addClass('bg-danger');
              $badgeElement.append('<h7>Offline</h7>');
            }
            $connectionStatusElement.append($badgeElement);
            $('.nav.nav-pills.card-header-pills').append($connectionStatusElement);
          }
        });
    
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


      
  //   // Assuming throughputData is the variable containing the data from element0
  //   // WLAN0 Chart
  //   new Chart(document.querySelector('#wlan0Chart'), {
  //     type: 'line',
  //     data: {
  //       labels: [],
  //       datasets: [
  //         {
  //           label: 'WLAN0 RX',
  //           data: throughputData['throughput WLAN0 RX'],
  //           fill: false,
  //           borderColor: 'rgb(75, 192, 192)',
  //           tension: 0.1
  //     },
  //         {
  //           label: 'WLAN0 TX',
  //           data: throughputData['throughput WLAN0 TX'],
  //           fill: false,
  //           borderColor: 'rgb(192, 75, 192)',
  //           tension: 0.1
  //     }
  //   ]
  //     },
  //     options: {
  //       scales: {
  //         y: {
  //           beginAtZero: true,
  //           suggestedMax: Math.max(...throughputData['throughput WLAN0 RX'], ...throughputData['throughput WLAN0 TX']),
  //           ticks: {
  //             callback: function (value, index, values) {
  //               return formatDataSize(value); // Call a function to format the data size dynamically
  //             }
  //           }
  //         }
  //       }
  //     }
  //   });
  //   // LAN0 Chart
  //   new Chart(document.querySelector('#lan0Chart'), {
  //     type: 'line',
  //     data: {
  //       labels: [],
  //       datasets: [
  //         {
  //           label: 'LAN0 RX',
  //           data: throughputData['throughput LAN0 RX'],
  //           fill: false,
  //           borderColor: 'rgb(75, 192, 75)',
  //           tension: 0.1
  //     },
  //         {
  //           label: 'LAN0 TX',
  //           data: throughputData['throughput LAN0 TX'],
  //           fill: false,
  //           borderColor: 'rgb(192, 75, 75)',
  //           tension: 0.1
  //     }
  //   ]
  //     },
  //     options: {
  //       scales: {
  //         y: {
  //           beginAtZero: true,
  //           suggestedMax: Math.max(...throughputData['throughput LAN0 RX'], ...throughputData['throughput LAN0 TX']),
  //           ticks: {
  //             callback: function (value, index, values) {
  //               return formatDataSize(value); // Call a function to format the data size dynamically
  //             }
  //           }
  //         }
  //       }
  //     }
  //   });

  //  });


  //   // Function to format data size dynamically
  //   function formatDataSize(value) {
  //     if (value >= 1e9) {
  //       return (value / 1e9).toFixed(2) + ' Gbps';
  //     }
  //     else if (value >= 1e6) {
  //       return (value / 1e6).toFixed(2) + ' Mbps';
  //     }
  //     else if (value >= 1e3) {
  //       return (value / 1e3).toFixed(2) + ' Kbps';
  //     }
  //     else {
  //       return value.toFixed(2) + ' Bps';
  //     }
  //  }

  });

    


</script>
