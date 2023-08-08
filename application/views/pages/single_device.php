<div class="pagetitle">
  <h1 id="ipaddress"><?php echo $ip_address;?></h1>
  <nav>
    <ol class="breadcrumb">
      <li class="breadcrumb-item">
        <a href=<?php echo base_url("home")?>">Home</a>
      </li>
      <li class="breadcrumb-item">
        <a href="<?php echo base_url("devices")?>">Devices</a>; 
      </li>
      <li class="breadcrumb-item active">
        <a href="#">Device</a>
      </li>
    </ol>
  </nav>
</div>
<section class="section">
  <div class="row">
    <div class="col-lg-7">
      <div class="card">
        <div class="card-body">
          <!-- List group with active and disabled items -->
          <ul class="list-group list-group-flush">
          <?php if($mastid==='Client'):?>
            <li class="list-group-item"><strong>Client</strong>
            </li>
            <?php else:?>
            <li class="list-group-item">Mast: <strong><?php echo $mastid;?></strong>
            </li>
            <?php endif;?>
            <?php if($wireless_mode==='AP'):?>
            <li class="list-group-item">Connections: <span id="connections"></span>
            </li>
            <?php endif;?>
            <li class="list-group-item">Noise Floor: <span id="noiseFloor"></span> dBm </li>
            <li class="list-group-item">CCQ: <span id="ccq"></span> % </li>
            <li class="list-group-item">airMAX Quality <div class="progress">
                <div id="airmaxQualityProgressBar" class="progress-bar" role="progressbar" aria-valuemin="0" aria-valuemax="100"><strong><span id=airmaxqualityvalue></span>%</strong></div>
              </div>
            </li>
            <li class="list-group-item">airMAX Capacity <div class="progress">
                <div id="airmaxCapacityProgressBar" class="progress-bar" role="progressbar" aria-valuemin="0" aria-valuemax="100"><strong><span id=airmaxcapacityvalue></span>%</strong></div>
              </div>
            </li>
            <li class="list-group-item">Antenna: <strong><span id="RadioAntenna"></span></strong></li>
            <li class="list-group-item">LAN: <strong><span id="lan"></span></strong></li>
          </ul>
          <!-- End Clean list group -->
        </div>
      </div>
    </div>
    <div class="col-lg-3 offset-md-1">
      <div class="card text-center">
        <div class="card-header">
          <ul class="nav nav-pills card-header-pills">
            <li class="nav-item" style="margin-left: 25px;">
              <h5>Connection Status:</h5>
            </li>
            <li class="nav-item" style="margin-left: 3px;">
              <span class="badge rounded-pill" id="connectionStatusBadge"></span>
            </li>
          </ul>
        </div>
        <div class="card-body">
          <h5 class="card-title" style="font-size: 14px; padding-top: 5px; padding-bottom: 5px;">Device Model: <strong><?php echo $device_model;?></strong>
          </h5>
          <p class="card-text">
            <img src="<?php echo base_url('assets\img\airmax_devices\LBE-M5-23.png'); ?>" class="img-fluid rounded-start" alt="...">
          </p>
          <a href="http://<?php echo $ip_address; ?>" target="_blank" class="btn btn-primary">Login </a>
          <div style="margin-top:10px">
          <button id="update_button" class="btn btn-primary" type="button">Update</button>
          </div>
        </div>
      </div>
      
    </div>
    <div class="row">
      <div class="col-lg-6">
        <div class="card">
          <div class="card-body">
            <!-- List group with active and disabled items -->
            <ul class="list-group list-group-flush">
              <li class="list-group-item">SSID: <strong><span id="ssid"></span></strong></li>
              <li class="list-group-item">Signal: <strong><span id="signal"></span></strong></li>
              <li class="list-group-item">Channel/Frequency: <strong><span id="ChannelCode"></span>/<span id="channelFrequency"></span> MHz </strong></li>
              <li class="list-group-item">Channel Width: <strong><span id="channelWidth"></span> MHz </strong></li>
              <!-- <li class="list-group-item">Frequency Band: <span id="frequencyBand"></span> MHz </li> -->
              <li class="list-group-item">TX Power: <strong><span id="txPower"></span> dBm</strong></li>
            </ul>
            <!-- End Clean list group -->
          </div>
        </div>
      </div>
      <div class="col-lg-6">
        <div class="card">
          <div class="card-body">
            <!-- List group with active and disabled items -->
            <ul class="list-group list-group-flush">
            <li class="list-group-item">Device Name: <strong><?php echo $device_name;?></strong>
            </li>
            <li class="list-group-item">Radio Mode: <strong><?php echo $wireless_mode;?></strong>
            </li>
            <li class="list-group-item">Firmware Version: <strong><?php echo $firmware_version;?></strong>
            </li>
            <li class="list-group-item">Uptime: <strong><span id="uptime"></span></strong>
            </li>
            <li class="list-group-item">MAC: <strong><?php echo $mac;?></strong>
            </li>
            </ul>
            <!-- End Clean list group -->
          </div>
        </div>
      </div>
    </div>
  </div>
</section>