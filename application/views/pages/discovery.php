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
<div class="card col-4">
  <div class="card-body">
    <h5 class="card-title">Network Interface Details</h5>
    <!-- List group with active and disabled items -->
    <ul class="list-group list-group-flush">
  <?php foreach($interfaces as $each) { ?>
    <?php if ($each->id == 1) { ?>
      <li class="list-group-item">Interface Name: <?php echo $each->interfacedisplayname; ?></li>
      <li class="list-group-item">IP Address: <?php echo $each->ipaddress; ?></li>
      <li class="list-group-item">Subnet: <?php echo $each->subnet; ?></li>
    <?php } ?>
  <?php } ?>
</ul>

    <!-- End Clean list group -->
  </div>
</div>
<div class="d-grid gap-2 d-md-flex justify-content-md-end">
  <button id="scan" class="btn btn-primary" type="button" onclick="scan()">Scan</button>
  <button id="select_int" class="btn btn-primary" type="button">Select Interface</button>
</div>
<div class="card">
  <div class="card-body">
    <h5 class="card-title">Scanned Devices</h5>
    <!-- Table with hoverable rows -->
    <table class="table table-hover" id="Discovery_table">
      <thead>
        <tr>
          <th scope="col">Device Name</th>
          <th scope="col">IP address</th>
          <th scope="col">Wireless Mode</th>
          <th scope="col">Signal</th>
          <th scope="col">Connected From</th>
        </tr>
      </thead>
      <tbody></tbody>
      <tfoot>
        <tr>
          <th scope="col">Device Name</th>
          <th scope="col">IP address</th>
          <th scope="col">Wireless Mode</th>
          <th scope="col">Signal</th>
          <th scope="col">Connected From</th>
        </tr>
      </tfoot>
    </table>
    <!-- End Table with hoverable rows -->
    <div class="modal fade" id="InterfaceModal" tabindex="-1">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="InterfaceModalTitle">Add Interface Name</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <!-- No Labels Form -->
            <form class="row g-3" id="InterfaceForm" method="POST" action="javascript:void(0)">
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
    </div>
  </div>
</div>
</div>