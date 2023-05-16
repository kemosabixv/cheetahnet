<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Pages / Register - NiceAdmin Bootstrap Template</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="assets/img/favicon.png" rel="icon">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.gstatic.com" rel="preconnect">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="assets/vendor/quill/quill.snow.css" rel="stylesheet">
  <link href="assets/vendor/quill/quill.bubble.css" rel="stylesheet">
  <link href="assets/vendor/remixicon/remixicon.css" rel="stylesheet">
  <link href="assets/vendor/simple-datatables/style.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="assets/css/style.css" rel="stylesheet">

  <!-- =======================================================
  * Template Name: NiceAdmin - v2.5.0
  * Template URL: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>

<body>

  <main>
    <div class="container">

      <section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
        <div class="container">
          <div class="row justify-content-center">
            <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">

              <div class="d-flex justify-content-center py-4">
                <a href="index.html" class="logo d-flex align-items-center w-auto">
                  <img src="assets/img/logo.png" alt="">
                  <span class="d-none d-lg-block">CheetahNet</span>
                </a>
              </div><!-- End Logo -->

              <div class="card mb-3">

                <div class="card-body">

                  <div class="pt-4 pb-2">
                    <h5 class="card-title text-center pb-0 fs-4">Reset Your Password</h5>
                    <p class="text-center small">Enter your e-mail to reset your password</p>
                  </div>

                  <form class="row g-3 needs-validation" id="resetPasswordForm" method="POST" action="javascript:void(0)">
                    <div class="col-12">
                      <label for="yourEmail" class="form-label">Your Username</label>
                      <input type="text" name="userName" class="form-control" id="userName" required>
                      <div class="invalid-feedback">Please enter your username</div>
                    </div>
                    <div class="col-12">
                      <button class="btn btn-primary w-100" type="submit">Reset</button>
                    </div>
                  </form>

                </div>
              </div>

              

            </div>
          </div>
        </div>

      </section>

    </div>
  </main><!-- End #main -->

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
  <script src="assets/js/sweet-alert.js"></script>

  <!-- Template Main JS File -->
  <script src="assets/js/main.js"></script>
  <script type="text/javascript">
      $('#resetPasswordForm').submit(function(e) {
        e.preventDefault();
        var formData = new FormData(this);
        showLoadingDialog("Please Wait...");
        $.ajax({
            type: 'POST',
            url: "resetPassword",
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            success: (data) => {
                console.log(data);
                if (data.error === 0) {
                   
                    swal.close();
                    showResultSweetAlert(data.message, "assets/img/successful_anim.gif");

                } else {
                   
                    swal.close();
                    showResultSweetAlert(data.message, "assets/img/error_anim.gif");

                }
            },
            error: function(data) {
                console.log(data);
            }
        });
    });

    function showLoadingDialog(Message){
        Swal.fire({
            title: Message,
            imageUrl: "assets/img/loading_anim.gif",
            imageWidth: 100,
            imageHeight: 100,
            showConfirmButton: false,
            allowOutsideClick: false

          });
      };


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