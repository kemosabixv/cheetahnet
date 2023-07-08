<script>
$(document).ready(function () {
	var mast_table = $('#non_client_notifications_table').DataTable({
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
					var singleDeviceRoute = "<?php echo base_url("
					devices / device / "); ?>" + data;
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

		"rowCallback": function (row, data, index) {
			$(row).addClass("bg-primary-light"); // Add CSS class for all rows
		}
	});




	$('#update_seen_button').click(function () {
		var selectedRows = mast_table.rows('tr:has(input[name="select"])').data();
		var rowData = [];

		selectedRows.each(function (rowDataItem) {
			var checkbox = $(rowDataItem[5]).find('input[name="select"]');
			if (checkbox.is(':checked') && !checkbox.is(':disabled')) {
				rowData.push(rowDataItem);
			}
		});

		if (rowData.length > 0) {
			// Send the row data to the controller via AJAX
			$.ajax({
				url: '<?php echo base_url("update_seen"); ?>',
				type: 'POST',
				data: {
					rows: rowData
				},
				success: function (response) {
					console.log(response);
					// Handle the success response
				},
				error: function () {
					console.error('Error updating seen status');
					// Handle the error case
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
					var singleDeviceRoute = "<?php echo base_url("
					devices / device / "); ?>" + data;
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



</script>