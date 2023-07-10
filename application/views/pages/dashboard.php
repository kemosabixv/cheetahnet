<div class="pagetitle">
  <h1>Dashboard</h1>
  <nav>
    <ol class="breadcrumb">
      <li class="breadcrumb-item active">Home</li>
    </ol>
  </nav>
</div>
<!-- End Page Title -->
<section class="section dashboard">
  <div class="row">
    <!-- Left side columns -->
    <div class="col-lg-8">
      <div class="row">
        <!-- Stations Card -->
        <div class="col-xxl-4 col-md-6">
          <div class="card info-card stations-card">
            <div class="filter">
              <a class="icon" href="#" data-bs-toggle="dropdown">
                <i class="bi bi-three-dots"></i>
              </a>
              <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                <li class="dropdown-header text-start">
                  <h6>Filter</h6>
                </li>
                <li>
                <a id="stations_filter_today" class="dropdown-item" href="#">Today</a>
                </li>
                <li>
                <a id="stations_filter_yesterday" class="dropdown-item" href="#">Yesterday</a>
                </li>
                <li>
                <a id="stations_filter_lastweek" class="dropdown-item" href="#">Last Week</a>
                </li>
                <li>
                <a id="stations_filter_lastmonth" class="dropdown-item" href="#">Last Month</a>
                </li>
                <li>
                <a id="stations_filter_lastyear" class="dropdown-item" href="#">Last Year</a>
                </li>
              </ul>
            </div>
            <div class="card-body">
              <h5 class="card-title">Stations <span id='stations_filter_display'>| Today</span>
              </h5>
              <div class="d-flex align-items-center">
                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                  <i class="ri-base-station-fill"></i>
                </div>
                <div class="ps-3">
                  <h6 id='stations_current'></h6>
                  <span id='stations_difference'>
                  </span>
                  <span id='stations_difference_type'></span>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- End Stations Card -->
        <!-- Access Points Card -->
        <div class="col-xxl-4 col-md-6">
          <div class="card info-card access_points-card">
            <div class="filter">
              <a class="icon" href="#" data-bs-toggle="dropdown">
                <i class="bi bi-three-dots"></i>
              </a>
              <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                <li class="dropdown-header text-start">
                  <h6>Filter</h6>
                </li>
                <li>
                  <a id="aps_filter_today" class="dropdown-item" href="#">Today</a>
                </li>
                <li>
                  <a id="aps_filter_yesterday" class="dropdown-item" href="#">Yesterday</a>
                </li>
                <li>
                <a id="aps_filter_lastweek" class="dropdown-item" href="#">Last Week</a>
                </li>
                <li>
                <a id="aps_filter_lastmonth" class="dropdown-item" href="#">Last Month</a>
                </li>
                <li>
                <a id="aps_filter_lastyear" class="dropdown-item" href="#">Last Year</a>
                </li>
              </ul>
            </div>
            <div class="card-body">
              <h5 class="card-title">AP's <span id='aps_filter_display'>| Today</span>
              </h5>
              <div class="d-flex align-items-center">
                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                  <i class="ri-base-station-line"></i>
                </div>
                <div class="ps-3">
                  <h6 id='aps_current'></h6>
                  <span id='aps_difference'>
                  </span>
                  <span id='aps_difference_type'></span>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- End Access Points Card -->
        <!-- Total Devices Card -->
        <div class="col-xxl-4 col-xl-12">
          <div class="card info-card customers-card">
            <div class="card-body">
              <h5 class="card-title">Total Devices <span id='total_devices_filter_display'>| Today</span>
              </h5>
              <div class="d-flex align-items-center">
                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                  <i class="ri-radar-fill"></i>
                </div>
                <div class="ps-3">
                  <h6 id='total_devices_current'></h6>
                  <span id='total_devices_difference'></span>
                  <span id='total_devices_difference_type'></span>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- Total Devices Card -->
        <!-- Reports -->
        <div class="col-12">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Reports <span>/Today</span>
              </h5>
              <!-- Line Chart -->
              <div id="reportsChart"></div>
              <!-- End Line Chart -->
            </div>
          </div>
        </div>
        <!-- End Reports -->
        <!-- Recent Disconnections -->
        <div class="col-12">
          <div class="card top-selling overflow-auto">
            <div class="filter">
              <a class="icon" href="#" data-bs-toggle="dropdown">
                <i class="bi bi-three-dots"></i>
              </a>
              <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                <li class="dropdown-header text-start">
                  <h6>Filter</h6>
                </li>
                <li>
                  <a id="recent_disconnections_table_filter_today" class="dropdown-item" href="#">Today</a>
                </li>
                <li>
                  <a id="recent_disconnections_table_filter_yesterday" class="dropdown-item" href="#">Yesterday</a>
                </li>
              </ul>
            </div>
            <div class="card-body">
              <h5 class="card-title">Recent Disconnections <span id="recent_disconnections_table_filter"></span>
              </h5>
              <table id="recent_disconnections_table" class="table table-borderless">
                <thead>
                  <tr>
                    <th scope="col">Device Name</th>
                    <th scope="col">Ip Address</th>
                    <th scope="col">Model</th>
                    <th scope="col">Date/Time</th>
                    <th scope="col">Current Status</th>
                  </tr>
                </thead>
                <tbody></tbody>
              </table>
            </div>
          </div>
        </div>
        <!-- End Recent Disconnections -->
        <!-- Connections per AP-->
        <div class="col-12">
          <div class="card top-selling overflow-auto">
            <div class="card-body pb-0">
              <h5 class="card-title">Connections per AP <span>| Today</span>
              </h5>
              <table id="connections_per_ap_table" class="table table-borderless">
                <thead>
                  <tr>
                    <th scope="col"></th>
                    <th scope="col">Device Name</th>
                    <th scope="col">Ip Address</th>
                    <th scope="col">Model</th>
                    <th scope="col">Connections</th>
                  </tr>
                </thead>
                <tbody></tbody>
              </table>
            </div>
          </div>
        </div>
        <!-- End Top Selling -->
      </div>
    </div>
    <!-- End Left side columns -->
    <!-- Right side columns -->
    <div class="col-lg-4">
      <!-- Recent Activity -->
      <div class="card">
        <div class="card-body">
          <h5 class="card-title">Recent Activity</h5>
          <div class="activity" id="recent_activity_items">
            <span id="recent_activity_list"></span>
          </div>
        </div>
      </div>
      <!-- End Recent Activity -->
    </div>
    <!-- End Right side columns -->
    <!-- Mast Group -->
    <div class="card">
      <div class="card-body pb-0">
        <h5 class="card-title">Device Groups</h5>
        <div id="MastGroupChart" style="min-height: 400px;" class="echart"></div>
        <script></script>
      </div>
    </div>
    <!-- End Mast Group -->
  </div>
</section>