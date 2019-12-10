<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Untitled Document</title>
</head>

<body>

<?php
  $name="";
   $source="../Images/profile pictures/Annoymous.jpg"; 
   
?>
<div><img src="<?php echo $source?>"></div>

<form method="post" enctype="multipart/form-data" name="form1">
  <input type="file" name="uploadpp" id="upload_pp">
  <input type="submit">
  </form>

<?php
  $name="";
   $source="../Images/profile pictures/Annoymous.jpg";
   
   if(isset($_FILES["uploadpp"])){
	   //get extension of the image
	   $ext=pathinfo($_FILES["uploadpp"]['name'],PATHINFO_EXTENSION);
	   echo 'AAAAA';
	   //upload image to the folder
	   if(move_uploaded_file($_FILES['uploadpp']['tmp_name'],'../Images/Four/'.$m->getUserName().'+'.basename($_FILES['uploadpp']['name']))){ 
		    $names=$m->getUserName().'+'.basename($_FILES['uploadpp']['name']).'.'.$ext;
		    $source="../Images/Four/".$m->getUserName().'+'.basename($_FILES['uploadpp']['name']).'.'.$ext;				 		 
		}else{
			echo 'failed';
		}
   }
?>
</body>
</html>