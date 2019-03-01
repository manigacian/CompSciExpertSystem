<?php

require 'assets/init.php';

if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['btnSave'])) {

    //Create a new random reference

    $analysisReference = generateRandomString(8);

    $db = new db();

    $query = "INSERT INTO
                analysisTable
                (
                  analysisReference,
                  valueOne,
                  valueTwo,
                  valueThree,
                  valueFour,
                  valueFive
                )
            VALUES
              (
                  :analysisReference,
                  :valueOne,
                  :valueTwo,
                  :valueThree,
                  :valueFour,
                  :valueFive
              )";

    $stmt = $db -> prepare($query);
    $stmt -> bindParam("analysisReference", $analysisReference, PDO::PARAM_STR);
    $stmt -> bindParam("valueOne", $_POST['q1Group'], PDO::PARAM_INT);
    $stmt -> bindParam("valueTwo", $_POST['q2Group'], PDO::PARAM_INT);
    $stmt -> bindParam("valueThree", $_POST['q3Group'], PDO::PARAM_INT);
    $stmt -> bindParam("valueFour", $_POST['q4Group'], PDO::PARAM_INT);
    $stmt -> bindParam("valueFive", $_POST['q5Group'], PDO::PARAM_INT);
    $saved = $stmt -> execute();

    $stmt = null;
    $db = null;

    if($saved) {

        //Redirect somewhere
        header('Location:thankyou.php?ref=' . $analysisReference);
        die();

    } else {

        //Someone has messed with the form code - display an error.
        $error = "Sorry, an error saving your responses occurred";
    }


}


function generateRandomString($length = 8) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

require 'assets/includes/header.php';
require 'assets/includes/nav.php';

?>
<div class = "center-align">
<a type = "button" id = "startBtn" class = "btn waves-light">Start Analysis</a>
</div>

<form method="post" id = "analysisForm" style = "text-align: center;">

  <div class = "question hide" style = "" id = "question1">

    <h4 id="q1">What is your age?</h4>

    <input id="q1a1" value = "1" name="q1Group" type="radio"/>
    <label id="q1a1Txt" for="q1a1">Less than 65</label><br /> <br />
    <input id="q1a2" value = "2" name="q1Group" type="radio"/>
    <label id="q1a2Txt" for="q1a2">65 to 80</label><br /> <br />
    <input id="q1a3" value = "3" name="q1Group" type="radio"/>
    <label id="q1a3Txt" for="q1a3">81 to 90</label><br /> <br />
    <input id="q1a4" value = "4" name="q1Group" type="radio"/>
    <label id="q1a4Txt" for="q1a4">More than 90</label><br /> <br />
  </div>
  <div class = "question hide" style = "" id="question2">

    <h4 id="q2">Do you smoke / have you ever (regularly) smoked?</h4>

    <input id="q2a1" value = "1" name="q2Group" type="radio"/>
    <label id="q2a1Txt" for="q2a1">Yes</label><br /> <br />
    <input id="q2a2" value = "2" name="q2Group" type="radio"/>
    <label id="q2a2Txt" for="q2a2">No</label><br /> <br />

  </div>
  <div class = "question hide" id="question3">

    <h4 id = "q3">Do you have close family living within 15 miles?</h4>

    <input id="q3a1" value = "1" name="q3Group" type="radio"/>
    <label id="q3a1Txt" for="q3a1">Yes</label><br /> <br />
    <input id="q3a2" value = "2" name="q3Group" type="radio"/>
    <label id="q3a2Txt" for="q3a2">No</label><br /> <br />

  </div>
  <div class = "question hide" id = "question4">

      <h4 id="q4">What is the highest level of health condition you have / have had?</h4>

      <input id="q4a1" value = "1" name="q4Group" type="radio"/>
      <label id="q4a1Txt" for="q4a1">Terminal - ( Any terminal conditions )</label><br /> <br />
      <input id="q4a2" value = "2" name="q4Group" type="radio"/>
      <label id="q4a2Txt" for="q4a2">Severe - ( Non terminal cancer, heart attacks, strokes )</label><br /> <br />
      <input id="q4a3" value = "3" name="q4Group" type="radio"/>
      <label id="q4a3Txt" for="q4a3">Moderate - ( Diabetes, High blood pressure, anaemia, angina, etc. )</label><br /> <br />
      <input id="q4a4" value = "4" name="q4Group" type="radio"/>
      <label id="q4a4Txt" for="q4a4">Low-none</label><br /> <br />

  </div>
  <div class = "question hide" id="question5">

    <h4 id = "q5">Have you ever been addicted to drugs and/or alcohol?</h4>

    <input id="q5a1" value = "1" name="q5Group" type="radio"/>
    <label id="q5a1Txt" for="q5a1">Yes</label><br /> <br />
    <input id="q5a2" value = "2" name="q5Group" type="radio"/>
    <label id="q5a2Txt" for="q5a2">No</label><br /> <br />

  </div>

  <button id = "btnSave" name="btnSave" type="submit" class = "btn waves-light hide">Save Analysis</button>

</form>

<?=isset($error) ? $error : '' ?>

<script type = "text/javascript">

$(document).ready(function(){

  var currentQuestion = 1;

  $('#startBtn').on('click', function(){

    $('#question'+currentQuestion).removeClass('hide');
    $('#startBtn').addClass('hide');
    currentQuestion++;

  });

  $('.question > input:radio').on('click', function(){

    if(currentQuestion <= 5) {
        $('#question'+currentQuestion).removeClass('hide');
        $('#question'+(currentQuestion-1)).addClass('hide');
        currentQuestion++;
    } else {
        $('#question'+(currentQuestion-1)).addClass('hide');
        $('#btnSave').removeClass('hide');
    }

  });


});


</script>

<?php

require 'assets/includes/footer.php';

?>
