<?php
    require_once('config/DBConnection.php');
	
	class Video{
		private $videoId;
		private $videoName;
		private $videoImage;
		private $url;
		private $releaseId;
		
		//set methods
		
		public function setVideoId($videoId){
			$this->videoId=$videoId;
		}
		public function setVideoName($videoName){
			$this->videoName=$videoName;
	    }
		public function setVideoImage($videoImage){
			$this->videoImage=$videoImage;
		}		
		public function setUrl($url){
			$this->url=$url;
		}
		public function setReleaseId($releaseId){
			$this->releaseId=$releaseId;
		}
		
		//get methods
		
		public function getVideoId(){
			return $this->videoId;
		}
		public function getVideoName(){
			return $this->videoName;
		}
		public function getVideoImage(){
			return $this->videoImage;
		}
		public function getUrl(){
			return $this->url;
		}
		public function getReleaseId(){
			return $this->releaseId;
		}
		
		//get videos according to the specific release id
	 
	 public function GetVideosAccordingToId($releaseId){	
	  
		try{
			$conn = DBConnection::GetConnection();	
			$myquery= "SELECT video_id,video_name,video_image,url,release_id from video where release_id='".$releaseId."'";
			$result= $conn->query($myquery);
			$videos=array();
			foreach($result as $video){
				$v1=new Video();
				$v1->setVideoId($video["video_id"]);
				$v1->setVideoName($video["video_name"]);
				$v1->setVideoImage($video["video_image"]);
				$v1->setUrl($video["url"]);
				$v1->setReleaseId($video["release_id"]);
				array_push($videos,$v1);				
			}
			$conn =null;//To close the connection 
			return $videos;
		}catch(PDOException $e){
			echo 'Fail to connect';
			echo $e->getMessage();
		}	
		  
     }
	 
	 //get all the videos
	 
	 public function getAllTheVideos($offset,$photos_per_page){
		 try{
		    $conn = DBConnection::GetConnection();	
			$myquery= "SELECT video_id,video_name,video_image,url,release_id from video LIMIT $offset,$photos_per_page";
			$result= $conn->query($myquery);
			$videos=array();
			foreach($result as $video){
				$v1=new Video();
				$v1->setVideoId($video["video_id"]);
				$v1->setVideoName($video["video_name"]);
				$v1->setVideoImage($video["video_image"]);
				$v1->setUrl($video["url"]);
				$v1->setReleaseId($video["release_id"]);
				array_push($videos,$v1);				
			}
			$conn =null;//To close the connection 
			return $videos;
		 }catch(PDOException $e){
			 echo 'Fail to connect';
			 echo $e->getMessage();
		 }
     }
	 
	 //get total number of videos 
	  
	  public function getTotalNumberOfVideos(){
		  try{
			 $conn=DBConnection::GetConnection();
			 $queryForGetTotal="SELECT COUNT(video_id) AS total_value FROM video";
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
	  
	  //get videos according to video id
	  public function GetVideosAccordingToVideoId($videoId){	
	  
		try{
			$conn = DBConnection::GetConnection();	
			$myquery= "SELECT video_id,video_name,video_image,url,release_id from video where video_id='".$videoId."'";
			$result= $conn->query($myquery);
			$v1=new Video();
			foreach($result as $video){				
				$v1->setVideoId($video["video_id"]);
				$v1->setVideoName($video["video_name"]);
				$v1->setVideoImage($video["video_image"]);
				$v1->setUrl($video["url"]);
				$v1->setReleaseId($video["release_id"]);								
			}
			$conn =null;//To close the connection 
			return $v1;
		}catch(PDOException $e){
			echo 'Fail to connect';
			echo $e->getMessage();
		}	
		  
     }
	 
	 //get max id from the databse
	 public function getMaxID(){
		 try{
			$conn = DBConnection::GetConnection();	
			$queryForGetMaxId="SELECT MAX(video_id) AS max_value FROM video";
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
	 
	 //delete specific video
	  public function deleteVideo($videoID){
		  try{
			  $conn=DBConnection::GetConnection();
			  $myQuery="DELETE FROM video where video_id='".$videoID."'";
			  $cmd=$conn->query($myQuery);
			  
			  return $cmd;
		  }catch(PDOException $p){
			  echo 'Fail to connect';
			  echo $p->getMessage();
		  }
	  }
	  
	  //add new video
	  public function addNewVideo(){
		 try{
			  $conn=DBConnection::getConnection();			  
			  			  
			  $insertQuery="INSERT INTO video(video_name,video_image,url,release_id) VALUES (:video_name,:video_image,:url,:release_id)";
			  $cmd=$conn->prepare($insertQuery);
			  
			  $cmd->bindValue(':video_name',$this->getVideoName(),PDO::PARAM_STR);
			  $cmd->bindValue(':video_image',$this->getVideoImage(),PDO::PARAM_STR);
			  $cmd->bindValue(':url',$this->getUrl(),PDO::PARAM_STR);
			  $cmd->bindValue(':release_id',$this->getReleaseId(),PDO::PARAM_INT);			  			  
			  
			  $returnedValue=$cmd->execute(); //Returns TRUE on success or FALSE on failure
			  return $returnedValue;
		  }catch(PDOException $p){
			  echo 'Fail to connect';
			  echo $p->getMessage();
		  }
     }
	 
	 //this method is for updating video details
	  public function updateVideoDetails($videoID){
		  try{
			  $conn=DBConnection::getConnection();
			  $updateQuery="UPDATE video SET video_name=:video_name,video_image=:video_image,url=:url,release_id=:release_id WHERE video_id='".$videoID."'";
			  $cmd=$conn->prepare($updateQuery);
			  $cmd->bindValue(':video_name',$this->getVideoName(),PDO::PARAM_STR);
			  $cmd->bindValue(':video_image',$this->getVideoImage(),PDO::PARAM_STR);
			  $cmd->bindValue(':url',$this->getUrl(),PDO::PARAM_STR);
			  $cmd->bindValue(':release_id',$this->getReleaseId(),PDO::PARAM_INT);	
			  return $cmd->execute();
		  }catch(PDOException $p){
			  echo 'Fail to connect';
			  echo $p->getMessage();
		  }
	  } 
	  
	  //get all the video details
	  public function GetVideos(){	
	  
		try{
			$conn = DBConnection::GetConnection();	
			$myquery= "SELECT video_id,video_name,video_image,url,release_id FROM video";
			$result= $conn->query($myquery);
			$videos=array();
			foreach($result as $video){
				$v1=new Video();
				$v1->setVideoId($video["video_id"]);
				$v1->setVideoName($video["video_name"]);
				$v1->setVideoImage($video["video_image"]);
				$v1->setUrl($video["url"]);
				$v1->setReleaseId($video["release_id"]);		
				array_push($videos,$v1);								
			}
			$conn =null;//To close the connection 
			return $videos;
		}catch(PDOException $e){
			echo 'Fail to connect';
			echo $e->getMessage();
		}	
		  
     }   
	 
	}
?>