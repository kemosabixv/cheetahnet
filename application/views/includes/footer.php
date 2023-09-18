   </main><!-- End #main -->

   <footer id="footer" class="footer">
  <div class="credits">
    Designed by <a href="https://bootstrapmade.com/">Pascal Muchiri</a>
  </div>
  <!-- <div class="copyright">
    &copy; <span>Codezuka Developers</span>. All Rights Reserved
  </div> -->
</footer><!-- End Footer -->

<a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

<!-- Vendor JS Files -->
<script src="<?php echo base_url('assets/js/jquery.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/vendor/apexcharts/apexcharts.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/vendor/bootstrap/js/bootstrap.bundle.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/vendor/chart.js/chart.umd.js'); ?>"></script>
<script src="<?php echo base_url('assets/vendor/echarts/echarts.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/vendor/quill/quill.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/vendor/simple-datatables/simple-datatables.js'); ?>"></script>
<script src="<?php echo base_url('assets/vendor/tinymce/tinymce.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/vendor/php-email-form/validate.js'); ?>"></script>
<script src="<?php echo base_url('assets/vendor/datatable/js/jquery.dataTables.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/vendor/datatable/js/dataTables.bootstrap5.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/sweet-alert.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/main.js'); ?>"></script>


<script>
$(document).ready(function () {
	// Start ping button
	$('#monitor-on').click(function () {
		showLoadingSweetAlert("Turning Monitor On...");
		$.ajax({
			url: "<?php echo base_url('start-ping'); ?>",
			type: "GET",
			success: function (response) {
				console.log(response);
				if (response === "Ping module started") {
					showResultSweetAlert(response, "<?php echo base_url('assets/img/successful_anim.gif'); ?>");
				}
			},
			error: function () {
				showResultSweetAlert("<?php echo base_url('assets/img/error_anim.gif'); ?>");
			}
		});
	});

	// Stop ping button
	$('#monitor-off').click(function () {
		showLoadingSweetAlert("Turning Monitor Off...");
		$.ajax({
			url: "<?php echo base_url('stop-ping'); ?>",
			type: "GET",
			success: function (response) {
				console.log(response);
				if (response === "Ping module stopped") {
					showResultSweetAlert(response, "<?php echo base_url('assets/img/successful_anim.gif'); ?>");
				}
			},
			error: function () {
				showResultSweetAlert("<?php echo base_url('assets/img/error_anim.gif'); ?>");
			}
		});
	});
	
		// Update monitor status function
		function updateMonitorStatus() {
			$.ajax({
				url: "<?php echo base_url('monitor-status'); ?>",
				method: "GET",
				success: function (response) {
					// console.log(response);
					if (response === "true") {
						$('#monitor-status').html('<span class="badge bg-success">Running</span>');
					} else if (response === "false") {
						$('#monitor-status').html('<span class="badge bg-danger">Not Running</span>');
					} else {
						$('#monitor-status').html('<span class="badge bg-danger">Error</span>');
					}
				},
				error: function (jqXHR, textStatus, errorThrown) {
					console.error(textStatus, errorThrown);
				}
			});
		}
	


	setInterval(() => {
		$.ajax({
		url: "<?php echo base_url('getNotificationList'); ?>",
		method: "GET",
		success: function (response) {
			var notifications = response.data;

			// Clear the existing notifications
			$('#notificationlist').empty();

			// Set the notification count
			$('#notification_count_1').text(notifications.length);
			$('#notification_count_2').text(notifications.length);

			// Iterate through each notification and create the corresponding HTML
			notifications.forEach(function (notification) {
				var iconClass = (notification.connection_status === 'Offline') ? 'bi-exclamation-circle text-warning' : 'bi-check-circle text-success';
				var deviceName = notification.device_name;
				var ipNotice = notification.ip_address + ' is ' + notification.connection_status;
				var dateTime = calculateTimeAgo(notification.date_created);

				var notificationItem = `
      <li>
              <hr class="dropdown-divider">
            </li>
        <li class="notification-item">
          <i class="bi ${iconClass}"></i>
          <div>
            <h4>${deviceName}</h4>
            <p>${ipNotice}</p>
            <p>${dateTime}</p>
          </div>
        </li>
      `;

				// Append the notification item to the notifications list
				$('#notificationlist').append(notificationItem);
			});
		},
		error: function (jqXHR, textStatus, errorThrown) {
			console.error(textStatus, errorThrown);
		}
	});
	}, 2000);




	// Function to calculate the time ago from the given date
	function calculateTimeAgo(date) {
		var currentDate = new Date();
		var notificationDate = new Date(date);
		var timeDiff = Math.abs(currentDate.getTime() - notificationDate.getTime());

		var days = Math.floor(timeDiff / (1000 * 3600 * 24));
		var hours = Math.floor((timeDiff % (1000 * 3600 * 24)) / (1000 * 3600));
		var minutes = Math.floor((timeDiff % (1000 * 3600)) / (1000 * 60));

		var timeAgo = '';
		if (days > 0) {
			timeAgo += days + 'd ';
		}
		if (hours > 0) {
			timeAgo += hours + 'h ';
		}
		if (minutes > 0) {
			timeAgo += minutes + 'm ';
		}
		timeAgo += 'ago';

		return timeAgo;
	}
	updateMonitorStatus();

	setInterval(() => {
	updateMonitorStatus(); // Call the function to update the monitor status initially
	}, 2000);
});

function showLoadingSweetAlert(title) {
	Swal.fire({
		text: title,
		imageUrl: "<?php echo base_url('assets/img/loading_anim.gif'); ?>",
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