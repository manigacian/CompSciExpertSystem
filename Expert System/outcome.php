<?php

require 'assets/init.php';

require 'assets/includes/header.php';
require 'assets/includes/nav.php';

if($_SERVER['REQUEST_METHOD'] == 'POST'){

  $db = new db();

  $query = "UPDATE analysisTable
  SET actualResult= :outcome
  WHERE analysisReference = :analysisReference";

  $stmt = $db -> prepare($query);
  $stmt -> bindParam("outcome", $_POST['outcomeGroup'], PDO::PARAM_INT);
  $stmt -> bindParam("analysisReference", $_POST['analysisReference'], PDO::PARAM_STR);

  $saved = $stmt -> execute();

  $stmt = null;
  $db = null;

}

?>
<script>
  $(document).ready(function() {
    $('select').material_select();
  });
  function showThanks(){

    document.getElementById("outcomeForm").style = "display: none;";
    document.getElementById("TY").style = "";

  }

</script>

<form id = "outcomeForm" method = "post">

  <div class = "center-align">

    <h5>Please enter your reference:</h5>

    <br /><br /><br /><br />
    <div class = "container">
      <input type="text" name="analysisReference"></input>
    </div>
    <br /><br /><br /><br />

    <h5>Please enter an outcome:</h5>

    <div class="container input-field col s12">
      <select name = "outcomeGroup">
        <option value="" disabled selected>Choose</option>
        <option value="1">Should have gone to a nursing home</option>
        <option value="0">Shouldn't have gone to a nursing home</option>
      </select>
    </div>

    <br />

    <button id = "btnSubmit" name = "btnSubmit" type = "submit" class = "btn waves-light">Submit Outcome</button>

  </div>
</form>

<div style = "display: none;" id = "TY" class="center-align row">
  <div class="col s6 offset-s3">
    <div class="card blue-grey darken-1">
      <div class="card-content white-text">
        <span class="card-title">Thank You!</span>
        <p>Your submission is greatly appreciated!</p>
      </div>
    </div>
  </div>
</div>

<?php

if ($saved){

  echo "<script> showThanks(); </script>";

}

require 'assets/includes/footer.php';
?>
