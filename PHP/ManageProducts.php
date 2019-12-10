<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Manage Products</title>   
<link rel="stylesheet" href="../CSS/FormatManageProducts.css">

</head>

<body>
  <nav class="navbar navbar-default">
  <div class="container-fluid">    
    <ul class="nav navbar-nav">
       <li><a class="navbar-brand" href="HomePage.php">One Direction</a></li>
      <li class="active"><a href="HomePageAdminPanel.php">Home</a></li>
      <li><a href="?link=logoutLink">Logout</a></li>
      <li><a href="#" id="welcome">Welcome <?php session_start();echo $_SESSION["admin_details"]["username"]?></a></li>        
    </ul>
  </div>
</nav>
<section id="main_wrapper">
    
<div id="second_bar">
<ul class="nav nav-tabs">
  <li class="active"><a href="HomePageAdminPanel.php">Members</a></li>
  <li><a href="ManageReleaseAlbums.php">Release Albums</a></li>
  <li><a href="ManagePhotoAlbums.php">Photo Albums</a></li>
  <li><a href="ManageReleaseVideos.php">Videos</a></li> 
  <li><a href="ManageEvents.php">Events</a></li>
  <li><a href="ManageNews.php">News</a></li>
  <li><a href="ManageComments.php">Comments</a></li>
  <li><a href="ManageOneDMembers.php">One D Members</a></li>
  <li><a href="#">Products</a></li>
</ul>
</div>
<?php
    
    require_once('Classes/Product.php');

    $rel=new Product();
	$product_id="";
	$product_name="";
	$unit_price=0.00;
	$image_name="";
	$description="";
	$qty=0;
	$cat="";
  
	$visi="disap";
	$source="../Images/Official Store/";
	$vis="disVis";

	if(isset($_POST["search"])){
		if(isset($_POST["product_id"])){			
		    $rel=$rel->GetProductAccordingToProductID($_POST["product_id"]);
			
				$product_id=$_POST["product_id"];
				$product_name=$rel->getProductName();
				$unit_price=$rel->getProductPrice();
				$image_name=$rel->getProductImage();
				$description=$rel->getProductDescription();
				$qty=$rel->getQuantity();
				$cat=$rel->getCategory();
				
				$vis="vis";
				
				$source="../Images/Official Store/".$image_name;
				$visi="app";
		    			
	    }else{
			echo '<script>alert("Enter Product ID")</script>';
	    }		
    }
?>
<div id="form_section">   
   <form method="post" enctype="multipart/form-data" id="form_1">
   <div id="<?php echo $visi; ?>"><img src="<?php echo $source;?>" width="400" height="auto" alt="No Photo"></div>
       <label for="product_id">Product ID:</label><br>
       <input type="number" name="product_id" id="product_id" class="input" min="1" value="<?php if(isset($_POST["Refreash"])){ echo $rel->getMaxID();}else if(isset($_POST["product_id"])){ echo $_POST["product_id"];}else{echo $rel->getMaxID();}?>"><br><br>
       <label for="product_name">Product Name:</label><br>
       <input type="text" name="product_name" id="product_name" placeholder="Product Name" class="input" value="<?php if(isset($_POST["Refreash"])){ echo "";}else if(isset($_POST["search"])){echo $product_name;}else if(isset($_POST["product_name"])) echo $_POST["product_name"];?>"><br><br>
       <label for="unit_price">Unit Price:</label><br>
       <input type="text" name="unit_price" id="unit_price" placeholder="Unit Price" class="input" value="<?php if(isset($_POST["Refreash"])){ echo "";}else if(isset($_POST["search"])){echo $unit_price;}else if(isset($_POST["unit_price"])) echo $_POST["unit_price"];?>"><br><br>   
         <label for="qty">Quantity:</label><br>
       <input type="number" name="qty" id="qty" placeholder="Quantity" class="input" value="<?php if(isset($_POST["Refreash"])){ echo "";}else if(isset($_POST["search"])){echo $qty;}else if(isset($_POST["qty"])) echo $_POST["qty"];?>"><br><br>  
       <label for="cat">Category:</label><br>
       <input type="text" name="cat" id="cat" placeholder="Category" class="input" value="<?php if(isset($_POST["Refreash"])){ echo "";}else if(isset($_POST["search"])){echo $cat;}else if(isset($_POST["cat"])) echo $_POST["cat"];?>"><br><br>
       <label for="description">Description:</label><br>
           <textarea name="description" rows="10" cols="55" id="lyrixText"><?php if(isset($_POST["Refreash"])){ echo "";}else if(isset($_POST["search"])){echo $description;}else if(isset($_POST["description"])) echo $_POST["description"];?></textarea>      
           <br><br>
           
           <label for="photo_image">Upload Photo:</label><br><br>
           <input type="file" name="photo_image">           
           
       <div id="buttons">
         <button type="submit" name="add">Add New</button>
         <button type="submit" name="del">Delete</button>
         <button type="submit" name="update">Update</button>
         <button type="submit" name="search">Search</button>
         <button type="submit" name="view_all">View All</button>
         <button type="submit" name="Refreash">Refreash</button>
       </div>
     </form>   
