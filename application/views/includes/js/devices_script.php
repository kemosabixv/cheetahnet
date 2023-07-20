
<script>
   $(document).ready(function() {

   	$('#update_radiomode_connectedfrom').click(function() {
   		$('#update_radiomode_connectedfrom_modal').modal('show');
         
   		//on click update
   		$('#update').on('click', function() {
   			showLoadingSweetAlert("Updating Devices...");
   			$.ajax({
   				type: 'POST',
   				url: "update_radiomode_connectedfrom",
   				// AJAX success callback
   				success: function(data) {
   					console.log(data);
   					if (data[4].error === 0) {
   						// Clear the success table
   						const successTableBody = document.querySelector('#snmpupdate_success_table tbody');
   						successTableBody.innerHTML = '';

   						// Populate the success table with data
   						const successData = data[1];
   						successData.forEach((row) => {
   							const newRow = document.createElement('tr');
   							newRow.innerHTML = `
                        <td>${row.device_name}</td>
                        <td>${row.ip}</td>
                        <td>${row.radio_mode}</td>
                        <td>${row.connected_from}</td>
                      `;
   							successTableBody.appendChild(newRow);
   						});

   						// Clear the error table
   						const errorTableBody = document.querySelector('#snmpupdate_error_table tbody');
   						errorTableBody.innerHTML = '';

   						// Populate the error table with data
   						const errorData = data[3];
   						errorData.forEach((row) => {
   							const newRow = document.createElement('tr');
   							newRow.innerHTML = `
                        <td>${row.device_name}</td>
                        <td>${row.ip}</td>
                        <td>${row.error}</td>
                      `;
   							errorTableBody.appendChild(newRow);
   						});

   						// Prepare the table content for the modal
   						const tableContent = {
   							successTable: successTableBody.innerHTML,
   							errorTable: errorTableBody.innerHTML
   						};

   						showSnmpResultSweetAlert(data[4].message, "<?php echo base_url();?>assets/img/successful_anim.gif", tableContent);
   					} else {
   						swal.close();
   						showResultSweetAlert(data[4].message, "<?php echo base_url();?>assets/img/error_anim.gif");
   					}
   				},
   				error: function(data) {
   					console.log(data);
   				}
   			});
   		});
   	});


   	var table = $('#devices_table').DataTable({
   		"ajax": {
   			url: "<?php echo base_url("/getAllDevices ") ?>",
   			type: 'POST',

   		},
   		"columnDefs": [{
   				"visible": false,
   				"targets": 0
   			},
   			{
   				"targets": 6,
   				"render": function(data, type, row, meta) {
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
   					var singleDeviceRoute = "<?php echo base_url("devices/device/"); ?>" + data;
   					let ahref = '<a href="' + singleDeviceRoute + '" target="_blank">' + data + '</a>';
   					return ahref;
   				}
   			}

   		],
   		"createdRow": function(row, data, dataIndex) {
   			// Append the HTML template to each row
   			$(row).append('<td><button class="btn btn-primary btn-sm edit-btn">Edit</button><button class="btn btn-sm btn-danger delete-btn">Delete</button></td>');
   		},
   		lengthChange: true,

   	});

   	//

   	// Add event listener to the edit button
   	$('#devices_table').on('click', '.edit-btn', function() {
   		// Get the data of the clicked row
   		var deviceData = table.row($(this).parents('tr')).data();
   		// Do something with the data
   		console.log(deviceData);
   		var deviceid = deviceData[0];

   		var wirelessModeSelect = document.getElementById("wireless_mode");
   		var connectedFromDiv = document.getElementById("connected_from_div");
		if (deviceData[3] == "Station") {
			connectedFromDiv.style.display = "block";
   			} else {
   			connectedFromDiv.style.display = "none";
   			}
   		// Event listener for "change" event of wireless_mode select
   		wirelessModeSelect.addEventListener("change", function() {
   			if (this.value === "Station") {
   				connectedFromDiv.style.display = "block";
   			} else {
   				connectedFromDiv.style.display = "none";
   			}
   		});

   		$('#devicesModal').modal('show');
   		$('#deviceModalTitle').text("Edit: " + deviceData[1]);
   		document.getElementById("device_id").value = deviceData[0];
   		document.getElementById("device_name").value = deviceData[1];
   		// document.getElementById("mast_name").value = deviceData[2];
   		getMastId(deviceData[2], function(mast_id) {
   			console.log(mast_id);
   			document.getElementById("mast_name").value = mast_id;
   			console.log(mast_id);
   		});
   		document.getElementById("wireless_mode").value = deviceData[3];
   		document.getElementById("ip_address").value = deviceData[4];
   		// document.getElementById("connected_from").value = deviceData[5];
   		getConnectedFrom(deviceData[5], function(connectedfrom) {
   			console.log(connectedfrom);
   			document.getElementById("connected_from").value = connectedfrom;
   		});
		$('#devicesForm').attr('action', 'editDeviceData');
   	});

	//  $('#devicesForm').off('submit').on('submit', function(e) {
    // e.preventDefault();
    // var action = $(this).attr('action'); // Get the form action

    // if (action === 'addDeviceData') {
    //     insertsubmitForm();
    // } else if (action === 'editDeviceData') {
    //     editsubmitForm();
    // }
	// });

   	//Add event listener to the delete button
   	$('#devices_table').on('click', '.delete-btn', function() {

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
   					error: function(data) {
   						console.log(data);

   					}
   				});
   			}
   		});
   	});
   	table.buttons().container().appendTo('#example2_wrapper .col-md-6:eq(0)');

   	setInterval(function() {
   		var currentPage = table.page.info().page;
   		table.ajax.reload(function() {
   			// Set the current page after data has been reloaded
   			table.page(currentPage).draw(false);
   			console.log(currentPage);
   		});
   	}, 5000);


   	// // var select = document.getElementById("wireless_mode");
   	// // select.addEventListener("change", function() {

   	// // 	console.log("Selected option: " + select.value);
   	// // 	if (select.value == "AP") {
   	// // 		document.getElementById("connected_fromdiv").style.visibility = "hidden"

   	// // 	} else {
   	// // 		document.getElementById("connected_fromdiv").style.visibility = "visible"

   	// // 	}

   	// });

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
   	var wirelessModeSelect = document.getElementById("wireless_mode");
   	var connectedFromDiv = document.getElementById("connected_from_div");
   	var deviceData = [];

   	// Event listener for "change" event of wireless_mode select
   	wirelessModeSelect.addEventListener("change", function() {
   		if (this.value === "Station") {
   			connectedFromDiv.style.display = "block";
   		} else {
   			connectedFromDiv.style.display = "none";
   		}
   	});
   	$('#devicesModal').modal('show');
   	$('#deviceModalTitle').text("Add Device");
   	getConnectedFrom(deviceData[5], function(connectedfrom) {
   		console.log(connectedfrom);
   		document.getElementById("connected_from").value = connectedfrom;
   	});
	// Set action attribute for form submission
	$('#devicesForm').attr('action', 'addDeviceData');
   	$('#devicesForm').trigger('reset');
   }
   
   $('#devicesForm').off('submit').on('submit', function(e) {
    e.preventDefault();
    var action = $(this).attr('action'); // Get the form action

    if (action === 'addDeviceData') {
        insertsubmitForm();
    } else if (action === 'editDeviceData') {
        editsubmitForm();
    }
	});

   function insertsubmitForm() {
   		var formData = new FormData($('#devicesForm')[0]);
		console.log($('#devicesForm')[0]);
		for (var pair of formData.entries()) {
			console.log(pair[0]+ ', ' + pair[1]);
		}
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
   			error: function(data) {
   				console.log(data);
   			}
   		});
   	}
	   function editsubmitForm() {
   		var formData = new FormData($('#devicesForm')[0]);
   		showLoadingSweetAlert("Saving Device...");
   		$.ajax({
   			type: 'POST',
   			url: "editDeviceData",
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

   function showSnmpResultSweetAlert(title, url, tableContent) {
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
   		if (result.isConfirmed) {
   			showTableModal(tableContent);
   		} else {
   			location.reload();
   		}
   	});
   }

   // Add event listener to the "Save changes" button in the modal
   const saveChangesBtn = document.querySelector('#snmpUpdate_scrollingModal .btn-primary');
   saveChangesBtn.addEventListener('click', function() {
   	location.reload();
   });



   // Function to show the scrollable modal with the tables
   function showTableModal(tableContent) {
   	const modal = document.getElementById('snmpUpdate_scrollingModal');
   	const successTableBody = modal.querySelector('#snmpupdate_success_table tbody');
   	const errorTableBody = modal.querySelector('#snmpupdate_error_table tbody');

   	// Clear the success and error tables
   	successTableBody.innerHTML = '';
   	errorTableBody.innerHTML = '';

   	// Populate the tables with the provided table content
   	successTableBody.innerHTML = tableContent.successTable;
   	errorTableBody.innerHTML = tableContent.errorTable;

   	// Show the scrollable modal
   	const bsModal = new bootstrap.Modal(modal);
   	bsModal.show();
   }
</script>

</body>

</html>