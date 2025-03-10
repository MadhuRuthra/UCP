<?php
session_start();
error_reporting(0);
include_once('api/configuration.php');
extract($_REQUEST);

if ($_SESSION['yjucp_user_id'] == "") { ?>
  <script>
    window.location = "index";
  </script>
  <?php exit();
}
site_log_generate("Home Page : User : '" . $_SESSION['yjucp_user_id'] . "' access this page on " . date("Y-m-d H:i:s"));
$site_page_name = pathinfo($_SERVER['PHP_SELF'], PATHINFO_FILENAME);
?>
<!DOCTYPE html>
<html lang="en">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<meta http-equiv="content-type" content="text/html;charset=UTF-8" />

<head>
  <style>
    #chartdiv {
      width: 100%;
      height: 500px;
    }
  </style>
  <title>Dashboard ::
    <?= $site_title ?>
  </title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="description"
    content="Admindek Bootstrap admin template made using Bootstrap 4 and it has huge amount of ready made feature, UI components, pages which completely fulfills any dashboard needs." />
  <meta name="keywords"
    content="flat ui, admin Admin , Responsive, Landing, Bootstrap, App, Template, Mobile, iOS, Android, apple, creative app">
  <meta name="author" content="colorlib" />
  <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

  <link rel="icon" href="libraries/assets/png/favicon1.ico" type="image/x-icon">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Quicksand:500,700" rel="stylesheet">

  <link rel="stylesheet" type="text/css" href="libraries/assets/css/bootstrap.min.css">

  <link rel="stylesheet" href="libraries/assets/css/waves.min.css" type="text/css" media="all">

  <link rel="stylesheet" type="text/css" href="libraries/assets/css/feather.css">

  <link rel="stylesheet" type="text/css" href="libraries/assets/css/font-awesome-n.min.css">
  <link rel="stylesheet" type="text/css" href="libraries/assets/css/widget.css">

  <link rel="stylesheet" href="libraries/assets/css/chartist.css" type="text/css" media="all">

  <link rel="stylesheet" type="text/css" href="libraries/assets/css/style.css">
</head>

