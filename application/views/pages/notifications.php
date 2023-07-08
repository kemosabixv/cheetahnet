<div class="pagetitle">
  <h1>Notifications</h1>
  <nav>
    <ol class="breadcrumb">
      <li class="breadcrumb-item">
        <a href="home">Home</a>
      </li>
      <li class="breadcrumb-item active">Notifications</li>
    </ol>
  </nav>
</div>
<div class="col-md-12">
    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
      <button id="update_seen_button" class="btn btn-primary" type="button">Apply</button>
    </div>
  </div>
<div class="card">
  <div class="card-body">
    <h5 class="card-title">Mast Notifications</h5>
    <table class="table table-hover" id="non_client_notifications_table">
      <thead>
        <tr>
        <th scope="col">#</th>
          <th scope="col">Device Name</th>
          <th scope="col">Model</th>
          <th scope="col">IP</th>
          <th scope="col">Notice</th>
          <th scope="col">Date/Time</th>
          <th scope="col">Seen</th>
        </tr>
      </thead>
      <tbody></tbody>
    </table>
  </div>
</div>
    <!-- End Non-client Table Datatable-->
<div class="card">
  <div class="card-body">
    <h5 class="card-title">Client Notifications</h5>
    <table class="table table-hover" id="client_notifications_table">
      <thead>
        <tr>
        <th scope="col">#</th>
        <th scope="col">Device Name</th>
        <th scope="col">Model</th>
        <th scope="col">IP</th>
        <th scope="col">Notice</th>
        <th scope="col">Date/Time</th>
        </tr>
      </thead>
      <tbody></tbody>
    </table>
  </div>
</div>
<!-- End Client Table Datatable-->