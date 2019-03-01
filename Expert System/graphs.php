<?php

require 'assets/init.php';

require 'assets/includes/header.php';
require 'assets/includes/nav.php';
//graph 1
$db = new db();

$query = "SELECT predictedResult
FROM analysisTable";

$stmt = $db -> prepare($query);

$stmt -> execute();

$inc = 0;

while($row = $stmt->fetch()) {

 $predictedResults[$inc] = $row['predictedResult'];

 $inc = $inc + 1;

}

$db = null;
$stmt = null;
//graph 2
$db = new db();

$query = "SELECT actualResult
FROM analysisTable";

$stmt = $db -> prepare($query);

$stmt -> execute();

$inc = 0;

while($row = $stmt->fetch()) {

 $actualResults[$inc] = $row['actualResult'];

 $inc = $inc + 1;

}

$inc = 0;
$db = null;
$stmt = null;

$correct= 0;
$incorrect = 0;

for($x = 0; $x < count($predictedResults); $x++) {

  if ($predictedResults[$x] >= 1){

    if ($actualResults[$x] == 1){

      $correct = $correct + 1;

    } else {

      $incorrect = $incorrect + 1;

    }

  } else if ($predictedResults[$x] < 1){
    if ($actualResults[$x] == 0){

      $correct = $correct + 1;

    } else {

      $incorrect = $incorrect + 1;

    }
  }

}

$goHome = 0;
$noHome = 0;

for($x = 0; $x < count($predictedResults); $x++){

  if ($predictedResults[$x] >= 1){

    $goHome = $goHome + 1;

  } else {

    $noHome = $noHome + 1;

  }

}
//graph 3
$ageOne = array(0,0); // amount of that age group, average
$ageTwo = array(0,0);
$ageThree = array(0,0);
$ageFour = array(0,0);

$db = new db();

$query = "SELECT valueOne, predictedResult
FROM analysisTable";

$stmt = $db -> prepare($query);

$stmt -> execute();

$inc = 0;

while($row = $stmt->fetch()) {

 if($row['valueOne'] == 1){

   $ageOne[0] = $ageOne[0] + 1;
   $ageOne[1] = (($ageOne[1] * ($ageOne[0]-1)) + $row['predictedResult']) / $ageOne[0];

 } else if($row['valueOne'] == 2) {

   $ageTwo[0] = $ageTwo[0] + 1;
   $ageTwo[1] = (($ageTwo[1] * ($ageTwo[0]-1)) + $row['predictedResult']) / $ageTwo[0];

 } else if($row['valueOne'] == 3) {

   $ageThree[0] = $ageThree[0] + 1;
   $ageThree[1] = (($ageThree[1] * ($ageThree[0]-1)) + $row['predictedResult']) / $ageThree[0];

 } else if($row['valueOne'] == 4) {

   $ageFour[0] = $ageFour[0] + 1;
   $ageFour[1] = (($ageFour[1] * ($ageFour[0]-1)) + $row['predictedResult']) / $ageFour[0];

 }

 $inc = $inc + 1;

}

$inc = 0;
$db = null;
$stmt = null;

$healthOne = array(0,0); // amount of that age group, average
$healthTwo = array(0,0);
$healthThree = array(0,0);
$healthFour = array(0,0);

$db = new db();

$query = "SELECT valueFour, predictedResult
FROM analysisTable";

$stmt = $db -> prepare($query);

$stmt -> execute();

$inc = 0;

while($row = $stmt->fetch()) {

 if($row['valueFour'] == 1){

   $healthOne[0] = $healthOne[0] + 1;
   $healthOne[1] = (($healthOne[1] * ($healthOne[0]-1)) + $row['predictedResult']) / $healthOne[0];

 } else if($row['valueFour'] == 2) {

   $healthTwo[0] = $healthTwo[0] + 1;
   $healthTwo[1] = (($healthTwo[1] * ($healthTwo[0]-1)) + $row['predictedResult']) / $healthTwo[0];

 } else if($row['valueFour'] == 3) {

   $healthThree[0] = $healthThree[0] + 1;
   $healthThree[1] = (($healthThree[1] * ($healthThree[0]-1)) + $row['predictedResult']) / $healthThree[0];

 } else if($row['valueFour'] == 4) {

   $healthFour[0] = $healthFour[0] + 1;
   $healthFour[1] = (($healthFour[1] * ($healthFour[0]-1)) + $row['predictedResult']) / $healthFour[0];

 }

 $inc = $inc + 1;

}

