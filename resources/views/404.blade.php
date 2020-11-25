<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Page 404 - Not Found</title>

  <!-- Custom fonts for this template-->
    <link href="{{url('Admin/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css')}}">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

  <!-- Custom styles for this template-->
    <link rel="stylesheet" href="{{url('css/mystyle.css')}}">
    <link href="{{url('Admin/css/sb-admin-2.min.css')}}" rel="stylesheet">

</head>

<body id="page-top">

        <!-- Begin Page Content -->
        <div class="container-fluid page-404">

          <!-- 404 Error Text -->
          <div class="text-center">
            <div class="error mx-auto" data-text="404">404</div>
            <p class="lead text-gray-800 mb-5">Page Not Found</p>
            <p class="text-gray-500 mb-3">The best thing about a boolean is even if you are wrong, you are only off by a bit...</p>
            <a href="{{route('home')}}">&larr; Back to Dashboard</a>
          </div>

        </div>
        <!-- /.container-fluid -->

      </div>
      <!-- End of Main Content -->

      <!-- Footer -->
      <footer class="sticky-footer bg-white mt-5">
        <div class="container my-auto">
          <div class="copyright text-center my-auto">
            <span>Copyright &copy; D-Shopee @php echo date('Y') @endphp</span>
          </div>
        </div>
      </footer>
      <!-- End of Footer -->


  <!-- Bootstrap core JavaScript-->
  <script src=" {{url('Admin/vendor/jquery/jquery.min.js')}}"></script>
  <script src=" {{url('Admin/vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>

  <!-- Core plugin JavaScript-->
  <script src=" {{url('Admin/vendor/jquery-easing/jquery.easing.min.js')}}"></script>

  <!-- Custom scripts for all pages-->
  <script src=" {{url('Admin/js/sb-admin-2.min.js')}}"></script>

</body>

</html>
