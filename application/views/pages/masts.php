<div class="pagetitle">
  <h1>Masts</h1>
  <nav>
    <ol class="breadcrumb">
      <li class="breadcrumb-item">
        <a href="home">Home</a>
      </li>
      <li class="breadcrumb-item active">Masts</li>
    </ol>
  </nav>
</div>
<!-- End Page Title -->
<div class="d-grid gap-2 d-md-flex justify-content-md-end">
  <button id="add_mastmodal" class="btn btn-primary" type="button" onclick="add_mastmodal()">Add Mast</button>
</div>
<br>
<div class="card">
  <div class="card-body">
    <h5 class="card-title">All Masts</h5>
    <!-- Table with hoverable rows -->
    <table class="table table-hover" id="masts_table">
      <thead>
        <tr>
          <th scope="col">#</th>
          <th scope="col">Mast Name</th>
          <th scope="col">Location</th>
          <th scope="col">Connected Via</th>
          <th scope="col">Connected From</th>  
          <th scope="col">Date Created</th>
        </tr>
      </thead>
      <tbody></tbody>
      <tfoot>
        <tr>
          <th scope="col">#</th>
          <th scope="col">Mast Name</th>
          <th scope="col">Location</th>
          <th scope="col">Connected Via</th>
          <th scope="col">Connected From</th>  
          <th scope="col">Date Created</th>
        </tr>
      </tfoot>
    </table>
    <!-- End Table with hoverable rows -->
  </div>
</div>
<div class="modal fade" id="mastsModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="mastsModalTitle">Add Mast</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <!-- No Labels Form -->
        <form class="row g-3" id="mastsForm" method="POST" action="javascript:void(0)">
          <input type="text" name="mastid" id="mastid" class="form-control" hidden>
          <div class="col-md-12">
            <input type="text" name="mast_name" id="mast_name" class="form-control" placeholder="Mast Name">
          </div>
          <div class="col-md-12">
            <input type="text" name="mast_location" id="mast_location" class="form-control" placeholder="Mast Location (Lat. , Long.)"> 
          </div>

          <div class="col-md-12">
                  <select name="mast_connected_via" id="mast_connected_via" class="form-select" placeholder="">
                    <option>Radio</option>
                    <option>Fiber</option>
                  </select>
                </div>

          <div class="mb-1">
                                <label class="form-label" for="basicSelect">Connected From</label>
                                <select class="form-select" id="mast_connected_from" name="mast_connected_from">
                                  <option>Choose Mast</option>
                                  <?php foreach($all_masts as $each){ ?> <option value="<?php echo $each->mastid; ?>"> <?php echo $each->mast_name;?> </option>'; <?php } ?> 
                                </select>
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
<!-- End Basic Modal-->