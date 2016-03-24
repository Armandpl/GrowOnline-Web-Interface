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

    <link rel="stylesheet" href="plugins/select2/select2.min.css">

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
                    <a href="editUserProfile.php" class="btn btn-default btn-flat">Edit</a>
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
            <li class="active"><a href="#"><i class="fa fa-tv"></i> <span>Dashboard</span></a></li>
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

        <div class="row">
          
            <div class="col-md-6 col-xs-12">
              <!-- interactive chart -->
              <div class="box box-danger">
                <div class="box-header with-border">
                  <i class="fa fa-bar-chart-o"></i>
                  <h3 class="box-title">Temperature</h3>
                </div>
                <div class="box-body">
                  <div id="temperature_chart" style="height: 300px;"></div>
                </div><!-- /.box-body-->
              </div><!-- /.box -->

            </div><!-- /.col -->

            <div class="col-md-6 col-xs-12">
              <!-- interactive chart -->
              <div class="box box-primary">
                <div class="box-header with-border">
                  <i class="fa fa-bar-chart-o"></i>
                  <h3 class="box-title">Humidity</h3>
                </div>
                <div class="box-body">
                  <div id="humidity_chart" style="height: 300px;"></div>
                </div><!-- /.box-body-->
              </div><!-- /.box -->

            </div><!-- /.col -->

          <div class="col-md-6 col-xs-12">

                <div class="info-box bg-orange">
                  <a onclick="trigger('heater');" class="info-box-icon" style="cursor: pointer;"><i class="glyphicon glyphicon-flash" style="color: white;"></i></a>                  
                  <div class="info-box-content">
                    <span class="info-box-text">Heater</span>
                    <span class="info-box-number" id="heater"></span>                    
                  </div><!-- /.info-box-content -->
                </div><!-- /.info-box -->

                <!-- Info Boxes Style 2 -->
                <div class="info-box bg-yellow">
                  <a onclick="updateSelect();" class="info-box-icon" style="cursor: pointer;"><i class="fa fa-link" style="color: white;"></i></a>
                  <div class="info-box-content">
                    <span class="info-box-text">Current Profile</span>
                    <div class="form-group">
                    <select onchange="onSelectChange();" id="select" class="form-control select2" style="width: 75%;">
                      <?php include("api/getProfilesList.php");?>                     
                    </select>
                    <a href="edit.php" style="display: inline-block;"><button class="btn btn-default">Edit</button></a>
                  </div><!-- /.form-group -->
                    <!--<span class="info-box-number" id="currentProfile"></span>-->
                    
                  </div><!-- /.info-box-content -->
                </div><!-- /.info-box -->

                <div class="info-box bg-green">
                  <span class="info-box-icon"><i class="ion ion-leaf"></i></span>
                  <div class="info-box-content">
                    <span class="info-box-text">Environnement</span>
                    <span class="info-box-number" id="temperature"></span>                    
                    <span class="info-box-number" id="humidity"></span>      
                  </div><!-- /.info-box-content -->
                </div><!-- /.info-box -->

                <div class="info-box bg-red">
                  <a onclick="trigger('lamp');" class="info-box-icon" style="cursor: pointer;"><i class="ion ion-android-sunny" style="color: white;"></i></a>                  
                  <div class="info-box-content">
                    <span class="info-box-text">Lamp</span>
                    <span class="info-box-number" id="lamp"></span>                    
                  </div><!-- /.info-box-content -->
                </div><!-- /.info-box -->

          </div>

          <div class="col-md-6 col-xs-12">
                  <div class="info-box bg-maroon">
                  <a onclick="trigger('fan');" class="info-box-icon" style="cursor: pointer;"><i class="ion ion-load-b" style="color: white;"></i></a>                                    
                  <div class="info-box-content">
                    <span class="info-box-text">Fan</span>
                    <span class="info-box-number" id="fan"></span>                    
                  </div><!-- /.info-box-content -->
                </div><!-- /.info-box -->

                <div class="info-box bg-aqua">                  
                  <a onclick="trigger('waterPump');" class="info-box-icon" style="cursor: pointer;"><i class="ion ion-waterdrop" style="color: white;"></i></a>                                    
                  <div class="info-box-content">
                    <span class="info-box-text">Water Pump</span>
                    <span class="info-box-number" id="waterPump"></span>                    
                  </div><!-- /.info-box-content -->
                </div><!-- /.info-box -->

                <div class="info-box bg-purple">
                  <span class="info-box-icon"><i class="fa fa-tv"></i></span>
                  <div class="info-box-content">
                    <span class="info-box-text">Uptime</span>
                    <span class="info-box-number" id="uptime"></span>                    
                  </div><!-- /.info-box-content -->
                </div><!-- /.info-box -->
          </div>

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
     <!-- FLOT CHARTS -->
    <script src="plugins/flot/jquery.flot.min.js"></script>
    <!-- FLOT RESIZE PLUGIN - allows the chart to redraw when the window is resized -->
    <script src="plugins/flot/jquery.flot.resize.min.js"></script>
    <!-- FLOT PIE PLUGIN - also used to draw donut charts -->
    <script src="plugins/flot/jquery.flot.pie.min.js"></script>
    <!-- FLOT CATEGORIES PLUGIN - Used to draw bar charts -->
    <script src="plugins/flot/jquery.flot.categories.min.js"></script>

    <script src="plugins/select2/select2.full.min.js"></script>
    
        <!-- Page script -->
    <script>
      $(function () {$(".select2").select2(); });

      function trigger(target)
      {
        $.post("api/trigger.php",{target: target},function( data ) 
          {
            if(target=="lamp"){$("#lamp").html(data);}
            if(target=="fan"){$("#fan").html(data);}
            if(target=="waterPump"){$("#waterPump").html(data);}
            if(target=="heater"){$("#heater").html(data);}
          });
      }

      function onSelectChange()
      {
        select = $("#select").val();
        $.post("api/setProfile.php",{select: select});
      }

      $(function () {
        /*
         * Flot Interactive Chart
         * -----------------------
         */

        var data_h = [];
        function getHum() {

          if (data_h.length > 0){data_h = data_h.slice(1);}            

            var array;  
            var hum=0;  
            var res = [];               

            $.ajax({
            url : 'api/getStatus.php',
            type : 'GET',
            data : '',
            dataType : 'html', 
            async : false,           
            success : function(result, status){
              if(result == "403"){
                alert("You must be connected.");
                window.location.href = "index.php";
              }
              array = result.split(";");    
              hum+=parseFloat(array[2]); 
              while (data_h.length < totalPoints) 
              {            
                data_h.push(hum);
              }                  

              for (var i = 0; i < data_h.length; ++i) 
              {
                res.push([i, data_h[i]]);
              }   

            },error : function(result, statut, error){}});       
            return res;
        }

        var data_t = [], totalPoints = 100;
        function getTemp() {

          if (data_t.length > 0){data_t = data_t.slice(1);}            

            var array;  
            var temp=0;  
            var res = [];               

            $.ajax({
            url : 'api/getStatus.php',
            type : 'GET',
            data : '',
            dataType : 'html', 
            async : false,           
            success : function(result, status){
              if(result == "403"){
                alert("You must be connected.");
                window.location.href = "index.php";
              }
              array = result.split(";");    
              temp+=parseFloat(array[1]); 
              while (data_t.length < totalPoints) 
              {            
                data_t.push(temp);
              }                  

              for (var i = 0; i < data_t.length; ++i) 
              {
                res.push([i, data_t[i]]);
              }   

            },error : function(result, statut, error){}});       
            return res;
        }

        var temp_plot = $.plot("#temperature_chart", [getTemp()], {
          grid: {
            borderColor: "#f3f3f3",
            borderWidth: 1,
            tickColor: "#f3f3f3"
          },
          series: {
            shadowSize: 0, // Drawing is faster without shadows
            color: "#DD4B39"
          },
          lines: {
            fill: true, //Converts the line chart to area chart
            color: "#DD4B39"
          },
          yaxis: {
            min: 15,
            max: 30,
            show: true
          },
          xaxis: {
            show: false
          }
        });

        var hum_plot = $.plot("#humidity_chart", [getHum()], {
          grid: {
            borderColor: "#f3f3f3",
            borderWidth: 1,
            tickColor: "#f3f3f3"
          },
          series: {
            shadowSize: 0, // Drawing is faster without shadows
            color: "#3c8dbc"
          },
          lines: {
            fill: true, //Converts the line chart to area chart
            color: "#3c8dbc"
          },
          yaxis: {
            min: 0,
            max: 100,
            show: true
          },
          xaxis: {
            show: false
          }
        });

        var updateInterval = 5000; //Fetch data ever x milliseconds
        var realtime = "on"; //If == to on then fetch data every x seconds. else stop fetching
        function update() {

          temp_plot.setData([getTemp()]);
          hum_plot.setData([getHum()]);

           //Since the axes don't change, we don't need to call plot.setupGrid()
          temp_plot.draw();
          hum_plot.draw();
          if (realtime === "on")
            setTimeout(update, updateInterval);
        }

        //INITIALIZE REALTIME DATA FETCHING
        if (realtime === "on") {
          update();
        }
        //REALTIME TOGGLE
        $("#realtime .btn").click(function () {
          if ($(this).data("toggle") === "on") {
            realtime = "on";
          }
          else {
            realtime = "off";
          }
          update();
        });
        /*
         * END INTERACTIVE CHART
         */

      });

      /*
       * Custom Label formatter
       * ----------------------
       */
      function labelFormatter(label, series) {
        return '<div style="font-size:13px; text-align:center; padding:2px; color: #fff; font-weight: 600;">'
                + label
                + "<br>"
                + Math.round(series.percent) + "%</div>";
      }

      function updateSelect()
      {        
        $('#select').load('api/getProfilesList.php').fadeIn("slow");
        $(".select2").select2();
      }

      function updateData(){
        $.ajax({
            url : 'api/getStatus.php',
            type : 'GET',
            data : '',
            dataType : 'html',
            success : function(result, status){
              if(result == "403"){
                alert("You must be connected.");
                window.location.href = "index.php";


              }
              if(result != "false"){
                var array = result.split(";");
                $("#currentProfile").html(array[0]);
                $("#temperature").html("Temperature: " + array[1] + "°C");
                $("#humidity").html("Humidity: "  + array[2]  + "%");
                $("#lamp").html(array[3]);
                $("#fan").html(array[4]);
                $("#waterPump").html(array[5]);
                $("#heater").html(array[6]);
                $("#uptime").html(array[7]);
              }
            },

            error : function(result, statut, error){
              $("#currentProfile").html("N/A");
              $("#temperature").html("Temperature: N/A");
              $("#humidity").html("Humidity: N/A");
              $("#lamp").html("N/A");
              $("#fan").html("N/A");
              $("#waterPump").html("N/A");
              $("#uptime").html("N/A");
            }

          });
        setTimeout(updateData,2000);
      }
      updateData();//??
    </script>

  </body>
</html>
