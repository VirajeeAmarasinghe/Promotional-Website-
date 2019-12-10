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
	   
   }
?>