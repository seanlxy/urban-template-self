<?php
  #const account_data_url = 'https://www.googleapis.com/analytics/v2.4/management/accounts?start-index=1&max-results=100&key=AIzaSyBviYHGHu8-FIeIeRNt9lbVEYi1xIVq2Lw';
  #const report_data_url = 'https://www.googleapis.com/analytics/v2.4/data';
function secondMinute($seconds) {
  $minResult = floor($seconds/60);
  if($minResult < 10){$minResult = 0 . $minResult;}
  $secResult = ($seconds/60 - $minResult)*60;
  if($secResult < 10){$secResult = 0 . round($secResult);}
  else { $secResult = round($secResult); }
  return $minResult.":".$secResult;
}

function render_ga_data()
{

  global $message,$valid,$item_select,$testm_id,$testm_rank,$htmladmin, $main_heading, $rootfull, $date_start_obj, $date_end_obj;

  define('ga_email','webdirectionz@gmail.com');
  define('ga_password','webd7732');
  define('ga_profile_id','74205299');

  $ga_url = $_SERVER['REQUEST_URI'];

  require 'classes/gapi.class.php';

  $ga = new gapi(ga_email,ga_password);




  // $filter = 'browser == Firefox || browser == Chrome || browser == IE';
  // requestReportData($report_id, $dimensions, $metrics, $sort_metric=null, $filter=null, $start_date=null, $end_date=null, $start_index=1, $max_results=30)

  if($_POST['get-ga'])
  {
    $start_date = date_create_from_format('d/m/Y', $_POST['ga-date-from']);
    $end_date   = date_create_from_format('d/m/Y', $_POST['ga-date-to']);

    $_SESSION['start_date'] = $start_date->format('Y-m-d');
    $_SESSION['end_date'] = $end_date->format('Y-m-d');

    header("Location: $htmladmin/index.php?do=dashboard");
    exit();
  }

  $start_date = ($_SESSION['start_date']) ? $_SESSION['start_date'] : '-1 Month';
  $end_date = $_SESSION['end_date'];

  $date_start_obj = new DateTime($start_date);
  $date_end_obj   = new DateTime($end_date);
  $date_diff = $date_start_obj->diff($date_end_obj);

  $ga->requestReportData(ga_profile_id, array('date'),array('pageViews', 'visits', 'uniquePageviews', 'exitRate', 'avgTimeOnPage', 'bounceRate', 'avgSessionDuration'), 'date', null, $date_start_obj->format('Y-m-d'), $date_end_obj->format('Y-m-d'), 1, ($date_diff->days + 1));      
  $results = $ga->getResults();
if(isset($_GET['mode']) && $_GET['mode'] == 'test')
{

preprint_r($results);
die();


}

  $output = '<div class="row"><div class="col-xs-12 ditem-body">';
  $output .= '<div id="ga-chart"></div>';

  $output .= <<< JS

  <script src="https://www.google.com/jsapi"></script>
  <script>
    google.load("visualization", "1", {packages:["corechart"]});
    google.setOnLoadCallback(drawChart);
    function drawChart() {   
    var data = new google.visualization.DataTable();       
    data.addColumn('string', 'Day');
    // data.addColumn('string', 'Day');
    // data.addColumn('string', 'Week');
    // data.addColumn('string', 'Month');
    data.addColumn('number', 'Pageviews');
    data.addRows([

JS;
 
  foreach($results as $result)
  {

    $output .= '["'.date("M j",strtotime($result->getDate())).'", '.$result->getPageviews().'],';

  }

  $some_date = $date_start_obj->format('M j, Y').' - '.$date_end_obj->format('M j, Y');

  $output .= <<< JS

    ]);
    var chart = new google.visualization.AreaChart(document.getElementById('ga-chart'));   
    chart.draw(data, {width:($('#ga-chart').outerWidth()), height:350, fill:'#F9F9F9', title: '$some_date',                     
    colors:['#058dc7','#e6f4fa'],                     
    areaOpacity: 0.1,                     
    hAxis: {textPosition: 'in', showTextEvery: 5, slantedText: false, textStyle: { color: '#058dc7', fontSize: 10 } },                     
    pointSize: 5,                       
    legend: 'none',
    backgroundColor:'transparent',       
    explorer:{actions:['dragToZoom', 'rightClickToReset']},        
    chartArea:{left:0,top:30,width:"100%",height:"100%"}   
    }); 
    }
  </script>

JS;

$output .= '</div></div>';

$output .= '<div class="row" id="site-stats">';
$output .= '<div class="col-xs-12">';
$output .= '<div>';
$output .= '<div class="stat-item"><small>Page Views</small><span class="val">'.number_format($ga->getPageviews()).'</span></div>';
$output .= '<div class="stat-item"><small>Unique Page Views</small><span class="val">'.number_format($ga->getUniquepageviews()).'</span></div>';
$output .= '<div class="stat-item"><small>Avg time on page</small><span class="val">'.secondMinute($ga->getAvgtimeonpage()).'</span></div>';
$output .= '<div class="stat-item"><small>Avg Session Duration</small><span class="val">'.secondMinute($ga->getAvgsessionduration()).'</span></div>';
$output .= '<div class="stat-item"><small>Bounce Rate</small><span class="val">'.round($result->getBounceRate(), 2).'%</span></div>';
$output .= '<div class="stat-item"><small>Exit Rate</small><span class="val">'.round($result->getExitrate(), 2).'%</span></div>';
$output .= '<div class="stat-item"><small>Visits</small><span class="val">'.$result->getVisits().'</span></div>';
$output .= '</div>';
$output .= '<p class="clearfix"></p>';
$output .= '</div>';
$output .= '</div>';


return $output;


}

?>