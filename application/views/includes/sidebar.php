
  <!-- ======= Sidebar ======= -->
  <aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">

    <li class="nav-item">
        <a class="nav-link collapsed" href="<?php echo base_url("dashboard"); ?>">
          <i class="bi bi-grid"></i>
          <span>Dashboard</span>
        </a>
      </li><!-- End F.A.Q Page Nav -->

      <?php if($this->session->userdata('level')==='1'):?>
      <li class="nav-item">
        <a class="nav-link collapsed" href="<?php echo base_url("users"); ?>">
          <i class="bi bi-person-circle"></i>
          <span>Users</span>
        </a>
      </li>
     <?php endif;?>
     <!-- End Contact Page Nav -->
        
      <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#forms-nav" data-bs-toggle="collapse" href="<?php echo base_url("masts"); ?>" aria-expanded="false">
          <i class="bi bi-cone-striped"></i><span>Masts</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="forms-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
          <li>
            <a href="<?php echo base_url("masts"); ?>">
              <i class="bi bi-circle"></i><span>All Masts</span>
            </a>
          </li>
          <li>
            <a href="<?php echo base_url("mastdevices"); ?>">
              <i class="bi bi-circle"></i><span>Mast Groups</span>
            </a>
          </li>
        </ul>
      </li>
      <!-- End Masts Nav -->

      <li class="nav-item">
        <a class="nav-link collapsed" href="<?php echo base_url("topology"); ?>">
          <i class="bi bi-asterisk"></i>
          <span>Topology</span>
        </a>
      </li><!-- End Topology Page Nav -->





      <li class="nav-item">
        <a class="nav-link collapsed" href="<?php echo base_url("devices"); ?>">
          <i class="ri-radar-line"></i>
          <span>Devices</span>
        </a>
      </li><!-- End Devices Page Nav -->

      

      

     <li class="nav-item">
        <a class="nav-link collapsed" href="<?php echo base_url("discovery"); ?>">
          <i class="bi bi-rainbow"></i>
          <span>Discovery</span>
        </a>
      </li><!-- End Discover Page Nav -->

      <li class="nav-item">
      <a class="nav-link collapsed" href="#">
          <i class="bi bi-bell"></i>
          <span>Monitor:</span>
          <span id="monitor-status" style="margin-left: 5px;">
          </span>
      </a>
      <li style="margin-left: 30px;">
     <button id="monitor-on" type="button" class="btn btn-success rounded-pill">ON</button>
     <button id="monitor-off" type="button" class="btn btn-danger rounded-pill">OFF</button>
    </li>
    <!-- End Monitor Nav -->

      
     
    </ul>

  </aside><!-- End Sidebar-->
  <main id="main" class="main">