
<!DOCTYPE html>
<html lang="en">
<head>
 @include('head')
 @if (session('message'))
 <span class ="aler alert-danger">
<strong> {{session('message')}}</strong>
 </span>
 @endif

</head>
<body class="hold-transition login-page">
<style>
body {
  background-image: url('image/asdd.jpg');
  background-repeat: no-repeat;
  background-size: cover;
  background-attachment: fixed;
}
</style>
<div class="login-box">
  <!-- /.login-logo -->
  <div class="card card-outline card-primary">
    <div class="card-header text-center">
      <a href="template/index2.html" class="h1"><b>Tìm Đồ Thất Lạc</b></a>
    </div>
    <div class="card-body">
      <p class="login-box-msg">Đăng Nhập Để Bắt Đầu</p>
@include('alert')
@include('sweetalert::alert')
      <form action="{{ route('dang-nhap')}}" method="post">
        <div class="input-group mb-3">
          <input type="text" name ="username"  class="form-control" placeholder="Username">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" name="password" class="form-control" placeholder="Password">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-8">
            <div class="icheck-primary">
            <label >
              <input type="checkbox" name="remember" >
                Remember me
              </label>
            </div>
          </div>
          <!-- /.col -->
          <div class="col-4">
            <button type="submit"  class="btn btn-primary btn-block">Đăng Nhập</button>
          </div>
          <!-- /.col -->
        </div>
        @csrf
      </form>
      <script>



</script>
      <p id="demo"></p>
      <!-- /.social-auth-links -->

      
      <p class="mb-0">
        <a href="{{ route('form-them-moi-tai-khoan')}}" class="text-center">Đăng kí tài khoản</a>
      </p>
    </div>
    <!-- /.card-body -->
  </div>
  <!-- /.card -->
</div>
<!-- /.login-box -->
@include('sweetalert::alert') 
<!-- jQuery -->
@include('footer')
</body>
</html>