<body>

  <div class="loader-bg">
    <div class="loader-bar"></div>
  </div>

  <div id="pcoded" class="pcoded">
    <div class="pcoded-overlay-box"></div>
    <div class="pcoded-container navbar-wrapper">


      <div class="pcoded-main-container">
        <div class="pcoded-wrapper">
          <? include("libraries/site_header.php"); ?>
          <?
          include("libraries/site_menu.php"); ?>

          <div class="pcoded-content">

            <div class="page-header card">
              <div class="row align-items-end">
                <div class="col-lg-8">
                  <div class="page-header-title">
                    <i class="feather icon-home bg-c-blue"></i>
                    <div class="d-inline">
                      <h5>Dashboard UCP</h5>
                      <span></span>
                    </div>
                  </div>
                </div>
                <div class="col-lg-4">
                  <div class="page-header-breadcrumb">
                    <ul class=" breadcrumb breadcrumb-title">
                      <li class="breadcrumb-item">
                        <a href="dashboard"><i class="feather icon-home"></i></a>
                      </li>
                      <li class="breadcrumb-item"><a href="dashboard">Dashboard UCP</a> </li>
                    </ul>
                  </div>
                </div>
              </div>
            </div>

            <div class="pcoded-inner-content">
              <div class="main-body">
                <div class="page-wrapper">
                  <div class="page-body">

                    <div class="row">

                      <div class="col-xl-4 col-md-6">
                        <div class="card card-red st-cir-card text-white">
                          <div class="card-block">
                            <div class="row align-items-center">
                              <div class="col-auto">
                                <div id="status-round-1" class="chart-shadow st-cir-chart"
                                  style="width:80px;height:80px">
                                  <h5 id="total_msg_display">%</h5>
                                </div>
                              </div>
                              <div class="col text-center">
                                <h3 class=" f-w-700 m-b-5"><? echo $available_credits[0] ?></h3>
                                <h6 class="m-b-0 ">SMS</h6>
                              </div>
                            </div>
                            <span id="total_msg_display_msg" class="st-bt-lbl">%</span>
                          </div>
                        </div>
                      </div>
                      <div class="col-xl-4 col-md-6">
                        <div class="card card-blue st-cir-card text-white">
                          <div class="card-block">
                            <div class="row align-items-center">
                              <div class="col-auto">
                                <div id="status-round-2" class="chart-shadow st-cir-chart"
                                  style="width:80px;height:80px">
                                  <!-- Displaying b value in place of 56 -->
                                  <h5 id="status-percentage">%</h5>
                                </div>
                              </div>
                              <div class="col text-center">
                                <h3 class="f-w-700 m-b-5"><?php echo $available_credits[1]; ?></h3>
                                <h6 class="m-b-0">SMPP</h6>
                              </div>
                            </div>
                            <span id="status-percentage_msg" class="st-bt-lbl">%</span>
                          </div>
                        </div>
                      </div>

                      <div class="col-xl-4 col-md-6">
                        <div class="card card-green st-cir-card text-white">
                          <div class="card-block">
                            <div class="row align-items-center">
                              <div class="col-auto">
                                <div id="status-round-3" class="chart-shadow st-cir-chart"
                                  style="width:80px;height:80px">
                                  <h5 id="status-percentage_whsp">%</h5>
                                </div>
                              </div>
                              <div class="col text-center">
                                <h3 class="f-w-700 m-b-5"><? echo $available_credits[2] ?></h3>
                                <h6 class="m-b-0">Whtasapp</h6>
                              </div>
                            </div>
                            <span id="status-percentage_msg_whsp" class="st-bt-lbl">%</span>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div id="id_dashboard_count"></div>
                    <div class="col-md-12">
                      <div class="card sale-card">
                        <div class="card-header">
                          <h5>One week's Report </h5>
                        </div>
                        <div class="card-block">
                          <!-- HTML -->
                          <div id="chart"></div>
                        </div>
                      </div>
                    </div>

                  </div>
                </div>
              </div>
            </div>
          </div>

          <div id="styleSelector">
          </div>

        </div>
      </div>
    </div>
  </div>
  <!-- Resources -->
  <!-- <script src="https://cdn.amcharts.com/lib/5/index.js"></script>
  <script src="https://cdn.amcharts.com/lib/5/xy.js"></script>
  <script src="https://cdn.amcharts.com/lib/5/themes/Animated.js"></script>
   -->
   <script>
  $(document).ready(function () {
    find_dashboard();
  });

  function find_dashboard() {
    $.ajax({
      type: 'post',
      url: "ajax/display_functions.php?call_function=dashboard_counts",
      dataType: 'html',
      success: function (response) {
        $("#id_dashboard_count").html(response);

        // Extract and parse data from DOM elements
        const total_msg = JSON.parse(document.getElementById('total_msg').value).map(Number);
        const rights_nameArray = JSON.parse(document.getElementById('rights_name').value);
        const entry_dateArrayRaw = JSON.parse(document.getElementById('entry_date').value);

        // Ensure the correct order of data for SMS, SMPP, and WhatsApp
        const rightsOrder = ['SMS', 'SMPP', 'Whatsapp'];
        let dataMapping = {};
        rights_nameArray.forEach((name, index) => {
          if (rightsOrder.includes(name)) {
            dataMapping[name] = total_msg.slice(index * 7, (index + 1) * 7);
          }
        });

        // Create the series data in the correct order
        let series_data = rightsOrder.map((name) => ({
          name: name,
          type: 'column',
          data: dataMapping[name] || [0, 0, 0, 0, 0, 0, 0], // Default to zero if no data
        }));

        console.log("Constructed series_data:", JSON.stringify(series_data));

        // Extract the first values for SMS, SMPP, and WhatsApp
        const [a, b, c] = series_data.map((item) => item.data[0] || 0);
        console.log(`a = ${a}, b = ${b}, c = ${c}`);

        // Display the values in the HTML
        document.getElementById("total_msg_display").textContent = `${a}%`;
        document.getElementById("status-percentage").textContent = `${b}%`;
        document.getElementById("status-percentage_whsp").textContent = `${c}%`;

        // Prepare the x-axis categories (convert DD-MM-YYYY to YYYY-MM-DD)
        const entry_dateArray = entry_dateArrayRaw.map(date => {
          const [day, month, year] = date.split('-');
          return `${year}-${month}-${day}`;
        });

        // Chart options
        const options = {
          series: [
            ...series_data,
            {
              name: 'Total Message',
              type: 'line',
              data: [20, 29, 37, 36, 44, 45, 50] // Example line data
            }
          ],
          colors: ['#ff5370', '#008FFB', '#00E396', '#FEB019'], // Colors for each series
          chart: {
            height: 350,
            type: 'line',
            stacked: false,
          },
          dataLabels: {
            enabled: false,
          },
          stroke: {
            width: [1, 1, 4],
          },
          xaxis: {
            categories: entry_dateArray,
          },
          yaxis: [
            {
              seriesName: 'SMS',
              axisTicks: { show: true },
              axisBorder: { show: true, color: '#ff5370' },
              labels: { style: { colors: '#ff5370' } },
              title: { text: "Total Message", style: { color: '#ff5370' } },
              tooltip: { enabled: true },
            },
            {
              seriesName: 'SMPP',
              opposite: true,
              axisTicks: { show: true },
              axisBorder: { show: true, color: '#00E396' },
              labels: { style: { colors: '#00E396' } },
            },
            {
              seriesName: 'Whatsapp',
              opposite: true,
              axisTicks: { show: true },
              axisBorder: { show: true, color: '#008FFB' },
              labels: { style: { colors: '#008FFB' } },
            },
            {
              seriesName: 'Total Message',
              opposite: true,
              axisTicks: { show: true },
              axisBorder: { show: true, color: '#FEB019' },
              labels: { style: { colors: '#FEB019' } },
              title: { text: "Total Message", style: { color: '#FEB019' } },
            },
          ],
          tooltip: {
            fixed: {
              enabled: true,
              position: 'topLeft',
              offsetY: 30,
              offsetX: 60,
            },
          },
          legend: {
            horizontalAlign: 'left',
            offsetX: 40,
          },
        };

        // Render the chart
        const chart = new ApexCharts(document.querySelector("#chart"), options);
        chart.render();
      },
    });
  }
