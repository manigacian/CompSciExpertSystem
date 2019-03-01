<?php

require 'assets/init.php';

require 'assets/includes/header.php';
require 'assets/includes/nav.php';

if($_SERVER['REQUEST_METHOD'] == 'POST'){

  $db = new db();

  $query = "SELECT predictedResult
  FROM analysisTable
  WHERE analysisReference = :analysisReference";

  $stmt = $db -> prepare($query);
  $stmt -> bindParam("analysisReference", $_POST['analysisReference'], PDO::PARAM_STR);

  $stmt -> execute();

  /*while ($row = $stmt->fetch()) {
    echo $row['predictedResult']."<br />\n";
  }*/

  $db = null;

}

?>

<script type="text/javascript" src="predictionScript.js"></script>

<form id = "predictionForm" method = "post">

  <div class = "center-align">

    <h5>Please enter your reference:</h5>

    <br /><br /><br /><br />
    <div class = "container">
      <input type="text" name="analysisReference"></input>
    </div>
    <br /><br /><br /><br />

    <button id = "btnSubmit" name = "btnSubmit" type = "submit" class = "btn waves-light">Get Result</button>

  </div>
</form>

<div id = "showPredictionDiv" style = "display: none;" class = "center-align">

  <h3 id = "predWords"></h3>
  <br />

  <h5>Your risk factor is: </h5>
  <br />

  <h2 id = "predNumTxt"><?php
  if($_SERVER['REQUEST_METHOD'] == 'POST'){
    while ($row = $stmt->fetch()) {
      echo $row['predictedResult']."<br />\n";
    }
    $stmt = null;

    echo "<script> getWords(); </script>";
  }
  ?></h2>

  <br />

  <h5>What does this mean?</h5>

  <p>This factor is an expression of how well off a given person would be, in or out of a nursing home. <br /> For example, a factor of 2 indicates that they are 2x better off in a nursing home, and a factor of 0.5 indicates 0.5x better off in a nursing home, or 2x better off at home.<p>

</div>

<?php
if($_SERVER['REQUEST_METHOD'] == 'POST'){
  echo "<script> showPrediction(); </script>";
}
require 'assets/includes/footer.php';
?>
