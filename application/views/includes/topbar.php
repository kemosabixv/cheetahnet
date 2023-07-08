  <!-- ======= Header ======= -->
  <header id="header" class="header fixed-top d-flex align-items-center">
    <div class="d-flex align-items-center justify-content-between">
      <a href="home" class="logo d-flex align-items-center">
        <img src="
				<?php echo base_url('assets/img/logo.png'); ?>" alt="">
        <span class="d-none d-lg-block">Cheetahnet BM</span>
      </a>
      <i class="bi bi-list toggle-sidebar-btn"></i>
    </div>
    <!-- End Logo -->
    <nav class="header-nav ms-auto">
      <ul class="d-flex align-items-center">
        <li class="nav-item dropdown">
          <a class="nav-link nav-icon" href="#" data-bs-toggle="dropdown">
            <i class="bi bi-bell"></i>
            <span id='notification_count_1' class="badge bg-primary badge-number"></span>
          </a>
          <!-- End Notification Icon -->
          <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow notifications">
            <li class="dropdown-header"> You have <span id='notification_count_2'></span> new notifications <a href="
								<?php echo base_url('notifications'); ?>">
                <span class="badge rounded-pill bg-primary p-2 ms-2">View all</span>
              </a>
            </li>
            <span id="notificationlist"></span>
          </ul>
          <!-- End Notification Dropdown Items -->
        </li>
        <li class="nav-item dropdown pe-3">
          <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
            <span class="d-none d-md-block dropdown-toggle ps-2"> <?php
              $full_names = $this->session->userdata('full_names');
              echo $full_names;
              ?> </span>
          </a>
          <!-- End Profile Iamge Icon -->
          <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
            <li class="dropdown-header">
              <h6> <?php
              $full_names = $this->session->userdata('full_names');
              echo $full_names;
              ?> </h6>
              <span> <?php
              $role = $this->session->userdata('level_name');
              echo $role;
              ?> </span>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>
            <li>
              <a class="dropdown-item d-flex align-items-center" href="
									<?php echo base_url('account'); ?>">
                <i class="bi bi-gear"></i>
                <span>Account Settings</span>
              </a>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>
            <li>
              <a class="dropdown-item d-flex align-items-center" href="
										<?php echo base_url('signout'); ?>">
                <i class="bi bi-box-arrow-right"></i>
                <span>Sign Out</span>
              </a>
            </li>
          </ul>
          <!-- End Profile Dropdown Items -->
        </li>
        <!-- End Profile Nav -->
      </ul>
    </nav>
    <!-- End Icons Navigation -->
  </header>
  <!-- End Header -->