</script>

  <script type="461d1add94eeb239155d648f-text/javascript" src="libraries/assets/js/jquery.min.js"></script>
  <script type="461d1add94eeb239155d648f-text/javascript" src="libraries/assets/js/jquery-ui.min.js"></script>
  <script type="461d1add94eeb239155d648f-text/javascript" src="libraries/assets/js/popper.min.js"></script>
  <script type="461d1add94eeb239155d648f-text/javascript" src="libraries/assets/js/bootstrap.min.js"></script>

  <script type="461d1add94eeb239155d648f-text/javascript" src="libraries/assets/js/jquery.slimscroll.js"></script>

  <script src="libraries/assets/js/waves.min.js" type="461d1add94eeb239155d648f-text/javascript"></script>

  <script type="461d1add94eeb239155d648f-text/javascript" src="libraries/assets/js/modernizr.js"></script>
  <script type="461d1add94eeb239155d648f-text/javascript" src="libraries/assets/js/css-scrollbars.js"></script>

  <script src="libraries/assets/js/pcoded.min.js" type="461d1add94eeb239155d648f-text/javascript"></script>
  <script src="libraries/assets/js/vertical-layout.min.js" type="461d1add94eeb239155d648f-text/javascript"></script>
  <script src="libraries/assets/js/jquery.mcustomscrollbar.concat.min.js"
    type="461d1add94eeb239155d648f-text/javascript"></script>
  <script type="461d1add94eeb239155d648f-text/javascript" src="libraries/assets/js/script.js"></script>

  <script async src="https://www.googletagmanager.com/gtag/js?id=UA-23581568-13"
    type="461d1add94eeb239155d648f-text/javascript"></script>
  <script type="461d1add94eeb239155d648f-text/javascript">
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-23581568-13');
</script>
  <script src="libraries/assets/js/rocket-loader.min.js" data-cf-settings="461d1add94eeb239155d648f-|49"
    defer=""></script>
</body>

<!-- Mirrored from colorlib.com/polygon/admindek/default/dashboard-crm.html by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 12 Dec 2019 16:08:32 GMT -->

</html>
