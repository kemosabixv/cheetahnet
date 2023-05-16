
  <!-- ======= Sidebar ======= -->
  <aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">





       <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#icons-nav" data-bs-toggle="collapse" href="masts">
          <i class="bx bx-traffic-cone"></i><span>Masts</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="icons-nav" class="nav-content cosllapse " data-bs-parent="#sidebar-nav">
          <li>
            <a href="masts">
              <i class="bi bi-circle"></i><span>All Masts</span>
            </a>
          </li>
          <li>
            <a href="mastdevices">
              <i class="bi bi-circle"></i><span>Mast Devices</span>
            </a>
          </li>
          
        </ul>
      </li>

      <!-- End Icons Nav -->





      <li class="nav-item">
        <a class="nav-link collapsed" href="devices">
          <i class="ri-radar-line"></i>
          <span>Devices</span>
        </a>
      </li><!-- End F.A.Q Page Nav -->

      <li class="nav-item">
        <a class="nav-link collapsed" href="topology">
          <i class="bi bi-asterisk"></i>
          <span>Topology</span>
        </a>
      </li><!-- End Contact Page Nav -->

      <?php if($this->session->userdata('level')==='1'):?>
      <li class="nav-item">
        <a class="nav-link collapsed" href="users">
          <i class="ri-account-box-fill"></i>
          <span>Users</span>
        </a>
      </li><!-- End Contact Page Nav -->
     <?php endif;?>

     <li class="nav-item">
        <a class="nav-link collapsed" href="discovery">
          <i class="bi bi-asterisk"></i>
          <span>Discovery</span>
        </a>
      </li><!-- End Contact Page Nav -->

      <li class="nav-item">
      <a class="nav-link collapsed" href="#">
          <i class="ri-radar-line"></i>
          <span>Monitor:</span><span id="monitor-status"></span>
        </a>
        <button id="monitor-on" type="button" class="btn btn-success rounded-pill" >ON</button>
        <button id="monitor-off" type="button" class="btn btn-danger rounded-pill" >OFF</button>

      </li>
    <!-- End Contact Page Nav -->

      
     
    </ul>

  </aside><!-- End Sidebar-->
  <main id="main" class="main">