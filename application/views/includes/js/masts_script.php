<script>

   $(document).ready(function() {

      //render masts table
      var table = $('#masts_table').DataTable({
            "ajax": {
               url: " <?php echo base_url ("getAllMasts") ?>",
               type: 'POST'
            },
            "columnDefs": [{
               "visible": false,
               "targets": 0
            }],
            "createdRow": function(row, data, dataIndex) {
               // Append the HTML template to each row
               $(row).append('<td><button class="btn btn-primary btn-sm edit-btn">Edit</button><button class="btn btn-sm btn-danger delete-btn">Delete</button></td>');
            },
            lengthChange: false,
            buttons: ['copy', 'excel', 'pdf', 'print']
         });

      table.buttons().container().appendTo('#example2_wrapper .col-md-6:eq(0)');


      //masts table edit & delete buttons
      //Add event listener to the edit button
      $('#masts_table')
         .on('click', '.edit-btn', function() {
            //get the data of the clicked row
            var mastData = table.row($(this).parents('tr')).data();
            // do something with the data
            console.log(mastData);
            var mastid = mastData[0];

            $('#mastsModal').modal('show');
            $('#mastsModalTitle').text("Edit: " + mastData[1]);
            document.getElementById("mastid").value = mastData[0];
            document.getElementById("mast_name").value = mastData[1];
            document.getElementById("mast_location").value = mastData[2];
            document.getElementById("mast_connected_via").value = mastData[4];
            document.getElementById("mast_height").value = mastData[3];
            document.getElementById("mast_connected_from").value = mastData[5];
            $('#mastsForm').attr('action', 'editMastData');
         });


      //Add event listener to the delete button
      $('#masts_table')
         .on('click', '.delete-btn', function() {

            //get the data of the clicked row
            var mastData = table.row($(this).parents('tr')).data();
            // do something with the data
            console.log(mastData);
            var mastid = mastData[0];

            Swal.fire({
                  title: 'Are you sure?',
                  text: "You won't be able to revert this!",
                  icon: 'warning',
                  showCancelButton: true,
                  confirmButtonColor: '#3085d6',
                  cancelButtonColor: '#d33',
                  confirmButtonText: 'Yes, delete it!'
               })
               .then((result) => {
                  if(result.value) {
                     // Perform the action
                     showLoadingSweetAlert("Deleting Device...");
                     $.ajax({
                        type: 'POST',
                        url: "deleteMast",
                        dataType: 'json',
                        cache: false,
                        data: {
                           mastid: mastid
                        },
                        success: (data) => {
                           console.log(data);
                           if(data.error === 0) {
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

   });



function getMastId(mastname, callback) {
    console.log(mastname);
    var mastname;
    $.ajax({
        type: 'POST',
        url: "getMastId",
        dataType: 'json',
        cache: false,
        data: {
            mastname: mastname
        },
        success: (data) => {
            console.log(data.mast_id);
            callback(data.mast_id);

        },
        error: function(data) {
            console.log(data);

        }
    });
}


function getConnectedFrom(connectedfrom, callback) {
    console.log(connectedfrom);
    var connectedfrom;
    $.ajax({
        type: 'POST',
        url: "getConnectedFrom",
        dataType: 'json',
        cache: false,
        data: {
            connectedfrom: connectedfrom
        },
        success: (data) => {
            console.log(data.device_id);
            callback(data.device_id);

        },
        error: function(data) {
            console.log(data);

        }
    });
}

function add_mastmodal() {
    $('#mastsModal').modal('show');
    $('#mastsModalTitle').text("Add Mast");
    $('#mastsForm').attr('action', 'addMastData');
    $("#mastsForm").trigger("reset");
}
   

$('#mastsForm').off('submit').on('submit', function(e) {
e.preventDefault();
var action = $(this).attr('action'); // Get the form action

if (action === 'addMastData') {
    insertsubmitForm();
} else if (action === 'editMastData') {
    editsubmitForm();
}
    
});

function insertsubmitForm() {
var formData = new FormData($('#mastsForm')[0]);
for (var pair of formData.entries()) {
			console.log(pair[0]+ ', ' + pair[1]);
		} 
showLoadingSweetAlert("Saving Mast...");
$.ajax({
    type: 'POST',
    url: "insertMastData",
    data: formData,
    cache: false,
    contentType: false,
    processData: false,
    success: function(data) {
        console.log(data);
        if (data.error === 0) {
            $("#mastModal").modal('hide');
            swal.close();
            showResultSweetAlert(data.message, "<?php echo base_url();?>assets/img/successful_anim.gif");
        } else {
            $("#mastModal").modal('hide');
            swal.close();
            showResultSweetAlert(data.message, "<?php echo base_url();?>assets/img/error_anim.gif");
        }
    },
    error: function(data) {
        console.log(data);
    }
});
}

function editsubmitForm() {
    var formData = new FormData($('#mastsForm')[0]);
    for (var pair of formData.entries()) {
			console.log(pair[0]+ ', ' + pair[1]);
		}    
    showLoadingSweetAlert("Saving Mast...");
    $.ajax({
        type: 'POST',
        url: "editMastData",
        data: formData,
        cache: false,
        contentType: false,
        processData: false,
        success: function(data) {
            console.log(data);
            if (data.error === 0) {
                $("#mastModal").modal('hide');
                swal.close();
                showResultSweetAlert(data.message, "<?php echo base_url();?>assets/img/successful_anim.gif");
            } else {
                $("#mastModal").modal('hide');
                swal.close();
                showResultSweetAlert(data.message, "<?php echo base_url();?>assets/img/error_anim.gif");
            }
        },
        error: function(data) {
            console.log(data);
        }
    });
}


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