<?php
if(isset($_POST['submit'])) {
  $barcode = $_POST['barcode'];

  echo "<br />". $barcode;
}

?>
<!doctype html>
<html lang="en">
 <head>
  <meta charset="UTF-8">
  <meta name="Generator" content="EditPlus®">
  <meta name="Author" content="">
  <meta name="Keywords" content="">
  <meta name="Description" content="">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Barcode</title>
 </head>
 <body>
  <form method="POST" action="/admin/barcode">
    <input type="text" name="barcode" autofocus />
	<input type="submit" name="submit" />
  </form>
 </body>
</html>
