

    <div class="pagetitle">
      <h1>Devices</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="home">Home</a></li>
          <li class="breadcrumb-item active">Devices</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->


    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
    <button id ="add_devicemodal" class="btn btn-primary" type="button" onclick="add_devicemodal()" >Add Device</button>
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
                    <th scope="col">Wireless Mode</th>
                    <th scope="col">IP address</th>
                    <th scope="col">Connected From</th>
                    <th scope="col">Connection  Status</th>
                  </tr>
                </thead>
                <tbody>
                </tbody>
                <tfoot>
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">Device Name</th>
                    <th scope="col">Mast</th>
                    <th scope="col">Wireless Mode</th>
                    <th scope="col">IP address</th>
                    <th scope="col">Connected From</th>
                    <th scope="col">Connection  Status</th>
                  </tr>
                </tfoot>
              </table>
              <!-- End Table with hoverable rows -->

              <div class="modal fade" id="devicesModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="deviceModalTitle">Add Device</h5>
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
                                  <option>Choose Mast</option>
                                  <?php foreach($all_masts as $each){ ?> <option value="<?php echo $each->mastid; ?>"> <?php echo $each->mast_name;?> </option>'; <?php } ?> </select>
            </div>
          <div class="col-md-12">
                  <select  name="wireless_mode" id="wireless_mode" class="form-select" placeholder="">
                    <option>Choose Wireless Mode</option>
                    <option>AP</option>
                    <option>Station</option>
                  </select>
                </div>
          <div class="col-12">
            <input type="text" name="ip_address" id="ip_address" class="form-control" placeholder="IP Address">
          
          <div id=connected_fromdiv>
          <div class="mb-1">
                                <label class="form-label" for="basicSelect">Connected From (Devices)</label>
                                <select class="form-select" id="connected_from" name="connected_from" value="0">
                                <option value="0">Choose Access Point</option><?php foreach($all_devices as $each){ ?><option value="<?php echo $each->deviceid; ?>"> <?php echo $each->device_name;?> </option>'; <?php } ?> </select>
            </div>
          </div>
          <div class="text-center">
            <button type="submit" class="btn btn-primary">Save</button>
            <button type="reset" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
          </div>
        </form>
        <!-- End No Labels Form -->
      </div>
      <!-- <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div> -->
    </div>
  </div>
</div>

            </div>
          </div>