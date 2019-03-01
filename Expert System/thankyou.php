<?php

require 'assets/init.php';

require 'assets/includes/header.php';
require 'assets/includes/nav.php';
?>

<div class="center-align row">
  <div class="col s6 offset-s3">
    <div class="card blue-grey darken-1">
      <div class="card-content white-text">
        <span class="card-title">Thank You!</span>
        <p>Your reference is: </p>
        <h2><?=$_GET['ref']?></h2>
      </div>
    </div>
  </div>
</div>

<?php
require 'assets/includes/footer.php';
?>
