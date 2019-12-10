<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Untitled Document</title>
</head>

<body>

Please enter data, at most 42 characters:<br>
<form method="post">
<textarea name="box" rows="5" cols="30">
</textarea>
<br><input type="submit">
</form>
<?php
  if($_POST['box']="") {
   print "No data included under the expected name - submission rejected.\n"; 
 }else if(count($_POST['box']) >30) {
   print "Too much data!\n"; 
 } else {
   print "The data was virtually accepted."; }
?>
</body>
</html>