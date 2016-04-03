<?php
include("api/config.php");
session_start();
if(empty($_SESSION["login"])){
  header("location: index.php");
  exit;
}


try{
  $bdd = new PDO("mysql:host=" . $configHostBdd . ";dbname=" . $configNameBdd .";charset=utf8", $configUserBdd, $configPassBdd);
}
catch (Exception $e){
  die($e->getMessage());
}

$request = $bdd->prepare('SELECT * FROM users WHERE id = :id');
$request ->execute(array(
    'id' => $_SESSION["id"]
    ));

$data = $request->fetch();

if(empty($data["avatar"])) $data["avatarURL"] = "dist/img/user2-160x160.jpg";
else $data["avatarURL"] = $data["avatar"];

if($data["admin"] == 1) $data["status"] = "Admin";
else $data["status"] = "User";
$request->closeCursor();



if(!empty($_GET["id"]) && $_GET["id"] !== $data["id"] && $data["admin"] == 1){

  $request = $bdd->prepare('SELECT * FROM users WHERE id = :id');
  $request ->execute(array(
      'id' => $_GET["id"]
      ));
  $user = $request->fetch();

  if(empty($user["avatar"])) $user["avatarURL"] = "dist/img/user2-160x160.jpg";
  else $user["avatarURL"] = $user["avatar"];


  if($user["admin"] == 1) $user["status"] = "Admin";
  else $user["status"] = "User";

  $request->closeCursor();
}
else if(!empty($_GET["id"]) && $_GET["id"] == $data["id"]){
  $user = $data;
}
else{
  header("Location: index.php");
}


?>
<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Grow Online</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.5 -->
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- jvectormap -->
    <link rel="stylesheet" href="plugins/jvectormap/jquery-jvectormap-1.2.2.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">

    <link rel="stylesheet" href="plugins/iCheck/all.css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <script type="text/javascript">

  </script>
  </head>
  <!--
  BODY TAG OPTIONS:
  =================
  Apply one or more of the following classes to get the
  desired effect
  |---------------------------------------------------------|
  | SKINS         | skin-blue                               |
  |               | skin-black                              |
  |               | skin-purple                             |
  |               | skin-yellow                             |
  |               | skin-red                                |
  |               | skin-green                              |
  |---------------------------------------------------------|
  |LAYOUT OPTIONS | fixed                                   |
  |               | layout-boxed                            |
  |               | layout-top-nav                          |
  |               | sidebar-collapse                        |
  |               | sidebar-mini                            |
  |---------------------------------------------------------|
  -->
  <body class="hold-transition skin-green sidebar-mini">
    <div class="wrapper">

      <!-- Main Header -->
            <header class="main-header">

        <!-- Logo -->
        <a href="dashboard.php" class="logo">
          <!-- mini logo for sidebar mini 50x50 pixels -->
          <span class="logo-mini"><b>G</b>O</span>
          <!-- logo for regular state and mobile devices -->
          <span class="logo-lg"><b>Grow</b>Online</span>
        </a>

        <!-- Header Navbar -->
        <nav class="navbar navbar-static-top" role="navigation">
          <!-- Sidebar toggle button-->
          <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
          </a>
          <!-- Navbar Right Menu -->
          <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">

              <!-- Notifications Menu -->
              <li class="dropdown notifications-menu">
                <!-- Menu toggle button -->
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                  <i class="fa fa-bell-o"></i>
                  <!--<span class="label label-info">10</span>-->
                </a>
                <ul class="dropdown-menu">
                  <li class="header">No notifications</li>
                  <li>
                    <!-- Inner Menu: contains the notifications -->
                    <ul class="menu">
                      <!--<li>
                        <a href="#">
                          <i class="fa fa-users text-aqua"></i> 5 new members joined today
                        </a>
                      </li>--><!-- end notification -->
                    </ul>
                  </li>
                  <li class="footer"><a href="#">View all</a></li>
                </ul>
              </li>              
              <!-- User Account: style can be found in dropdown.less -->
              <li class="dropdown user user-menu">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                  <img src="<?php echo($data["avatarURL"]) ?>" class="user-image" alt="User Image">
                  <span class="hidden-xs"><?php echo($data["login"])?></span>
                </a>
                <ul class="dropdown-menu">
                  <!-- User image -->
                  <li class="user-header">
                    <img src="<?php echo($data["avatarURL"]) ?>" class="img-circle" alt="User Image">
                    <p>
                      <?php echo($data["login"])?>
                      <small><?php echo($data["status"]) ?></small>
                    </p>
                  </li>
                  <!-- Menu Footer-->
                  <li class="user-footer">
                    <div class="pull-left">
                    <a href="editUserProfile.php?id=<?php echo($data["id"])?>" class="btn btn-default btn-flat">Edit</a>
                    </div>
                    <div class="pull-right">
                      <a href="api/logout.php" class="btn btn-default btn-flat">Sign out</a>
                    </div>
                  </li>
                </ul>

              </li>
              
            </ul>
          </div>
        </nav>
      </header>
      <!-- Left side column. contains the logo and sidebar -->
      <aside class="main-sidebar">

        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">

          <!-- Sidebar Menu -->
          <ul class="sidebar-menu">
            <!--<li class="header">HEADER</li>-->
            <!-- Optionally, you can add icons to the links -->
            <li><a href="dashboard.php"><i class="fa fa-tv"></i> <span>Dashboard</span></a></li>
            <li><a href="profiles.php"><i class="fa fa-link"></i> <span>Profiles</span></a></li>
            <li><a href="settings.php"><i class="fa fa-gear"></i> <span>Settings</span></a></li>
          </ul><!-- /.sidebar-menu -->
        </section>
        <!-- /.sidebar -->
      </aside>

      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
         <h1>
            User Profile
          </h1>
        </section>

        <!-- Main content -->
        <section class="content">

        <div class="row">

          <div class="col-xs-12 col-md-6 col-md-offset-3">

              <!-- Profile Image -->
              <div class="box box-primary">
                <div class="box-body box-profile">
                  <img class="profile-user-img img-responsive img-circle" src="<?php echo($user["avatarURL"]); ?>" alt="User profile picture">
                  <h3 class="profile-username text-center">
                    <span contenteditable="true" id="inputLogin"><?php echo($user["login"]); ?></span>
                    <span class="fa fa-edit"></span>
                  </h3>
                  <!-- <p class="text-muted text-center"><?php echo($user["status"]) ?></p> -->
