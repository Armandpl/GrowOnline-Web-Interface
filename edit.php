<?php
include("api/config.php");
session_start();
if(empty($_SESSION["login"])){
  header("location: index.php");
  exit;
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
    <link rel="stylesheet" href="plugins/font-awesome/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="plugins/ionic/ionicons.min.css">
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

<?php
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

if(empty($data["avatar"])) $avatar = "dist/img/user2-160x160.jpg";
else $avatar = $data["avatar"];

if($data["admin"] == 1) $status = "Admin";
else $status = "User";
?>
              <li class="dropdown user user-menu">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                  <img src="<?php echo($avatar) ?>" class="user-image" alt="User Image">
                  <span class="hidden-xs"><?php echo($data["login"])?></span>
                </a>
                <ul class="dropdown-menu">
                  <!-- User image -->
                  <li class="user-header">
                    <img src="<?php echo($avatar) ?>" class="img-circle" alt="User Image">
                    <p>
                      <?php echo($data["login"])?>
                      <small><?php echo($status) ?></small>
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
         
        </section>
        <!-- Main content -->
        <section class="content">
        
        <div class="box box-primary">
        <div class="box-body">

        <div class="row">

        <div class="col-md-4 col-sm-6 col-xs-12">
          <h4>Profile Name</h4>
          <div class="form-group">
          <input id="inputName" name="profile" type="text" min="0" class="form-control" required/>
          </div>        
        </div>  
        </div>

        <div class="row">


        <div class="col-md-4 col-sm-6 col-xs-12">
          <div class="form-group">
          <textarea class="form-control" id="inputDescription" rows="2" placeholder="Write a short description" maxlength="100"></textarea>
          </div>        
        </div>  

        </div>

        <div class="row">

            <div class="col-md-6 col-sm-12">
              <div class="box box-danger">

                  <div class="box-header with-border">
                    <span class="ion ion-android-sunny">
                      <h3 class="box-title">Lamp</h3>
                  </div><!-- /.box-header -->

                  <div class="box-body">

                      <div class="col-sm-3 col-xs-12">
                       <h5>Sunrise</h5>
                        <div class="form-group">
                        <input id="inputSunrise" name="sunrise" type="time" value="00:00" class="form-control" required/>
                        </div>        
                      </div>      
                              
                      <div class="col-sm-3 col-xs-12">
                       <h5>Sunset</h5>
                        <div class="form-group">
                        <input id="inputSunset" name="sunset" type="time" value="00:00" class="form-control" required/>
                        </div>        
                      </div>          

                  </div><!-- /.box-body -->

              </div><!-- /.box -->
            </div>

            <div class="col-md-6 col-sm-12">
              <div class="box box-gray">

                    <div class="box-header with-border">
                      <span class="ion ion-load-b">
                        <h3 class="box-title">Fan</h3>
                    </div><!-- /.box-header -->

                    <div class="box-body">

                      <div class="col-sm-3 col-xs-12">
                       <h5>Working Time</h5>
                        <div class="form-group">
                        <input id="inputWorkingTime" name="working_time" type="time" value="00:00" class="form-control" required/>
                        </div>        
                      </div>      
                              
                      <div class="col-sm-3 col-xs-12">
                       <h5>Interval</h5>
                        <div class="form-group">
                        <input id="inputInterval" name="interval" type="time" value="00:00" class="form-control" required/>
                        </div>        
                      </div>          

                    </div><!-- /.box-body -->

                </div><!-- /.box -->
            </div>
            
        </div><!--/.row-->
        <div class="row">

            <div class="col-md-6 col-sm-12">
              <div class="box box-info">

                  <div class="box-header with-border">
                    <span class="ion ion-waterdrop">
                      <h3 class="box-title">Watering</h3>
                  </div><!-- /.box-header -->

                  <div class="box-body">
                    <div class="col-sm-4 col-xs-12" id="water_days">
                      <h4>Water Days</h4>

                            <label style="display:block;">
                              <input id="inputMonday" type="checkbox" class="flat-red" >
                              Monday
                            </label> 
                            <label style="display:block;">
                              <input checked='checked' id="inputTuesday" type="checkbox" class="flat-red" >
                              Tuesday
                            </label> 
                            <label style="display:block;">
                              <input id="inputWednesday" type="checkbox" class="flat-red" >
                              Wednesday
                            </label> 
                            <label style="display:block;">
                              <input id="inputThursday" type="checkbox" class="flat-red" >
                              Thursday
                            </label> 
                            <label style="display:block;">
                              <input id="inputFriday" type="checkbox" class="flat-red" >
                              Friday
                            </label> 
                            <label style="display:block;">
                              <input id="inputSaturday" type="checkbox" class="flat-red" >
                              Saturday
                            </label> 
                            <label style="display:block;">
                              <input id="inputSunday" type="checkbox" class="flat-red" >
                              Sunday
                            </label> 

                            
                      </div>  

                    <div class="col-sm-4 col-xs-12">
                     <h5>Tank Capacity</h5> 
                      <div class="form-group">
                      <input id="inputTankCapacity" name="tank_capacity" type="number" min="0" step="0.1" class="form-control" value="0" required/>
                      </div>        
                    </div>      
                            
                    <div class="col-sm-4 col-xs-12">
                     <h5>Pump Flow</h5>
                      <div class="form-group">
                      <input id="inputPumpFlow" name="pump_flow" type="number" min="0" step="0.1" value="105" class="form-control" required/>
                      </div>        
                    </div>          
                      
                    <div class="col-sm-4 col-xs-12">
                     <h5>Watering Hour</h5>
                      <div class="form-group">
                      <input id="inputWateringHour" name="watering_hour" type="time" value="" class="form-control" required/>
                      </div>        
                    </div>      
                    
                    <div class="col-sm-4 col-xs-12">
                     <h5>Amount of water</h5>
                      <div class="form-group">
                      <input id="inputWaterAmount" name="water" type="number" min="0" step="0.1" value="25" class="form-control" required/>
                      </div>        
                    </div>    
                  </div><!-- /.box-body -->

              </div><!-- /.box -->
            </div>

            <div class="col-md-6 col-sm-12">
              <div class="box box-success">

                    <div class="box-header with-border">
                      <span class="ion ion-leaf">
                        <h3 class="box-title">Environment</h3>
                    </div><!-- /.box-header -->

                    <div class="box-body">

                      <div class="col-sm-3 col-xs-12">
                       <h5>Temperature</h5>
                        <div class="form-group">
                        <input id="inputTemperature" name="temperature" type="number" min="0" max="50" step="0.1" class="form-control" value="25" required/>
                        </div>        
                      </div>      
                              
                      <div class="col-sm-3 col-xs-12">
                       <h5>Humidity</h5>
                        <div class="form-group">
                        <input id="inputHumidity" name="humidity" type="number" min="0" max="100" step="0.1" class="form-control" value="50" required/>
                        </div>        
                      </div>          

                    </div><!-- /.box-body -->

                </div><!-- /.box -->

            </div> 
            <div id="alert" class="col-md-4 col-md-offset-4 col-xs-12"></div>
           
            
        </div><!--/.row-->

         <div class="col-xs-12"> 
          <div class="pull-right">
          <button id="saveButton" type="submit" class="btn btn-success btn-lg">Save</button> <a href="profiles.php"><button type="cancel" class="btn bg-gray btn-lg">cancel</button></a>
          </div>
         </div> 

        </div>
        </div>
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

    <script src="plugins/iCheck/icheck.min.js"></script>  

    <script>
            //iCheck for checkbox and radio inputs
        $('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
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
        });

        $("#saveButton").click(function(){
          var name = $('#inputName').val();
          var description = $('#inputDescription').val();
          var sunrise = $('#inputSunrise').val();
          var sunset = $('#inputSunset').val();
          var workingTime = $('#inputWorkingTime').val();
          var interval = $('#inputInterval').val();
          var monday = $('#inputMonday').is(':checked');
          var tuesday = $('#inputTuesday').is(':checked');
          var thursday = $('#inputThursday').is(':checked');
          var wednesday = $('#inputWednesday').is(':checked');
          var friday = $('#inputFriday').is(':checked');
          var saturday = $('#inputSaturday').is(':checked');
          var sunday = $('#inputSunday').is(':checked');
          var tankCapacity = $('#inputTankCapacity').val();
          var pumpFlow = $('#inputPumpFlow').val();
          var wateringHour = $('#inputWateringHour').val();
          var waterAmount = $('#inputWaterAmount').val();
          var temperature = $('#inputTemperature').val();
          var humidity = $('#inputHumidity').val();

          //var data = "name=" + name + "&description=" + description + "&sunrise=" + sunrise + "&sunset=" + sunset + "&interval=" + interval + "&working_time=" + workingTime + "&tank_capacity=" + tankCapacity + "&pump_flow=" + pumpFlow + "&watering_hour=" + wateringHour + "&water_amount=" + waterAmount + "&temperature=" + temperature + "&humidity=" + humidity + "&monday=" + monday + "&tuesday=" + tuesday +"&wednesday=" + wednesday + "&thursday=" + thursday + "&friday=" + friday + "&saturday=" + saturday + "&sunday=" + sunday;
<?php
if(!empty($_GET["id"])){
  echo('var data = "name=" + name + "&description=" + description + "&sunrise=" + sunrise + "&sunset=" + sunset + "&interval=" + interval + "&working_time=" + workingTime + "&tank_capacity=" + tankCapacity + "&pump_flow=" + pumpFlow + "&watering_hour=" + wateringHour + "&water_amount=" + waterAmount + "&temperature=" + temperature + "&humidity=" + humidity + "&monday=" + monday + "&tuesday=" + tuesday +"&wednesday=" + wednesday + "&thursday=" + thursday + "&friday=" + friday + "&saturday=" + saturday + "&sunday=" + sunday + "&update=true&id=' . $_GET["id"] . '";');
}
else{
  echo('var data = "name=" + name + "&description=" + description + "&sunrise=" + sunrise + "&sunset=" + sunset + "&interval=" + interval + "&working_time=" + workingTime + "&tank_capacity=" + tankCapacity + "&pump_flow=" + pumpFlow + "&watering_hour=" + wateringHour + "&water_amount=" + waterAmount + "&temperature=" + temperature + "&humidity=" + humidity + "&monday=" + monday + "&tuesday=" + tuesday +"&wednesday=" + wednesday + "&thursday=" + thursday + "&friday=" + friday + "&saturday=" + saturday + "&sunday=" + sunday;');
}
?>

          $.ajax({
            url : 'api/addProfile.php',
            type : 'POST',
            data : "" + data,
            dataType : 'html',
            success : function(result, status){
              alert(result);
              $("#apikeycontain").html(result);
              if(result ==  "1"){
                //alert("Your account has been added with success !"); //Need un truc plus propre, armand halp
                var newAlert = document.createElement('div');
                  newAlert.innerHTML = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-check"></i> Congratulations !</h4>Your profile has been added with success !</div>'
                document.getElementById('alert').appendChild(newAlert);
                //setTimeout(function(){window.location.href = "profiles.php";},3000);;
              }
              else if(result == "2"){
                //alert("Your account has been updated with success !"); //Need un truc plus propre, armand halp
                var newAlert = document.createElement('div');
                  newAlert.innerHTML = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-check"></i> Congratulations !</h4>Your profile has been updated with success !</div>'
                document.getElementById('alert').appendChild(newAlert);
                setTimeout(function(){window.location.href = "profiles.php";},3000);;
              }
              else if(result == "false"){
                //alert("An error occured."); //Need un truc plus propre, armand halp
                var newAlert = document.createElement('div');
                  newAlert.innerHTML = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-ban"></i> Alert !</h4>An error occurred.</div>'
                document.getElementById('alert').appendChild(newAlert);
                //setTimeout(function(){window.location.href = "profiles.php";},3000);;
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


    </script>
  </body>
</html>
