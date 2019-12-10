<?php
  require_once('config/DBConnection.php');
  
  class News{
	  private $news_id;
	  private $title;
	  private $news_date;
	  private $description;
	  private $image;
	  
	  //set methods
	  
	  public function setNewId($id){
		  $this->news_id=$id;
	  }
	  public function setTitle($title){
		  $this->title=$title;
	  }
	  public function setNewsDate($date){
		  $this->news_date=$date;
	  }
	  public function setDescription($des){
		  $this->description=$des;
	  }
	  public function setImage($image){
		  $this->image=$image;
	  }
	  
	  //get methods
	  
	  public function getNewsId(){
		  return $this->news_id;
	  }
	  public function getTitle(){
		  return $this->title;
      }
	  public function getNewsDate(){
		  return $this->news_date;
	  }
	  public function getDescription(){
		  return $this->description;
	  }
	  public function getImage(){
		  return $this->image;
	  }
	  
	  //get all the news details
	  
	  public function getAllTheNews($offset,$news_per_page){
		 try{
		    $conn = DBConnection::GetConnection();	
			$myquery= "SELECT news_id,title,news_date,description from news LIMIT $offset,$news_per_page";
			$result= $conn->query($myquery);
			$allnews=array();
			foreach($result as $news){
				$n1=new News();
				$n1->setNewId($news["news_id"]);
				$n1->setTitle($news["title"]);
				$n1->setNewsDate($news["news_date"]);
				$n1->setDescription($news["description"]);
				$newsId=$news["news_id"];
				$myQuery2="SELECT image from news_image where news_id='".$newsId."'";
				$result2=$conn->query($myQuery2);
				foreach($result2 as $image){
					$n1->setImage($image["image"]);
					break;
			    }
				array_push($allnews,$n1);				
			}
			$conn =null;//To close the connection 
			return $allnews;
		 }catch(PDOException $e){
			 echo 'Fail to connect';
			 echo $e->getMessage();
		 }
     }
	 
	 //get news title according to the news id
	 
	 public function getTitleAccordingToId($newsId){
		 try{
			$conn = DBConnection::GetConnection();
			$myQuery="SELECT title from news where news_id='".$newsId."'";
			$result= $conn->query($myQuery);
			$title="";
			foreach($result as $news){
				$title=$news["title"];
			} 
			$conn=null;
			return $title;
		}catch(PDOException $e){
			echo 'Fail to connect';
			echo $e->getMessage();
		}
     }
	 
	 //get new details according to the news id
	  
	  public function getNewsDetailsAccordingToId($newsID){
		 try{
		    $conn = DBConnection::GetConnection();	
			$myquery= "SELECT news_id,title,news_date,description from news where news_id='".$newsID."'";
			$result= $conn->query($myquery);
		    $n1=new News();
			foreach($result as $news){				
				$n1->setNewId($news["news_id"]);
				$n1->setTitle($news["title"]);
				$n1->setNewsDate($news["news_date"]);
				$n1->setDescription($news["description"]);
				$newsId=$news["news_id"];
				$myQuery2="SELECT image from news_image where news_id='".$newsID."'";
				$result2=$conn->query($myQuery2);
				foreach($result2 as $image){
					$n1->setImage($image["image"]);
					break;  //only one image is taken,so break statement is used in here to break the inner loop
			    }						
			}
			$conn =null; 
			return $n1;
		 }catch(PDOException $e){
			 echo 'Fail to connect';
			 echo $e->getMessage();
		 }
     }
	 
	 //get total number of news
	 
	 public function getTotalNumberOfNews(){
		  try{
			 $conn=DBConnection::GetConnection();
			 $queryForGetTotal="SELECT COUNT(news_id) AS total_value FROM news";
			 $tot_result=$conn->prepare($queryForGetTotal);
			 $tot_result->execute();
			 $tot= $tot_result->fetch(PDO::FETCH_ASSOC);              
			 $total=$tot['total_value'];  
			 $conn=null;
			 return $total;
		  }catch(PDOException $p){
			  echo 'Fail to connect';
			  echo $p->getMessage();
		  }
	  }
	 
	 //get images according to the news id
	  
	  public function getImagesAccordingToId($newsID){
		 try{
		    $conn = DBConnection::GetConnection();	
			
			$myQuery2="SELECT image from news_image where news_id='".$newsID."'";
			$result2=$conn->query($myQuery2);
			$imageArray=array();
			foreach($result2 as $image){				
				array_push($imageArray,$image["image"]);
			}						
			
			$conn =null; 
			return $imageArray;
		 }catch(PDOException $e){
			 echo 'Fail to connect';
			 echo $e->getMessage();
		 }
     }
	 
	 //get max id from the databse
	 public function getMaxID(){
		 try{
			$conn = DBConnection::GetConnection();	
			$queryForGetMaxId="SELECT MAX(news_id) AS max_value FROM news";
			$max_result=$conn->prepare($queryForGetMaxId);
			$max_result->execute();
			$maxId = $max_result->fetch(PDO::FETCH_ASSOC);              
			$pId=$maxId['max_value']; 
			$incrementPid=$pId+1;
			return $incrementPid;
		}catch(PDOException $e){
			echo 'Fail to connect';
			echo $e->getMessage();
		}	
     }
	 
	 //delete specific news
	  public function deleteNews($newsID){
		  try{
			  $conn=DBConnection::GetConnection();
			  $myQuery="DELETE FROM news where news_id='".$newsID."'";
			  $cmd=$conn->query($myQuery);
			  
			  return $cmd;
		  }catch(PDOException $p){
			  echo 'Fail to connect';
			  echo $p->getMessage();
		  }
	  } 
	  
	  //insert new news to the database
	 public function addNewEvent(){
		 try{
			  $conn=DBConnection::getConnection();			  
			  			  
			  $insertQuery="INSERT INTO news(title,news_date,description) VALUES (:title,:news_date,:description)";
			  $cmd=$conn->prepare($insertQuery);
			  
			  $cmd->bindValue(':title',$this->getTitle(),PDO::PARAM_STR);
			  $cmd->bindValue(':news_date',$this->getNewsDate(),PDO::PARAM_STR);
			  $cmd->bindValue(':description',$this->getDescription(),PDO::PARAM_STR);
			  			  
			  $returnedValue=$cmd->execute(); //Returns TRUE on success or FALSE on failure
			  return $returnedValue;
		  }catch(PDOException $p){
			  echo 'Fail to connect';
			  echo $p->getMessage();
		  }
     } 
	 
	 //insert news images to the database
	 public function addNewEventImages(){
		 try{
			  $conn=DBConnection::getConnection();			  
			  			  
			  $insertQuery="INSERT INTO news_image(news_id,image) VALUES (:news_id,:image)";
			  $cmd=$conn->prepare($insertQuery);
			  
			  $cmd->bindValue(':news_id',$this->getNewsId(),PDO::PARAM_INT);
			  $cmd->bindValue(':image',$this->getImage(),PDO::PARAM_STR);
			  
			  			  
			  $returnedValue=$cmd->execute(); //Returns TRUE on success or FALSE on failure
			  return $returnedValue;
		  }catch(PDOException $p){
			  echo 'Fail to connect';
			  echo $p->getMessage();
		  }
     }
	 
	 //this method is for updating news details
	  public function updateNewsDetails($newsID){
		  try{
			  $conn=DBConnection::getConnection();
			  $updateQuery="UPDATE news SET title=:title,news_date=:news_date,description=:description WHERE news_id='".$newsID."'";
			  $cmd=$conn->prepare($updateQuery);
			  $cmd->bindValue(':title',$this->getTitle(),PDO::PARAM_STR);
			  $cmd->bindValue(':news_date',$this->getNewsDate(),PDO::PARAM_STR);
			  $cmd->bindValue(':description',$this->getDescription(),PDO::PARAM_STR);			  
			  
			  return $cmd->execute();
		  }catch(PDOException $p){
			  echo 'Fail to connect';
			  echo $p->getMessage();
		  }
	  } 
	  
	  //delete images of specific news 
	  public function deleteNewsImages($newsID){
		  try{
			  $conn=DBConnection::GetConnection();
			  $myQuery="DELETE FROM news_image where news_id='".$newsID."'";
			  $cmd=$conn->query($myQuery);
			  
			  return $cmd;
		  }catch(PDOException $p){
			  echo 'Fail to connect';
			  echo $p->getMessage();
		  }
	  } 
	  
	  //get all the news details
	  
	  public function getAllTheNews2(){
		 try{
		    $conn = DBConnection::GetConnection();	
			$myquery= "SELECT news_id,title,news_date,description from news";
			$result= $conn->query($myquery);
			$allnews=array();
			foreach($result as $news){
				$n1=new News();
				$n1->setNewId($news["news_id"]);
				$n1->setTitle($news["title"]);
				$n1->setNewsDate($news["news_date"]);
				$n1->setDescription($news["description"]);
				
				array_push($allnews,$n1);				
			}
			$conn =null;//To close the connection 
			return $allnews;
		 }catch(PDOException $e){
			 echo 'Fail to connect';
			 echo $e->getMessage();
		 }
     } 
  }
?>