$inc = 0;
$db = null;
$stmt = null;

?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.3/Chart.bundle.js"></script>
<div id = "firstChartDiv" style = "width: 40%;" class = "container">

  <h4 style = "text-align: center;" >Accuracy Rate of this system:</h4>

  <canvas id="firstChart" width="100%" height="100%"></canvas>
</div>
<div id = "secondChartDiv" style = "display: none;" class = "container">

  <h4 style = "text-align: center;" >For/Against nursing home</h4>

  <canvas id="secondChart" width="100%" height="100%"></canvas>
</div>
<div id = "thirdChartDiv" style = "display:none;" class = "container">

  <h4 style = "text-align: center;" >Average Predicted Risk / age</h4>

  <canvas id="thirdChart" width="100%" height="100%"></canvas>
</div>
<div id = "fourthChartDiv" style = "display:none;" class = "container">

  <h4 style = "text-align: center;" >Average Predicted Risk / health</h4>

  <canvas id="fourthChart" width="100%" height="100%"></canvas>
</div>

<div style = "position: absolute; top: 50%; left: 1%;">

  <a onclick = "change('firstChartDiv')" class = "btn waves-light">Accuracy</a>
  <br />
  <a onclick = "change('secondChartDiv')" class = "btn waves-light">For/Against Home</a>
  <br />
  <a onclick = "change('thirdChartDiv')" class = "btn waves-light">Average Predicted Value / age</a>
  <br />
  <a onclick = "change('fourthChartDiv')" class = "btn waves-light">Average Predicted Value / Health</a>

</div>

<script>

var active = "firstChartDiv";

var ctx1 = document.getElementById('firstChart').getContext('2d');
var ctx2 = document.getElementById('secondChart').getContext('2d');
var ctx3 = document.getElementById('thirdChart').getContext('2d');
var ctx4 = document.getElementById('fourthChart').getContext('2d');

var data1 = {
    datasets: [{
        data: [<?php echo $correct ?>,<?php echo $incorrect ?>],
        backgroundColor: ['#76BA1B', '#ED2939']
    }],

    // These labels appear in the legend and in the tooltips when hovering different arcs
    labels: [
        'Correct',
        'Incorrect'
    ]
};

var data2 = {
    datasets: [{
        data: [<?php echo $goHome ?>,<?php echo $noHome ?>],
        backgroundColor: ['#76BA1B', '#ED2939']
    }],

    // These labels appear in the legend and in the tooltips when hovering different arcs
    labels: [
        'For Nursing Home',
        'Against Nursing Home'
    ]
};

var data3 = {
    datasets: [{
        data: [<?php echo $ageOne[1] ?>,<?php echo $ageTwo[1]?>,<?php echo $ageThree[1]?>,<?php echo $ageFour[1]?>],
        backgroundColor: ["#013243"],
        label: ["Average Predicted Risk Factor"]
    }],

    // These labels appear in the legend and in the tooltips when hovering different arcs
    labels: [
        '<65',
        '65-80',
        '81-90',
        '>90'
    ]
};

var data4 = {
    datasets: [{
        data: [<?php echo $healthOne[1] ?>,<?php echo $healthTwo[1]?>,<?php echo $healthThree[1]?>,<?php echo $healthFour[1]?>],
        backgroundColor: ["#013243"],
        label: ["Average Predicted Risk Factor"]
    }],

    // These labels appear in the legend and in the tooltips when hovering different arcs
    labels: [
        'Terminal',
        'Severe',
        'Moderate',
        'Low-none'
    ]
};

var options = {}

var chartOne = new Chart(ctx1, {
  type: 'doughnut',
  data: data1,
  options: options
});

var chartTwo = new Chart(ctx2, {
  type: 'doughnut',
  data: data2,
  options: options
});

var chartThree = new Chart(ctx3, {
    type: 'line',
    data: data3,
    options: options
});

var chartFour = new Chart(ctx4, {
    type: 'line',
    data: data4,
    options: options
});

function change(x){

  document.getElementById(active).style = "display: none;";
  document.getElementById(x).style = "width: 40%;";
  active = x;

}

</script>
<?php
require 'assets/includes/footer.php';
?>
