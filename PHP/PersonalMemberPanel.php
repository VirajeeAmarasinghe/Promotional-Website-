<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Member Profile</title>

  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="../CSS/FormatPersonalMemberPanel.css">  
  
</head>

<body>
<?php 
  session_start();
  require_once('Classes/Member.php');
  $mem=new Member();
  if(isset($_SESSION["user_details"])){		  
	  $mem=$mem->getMemberPersonalDetailsAccordingToUsername($_SESSION["user_details"]["username"]);	  	  
  }
  if(isset($_GET["link"])){
	   unset($_SESSION["user_details"]);
	   header("Location:HomePage.php");
   }
?>
  <nav class="navbar navbar-default">
  <div class="container-fluid">
    <div class="navbar-header">
      <a class="navbar-brand" href="HomePage.php">One Direction</a>
    </div>
    <ul class="nav navbar-nav">
      <li class="active"><a href="HomePage.php">Home</a></li>
      <li><a href="?link=logoutLink">Logout</a></li>
      <li><a href="#" id="welcome">Welcome <?php echo $_SESSION["user_details"]["username"]?></a></li>        
    </ul>
  </div>
</nav>
<section id="main_wrapper">
    
</div>
<div id="second_bar">
<ul class="nav nav-tabs">
  <li><a href="MemberPanel.php">General</a></li>
  <li class="active"><a href="#">Personal</a></li>  
</ul>
</div>

