<script>

    $(document).ready(function() {
    var table = $('#users_table').DataTable({
        "ajax": {
            url: "<?php echo base_url("getAllUsers ") ?>",
            type: 'POST'
        },
        "createdRow": function(row, data, dataIndex) {
            // Append the HTML template to each row
            $(row).append('<td><button class="btn btn-primary btn-sm edit-btn">Edit</button><button class="btn btn-sm btn-danger delete-btn">Delete</button></td>');
        },
        lengthChange: false,
        buttons: ['copy', 'excel', 'pdf', 'print']
    });

    //Add event listener to the edit button
    $('#users_table').on('click', '.edit-btn', function() {
        //get the data of the clicked row
        var userData = table.row($(this).parents('tr')).data();
        // do something with the data
        console.log(userData);
        var user_id = userData[0];

        $('#usersModal').modal('show');
        $('#usersModalTitle').text("Edit: " + userData[2]);
        document.getElementById("user_id").value = userData[0];
        document.getElementById("user_name").value = userData[1];
        document.getElementById("full_name").value = userData[2];
        document.getElementById("phone_number").value = userData[3];
        document.getElementById("email").value = userData[4];
        if (userData[5] === "Admin") {
            document.getElementById("user_role").value = "1";
        } else if (userData[5] === "Staff") {
            document.getElementById("user_role").value = "2";
        } else {
            document.getElementById("user_role").value = "3";
        }




    });

    //Add event listener to the delete button
    $('#users_table').on('click', '.delete-btn', function() {

        //get the data of the clicked row
        var userData = table.row($(this).parents('tr')).data();
        // do something with the data
        console.log(userData[0]);
        var user_id = userData[0];

        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.value) {
                // Perform the action
                showLoadingSweetAlert("Deleting User...");
                $.ajax({
                    type: 'POST',
                    url: "deleteUser",
                    dataType: 'json',
                    cache: false,
                    data: {
                        user_id: user_id
                    },
                    success: (data) => {
                        console.log(data);
                        if (data.error === 0) {
                            swal.close();
                            showResultSweetAlert(data.message, "<?php echo base_url();?>assets/img/successful_anim.gif");
                        } else {
                            swal.close();
                            showResultSweetAlert(data.message, "<?php echo base_url();?>assets/img/error_anim.gif");
                        }

                    },
                    error: function(data) {
                        console.log(data);

                    }
                });
            }
        });


    });
        table.buttons().container()
        .appendTo('#example2_wrapper .col-md-6:eq(0)');
    });

    $('#usersForm').submit(function(e) {
        e.preventDefault();
        var formData = new FormData(this);
        showLoadingSweetAlert("Saving User...");
        $.ajax({
            type: 'POST',
            url: "insertUserData",
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            success: (data) => {
                console.log(data);
                if (data.error === 0) {
                    $("#usersModal").modal('hide');
                    swal.close();
                    showResultSweetAlert(data.message, "<?php echo base_url();?>assets/img/successful_anim.gif");

                } else {
                    $("#userModal").modal('hide');
                    swal.close();
                    showResultSweetAlert(data.message, "<?php echo base_url();?>assets/img/error_anim.gif");

                }
            },
            error: function(data) {
                console.log(data);
            }
        });
    });

    $('#change-password').submit(function(e) {
        e.preventDefault();
        var formData = new FormData(this);
        showLoadingSweetAlert("Changing Password...");
        $.ajax({
            type: 'POST',
            url: "changePassword",
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            success: (data) => {
                console.log(data);
                if (data.error === 0) {

                    swal.close();
                    showResultSweetAlert(data.message, "<?php echo base_url();?>assets/img/successful_anim.gif");

                } else {

                    swal.close();
                    showResultSweetAlert(data.message, "<?php echo base_url();?>assets/img/error_anim.gif");

                }
            },
            error: function(data) {
                console.log(data);
            }
        });
    });


    $('#edit-profile').submit(function(e) {
        e.preventDefault();
        var formData = new FormData(this);
        showLoadingSweetAlert("Editing Profile...");
        $.ajax({
            type: 'POST',
            url: "editProfile",
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            success: (data) => {
                console.log(data);
                if (data.error === 0) {

                    swal.close();
                    showResultSweetAlert(data.message, "<?php echo base_url();?>assets/img/successful_anim.gif");

                } else {

                    swal.close();
                    showResultSweetAlert(data.message, "<?php echo base_url();?>assets/img/error_anim.gif");

                }
            },
            error: function(data) {
                console.log(data);
            }
        });
    });

    
function showLoadingSweetAlert(title) {
    Swal.fire({
        text: title,
        imageUrl: "assets/img/loading_anim.gif",
        imageWidth: 100,
        imageHeight: 100,
        showCancelButton: false,
        showConfirmButton: false
    });
}

function showResultSweetAlert(title, url) {
    Swal.fire({
        text: title,
        imageUrl: url,
        imageWidth: 100,
        imageHeight: 100,
        showCancelButton: false,
        showConfirmButton: true,
        customClass: {
            icon: 'no-border'
        }
    }).then((result) => {
        location.reload();
    });
}




</script>

</body>

</html>