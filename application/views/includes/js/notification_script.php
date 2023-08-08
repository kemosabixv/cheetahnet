<script>
$(document).ready(function () {
	var non_client_notifications_table = $('#non_client_notifications_table').DataTable({
		"ajax": {
			"url": "<?php echo base_url('get_all_nonclient_notifications'); ?>",
			"type": "POST",
			"dataSrc": "data"
		},
		"columns": [{
				"data": "id",
				"visible": false
			},
			{
				"data": "device_name"
			},
			{
				"data": "model"
			},
			{
				"data": "ip",
				"render": function (data, type, row, meta) {
					var singleDeviceRoute = "<?php echo base_url("devices/device/"); ?>" + data;
					let ahref = '<a href="' + singleDeviceRoute + '" target="_blank">' + data + '</a>';
					return ahref;
				}
			},
			{
				"data": "notice"
			},
			{
				"data": "date"
			},
			{
				"data": "seen",
				"render": function (data, type, row, meta) {
					if (data == 1) {
						return '<input class="form-check-input" type="checkbox" disabled checked name="select" value="' + row.id + '">';
					} else {
						return '<input class="form-check-input" type="checkbox" name="select" value="' + row.id + '">';
					}
				}
			}
		],
		"columnDefs": [{
				"targets": [1, 2, 3, 4],
				"orderable": false
			}

		],
		order: [
			[5, 'desc']
		],
		"rowCallback": function (row, data, index) {
			$(row).addClass("bg-primary-light"); // Add CSS class for all rows
		}
	});



	$('#update_seen_button').click(function () {
		var rowData = [];
		$('.form-check-input:checked').each(function() {
			console.log("row checked");
			var row = $(this).closest('tr');
			console.log(non_client_notifications_table.row(row).data());
			rowData.push(non_client_notifications_table.row(row).data());
		});
		console.log(rowData);
		
		
		if (rowData.length > 0) {
			// Send the row data to the controller via AJAX
			showLoadingSweetAlert("Updating...");
			$.ajax({
				url: '<?php echo base_url("update_seen"); ?>',
				type: 'POST',
				data: {
					rows: rowData
				},
				success: function (response) {
					console.log(response);
					if (response.error === 0) {
   					swal.close();
   					showResultSweetAlert(response.message, "<?php echo base_url();?>assets/img/successful_anim.gif");
					} else {
					swal.close();
					showResultSweetAlert(response.message, "<?php echo base_url();?>assets/img/error_anim.gif");
					}				
				},
				error: function () {
					console.error('Error updating seen status');
				}
			});
		} else {
			console.log('No rows selected');
		}
	});


	var client_table = $('#client_notifications_table').DataTable({
		"ajax": {
			"url": "<?php echo base_url('get_all_client_notifications'); ?>",
			"type": "POST",
			"dataSrc": "data"
		},
		"columns": [

			{
				"data": "id"
			},
			{
				"data": "device_name"
			},
			{
				"data": "model"
			},
			{
				"data": "ip",
				"render": function (data, type, row, meta) {
					var singleDeviceRoute = "<?php echo base_url("devices/device/"); ?>" + data;
					let ahref = '<a href="' + singleDeviceRoute + '" target="_blank">' + data + '</a>';
					return ahref;
				}
			},
			{
				"data": "notice"
			},
			{
				"data": "date"
			},
		],
		"columnDefs": [{
				"targets": [1, 2, 3, 4],
				"orderable": false
			},
			{
				"visible": false,
				"targets": 0
			},
		],
		"rowCallback": function (row, data, index) {
			$(row).addClass("bg-warning-light"); // Add CSS class for all rows
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