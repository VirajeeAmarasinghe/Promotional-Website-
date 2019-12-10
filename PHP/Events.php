<!doctype html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Events</title>
    <link rel="stylesheet" href="../CSS/FormatEvents.css">
  </head>

  <body>
    <div id="top_stripe">
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
           <li><a href="Events.php" class="this_form">EVENTS</a></li>
           <li><a href="Photos.php">PHOTOS</a></li>
           <li><a href="Videos.php">VIDEOS</a></li>
           <li><a href="#">NEWS</a></li>
           <li><a href="http://www.onedirectionstore.com/">STORE</a></li>
           <li><a href="#">CONTACT</a></li>
        </ul>
        </div>
    </nav>
    
    <div id="top_banner">
      <img src="../Images/OneDirectionBanner2.jpg" alt="top_banner_event_one_direction" width="100%">
    </div> 
    
    <section class="events">
      <div class="ev_header">
        <h2 class="title"><span>UPCOMING EVENTS</span></h2>
      </div>
      <div class="listing">
        <table>
          <thread>
            <tr>
              <th>Date</th>
              <th>Venue</th>
              <th>Location</th>
            </tr>
          </thread>
          <tbody>
          <?php
           require_once('config/DBConnection.php');			
			
			try{
				  $conn = DBConnection::GetConnection();			  
			
				  
				  $rec_limit = 5;
				  
				  /* Get total number of records */
				  $sql = "SELECT * FROM event ";
				  $result= $conn->query($sql);
				  
				  if(! $result ) {
					 die('Could not get data: ' . mysql_error());
				  }
				  
				  
				  $rec_count = 0;
				  
				  foreach($result as $ev){
					  $rec_count++;
			      }
				  
			      $numOfPage=ceil($rec_count/$rec_limit);  //get total number of pages
				  
			      $page=0;
				  $offset=0;
				  if( isset($_GET['page'] ) ) {
					 $page =((int)$_GET['page']) + 1;
					 $offset = $rec_limit * $page ;
				  }else {
					 $page = 0;
					 $offset = 0;
				  }
			 
				  $left_rec = $rec_count - ($page * $rec_limit);
				  $sql = "SELECT event_id,event_date,venue,location FROM event LIMIT $offset, $rec_limit";
				  
				  $result2= $conn->query($sql);
			 
				  if(! $result2 ) {
					 die('Could not get data: ' . mysql_error());
				  }
			 
				  foreach($result2 as $event) {
					  echo '<tr>';
					  echo '<td class="date">';
					  echo '<span class="time">'.$event['event_date'].'</span>';
					  echo '</td>';
					  echo '<td class="venue">';
					  echo '<span class="venue">'.$event['venue'].',</span>';
					  echo '</td>';
					  echo '<td class="location">';
					  echo '<span class="locality">'.$event['location'].'</span>';
					  echo '<td>';
					  echo '</tr>';
				 }
				 echo '</tbody></table></div>';
				  $_PHP_SELF="Events.php";
				  $realPageNo=$page+1;
				  echo '<div id="pagination_links">';
				  echo '<div id="text">';
				  if( $page > 0 && $realPageNo<$numOfPage) {
					 $last = $page - 2;
					 echo "<a href = \"$_PHP_SELF?page=".$last."\">Previous</a>";
					 echo "<a href = \"$_PHP_SELF?page=".$page."\">Next</a>";
				  }else if( $page == 0 ) {
					 echo "<a href = \"$_PHP_SELF?page=".$page."\">Next</a>";
				  }else if( $left_rec < $rec_limit ) {
					 $last = $page - 2;
					 echo "<a href = \"$_PHP_SELF?page=".$last."\">Previous</a>";
				  }
			   echo '</div>';
			   echo '</div';
				  $conn=null;
			  
			}catch(PDOException $e){
			  echo 'Fail to connect';
			  echo $e->getMessage();	  
			}		
			 
		  ?>            
          
      
    </section>
    
    <div id="forth_stripe"> 
      <a href="Events.php">
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