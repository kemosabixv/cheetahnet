<script >

  $(document).ready(function () {
    // $('#select_int').click(function () {
    //   $('#InterfaceModal').modal('show');
    // });

    $('#clear_table').click(function () {
      showLoadingSweetAlert("Clearing Table...");
      $.ajax({
      type: 'POST',
      url: "<?php echo base_url('cleardiscoverydata'); ?>",
      success: function (data) {
          console.log(data);
          if (data.error === 0) {
            
            swal.close();
            showResultSweetAlert("Table Cleared", "<?php echo base_url();?>assets/img/successful_anim.gif");
          }
          else {
            swal.close();
            showResultSweetAlert("Error", "<?php echo base_url();?>assets/img/error_anim.gif");
          }
        },
      error: function (data) {
        console.log(data);
      }
    });
    });

    // $('#InterfaceForm').submit(function (e) {
    //   e.preventDefault();
    //   var formData = new FormData(this);
    //   showLoadingSweetAlert("Saving Interface...");
    //   $.ajax({
    //     type: 'POST',
    //     url: "<?php echo base_url('addinterface'); ?>",
    //     data: formData,
    //     cache: false,
    //     contentType: false,
    //     processData: false,
    //     success: function (data) {
    //       console.log(data);
    //       if (data.error === 0) {
    //         $("#InterfaceModal").modal('hide');
    //         swal.close();
    //         showResultSweetAlert(data.message, "<?php echo base_url();?>assets/img/successful_anim.gif");
    //       }
    //       else {
    //         $("#InterfaceModal").modal('hide');
    //         swal.close();
    //         showResultSweetAlert(data.message, "<?php echo base_url();?>assets/img/error_anim.gif");
    //       }
    //     },
    //     error: function (data) {
    //       console.log(data);
    //     }
    //   });
    // });

    $('#scan').click(function () {
      showLoadingSweetAlert("Scanning...");

      $.ajax({
        type: 'POST',
        url: "<?php echo base_url('updatediscoverydata'); ?>",
        success: function (response) {
          console.log(response);
          console.log(response.error);
          if (response.error === 0) {

            swal.close();
            showResultSweetAlert("Scan Complete", "<?php echo base_url();?>assets/img/successful_anim.gif");

          }
          else {
            swal.close();
            showResultSweetAlert("Error Occurred", "<?php echo base_url();?>assets/img/error_anim.gif");
          }
        },
        error: function (data) {
          console.log(data);
        }
      });
    });

    

    var table = $('#Discovery_table').DataTable({
      "ajax": {
        "url": "<?php echo base_url('getdiscoverydata'); ?>",
        "type": "POST",
        "dataSrc": "data"
      },
      "columns": [
        {
          "data": "select",
          "render": function (data, type, row, meta) {
            return '<input class="form-check-input" type="checkbox" name="select" value="' + row.id + '">';
          }
            },
        {
          "data": "device_name"
      },
        {
          "data": "ip_address"
      },
        {
          "data": "model"
      },
        {
          "data": "firmware_version"
      }
          ],
      "columnDefs": [
        {
          "targets": [1],
          "orderable": false
            }
          ]
    });




$('#AddDevicesButton').click(function () {
  
  var selectedDevicesTableBody = $('#selectedDevices tbody');
  selectedDevicesTableBody.empty(); // Clear previous rows
  console.log("selectedDevices tbody empty");

  var rowData;

  $('.form-check-input:checked').each(function() {
    console.log("row checked");
    var row = $(this).closest('tr');
    rowData = table.row(row).data();
    rowData.mastid = $('#mast_name').val(); // Add mastid to rowData
    rowData.connected_from = '0'// Add connected_from to rowData
    console.log(rowData);
    selectedDevicesTableBody.append('<tr><td>'+rowData.device_name+'</td><td>'+rowData.ip_address+'</td></tr>');
  });
  // Show the modal
  $('#AddDevicesModal').modal('show');
  $('#mast_name').change(function() {
      var mastid = $(this).val();
      // change the mastid in rowData
      rowData.mastid = mastid;
      console.log(mastid);
      console.log(rowData);
    });

  $('#AddFromDiscoveryForm').submit(function (e) {
    e.preventDefault();
    var formData = new FormData(this);
    formData.append('rowData', JSON.stringify(rowData)); // Add rowData as a parameter
    showLoadingSweetAlert("Saving Devices...");
    $.ajax({
      type: 'POST',
      url: "<?php echo base_url('addDiscoveryDevices'); ?>",
      data: formData,
      cache: false,
      contentType: false,
      processData: false,
      success: function (data) {
        console.log(data);
        if (data.error === 0) {
          $("#AddDevicesModal").modal('hide');
          swal.close();
          showResultSweetAlert(data.message, "<?php echo base_url();?>assets/img/successful_anim.gif");
        }
        else {
          $("#AddDevicesModal").modal('hide');
          swal.close();
          showResultSweetAlert(data.message, "<?php echo base_url();?>assets/img/error_anim.gif");
        }
      },
      error: function (data) {
        console.log(data);
      }
    });
  });

});

});

</script>
