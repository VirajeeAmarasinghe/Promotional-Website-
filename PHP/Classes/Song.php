<?php
   require_once('config/DBConnection.php');
   
   class Song{
	   
	   private $songId;
	   private $songName;	   
	   private $itune_url;
	   private $googlePlay_url;
	   private $spotify_url;
	   private $lyric;
	   private $releaseId;
	   
	   //set methods
	   
	   public function setSongId($songId){
		   $this->songId=$songId;
	   }
	   public function setSongName($songName){
		   $this->songName=$songName;
	   }	   
	   public function setItuneUrl($url){
		   $this->itune_url=$url;
	   }
	   public function setGooglePlayUrl($url){
		   $this->googlePlay_url=$url;
	   }
	   public function setSpotifyUrl($url){
		   $this->spotify_url=$url;
	   }
	   public function setLyric($lyric){
		   $this->lyric=$lyric;
	   }
	   public function setReleaseId($releaseId){
		   $this->releaseId=$releaseId;
	   }
	   
	   //get methods
	   
	   public function getSongId(){
		   return $this->songId;
	   }
	   public function getSongName(){
		   return $this->songName;
	   }	   
	   public function getITuneUrl(){
		   return $this->itune_url;
	   }
	   public function getGooglePlayUrl(){
		   return $this->googlePlay_url;
	   }
	   public function getSpotifyUrl(){
		   return $this->spotify_url;
	   }
	   public function getLyric(){
		   return $this->lyric;
	   }
	   public function getReleaseId(){
		   return $this->releaseId;
	   }
	   
	   //get song according to given release id
	   
	   public function getSongsAccordingToReleaseId($releaseId){
		   try{
			  $conn=DBConnection::GetConnection();
			  $myQuery="SELECT song_id,song_name,itune_url,googlePlay_url,spotify_url,lyric,release_id from release_song where release_id='".$releaseId."'"; 
			  $result=$conn->query($myQuery);
			  $songs=array();
			  foreach($result as $song){
				  $s1=new Song();
				  $s1->setSongId($song["song_id"]);
				  $s1->setSongName($song["song_name"]);
				  $s1->setItuneUrl($song["itune_url"]);
				  $s1->setGooglePlayUrl($song["googlePlay_url"]);
				  $s1->setSpotifyUrl($song["spotify_url"]);
				  $s1->setLyric($song["lyric"]);
				  $s1->setReleaseId($song["release_id"]);  
				 
				  array_push($songs,$s1);
			  }
			  $conn=null;
			  return $songs;
		   }catch(PDOException $e){
			   echo 'Fail To Connect';
			   echo $e->getMessage();
		   }
	   }
	   
	   //get song lyric
	   public function getSongLyric($songId){
		   try{
			  $conn=DBConnection::GetConnection();
			  $myQuery="SELECT lyric from release_song where song_id='".$songId."'"; 
			  $result=$conn->query($myQuery);
			 
			  $lyric="";
			  foreach($result as $songLyric){
				  $lyric=$songLyric["lyric"];
			  }
			  $conn=null;
			  return $lyric;
		   }catch(PDOException $e){
			   echo 'Fail To Connect';
			   echo $e->getMessage();
		   }
	   } 
	   
	   //get song name
	   public function getSongNameAccordingToId($songId){
		   try{
			  $conn=DBConnection::GetConnection();
			  $myQuery="SELECT song_name from release_song where song_id='".$songId."'"; 
			  $result=$conn->query($myQuery);
			 
			  $name="";
			  foreach($result as $songLyric){
				  $name=$songLyric["song_name"];
			  }
			  $conn=null;
			  return $name;
		   }catch(PDOException $e){
			   echo 'Fail To Connect';
			   echo $e->getMessage();
		   }
	   } 
	   
	   //get max id from the databse
	 public function getMaxID(){
		 try{
			$conn = DBConnection::GetConnection();	
			$queryForGetMaxId="SELECT MAX(song_id) AS max_value FROM release_song";
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
	 
	 //get song according to song id
	 
	 public function getSongAccordingToSongID($song_id){
		 try{
			 $conn=DBConnection::GetConnection();
			 $myQuery="SELECT song_id,song_name,itune_url,googlePlay_url,spotify_url,lyric,release_id from release_song where song_id='".$song_id."'";
			 $result=$conn->query($myQuery);
			 $s=new Song();
			 foreach($result as $song){
				 $s->setSongId($song["song_id"]);
				 $s->setSongName($song["song_name"]);
				 $s->setItuneUrl($song["itune_url"]);
				 $s->setGooglePlayUrl($song["googlePlay_url"]);
				 $s->setSpotifyUrl($song["spotify_url"]);
				 $s->setLyric($song["lyric"]);
				 $s->setReleaseId($song["release_id"]);
			 }
			 $conn=null;
			 return $s; 
		}catch(PDOException $e){
			echo 'Fail to connect';
			echo $e->getMessage();
		}
     }
	 
	 //delete specific song
	  public function deleteSong($songID){
		  try{
			  $conn=DBConnection::GetConnection();
			  $myQuery="DELETE FROM release_song where song_id='".$songID."'";
			  $cmd=$conn->query($myQuery);
			  
			  return $cmd;
		  }catch(PDOException $p){
			  echo 'Fail to connect';
			  echo $p->getMessage();
		  }
	  } 
	  
	  //add new song
	  public function addNewSong(){
		 try{
			  $conn=DBConnection::getConnection();			  
			  			  
			  $insertQuery="INSERT INTO release_song(song_name,itune_url,googlePlay_url,spotify_url, lyric, release_id) VALUES (:song_name,:itune_url,:googlePlay_url,:spotify_url,:lyric,:release_id)";
			  $cmd=$conn->prepare($insertQuery);
			  
			  $cmd->bindValue(':song_name',$this->getSongName(),PDO::PARAM_STR);
			  $cmd->bindValue(':itune_url',$this->getITuneUrl(),PDO::PARAM_STR);
			  $cmd->bindValue(':googlePlay_url',$this->getGooglePlayUrl(),PDO::PARAM_STR);
			  $cmd->bindValue(':spotify_url',$this->getSpotifyUrl(),PDO::PARAM_STR);
			  $cmd->bindValue(':lyric',$this->getLyric(),PDO::PARAM_STR);
			  $cmd->bindValue(':release_id',$this->getReleaseId(),PDO::PARAM_INT);			  
			  
			  $returnedValue=$cmd->execute(); //Returns TRUE on success or FALSE on failure
			  return $returnedValue;
		  }catch(PDOException $p){
			  echo 'Fail to connect';
			  echo $p->getMessage();
		  }
     } 
	 
	 //this method is for updating song details
	  public function updateSongDetails($songID){
		  try{
			  $conn=DBConnection::getConnection();
			  $updateQuery="UPDATE release_song SET song_name=:song_name,itune_url=:itune_url,googlePlay_url=:googlePlay_url,spotify_url=:spotify_url,lyric=:lyric,release_id=:release_id WHERE song_id='".$songID."'";
			  $cmd=$conn->prepare($updateQuery);
			  $cmd->bindValue(':song_name',$this->getSongName(),PDO::PARAM_STR);
			  $cmd->bindValue(':itune_url',$this->getITuneUrl(),PDO::PARAM_STR);
			  $cmd->bindValue(':googlePlay_url',$this->getGooglePlayUrl(),PDO::PARAM_STR);
			  $cmd->bindValue(':spotify_url',$this->getSpotifyUrl(),PDO::PARAM_STR);
			  $cmd->bindValue(':lyric',$this->getLyric(),PDO::PARAM_STR);
			  $cmd->bindValue(':release_id',$this->getReleaseId(),PDO::PARAM_INT);
			  return $cmd->execute();
		  }catch(PDOException $p){
			  echo 'Fail to connect';
			  echo $p->getMessage();
		  }
	  }
	  
	  //get all the song details
	  public function GetSongs(){	
	  
		try{
			$conn = DBConnection::GetConnection();	
			$myquery= "SELECT song_id,song_name,itune_url,googlePlay_url,spotify_url,lyric,release_id FROM release_song";
			$result= $conn->query($myquery);
			$songs=array();
			foreach($result as $release){
				$s=new Song;
				$s->setSongId($release["song_id"]);
				$s->setSongName($release["song_name"]);
				$s->setItuneUrl($release["itune_url"]);
				$s->setGooglePlayUrl($release["googlePlay_url"]);
				$s->setSpotifyUrl($release["spotify_url"]);	
				$s->setReleaseId($release["release_id"]);			
				array_push($songs,$s);								
			}
			$conn =null;//To close the connection 
			return $songs;
		}catch(PDOException $e){
			echo 'Fail to connect';
			echo $e->getMessage();
		}	
		  
     }
   }
?>