<div class="pagetitle">
  <h1>Users</h1>
  <nav>
    <ol class="breadcrumb">
      <li class="breadcrumb-item">
        <a href="home">Home</a>
      </li>
      <li class="breadcrumb-item active">Users</li>
    </ol>
  </nav>
</div>
<!-- End Page Title -->
<div class="d-grid gap-2 d-md-flex justify-content-md-end">
  <button class="btn btn-primary" type="button" data-bs-toggle="modal" data-bs-target="#usersModal">Add User</button>
</div>
<br>
<div class="card">
  <div class="card-body">
    <h5 class="card-title">All Users</h5>
    <!-- Table with hoverable rows -->
    <table class="table" id="users_table">
      <thead>
        <tr>
          <th scope="col">#</th>
          <th scope="col">User Name</th>
          <th scope="col">Full Name</th>
          <th scope="col">Phone Number</th>
          <th scope="col">E-Mail</th>
          <th scope="col">Role</th>
        </tr>
      </thead>
      <tbody></tbody>
    </table>
    <!-- End Table with hoverable rows -->
    <div class="modal fade" id="usersModal" tabindex="-1">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title"id="usersModalTitle">Add User</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <!-- No Labels Form -->
            <form class="row g-3" id="usersForm" method="POST" action="javascript:void(0)">
              <input type="text" name="user_id" id="user_id" class="form-control" value="" hidden>
              <div class="col-md-12">
                <input type="text" name="user_name" id="user_name" class="form-control" placeholder="User Name">
              </div>
              <div class="col-md-12">
                <input type="text" name="full_name" id="full_name" class="form-control" placeholder="Full Name">
              </div>
              <div class="col-12">
                <input type="text" name="phone_number" id="phone_number" class="form-control" placeholder="Phone Number">
              </div>
              <div class="col-12">
                <input type="email" name="email" id="email" class="form-control" placeholder="E-Mail">
              </div>
              <div class="mb-1">
                <label class="form-label" for="basicSelect">User Role</label>
                <select class="form-select" id="user_role" name="user_role"> <?php foreach($all_roles as $each){ ?> <option value="<?php echo $each->id; ?>"> <?php echo $each->level_name;?> </option>'; <?php } ?> </select>
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
  </div>
</div>