</div>
  


<?php
    require_once('Classes/AvoidErrors.php');      
   
    
   //to avoid object incomplete error
   
	  $err=new Errors();
	  $err->fixObject($_SESSION["admin_details"]); 
   
   if(isset($_GET["link"])){
	   unset($_SESSION["admin_details"]);
	   header("Location:LoginFormAdmin.php");
   }
   
   if(isset($_POST["btn_delete"])){	
     
	   $productID=$_POST["btn_delete"];
	   $p=new Product();
	   $result=$p->deleteProduct($productID);
	      
   } 
   
   if(isset($_POST["add"])){
	   if(validation()==true){
		   if(isset($_FILES["photo_image"])){
			   
			   $uploadOk=1;
		      
		       //get extension of the image
		       $ext=pathinfo($_FILES["photo_image"]['name'],PATHINFO_EXTENSION);
		   
		       // Check if image file is a actual image or fake image
		       $check =getimagesize($_FILES["photo_image"]["tmp_name"]);
			   
               if($check !== false) {                
                  $uploadOk = 1;
               }else {
			      echo '<script>alert("File is not an image")</script>';                
                  $uploadOk=0;
               }
		   
		       // Check file size
               if ($_FILES["photo_image"]["size"]>1000000) {
			       echo '<script>alert("Sorry, your file is too large.")</script>';                
                   $uploadOk=0;
                }
		   
		        // Allow certain file formats
                if($ext!="jpg" && $ext!="png" && $ext!="jpeg" && $ext!="gif"){
			        echo '<script>alert("Sorry, only JPG, JPEG, PNG & GIF files are allowed.")</script>';                    $uploadOk = 0;
                }
				
				$uploadOk2=false;
				if($uploadOk===1){
			     //upload image to the folder    //change photo name
				 if(move_uploaded_file($_FILES['photo_image']['tmp_name'],'../Images/Official Store/'.$_POST["product_id"].'+'.$_POST["product_name"].'.'.$ext)){ 
				      $image=$_POST["product_id"].'+'.$_POST["product_name"].'.'.$ext;
					  $_SESSION['image']=$image;		  	
					  $uploadOk2=true;		 		 
				  }else{
					  echo '<script>alert("Sorry, there was an error uploading your file.")</script>';             
				  }
		        }else{			
                    echo '<script>alert("Sorry, there was an error uploading your file.")</script>';             
		        } 			   
				 
				   
				   //if only image uplaoding was successful, then data will be saved in the database.
				   if($uploadOk2==true){
					   $p=new Product();
					   $p->setProductName($_POST["product_name"]);
					   $p->setProductPrice($_POST["unit_price"]);
					   $p->setProductImage($_SESSION['image']);
					   $p->setProductDescription($_POST["description"]);
					   $p->setCategory($_POST["cat"]);
					   $p->setQuantity($_POST["qty"]);
					   
					   $result1=$p->Add();
					   if($result1==true){
						   echo '<script>alert("Saved Succefully.")</script>';
					   }else{
						   echo '<script>alert("Sorry,Error Occurred.")</script>';
					   }				   
				   }					   
				   
		   }else{
			   echo '<script>alert("Select Image.")</script>';
			}
	   }
   }
   
   if(isset($_POST["update"])){
	   if(validation()==true){
		   if(isset($_FILES["photo_image"])){
			   
			   $uploadOk=1;
		      
		       //get extension of the image
		       $ext=pathinfo($_FILES["photo_image"]['name'],PATHINFO_EXTENSION);
		   
		       // Check if image file is a actual image or fake image
		       $check =getimagesize($_FILES["photo_image"]["tmp_name"]);
			   
               if($check !== false) {                
                  $uploadOk = 1;
               }else {
			      echo '<script>alert("File is not an image")</script>';                
                  $uploadOk=0;
               }
		   
		       // Check file size
               if ($_FILES["photo_image"]["size"]>1000000) {
			       echo '<script>alert("Sorry, your file is too large.")</script>';                
                   $uploadOk=0;
                }
		   
		        // Allow certain file formats
                if($ext!="jpg" && $ext!="png" && $ext!="jpeg" && $ext!="gif"){
			        echo '<script>alert("Sorry, only JPG, JPEG, PNG & GIF files are allowed.")</script>';                    $uploadOk = 0;
                }
				
				$uploadOk2=false;
				if($uploadOk===1){
			     //upload image to the folder    //change photo name
				 if(move_uploaded_file($_FILES['photo_image']['tmp_name'],'../Images/Official Store/'.$_POST["product_id"].'+'.$_POST["product_name"].'.'.$ext)){ 
				      $image=$_POST["product_id"].'+'.$_POST["product_name"].'.'.$ext;
					  $_SESSION['image']=$image;		  	
					  $uploadOk2=true;		 		 
				  }else{
					  echo '<script>alert("Sorry, there was an error uploading your file.")</script>';             
				  }
		        }else{			
                    echo '<script>alert("Sorry, there was an error uploading your file.")</script>';             
		        } 			   
				 
				   
				   //if only image uplaoding was successful, then data will be saved in the database.
				   if($uploadOk2==true){
					   $p=new Product();
					   $p->setProductName($_POST["product_name"]);
					   $p->setProductPrice($_POST["unit_price"]);
					   $p->setProductImage($_SESSION['image']);
					   $p->setProductDescription($_POST["description"]);
					   $p->setCategory($_POST["cat"]);
					   $p->setQuantity($_POST["qty"]);
					   
					   $result1=$p->updateProductDetails($_POST["product_id"]);
					   if($result1==true){
						   echo '<script>alert("Updated Succefully.")</script>';
					   }else{
						   echo '<script>alert("Sorry,Error Occurred.")</script>';
					   }				   
				   }					   
				   
		   }else{
			   echo '<script>alert("Select Image.")</script>';
			}
	   }
   }
   
   function validation(){
	   $result=true;
	   if(empty($_POST["product_id"])){
		   echo '<script>alert("Product ID field is empty")</script>';
		   $result=false;
	   }else if(empty($_POST["product_name"])){
		   echo '<script>alert("Product Name field is empty")</script>';
		   $result=false;
	   }else if(empty($_POST["unit_price"])){
		   echo '<script>alert("Unit Price field is empty")</script>';
		   $result=false;
	   }else if(empty($_POST["description"])){
		   echo '<script>alert("Description field is empty")</script>';
		   $result=false;
	   }else if(empty($_POST["cat"])){
		   echo '<script>alert("Category field is empty")</script>';
		   $result=false;
	   }else if(empty($_POST["qty"])){
		   echo '<script>alert("Quantity field is empty")</script>';
		   $result=false;
	   }else if(empty($_POST["cat"])){
		   echo '<script>alert("Category field is empty")</script>';
		   $result=false;
	   }else if(isCurrency($_POST["unit_price"])<1){
		   echo '<script>alert("Enter Valid Unit Price")</script>';
		   $result=false;
	   }	   
	   return $result;
   }
   
   function isCurrency($number){
       return preg_match("/^-?[0-9]+(?:\.[0-9]{1,2})?$/", $number);
   }
    
  if(isset($_POST["del"])){
	  if(empty($_POST["product_id"])){
		  echo '<script>alert("Product ID field is empty")</script>';
	  }else{
		  $r=new Product();
		  $result=$r->deleteProduct($_POST["product_id"]);
		  if($result==true){
			  echo '<script>alert("Deleted!!!")</script>';
	      }else{
			  echo '<script>alert("Not Deleted!!!")</script>';
		  }
	  }
  }
  $visiblity="visible";
  echo '<form method="post">';
 if(isset($_POST["view_all"])||isset($_POST["btn_delete"])){
	 $release=new Product();
	 $releaseArray2=$release->GetAllProducts();
	 echo '<div id="table_box" class="'.$visiblity.'">';
     echo '<table>';
     echo '<tr>';
	 echo '<th>Product Image</th>';
     echo '<th>Product ID</th>';
     echo '<th>Product Name</th>';
     echo '<th>Unit Price</th>';
	 echo '<th>Quantity in Stock</th>';     
     echo '</tr> ';
	 echo '<tbody>';
	 foreach($releaseArray2 as $release2){
		 $release=$release2;
		 $source2="../Images/Official Store/".$release->getProductImage();		 
		 echo '<tr>';
	     echo '<td><img src="'.$source2.'" width="100" height="100"></td>';
		 echo '<td>'.$release->getProductCode().'</td>';
		 echo '<td>'.$release->getProductName().'</td>';
		 echo '<td>'.$release->getProductPrice().'</td>';
		 echo '<td>'.$release->getQuantity().'</td>';	
		 echo '<td><button type="submit" value="'.$release->getProductCode().'" name="btn_delete">Delete</button></td>';
	     echo '</tr>';
		 
     }	
	 echo '</tbody>'; 	
	 echo '</table>';
	 echo '</div>'; 
	 echo '</form>';
 }
 
  if(isset($_POST["Refreash"])){	 
	  $visiblity="hidden";
	  $visi="disap";
  }
  
  
  
?>


</section>
</body>
</html>