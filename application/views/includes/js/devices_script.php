<script src="assets/js/jquery.min.js"></script>
  <script src="assets/vendor/apexcharts/apexcharts.min.js"></script>
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/chart.js/chart.umd.js"></script>
  <script src="assets/vendor/echarts/echarts.min.js"></script>
  <script src="assets/vendor/quill/quill.min.js"></script>
  <script src="assets/vendor/simple-datatables/simple-datatables.js"></script>
  <script src="assets/vendor/tinymce/tinymce.min.js"></script>
  <script src="assets/vendor/php-email-form/validate.js"></script>
  <script src="<?php echo base_url();?>assets/vendor/datatable/js/jquery.dataTables.min.js"></script>
  <script src="<?php echo base_url();?>assets/vendor/datatable/js/dataTables.bootstrap5.min.js"></script>
  <script src="assets/js/sweet-alert.js"></script>

<script>

   $(document).ready(function () {
      var table = $('#devices_table').DataTable({
         "ajax": {
            url: "<?php echo base_url("getAllDevices") ?>",
            type: 'POST'
         },
         "columnDefs": [{
               "visible": false,
               "targets": 0
            },
            {
               "targets": 6,
               "render": function (data, type, row, meta) {
                  if (data == "Online") {
                     return ' <p style="color: green;">' + data + '</p>';
                  } else {
                     return ' <p style="color: red;">' + data + '</p>';
                  }
               }
            },
            {
               "targets": 4,
               "render": function(data, type, row, meta) {
                  return '<a href="http://' + data + '" target="_blank">' + data + '</a>';
               }
            }
            
        ],
         "createdRow": function (row, data, dataIndex) {
            // Append the HTML template to each row
            $(row).append('<td><button class="btn btn-primary btn-sm edit-btn">Edit</button><button class="btn btn-sm btn-danger delete-btn">Delete</button></td>');
         },
         lengthChange: false,
         buttons: ['copy', 'excel', 'pdf', 'print']
      });

      //Add event listener to the edit button
      $('#devices_table').on('click', '.edit-btn', function () {
         //get the data of the clicked row
         var deviceData = table.row($(this).parents('tr')).data();
         // do something with the data
         console.log(deviceData);
         var deviceid = deviceData[0];

         $('#devicesModal').modal('show');
         $('#deviceModalTitle').text("Edit: " + deviceData[1]);
         document.getElementById("device_id").value = deviceData[0];
         document.getElementById("device_name").value = deviceData[1];
         getMastId(deviceData[2], function (mast_id) {
            console.log(mast_id);
            document.getElementById("mast_name").value = mast_id;
         });
         document.getElementById("wireless_mode").value = deviceData[3];
         document.getElementById("ip_address").value = deviceData[4];
         getConnectedFrom(deviceData[5], function (connectedfrom) {
            console.log(connectedfrom);
            document.getElementById("connected_from").value = connectedfrom;
         });



      });



      //Add event listener to the delete button
      $('#devices_table').on('click', '.delete-btn', function () {

         //get the data of the clicked row
         var deviceData = table.row($(this).parents('tr')).data();
         // do something with the data
         console.log(deviceData[0]);
         var device_id = deviceData[0];

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
               showLoadingSweetAlert("Deleting Device...");
               $.ajax({
                  type: 'POST',
                  url: "deleteDevice",
                  dataType: 'json',
                  cache: false,
                  data: {
                     device_id: device_id
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
                  error: function (data) {
                     console.log(data);

                  }
               });
            }
         });
      });
      table.buttons().container().appendTo('#example2_wrapper .col-md-6:eq(0)');


      setInterval(function () {
         var currentPage = table.page.info().page;
         table.ajax.reload(function () {
            // Set the current page after data has been reloaded
            table.page(currentPage).draw(false);
            console.log(currentPage);
         });
      }, 5000);

      //uncomment the code below to check_device_connection_status 

      
      
      // const worker = new Worker('worker.js');
      //   worker.onmessage = function (e) {
      //   console.log('Message received from worker:', e.data);
      //   };
      //   worker.postMessage('start');
      //   console.log('Message sent to worker');


      var select = document.getElementById("wireless_mode");
      select.addEventListener("change", function () {

         console.log("Selected option: " + select.value);
         if (select.value == "AP") {
            document.getElementById("connected_fromdiv").style.visibility = "hidden"

         } else {
            document.getElementById("connected_fromdiv").style.visibility = "visible"

         }

      });

   });

$('#devicesForm').submit(function (e) {
   e.preventDefault();
   var formData = new FormData(this);
   showLoadingSweetAlert("Saving Device...");

   $.ajax({
      type: 'POST',
      url: "insertDeviceData",
      data: formData,
      cache: false,
      contentType: false,
      processData: false,
      success: (data) => {
         console.log(data);
         if (data.error === 0) {
            $("#deviceModal").modal('hide');
            swal.close();
            showResultSweetAlert(data.message, "<?php echo base_url();?>assets/img/successful_anim.gif");

         } else {
            $("#deviceModal").modal('hide');
            swal.close();
            showResultSweetAlert(data.message, "<?php echo base_url();?>assets/img/error_anim.gif");

         }
      },
      error: function (data) {
         console.log(data);
      }
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

function add_devicemodal() {
    $('#devicesModal').modal('show');
    $('#deviceModalTitle').text("Add Device");
    $("#devicesForm").trigger("reset");

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
