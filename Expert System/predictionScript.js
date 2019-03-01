function showPrediction(){

  document.getElementById("predictionForm").style = "display: none;";

  document.getElementById("showPredictionDiv").style = "";

}

function getWords(){

  var pred = parseFloat(document.getElementById("predNumTxt").innerHTML);

  if (pred > 1){

    document.getElementById("predWords").innerHTML = "We predict this person <i>should</i> go into a nursing home";

  } else {

    document.getElementById("predWords").innerHTML = "We predict this person <i>should not</i> go into a nursing home";

  }

}
