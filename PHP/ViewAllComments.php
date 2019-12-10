<!doctype html>
<html>
  <head>
    <meta charset="utf-8">
    <title>
       <?php
	      require_once('Classes/News.php');
          if(isset($_GET['news'])){
			  $n=new News();
			  $title=$n->getTitleAccordingToId($_GET['news']);
			  echo 'All Comments of News-'.$title;
		  }
	  ?>
    </title>
    <link rel="stylesheet" href="../CSS/FormatViewAllComments.css">
    <link href="../CSS/hover.css" rel="stylesheet" media="all">
  </head>
  
  <body>
  
    <div id="top_stripe">
     <div class="back">
      <p class="goToBack"><a href="javascript:history.go(-1)" title="Return to the previous page" class="goBack">&laquo; GO BACK</a></p>';
     </div>
     <div id="search_box_form_div">
        <form method="post" name="search_box_form" id="search_box_form">
          <!--style="border:none->"to remove the border/outline around the text box--> 
          <input type="text" name="search_box" id="search_box">        
        </form>
      </div> 
      <div id="registration_nav">
        <ul>
          <li><a href="RegistrationForm.php">REGISTER</a></li>
          <?php session_start();if(isset($_SESSION["user_details"])){
		             echo '<li><a href="?link=logoutLink">LOG OUT</a></li>';
			     }else if(!isset($_SESSION["user_details"])){
					 echo '<li><a href="LoginForm.php">LOGIN</a></li>';
				 }
		  ?>          
        </ul>
      </div>

    </div>
    <?php if(isset($_GET["link"])){
	        unset($_SESSION["user_details"]);
	        header("Location:HomePage.php");
       }
   ?>
    <div id="second_stripe">
      <a href="HomePage.php">
        <h1 id="singer_fname">ONE</h1>
        <h1 id="singer_lname">DIRECTION</h1>
      </a>
    </div>
    
    <nav class="main">
    <div id="Nav">
        <ul>
           <li><a href="HomePage.php">HOME</a></li>
           <li><a href="One Direction.php">ONE DIRECTION</a></li>
           <li><a href="Releases.php">RELEASES</a></li>
           <li><a href="Events.php">EVENTS</a></li>
           <li><a href="Photos.php">PHOTOS</a></li>
           <li><a href="Videos.php">VIDEOS</a></li>
           <li><a href="News.php" class="this_form">NEWS</a></li>
           <li><a href="StoreOneDirection.php">STORE</a></li>
           <li><a href="Contact.php">CONTACT</a></li>
        </ul>
        </div>
    </nav>
    
    <?php
	    require_once('Classes/Comment.php');
		require_once('Classes/Member.php');
	
        if(isset($_GET['news'])){
			$newsId=$_GET['news'];
			
			$news=new News();
			$news=$news->getNewsDetailsAccordingToId($newsId);			
			
			echo '<div id="title">';
			echo '<h1>'.$news->getTitle().'</h1>';
			echo '</div>'; 	
			
						
			echo '<div id="comment">';
			echo '<h2 id="all_comment_h1">All COMMENTS</h2>';
			$c=new Comment();
			$allCommentArray=$c->getAllTheCommentsForANews($newsId);
			
			foreach($allCommentArray as $comment){
				$c=$comment;
				echo '<div id="post_old_comments">'; 
			    echo '<div id="profile_pic">';
				$m=new Member();				
				$userName=$c->getUserName();
				$m=$m->getNameAndProfilePicAccordingToUsername($userName);
				$source="../Images/profile pictures/".$m->getImage();
			    echo '<img src="'.$source.'" alt="'.$m->getImage().'" width="80" height="80">';
			    echo '</div>';
			    echo '<div id="comment_description">';
			    echo '<h3>'.$m->getName().'</h3>';
				echo '<p>'.$c->getCommentDate().'</p>';
				echo '<p id="commentDes">'.$c->getCommentDescription().'</p>';
			    echo '</div>';
			    echo '</div>';
		    }	
			
			echo '</div>';
		}
	?>   
    
    
           
   <div id="forth_stripe"> 
      <a href="#">
       <img id="top_to_page_img" src="../Images/Arrows-Up-Circular-icon.png" alt= "top_to_page" height="40px" width="40px">     
       </a>
        <h3 id="top">Top To Page</h3>    
    </div>
    
        
    <nav class="sub">
    <div id="Nav_sub">
      <ul>
           <li><a href="https://web.facebook.com/onedirectionmusic?_rdr" class="highlight"><img src="../Images/facebook.jpg" alt="Facebook"></a></li> 
           <li><a href="https://twitter.com/onedirection" class="highlight"><img src="../Images/Twitter.jpg" alt="Twitter"></a></li>
           <li><a href="https://www.pinterest.com/1dofficial/" class="highlight"><img src="../Images/p.jpg" alt="p"></a></li> 
           <li><a href="https://soundcloud.com/onedirectionmusic" class="highlight"><img src="../Images/c.jpg" alt="c"></a></li>
           <li><a href="https://open.spotify.com/artist/4AK6F7OLvEQ5QYCBNiQWHq" class="highlight"><img src="../Images/o.jpg" alt="o"></a></li> 
           <li><a href="https://www.youtube.com/user/OneDirectionVEVO" class="highlight"><img src="../Images/uTube.jpg" alt="YouTube"></a></li>
           <li><a href="instagram.com/onedirection" class="highlight"><img src="../Images/Cam.jpg" alt="cam"></a></li>
           <li><a href="https://plus.google.com/+OneDirection/posts" class="highlight"><img src="../Images/googlePlus.jpg" alt="google_plus"></a></li>
        </ul>
        </div>
    </nav>
   
   <div id="footer">
      <div id="footer_para">
        <p>Copyright © 2015 One Direction. All Rights Reserved.</p>
      </div>
  </div>
   
  </body>
</html>