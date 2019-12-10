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
	 
	 public function getAllTheVideos(){
		 try{
		    $conn = DBConnection::GetConnection();	
			$myquery= "SELECT video_id,video_name,video_image,url,release_id from video";
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