<div id="form_section">
<form role="form" method="post">  
  <div class="col-sm-6" id="name_div">
    <label for="name">Country:</label>
    <select class="form-control" id="sel1" name="country">
    <option value="Argentina" <?php if(isset($_POST["country"])){setSelected("country","Argentina");}else if($mem->getCountry()=="Argentina"){echo 'selected';}?>>Argentina</option>
    <option value="Australia" <?php if(isset($_POST["country"])){setSelected("country","Australia");}else if($mem->getCountry()=="Australia"){echo 'selected';}?>>Australia</option>
    <option value="Brazil" <?php if(isset($_POST["country"])){setSelected("country","Brazil");}else if($mem->getCountry()=="Brazil"){echo 'selected';}?>>Brazil</option>
    <option value="Bulgaria" <?php if(isset($_POST["country"])){setSelected("country","Bulgaria");}else if($mem->getCountry()=="Bulgaria"){echo 'selected';}?>>Bulgaria</option>
    <option value="Canada" <?php if(isset($_POST["country"])){setSelected("country","Canada");}else if($mem->getCountry()=="Canada"){echo 'selected';}?>>Canada</option>
    <option value="Chile" <?php if(isset($_POST["country"])){setSelected("country","Chile");}else if($mem->getCountry()=="Chile"){echo 'selected';}?>>Chile</option>
    <option value="China" <?php if(isset($_POST["country"])){setSelected("country","China");}else if($mem->getCountry()=="China"){echo 'selected';}?>>China</option>
    <option value="Colombia" <?php if(isset($_POST["country"])){setSelected("country","Colombia");}else if($mem->getCountry()=="Colombia"){echo 'selected';}?>>Colombia</option>
    <option value="Cyprus" <?php if(isset($_POST["country"])){setSelected("country","Cyprus");}else if($mem->getCountry()=="Cyprus"){echo 'selected';}?>>Cyprus</option>
    <option value="Czech Republic" <?php if(isset($_POST["country"])){setSelected("country","Czech Republic");}else if($mem->getCountry()=="Czech Republic"){echo 'selected';}?>>Czech Republic</option>
    <option value="Denmark" <?php if(isset($_POST["country"])){setSelected("country","Denmark");}else if($mem->getCountry()=="Denmark"){echo 'selected';}?>>Denmark</option>
    <option value="Dominican Republic" <?php if(isset($_POST["country"])){setSelected("country","Dominican Republic");}else if($mem->getCountry()=="Dominican Republic"){echo 'selected';}?>>Dominican Republic</option>
    <option value="Egypt" <?php if(isset($_POST["country"])){setSelected("country","Egypt");}else if($mem->getCountry()=="Egypt"){echo 'selected';}?>>Egypt</option>
    <option value="Finland" <?php if(isset($_POST["country"])){setSelected("country","Finland");}else if($mem->getCountry()=="Finland"){echo 'selected';}?>>Finland</option>
    <option value="France" <?php if(isset($_POST["country"])){setSelected("country","France");}else if($mem->getCountry()=="France"){echo 'selected';}?>>France</option>
    <option value="Germany" <?php if(isset($_POST["country"])){setSelected("country","Germany");}else if($mem->getCountry()=="Germany"){echo 'selected';}?>>Germany</option>
    <option value="Greece" <?php if(isset($_POST["country"])){setSelected("country","Greece");}else if($mem->getCountry()=="Greece"){echo 'selected';}?>>Greece</option>
    <option value="Hong Kong" <?php if(isset($_POST["country"])){setSelected("country","Hong Kong");}else if($mem->getCountry()=="Hong Kong"){echo 'selected';}?>>Hong Kong</option>
    <option value="Hungary" <?php if(isset($_POST["country"])){setSelected("country","Hungary");}else if($mem->getCountry()=="Hungary"){echo 'selected';}?>>Hungary</option>
    <option value="Iceland" <?php if(isset($_POST["country"])){setSelected("country","Iceland");}else if($mem->getCountry()=="Iceland"){echo 'selected';}?>>Iceland</option>
    <option value="India" <?php if(isset($_POST["country"])){setSelected("country","India");}else if($mem->getCountry()=="India"){echo 'selected';}?>>India</option>
    <option value="Ireland" <?php if(isset($_POST["country"])){setSelected("country","Ireland");}else if($mem->getCountry()=="Ireland"){echo 'selected';}?>>Ireland</option>
    <option value="Israel" <?php if(isset($_POST["country"])){setSelected("country","Israel");}else if($mem->getCountry()=="Israel"){echo 'selected';}?>>Israel</option>
    <option value="Italy" <?php if(isset($_POST["country"])){setSelected("country","Italy");}else if($mem->getCountry()=="Italy"){echo 'selected';}?>>Italy</option>
    <option value="Latvia" <?php if(isset($_POST["country"])){setSelected("country","Latvia");}else if($mem->getCountry()=="Latvia"){echo 'selected';}?>>Latvia</option>
    <option value="Lithuania" <?php if(isset($_POST["country"])){setSelected("country","Lithuania");}else if($mem->getCountry()=="Lithuania"){echo 'selected';}?>>Lithuania</option>
    <option value="Luxembourg" <?php if(isset($_POST["country"])){setSelected("country","Luxembourg");}else if($mem->getCountry()=="Luxembourg"){echo 'selected';}?>>Luxembourg</option>
    <option value="Malaysia" <?php if(isset($_POST["country"])){setSelected("country","Malaysia");}else if($mem->getCountry()=="Malaysia"){echo 'selected';}?>>Malaysia</option>
    <option value="Mexico" <?php if(isset($_POST["country"])){setSelected("country","Mexico");}else if($mem->getCountry()=="Mexico"){echo 'selected';}?>>Mexico</option>
    <option value="Netherlands" <?php if(isset($_POST["country"])){setSelected("country","Netherlands");}else if($mem->getCountry()=="Netherlands"){echo 'selected';}?>>Netherlands</option>
    <option value="New Zealand" <?php if(isset($_POST["country"])){setSelected("country","New Zealand");}else if($mem->getCountry()=="New Zealand"){echo 'selected';}?>>New Zealand</option>
    <option value="Norway" <?php if(isset($_POST["country"])){setSelected("country","Norway");}else if($mem->getCountry()=="Norway"){echo 'selected';}?>>Norway</option>
    <option value="Philippines" <?php if(isset($_POST["country"])){setSelected("country","Philippines");}else if($mem->getCountry()=="Philippines"){echo 'selected';}?>>Philippines</option>
    <option value="Poland" <?php if(isset($_POST["country"])){setSelected("country","Poland");}else if($mem->getCountry()=="Poland"){echo 'selected';}?>>Poland</option>
    <option value="Portugal" <?php if(isset($_POST["country"])){setSelected("country","Portugal");}else if($mem->getCountry()=="Portugal"){echo 'selected';}?>>Portugal</option>
    <option value="Puerto Rico" <?php if(isset($_POST["country"])){setSelected("country","Puerto Rico");}else if($mem->getCountry()=="Puerto Rico"){echo 'selected';}?>>Puerto Rico</option>
    <option value="Romania" <?php if(isset($_POST["country"])){setSelected("country","Romania");}else if($mem->getCountry()=="Romania"){echo 'selected';}?>>Romania</option> 
    <option value="Serbia" <?php if(isset($_POST["country"])){setSelected("country","Serbia");}else if($mem->getCountry()=="Serbia"){echo 'selected';}?>>Serbia</option>
    <option value="Singapore" <?php if(isset($_POST["country"])){setSelected("country","Singapore");}else if($mem->getCountry()=="Singapore"){echo 'selected';}?>>Singapore</option>
    <option value="Slovakia" <?php if(isset($_POST["country"])){setSelected("country","Slovakia");}else if($mem->getCountry()=="Slovakia"){echo 'selected';}?>>Slovakia</option>
    <option value="Slovenia" <?php if(isset($_POST["country"])){setSelected("country","Slovenia");}else if($mem->getCountry()=="Slovenia"){echo 'selected';}?>>Slovenia</option>
    <option value="South Africa" <?php if(isset($_POST["country"])){setSelected("country","South Africa");}else if($mem->getCountry()=="South Africa"){echo 'selected';}?>>South Africa</option>
    <option value="South Korea" <?php if(isset($_POST["country"])){setSelected("country","South Korea");}else if($mem->getCountry()=="South Korea"){echo 'selected';}?>>South Korea</option>
    <option value="Spain" <?php if(isset($_POST["country"])){setSelected("country","Spain");}else if($mem->getCountry()=="Spain"){echo 'selected';}?>>Spain</option>
    <option value="Sweden" <?php if(isset($_POST["country"])){setSelected("country","Sweden");}else if($mem->getCountry()=="Sweden"){echo 'selected';}?>>Sweden</option>
    <option value="Switzerland" <?php if(isset($_POST["country"])){setSelected("country","Switzerland");}else if($mem->getCountry()=="Switzerland"){echo 'selected';}?>>Switzerland</option>
    <option value="Taiwan" <?php if(isset($_POST["country"])){setSelected("country","Taiwan");}else if($mem->getCountry()=="Taiwan"){echo 'selected';}?>>Taiwan</option>
    <option value="Thailand" <?php if(isset($_POST["country"])){setSelected("country","Thailand");}else if($mem->getCountry()=="Thailand"){echo 'selected';}?>>Thailand</option>
    <option value="Turkey" <?php if(isset($_POST["country"])){setSelected("country","Turkey");}else if($mem->getCountry()=="Turkey"){echo 'selected';}?>>Turkey</option>
    <option value="Ukraine" <?php if(isset($_POST["country"])){setSelected("country","Ukraine");}else if($mem->getCountry()=="Ukraine"){echo 'selected';}?>>Ukraine</option>
    <option value="United Arab Emirates" <?php if(isset($_POST["country"])){setSelected("country","United Arab Emirates");}else if($mem->getCountry()=="United Arab Emirates"){echo 'selected';}?>>United Arab Emirates</option>
    <option value="United States" <?php if(isset($_POST["country"])){setSelected("country","United States");}else if($mem->getCountry()=="United States"){echo 'selected';}?>>United States</option>
    <option value="Uruguay" <?php if(isset($_POST["country"])){setSelected("country","Uruguay");}else if($mem->getCountry()=="Uruguay"){echo 'selected';}?>>Uruguay</option>
    <option value="Venezuela" <?php if(isset($_POST["country"])){setSelected("country","Venezuela");}else if($mem->getCountry()=="Venezuela"){echo 'selected';}?>>Venezuela</option>
    <option value="Vietnam" <?php if(isset($_POST["country"])){setSelected("country","Vietnam");}else if($mem->getCountry()=="Vietnam"){echo 'selected';}?>>Vietnam</option>
  </select>
  </div>
  <div class="col-sm-6" id="username_div">
    <label for="username">Address:</label>
    <input type="username" class="form-control" id="username" type="text" name="address" value="
	<?php if(isset($_POST["address"])){
		     setValue("address");
		   }else{ 
		     echo $mem->getAddress();
		   }
	?>">
  </div>
  <div class="col-sm-6">
    <label for="dob">Birthday:</label>
    <input type="date" class="form-control" placeholder="dd/mm/yyyy" name="dob" id="dob" value="<?php if(isset($_POST["dob"])){
		     setValue("dob");
		   }else{ 
		     echo $mem->getDOB();
		   }
	?>">
  </div>
  <div class="col-sm-6">
    <label for="email">Profession:</label>
    <input type="text" class="form-control" id="email" type="email" name="email" value="<?php if(isset($_POST["email"])){
		     setValue("email");
		   }else{ 
		     echo $mem->getProfession();
		   }
	?>">
  </div>
  <div class="col-sm-6">
    <label class="radio-inline"><input type="radio" name="optradio" class="radio_btns" value="Male" <?php if(isset($_POST["optradio"])){setChecked("optradio","Male");}else if($mem->getGender()=="Male"){echo 'checked';}?>>Male</label>
    <label class="radio-inline"><input type="radio" name="optradio" class="radio_btns" value="Female" <?php if(isset($_POST["optradio"])){setChecked("optradio","Female");}else if($mem->getGender()=="Female"){echo 'checked';}?>>Female</label>
  </div>
  <button type="submit" class="btn btn-default" id="save_profile" name="btn_save">Save Profile</button><br>
  <div id="short_bio">
    <label for="user_shortbio">Short Bio</label>
    <textarea class="form-control" rows="10" cols="10" name="user_shortbio"><?php if(isset($_POST["user_shortbio"])){
		     setValue("user_shortbio");
		   }else{ 
		     echo $mem->getShortBio();
		   }
	?></textarea>
  </div>
</form>
</div>
<?php 
     
  
  if(isset($_POST["btn_save"])){	  
	  $m=new Member();
	  $m->setCountry($_POST["country"]);
	  $m->setDOB($_POST["dob"]);
	  $m->setGender($_POST["optradio"]);
	  $m->setAddress($_POST["address"]);
	  $m->setProfession($_POST["email"]);
	  $m->setShortBio($_POST["user_shortbio"]);
	  $m->updatePersonalDetails($_SESSION["user_details"]["username"]);
  }
  
  function setSelected($fieldName,$fieldValue){
	  if(isset($_POST[$fieldName])and $_POST[$fieldName]==$fieldValue){
		  echo 'selected="selected"';
	  }
  }
  
  function setValue($fieldName){
	  if(isset($_POST[$fieldName])){
		 echo $_POST[$fieldName]; 
	  }
   }
	  
  function setChecked($fieldName,$fieldValue){
	  if(isset($_POST[$fieldName])and $_POST[$fieldName]==$fieldValue){
		  echo 'checked="checked"';
	  }
  }
?>
</body>
</html>