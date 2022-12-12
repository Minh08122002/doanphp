
<!DOCTYPE html>
<html lang="en">
<head>
  @include('head')
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">
  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
     
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
     
      

     
      <li class="nav-item">
        <a class="nav-link" data-widget="fullscreen" href="#" role="button">
          <i class="fas fa-expand-arrows-alt"></i>
        </a>
      </li>
      
    </ul>
  </nav>
  <!-- /.navbar -->

 @include('sidebar')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        @include('alert')
        <div class="row">
          <!-- left column -->
          <div class="col-md-12">
            <!-- jquery validation -->
            <div class="card card-primary mt-3">
              <div class="card-header">
                <h3 class="card-title"></h3>  
                
              </div>
               @yield('content')

            </div>
            <!-- /.card -->
            </div>
          <!--/.col (left) -->
          <!-- right column -->
          <div class="col-md-6">

          </div>
          <!--/.col (right) -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
 
</div>
<!-- ./wrapper -->

@include('footer')
<script src="{{ url('/sweetalert2/dist/sweetalert2.all.min.js') }}"></script>
<script>
  $('.xoa').click(function(event) {
      //This will choose the closest form to the button
      var form = $(this).closest("form");

      //don't let the form submit yet
      event.preventDefault();

      //configure sweetalert alert as you wish
      Swal.fire({
        title: 'Bạn có muốn xóa?',
        text: "Bạn sẽ không thể hoàn tác tác vụ này.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Đồng ý!',
        cancelButtonText: "Huỷ bỏ!",
      }).then((result) => {
        if (result.isConfirmed) {
          form.submit();
        }
      })

    });
</script>
</body>
</html>
