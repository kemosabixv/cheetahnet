   </main><!-- End #main -->
 
 <!-- ======= Footer ======= -->
  <footer id="footer" class="footer">
    <div class="copyright">
      &copy; Copyright <strong><span>Codezuka Developers</span></strong>. All Rights Reserved
    </div>
    <div class="credits">
      <!-- All the links in the footer should remain intact. -->
      <!-- You can delete the links only if you purchased the pro version. -->
      <!-- Licensing information: https://bootstrapmade.com/license/ -->
      <!-- Purchase the pro version with working PHP/AJAX contact form: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/ -->
      Designed by <a href="https://bootstrapmade.com/">Pascal Muchiri</a>
    </div>
  </footer><!-- End Footer -->

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
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


  <!-- Template Main JS File -->
  <script src="assets/js/main.js"></script>

  <script>
$(document).ready(function () {
   // Start ping button
   $('#monitor-on').click(function () {
      showLoadingSweetAlert("Turning Monitor On...");
      $.ajax({
         url: "start-ping",
         type: "GET",
         success: function (response) {
            console.log(response);
            if (response === "Ping module started") {
               showResultSweetAlert(response, "assets/img/successful_anim.gif");
            }
         },
         error: function () {
            showResultSweetAlert("<?php echo base_url();?>assets/img/error_anim.gif");
         }
      });
   });

   // Stop ping button
   $('#monitor-off').click(function () {
      showLoadingSweetAlert("Turning Monitor Off...");
      $.ajax({
         url: "stop-ping",
         type: "GET",
         success: function (response) {
            console.log(response);
            if (response === "Ping module stopped") {
               showResultSweetAlert(response, "<?php echo base_url();?>assets/img/successful_anim.gif");
            }
         },
         error: function () {
            showResultSweetAlert("<?php echo base_url();?>assets/img/error_anim.gif");
         }
      });
   });

   // Make an AJAX call to the "monitor-status" route
   function updateMonitorStatus() {
   $.ajax({
      url: "monitor-status",
      method: "GET",
      success: function (response) {
         console.log(response);
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


   updateMonitorStatus(); // Call the function to update the monitor status initially
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






