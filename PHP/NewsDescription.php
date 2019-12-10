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
			  echo 'News-'.$title;
		  }
	  ?>
    </title>
    <link rel="stylesheet" href="../CSS/FormatNewsDescription.css">
    <link href="../CSS/hover.css" rel="stylesheet" media="all">  
    <script src="../script/jquery-1.12.0.min.js"></script>
    <script>
	     /*this jQuery is for count the charaters in the text area and print the remaining charaters*/
         $(document).ready(function(){
             var text_max =998;
             $('#textarea_feedback').html(text_max+' characters remaining');

             $('#txt_comment').keyup(function(){
                  var text_length=$('#txt_comment').val().length;
                  var text_remaining=text_max-text_length;

                  $('#textarea_feedback').html(text_remaining+' characters remaining');
             });
         });
		 
		 //this jQuery is for counting the characters in the text area and if limit is exceed,character is not printed.
		 jQuery(document).ready(function($) {
             var max = 998;
             $('#txt_comment').keypress(function(e) {
				 if (e.which < 0x20) {
					 // e.which < 0x20, then it's not a printable character
					 // e.which === 0 - Not a character
					 return;     // Do nothing
				}
				if (this.value.length == max) {
					e.preventDefault();
				} else if (this.value.length > max) {
					// Maximum exceeded
					this.value = this.value.substring(0, max);
				}
           });
        }); //end if ready(fn)
    </script>
    
    
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
      <?php if(isset($_GET["link"])){
	        unset($_SESSION["user_details"]);
	        header("Location:HomePage.php");
       }
   ?>
    </div>
    
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
	    session_start();
	    require_once('Classes/Comment.php');
		require_once('Classes/Member.php');
		require_once('Classes/AvoidErrors.php');
		
		//to avoid object incomplete error
	  $err=new Errors();
	  $err->fixObject($_SESSION["user_details"]);  	
	
        if(isset($_GET['news'])){
			$newsId=$_GET['news'];			
			
			$news=new News();
			$news=$news->getNewsDetailsAccordingToId($newsId);
			$source="../Images/News/".$news->getImage();
		
			echo '<div id="news_banner">';
			echo '<img src="'.$source.'" alt="'.$news->getImage().'">';
			echo '</div>';
			echo '<div id="news_description">';
			echo '<div id="title">';
			echo '<h1>'.$news->getTitle().'</h1>';
			echo '</div>';
			echo '<div id="content" class="content"">';
			echo '<h3 id="news_date">'.$news->getNewsDate().'</h3>';
			echo '<p id="description">'.$news->getDescription().'</p>';
			echo '</div>';
			echo '</div>';		
			
			
			$co=new Comment();
			$comments_per_page=3;
	        $totalNumberOfRecords=$co->getTotalNumberOfCommentsForANews($newsId);
	
			//get total number of pages
  
			$numOfPages=ceil($totalNumberOfRecords/$comments_per_page);
  
			$page=0;
			$offset=0;
  
			if( isset($_GET['page'] ) ) {
			   $page =((int)$_GET['page']) + 1;
			   $offset = $comments_per_page*$page ;
			}else {
			   $page = 0;
			   $offset = 0;
			}
  
			$left_rec = $totalNumberOfRecords-($page*$comments_per_page);
			
			
			
			$c=new Comment();
			$topFiveCommentArray=$c->getTopFiveCommentsAccordingToNewsId($newsId,$offset,$comments_per_page);
			
			//check whether there are comments for that news or not
			if(count($topFiveCommentArray)>0){
				echo '<div id="comment">';
			    echo '<h2>COMMENTS</h2>';
			    foreach($topFiveCommentArray as $comment){
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
			
			   $_PHP_SELF="NewsDescription.php";
			   $realPageNo=$page+1;	        
			   echo '<br>';
			   if( $page > 0 && $realPageNo<$numOfPages) {
				   $last = $page - 2;
				   echo "<a href = \"$_PHP_SELF?page=".$last."&amp;news=".$newsId."\" class=\"links\">PREVIOUS</a>";
				   echo "<a href = \"$_PHP_SELF?page=".$page."&amp;news=".$newsId."\" class=\"links\">NEXT</a>";
			   }else if( $page == 0 && $numOfPages!=1 && $numOfPages!=0) {
				   echo "<a href = \"$_PHP_SELF?page=".$page."&amp;news=".$newsId."\" class=\"links\">NEXT</a>";
			   }else if( $left_rec <= $comments_per_page && $comments_per_page<$totalNumberOfRecords) {
				   $last = $page - 2;
				   echo "<a href = \"$_PHP_SELF?page=".$last."&amp;news=".$newsId."\" class=\"links\">PREVIOUS</a>";
			   }	
			   $newsID=$_GET['news'];
			   $_PHP_PAGE="ViewAllComments.php";
			   echo '<div id="view_all_comments">';			
			   echo "<a href=\"$_PHP_PAGE?news=".$newsID."\">VIEW ALL</a>";
			   echo '</div>';
			
			   echo '</div>';
		    }else{
			   echo '<div id="comment">';
			   echo '<h2>NO COMMENTS FOR THIS NEWS</h2>';			   
			   echo '</div>';
		    }
			
			echo '<br><p id="post_a_coment_para">POST A COMMENT</p>';		
			
			if(isset($_SESSION["user_details"])){
				echo '<div id="post_comment_div">';
				echo '<form method="post">';
				echo '<input type="hidden" name="hdn_news_id" value="'.$newsId.'" >';				      
                echo '<textarea name="txt_comment" id="txt_comment" rows="10" cols="90" maxlength="998">Post Your Comment Here</textarea><br>';
				echo '<div id="textarea_feedback"></div>';
				echo '<input type="submit" name="btn_submit" value="SUBMIT" id="btn_submit" onClick="'.addComment().'"></button>';
				echo '</form>';
				echo '</div>';
			}else{				
				echo '<p id="login">Please '.'<a href="LoginForm.php">Login </a>'.'to comment</p>';
			}
		}
		function addComment(){
			
			if(isset($_POST['btn_submit'])){
				
				$com=new Comment();
				$com->setCommentDescription($_POST['txt_comment']);
				$com->setNewsId($_POST['hdn_news_id']);
				$com->setUserName($_SESSION["user_details"]["username"]);
				
				//get current date-time
				date_default_timezone_set('Europe/London');
				$date=date('Y-m-d');
				
				$com->setCommentDate($date);
				$com->addComment();
				
					
			}
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