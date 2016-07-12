<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>GrowOnline | Set Up</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.5 -->
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="plugins/font-awesome/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="plugins/ionicons/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
    <!-- iCheck -->
    <link rel="stylesheet" href="plugins/iCheck/square/blue.css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body class="hold-transition login-page" style="background-image:url(login_bg.jpg);">
    <div class="login-box">
      <div class="login-logo">
        <a href="">Welcome to <b>Grow</b>Online</a>
      </div><!-- /.login-logo -->
      <div class="login-box-body">
        <p class="login-box-msg">Enter your name and a password to create your account</p>
        <form action="" method="POST">
          <div class="form-group has-feedback">
            <input id="inputLogin" name="login" type="text" class="form-control" placeholder="Username">
            <span class="glyphicon glyphicon-user form-control-feedback"></span>
          </div>
          <div class="form-group has-feedback">
            <input id="inputPass" name="pass" type="password" class="form-control" placeholder="Password">
            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
          </div>
          <div class="row">
            <div class="col-xs-8">
              <div class="checkbox icheck">
                
              </div>
            </div><!-- /.col -->
            <div class="col-xs-4">
              <input id="goButton" class="btn btn-primary btn-block btn-flat" value="Go !" />
            </div><!-- /.col -->
          </div>
          </form>
      </div><!-- /.login-box-body -->
    </div><!-- /.login-box -->

    <div id="alert" class="col-md-4 col-md-offset-4 col-xs-12"></div>

    <!-- jQuery 2.1.4 -->
    <script src="plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <!-- Bootstrap 3.3.5 -->
    <script src="bootstrap/js/bootstrap.min.js"></script>
    <!-- iCheck -->
    <script src="plugins/iCheck/icheck.min.js"></script>
    <script>
          $("#goButton").click(function(){
          var login = $('#inputLogin').val();
          var pass = $('#inputPass').val();
          var email = "";
          var mobile = "";
          var rights = true;          
          $.ajax({
            url : 'api/addUser.php',
            type : 'POST',
            data : 'login=' + login + '&pass=' + pass + '&email='+ email + '&mobile=' + mobile + '&admin=' + rights,
            dataType : 'html',
            success : function(result, status){
              //$("#apikeycontain").html(result);
              if(result ==  "1"){
                //alert("Your account has been added with success !"); //Need un truc plus propre, armand halp
                var newAlert = document.createElement('div');
                  newAlert.innerHTML = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-check"></i> Congratulations !</h4>Your account has been added with success !</div>'
                document.getElementById('alert').appendChild(newAlert);
                setTimeout(function(){window.location.href = "dashboard.php";},3000);;
              }
              else if(result == "2"){
                //alert("Your account has been updated with success !"); //Need un truc plus propre, armand halp
                var newAlert = document.createElement('div');
                  newAlert.innerHTML = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-check"></i> Congratulations !</h4>Your account has been updated with success !</div>'
                document.getElementById('alert').appendChild(newAlert);
                setTimeout(function(){window.location.href = "settings.php";},3000);;
              }
              else if(result == "false"){
                //alert("An error occured."); //Need un truc plus propre, armand halp
                var newAlert = document.createElement('div');
                  newAlert.innerHTML = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-ban"></i> Alert !</h4>An error occurred.</div>'
                document.getElementById('alert').appendChild(newAlert);
                setTimeout(function(){window.location.href = "settings.php";},3000);;
              }
              else if(result == "incomplete"){
                //alert("incomplete"); //Need un truc plus propre, armand halp
                var newAlert = document.createElement('div');
                  newAlert.innerHTML = '<div class="alert alert-warning alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-warning"></i> Incomplete form</h4>The informations you entered are incomplete.</div>'
                document.getElementById('alert').appendChild(newAlert);
              }
              else if(result == "403"){
                alert("You must be connected to do this."); //Need un truc plus propre, armand halp
                window.location.href = "index.php";
              }
            },

            error : function(result, statut, error){
              alert("An error occured."); //Need un truc plus propre, armand halp
            }

          });

      });

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
