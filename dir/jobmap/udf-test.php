<?php require_once('../private/initialize.php'); ?>
<?php include(SHARED_PATH . '/public_header.php');

?>

<div class="container top">
  <div class="jumbotron">

<?php
$greet = "Hello World!";
test(); // Outpus: Hello World!
echo $greet; // Outpus: Hello World!

// Assign a new value to variable
$greet = "Goodbye";

test(); // Outputs: Goodbye
echo $greet; // Outputs: Goodbye

?>


  </div>
</div>

<?php include(SHARED_PATH . '/public_footer.php'); ?>
