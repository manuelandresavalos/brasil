<!DOCTYPE html>
<html>
<?php
  if (isset($this->session->userdata['logged_in'])) {
    header("location: http://localhost/brasil/index.php/user_authentication/user_login_process");
  }
  ?>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  
<!-- GOOGLE SINGLE SIGNIN -->
  <meta name="google-signin-scope" content="profile email">
  <meta name="google-signin-client_id" content="258072544669-82asti2n6k8qj3n952oreqs7hsk33k22.apps.googleusercontent.com">
  <script src="https://apis.google.com/js/platform.js" async defer></script>
  <script>
    //Tutorial:
    //https://developers.google.com/identity/sign-in/web/
    function onSignIn(googleUser) {
      // Useful data for your client-side scripts:
      var profile = googleUser.getBasicProfile();
      console.log("ID: " + profile.getId()); // Don't send this directly to your server!
      console.log('Full Name: ' + profile.getName());
      console.log('Given Name: ' + profile.getGivenName());
      console.log('Family Name: ' + profile.getFamilyName());
      console.log("Image URL: " + profile.getImageUrl());
      console.log("Email: " + profile.getEmail());

      // The ID token you need to pass to your backend:
      var id_token = googleUser.getAuthResponse().id_token;
      console.log("ID Token: " + id_token);
    };
  </script>
<!-- END GOOGLE SINGLE SINGIN -->
  <title>AdminLTE 2 | Log in</title>

  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>/assets/bootstrap/3.3.7/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>/assets/AdminLTE/2.3.11/dist/css/AdminLTE.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>/assets/AdminLTE/2.3.11/plugins/iCheck/square/blue.css">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
    <a href="../../index2.html"><b>Admin</b>LTE</a>
  </div>
  <!-- /.login-logo -->
  <div class="login-box-body">
    <p class="login-box-msg">
    <?php
    if (isset($message_display)) {
      echo "<div class='message'>";
      echo $message_display;
      echo "</div>";
    } else {
      echo "Sign in to start your session";
    }
    ?>
    </p>
    <?php echo form_open('login/user_login_process'); ?>
      <?php
      echo "<div class='error_msg'>";
      if (isset($error_message)) {
        echo $error_message;
      }
      echo validation_errors();
      echo "</div>";
      ?>
      <div class="form-group has-feedback">
        <input name="username" type="text" class="form-control" placeholder="Username">
        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
        <input name="password" type="password" class="form-control" placeholder="Password">
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
      </div>
      <div class="row">
        <div class="col-xs-8">
          <div class="checkbox icheck">
            <label>
              <input type="checkbox"> Remember Me
            </label>
          </div>
        </div>
        <!-- /.col -->
        <div class="col-xs-4">
          <button type="submit" class="btn btn-primary btn-block btn-flat">Sign In</button>
        </div>
        <!-- /.col -->
      </div>
    <?php echo form_close(); ?>

    <div class="social-auth-links text-center">
      <p>- OR -</p>
      <a href="#" class="btn btn-block btn-social btn-facebook btn-flat"><i class="fa fa-facebook"></i> Sign in using
        Facebook</a>
      <!-- <a href="#" class="btn btn-block btn-social btn-google btn-flat"><i class="fa fa-google-plus"></i> Sign in using
        Google+</a> -->
      <br>
      <div class="g-signin2" data-onsuccess="onSignIn" data-theme="dark"></div>
    </div>
    <!-- /.social-auth-links -->

    <a href="#">I forgot my password</a><br>
    <a href="register.html" class="text-center">Register a new membership</a>

  </div>
  <!-- /.login-box-body -->
</div>
<!-- /.login-box -->

<!-- jQuery 2.2.3 -->
<script src="<?php echo base_url(); ?>/assets/AdminLTE/2.3.11/plugins/jQuery/jquery-2.2.3.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="<?php echo base_url(); ?>/assets/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<!-- iCheck -->
<script src="<?php echo base_url(); ?>/assets/AdminLTE/2.3.11/plugins/iCheck/icheck.min.js"></script>
<script>
  $(function () {
    $('input').iCheck({
      checkboxClass: 'icheckbox_square-blue',
      radioClass: 'iradio_square-blue',
      increaseArea: '20%' // optional
    });
  });
</script>
</body>
</html>