<?php
if($data["admin"] == 1){
?>
                      <label class="col-sm-2 control-label">Rights</label>
                      <div class="col-sm-10">
                        <select id="rights" class="form-control">
                        <option value="0" <?php if($user["admin"] == 0) echo("selected"); ?> >User</option>
                        <option value="1" <?php if($user["admin"] == 1) echo("selected"); ?> >Admin</option>
                        </select>
                      </div>
<?php
}
?>
                    <div class="form-group">
                      <label for="inputPass" class="col-sm-2 control-label">Password</label>
                      <div class="col-sm-10">
                        <input type="password" class="form-control" id="inputPass" placeholder="Enter a new password">
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="inputEmail" class="col-sm-2 control-label">Avatar</label>
                      <div class="col-sm-10">
                        <input type="text" class="form-control" value="<?php echo($user["avatar"]); ?>" id="inputAvatar" placeholder="Enter an image URL for this account's avatar">
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="inputEmail" class="col-sm-2 control-label">E-mail</label>
                      <div class="col-sm-10">
                        <input type="email" class="form-control" value="<?php echo($user["email"]); ?>" id="inputEmail" placeholder="Enter e-mail address">
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="inputMobile" class="col-sm-2 control-label">Mobile Phone</label>
                      <div class="col-sm-10">
                        <input type="tel" class="form-control" value="<?php echo($user["mobile"]); ?>" id="inputMobile" placeholder="Enter mobile phone number">
                      </div>
                    </div>



                </div><!-- /.box-body -->
              </div><!-- /.box -->
                       
            <div class="box box-primary">

              <div class="box-header with-border">              
                <h3 class="box-title">Alerts/Notifications</h3>
                <div class="col-xs-12">
                  <form class="form-horizontal">
                  <div class="form-group">
                    <label class="col-sm-3 control-label">E-mail alerts</label> 
                    <div class="col-sm-8">
                      <input id="emailalerts" type="checkbox" class="flat-red" <?php if($user["alertemail"] == 1) echo("checked"); ?> />
                    </div>
                  </div>
                    <div class="form-group">
                      <label class="col-sm-3 control-label">SMS alerts</label> 
                      <div class="col-sm-8">
                        <input id="smsalerts" type="checkbox" class="flat-red" <?php if($user["alertsms"] == 1) echo("checked"); ?> />
                      </div>
                    </div>
                  </form>
                  </div>
              </div><!-- /.box-header -->

              <div class="box-body">
              </div>

            </div> 
                       
            <div class="box box-primary">

              <div class="box-header with-border">              
                <h3 class="box-title">SMS API</h3>                  
              </div><!-- /.box-header -->

              <div class="box-body">
              <div class="col-xs-12">
                <div class="form-group" id="alert">
                <label>Copy/Paste your SMS API link down below to receive SMS notifications.</label>                
                <input id="inputApiKey" value="<?php echo($user["apikey"]); ?>" placeholder="API link" type="text" min="0" class="form-control" required/>
                <div class="pull-right" style="margin-top:10px;">
                 <button class="btn btn-primary" id="saveButton">Save</button>
                </div>  
                </div>    
              </div>                        

              </div>

            </div> 

            </div><!-- /.col -->
          
        </div> <!--/.row-->
        </section><!-- /.content -->

      </div><!-- /.content-wrapper -->

      <!-- Main Footer -->
    <!--  <footer class="main-footer">
        <!-- To the right -->
        <!--<div class="pull-right hidden-xs">
          Anything you want
        </div>
        <!-- Default to the left -->
        <!--<strong>Copyright &copy; 2015 <a href="#">Company</a>.</strong> All rights reserved.
      </footer>-->

    </div><!-- ./wrapper -->

    <!-- REQUIRED JS SCRIPTS -->

    <!-- jQuery 2.1.4 -->
    <script src="plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <!-- Bootstrap 3.3.5 -->
    <script src="bootstrap/js/bootstrap.min.js"></script>
    <!-- FastClick -->
    <script src="plugins/fastclick/fastclick.min.js"></script>
    <!-- AdminLTE App -->
    <script src="dist/js/app.min.js"></script>
    <!-- Sparkline -->
    <script src="plugins/sparkline/jquery.sparkline.min.js"></script>
    <!-- jvectormap -->
    <script src="plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
    <script src="plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
    <!-- SlimScroll 1.3.0 -->
    <script src="plugins/slimScroll/jquery.slimscroll.min.js"></script>
    <!-- ChartJS 1.0.1 -->
    <script src="plugins/chartjs/Chart.min.js"></script>     

        <script>
            //iCheck for checkbox and radio inputs
        /*$('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
          checkboxClass: 'icheckbox_minimal-blue',
          radioClass: 'iradio_minimal-blue'
        });
        //Red color scheme for iCheck
        $('input[type="checkbox"].minimal-red, input[type="radio"].minimal-red').iCheck({
          checkboxClass: 'icheckbox_minimal-red',
          radioClass: 'iradio_minimal-red'
        });
        //Flat red color scheme for iCheck
        $('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
          checkboxClass: 'icheckbox_flat-green',
          radioClass: 'iradio_flat-green'

        });*/

        $("#saveButton").click(function(){
          var login = $('#inputLogin').html();
          var pass = $('#inputPass').val();
          var email = $('#inputEmail').val();
          var mobile = $('#inputMobile').val();
          var rights = $('#rights :selected').val();
          var apikey = $('#inputApiKey').val();
          var emailalerts = $('#emailalerts').is(':checked');
          var smsalerts = $('#smsalerts').is(':checked');
          var avatar = $('#inputAvatar').val();
          var id = getQueryVariable("id")
          //alert(id);
          //alert(login);
          $.ajax({
            url : 'api/updateUser.php',
            type : 'POST',
            data : 'login=' + login + '&pass=' + pass + '&email='+ email + '&mobile=' + mobile + '&alertemail=' + emailalerts + '&alertsms=' + smsalerts + '&admin=' + rights  + '&apikey=' + apikey + '&avatar=' + avatar + "&id=" + id,
            dataType : 'html',
            success : function(result, status){
              //alert(result);
              //$("#apikeycontain").html(result);
              if(result ==  "1"){
                //alert("Your account has been added with success !"); //Need un truc plus propre, armand halp
                var newAlert = document.createElement('div');
                  newAlert.innerHTML = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-check"></i> Congratulations !</h4>Your account has been added with success !</div>'
                document.getElementById('alert').appendChild(newAlert);
                setTimeout(function(){window.location.href = "settings.php";},3000);;
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
                //alert("An error occured."); //Need un truc plus propre, armand halp
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

      /*$("#smsalerts").click(function(){
        alert("test");
        var checkTest = $('#smsalerts').is(':checked');
          if(checkTest){
            $("#apikeycontain").html('<label for="apikey" class="col-sm-2 control-label">SMS api key</label><div class="col-sm-10"><input type="email" class="form-control" id="apikey" placeholder="Enter your SMS api key"></div>');
          }
          else{
            $("#apikeycontain").html(' ');
          }
          
   
      });*/


function getQueryVariable(variable) {
  var query = window.location.search.substring(1);
  var vars = query.split("&");
  for (var i=0;i<vars.length;i++) {
    var pair = vars[i].split("=");
    if (pair[0] == variable) {
      return pair[1];
    }
  } 
  return 0;
}



    </script>  

  </body>
</html>
