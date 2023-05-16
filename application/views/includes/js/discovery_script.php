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
$(document).ready(function() {
  $('#select_int').click(function() {
    $('#InterfaceModal').modal('show');
  });

  $('#InterfaceForm').submit(function(e) {
    e.preventDefault();
    var formData = new FormData(this);
    showLoadingSweetAlert("Saving Interface...");
    $.ajax({
      type: 'POST',
      url: "<?php echo base_url('addinterface'); ?>",
      data: formData,
      cache: false,
      contentType: false,
      processData: false,
      success: function(data) {
        console.log(data);
        if (data.error === 0) {
          $("#InterfaceModal").modal('hide');
          swal.close();
          showResultSweetAlert(data.message, "<?php echo base_url();?>assets/img/successful_anim.gif");
        } else {
          $("#InterfaceModal").modal('hide');
          swal.close();
          showResultSweetAlert(data.message, "<?php echo base_url();?>assets/img/error_anim.gif");
        }
      },
      error: function(data) {
        console.log(data);
      }
    });
  });
});
</script>


</body>

</html>
