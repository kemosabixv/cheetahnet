<div class="pagetitle">
  <h1>Discovery</h1>
  <nav>
    <ol class="breadcrumb">
      <li class="breadcrumb-item">
        <a href="home">Home</a>
      </li>
      <li class="breadcrumb-item active">Discovery</li>
    </ol>
  </nav>
</div>
<!-- End Page Title -->

<div class="row">
  <div class="col-md-6">
    <!-- Add button to trigger the modal dialog -->
    <button id="AddDevicesButton" class="btn btn-primary me-2" type="button">Add Devices</button>
    <button id="clear_table" class="btn btn-primary me-2" type="button">Clear Table</button>
  </div>
  <div class="col-md-6 text-md-end">
    <button id="scan" class="btn btn-primary me-2" type="button">Scan</button>
    <!-- <button id="select_int" class="btn btn-primary" type="button">Select Interface</button> -->
  </div>
</div>

<div class="card">
  <div class="card-body">
    <h5 class="card-title">Scanned Devices</h5>
    <!-- Table with hoverable rows -->
    <table class="table table-hover" id="Discovery_table">
      <thead>
        <tr>
          <!-- <th scope="col">#</th> -->
          <th scope="col">Select</th>
          <th scope="col">Device Name</th>
          <th scope="col">IP address</th>
          <th scope="col">Model</th>
          <th scope="col">Firmware Version</th>
        </tr>
      </thead>
      <tbody></tbody>
    </table>
    <!-- End Table with hoverable rows -->
    <!-- Modal dialog for bulk addition -->
    <div class="modal fade" id="AddDevicesModal">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Add Selected devices</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <!-- No Labels Form -->
            <form class="row g-3" id="AddFromDiscoveryForm" method="POST" action="javascript:void(0)">
              <div class="mb-1">
                <label class="form-label" for="basicSelect">Group to Mast</label>
                <select class="form-select" id="mast_name" name="mast_name"> <?php foreach($all_masts as $each) { ?> <option value="<?php echo $each->mastid; ?>"> <?php echo $each->mast_name;?> </option> <?php } ?> </select>
              </div>
              <div class="mb-1">
                <label class="form-label" for="selectedDevices">Selected Devices</label>
                <table class="table table-dark" id="selectedDevices">
                  <thead>
                    <tr>
                      <th scope="col">Name</th>
                      <th scope="col">IP</th>
                    </tr>
                  </thead>
                  <tbody></tbody>
                </table>
              </div>
              <div class="text-center">
                <button type="submit" class="btn btn-primary">Save</button>
                <button type="reset" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
              </div>
            </form>
            <!-- End No Labels Form -->
          </div>
        </div>
      </div>
    </div>



    <!-- <div class="modal fade" id="InterfaceModal" tabindex="-1">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="InterfaceModalTitle">Add Interface Name</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <!-- No Labels Form -->
            <!-- <form class="row g-3" id="InterfaceForm" method="POST" action="javascript:void(0)">
              <div class="col-12">
                <label for="interface_name" class="form-label">Interface Name</label>
                <input type="text" name="interface_name" id="interface_name" class="form-control" placeholder="Realtek PCIe GbE Family Controller"> `
              </div>
              <div class="text-center">
                <button type="submit" class="btn btn-primary">Save</button>
                <button type="reset" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div> -->
  </div>
</div>
</div>







<!-- 
     <li class="nav-item">
        <a class="nav-link collapsed" href="<?php echo base_url("discovery"); ?>">
          <i class="bi bi-rainbow"></i>
          <span>Discovery</span>
        </a>
        sidebar nav
      </li>End Discover Page Nav -->