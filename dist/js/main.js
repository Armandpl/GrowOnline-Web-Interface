$(function () {
  $(".select2").select2();

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
  updateData();

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

     var data_h = [];

     function getHum() {

       if (data_h.length > 0){
         data_h = data_h.slice(1);
       }

       var array;
       var hum=0;
       var res = [];

      while (data_h.length < totalPoints)
      {
           $.ajax({
           url : 'api/getHum.php',
           type : 'GET',
           data : 'id='+(100-data_h.length),
           dataType : 'html',
           async : false,
           success : function(result, status){
             if(result == "403"){
               alert("You must be connected.");
               window.location.href = "index.php";
             }
             result.split(',').reverse().forEach(function(entry){
                if(entry!=''){data_h.push(parseFloat(entry));}
             });

           },error : function(result, statut, error){}});

       }

           for (var i = 0; i < data_h.length; ++i)
           {
             res.push([i, data_h[i]]);
           }

           return res;
     }

     var data_t = [], totalPoints = 100;
     function getTemp() {

       if (data_t.length > 0){data_t = data_t.slice(1);}

         var array;
         var temp=0;
         var res = [];

            while (data_t.length < totalPoints)
            {

           $.ajax({
           url : 'api/getTemp.php',
           type : 'GET',
           data : 'id='+(100-data_t.length),
           dataType : 'html',
           async : false,
           success : function(result, status){
             if(result == "403"){
               alert("You must be connected.");
               window.location.href = "index.php";
             }
             result.split(',').reverse().forEach(function(entry){
                if(entry!=''){data_t.push(parseFloat(entry));}
             });

           },error : function(result, statut, error){}});

           }

           for (var i = 0; i < data_t.length; ++i)
           {
             res.push([i, data_t[i]]);
           }

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
});
