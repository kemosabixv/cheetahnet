<div class="pagetitle">
  <h1>Devices</h1>
  <nav>
    <ol class="breadcrumb">
      <li class="breadcrumb-item">
        <a href="home">Home</a>
      </li>
      <li class="breadcrumb-item active">Devices</li>
    </ol>
  </nav>
</div>
<!-- End Page Title -->
<div class="row">
  <div class="col-md-6">
    <div class="d-grid gap-2 d-md-flex justify-content-md-start">
      <button id="update_radiomode_connectedfrom" class="btn btn-primary" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-original-title="Update all Radio Mode and Connected From fields" type="button">Update</button>
    </div>
  </div>
  <div class="col-md-6">
    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
      <button id="add_devicemodal" class="btn btn-primary" type="button" onclick="add_devicemodal()">Add Device</button>
    </div>
  </div>
</div>
<br>
<div class="card">
  <div class="card-body">
    <h5 class="card-title">All Devices</h5>
    <!-- Table with hoverable rows -->
    <table class="table table-hover" id="devices_table">
      <thead>
        <tr>
          <th scope="col">#</th>
          <th scope="col">Device Name</th>
          <th scope="col">Mast</th>
          <th scope="col">Radio Mode</th>
          <th scope="col">IP address</th>
          <th scope="col">Connected From</th>
          <th scope="col">Connection Status</th>
        </tr>
      </thead>
      <tbody></tbody>
      <tfoot>
        <tr>
          <th scope="col">#</th>
          <th scope="col">Device Name</th>
          <th scope="col">Mast</th>
          <th scope="col">Radio Mode</th>
          <th scope="col">IP address</th>
          <th scope="col">Connected From</th>
          <th scope="col">Connection Status</th>
        </tr>
      </tfoot>
    </table>
    <!-- End Table with hoverable rows -->
    <div class="modal fade" id="devicesModal" tabindex="-1">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="deviceModalTitle"></h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <!-- No Labels Form -->
            <form class="row g-3" id="devicesForm" method="POST" action="javascript:void(0)">
              <div class="col-md-12">
                <input type="text" name="device_id" id="device_id" class="form-control" value="" hidden>
              </div>
              <div class="col-md-12">
                <input type="text" name="device_name" id="device_name" class="form-control" placeholder="Device Name">
              </div>
              <div class="mb-1">
                <label class="form-label" for="basicSelect">Mast Name</label>
                <select class="form-select" id="mast_name" name="mast_name">
                <!-- <option>Choose Mast</option> -->
                <?php foreach($all_masts as $each){ ?>
                  <option value="<?php echo $each->mastid; ?>">
                    <?php echo $each->mast_name; ?>
                  </option>
                <?php } ?>
              </select>
              </div>
              <div class="col-md-12">
                <select name="wireless_mode" id="wireless_mode" class="form-select" placeholder="Choose Radio Mode">
                  <option>AP</option>
                  <option>Station</option>
                </select>
              </div>
              <div class="col-12">
                <input type="text" name="ip_address" id="ip_address" class="form-control" placeholder="IP Address">
              </div>
              <div id="connected_from_div" style="display: none;">
                <div class="mb-1">
                  <label class="form-label" for="basicSelect">Connected From (Devices)</label>
                  <select class="form-select" id="connected_from" name="connected_from">
                  <!-- <option>Choose Access Point</option> -->
                  <?php foreach($all_devices as $each){ ?>
                    <option value="<?php echo $each->deviceid; ?>">
                      <?php echo $each->device_name; ?>
                    </option>
                  <?php } ?>
                </select>
                </div>
              </div>
              <div class="text-center">
                <button type="submit" class="btn btn-primary">Save</button>
                <button type="reset" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
              </div>
            </form>
            <!-- End No Labels Form -->
          </div>
          <script>
            var wirelessModeSelect = document.getElementById("wireless_mode");
            var connectedFromDiv = document.getElementById("connected_from_div");
            wirelessModeSelect.addEventListener("change", function() {
              if (this.value === "Station") {
                connectedFromDiv.style.display = "block";
              } else {
                connectedFromDiv.style.display = "none";
              }
            });
          </script>
          <!-- <div class="modal-footer"><button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button><button type="button" class="btn btn-primary">Save changes</button></div> -->
        </div>
      </div>
    </div>
    <!-- Update All Fields Modal -->
    <div class="modal fade" id="update_radiomode_connectedfrom_modal" tabindex="-1">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Update all Radio Mode and Connected From fields.</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <h5>Note:</h5> This functionality uses the <strong>SNMP</strong> Protocol. <br> If any device is <strong>OFFLINE</strong> its values will <strong>NOT</strong> be updated. <br> Please update the device manually using the <strong>edit</strong> button <br>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
              <button id="update" type="button" class="btn btn-primary">Update</button>
            </div>
          </div>
        </div>
      </div>
      <!-- End Update All Fields Modal-->

      <!-- Scrolling Modal-->
      <div class="modal fade" id="snmpUpdate_scrollingModal" tabindex="-1">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Results</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" style="min-height: 1500px;">
              <!-- SnmpUpdate Success Table -->
              <div id="snmpupdate_success_table">
                <h5 class="card-title">Successful Updates</h5>
                <!-- Dark Table -->
                <table class="table table-dark">
                  <thead>
                    <tr>
                      <th scope="col">Device Name</th>
                      <th scope="col">IP address</th>
                      <th scope="col">Radio Mode</th>
                      <th scope="col">Connected From</th>
                    </tr>
                  </thead>
                  <tbody></tbody>
                </table>
                <!-- End Dark Table -->
              </div>
              <!-- End SnmpUpdate Success Table -->
              <!-- SnmpUpdate Error Table -->
              <div id="snmpupdate_error_table">
                <h5 class="card-title">Errors</h5>
                <!-- Dark Table -->
                <table class="table table-dark">
                  <thead>
                    <tr>
                      <th scope="col">Device Name</th>
                      <th scope="col">IP address</th>
                      <th scope="col">Error Message</th>
                    </tr>
                  </thead>
                  <tbody></tbody>
                </table>
                <!-- End Dark Table -->
              </div>
              <!-- End SnmpUpdate Error Table -->
            </div>
            <div class="modal-footer">
              <!-- <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button> -->
              <button type="button" class="btn btn-primary">Close</button>
            </div>
          </div>
        </div>
      </div>
      <!-- End Scrolling Modal-->

    </div>
  </div>