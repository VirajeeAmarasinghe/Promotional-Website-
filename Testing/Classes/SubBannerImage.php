<?php

  require_once('config/DBConnection.php');

  class SubBannerImage{
	  private $subBannerImageID;
	  private $subBannerImageName;
	  private $subBannerImageTitle;
	  private $fbShareUrl;
	  private $twitShareUrl;
	  private $googleShareUrl;
	  private $releaseId;
	  
	  //set methods
	  
	  public function setSubBannerImageId($id){
		  $this->subBannerImageID=$id;
	  }	
	  public function setSubBannerImageName($name){
		  $this->subBannerImageName=$name;
	  }
	  public function setSubBannerImageTitle($title){
		  $this->subBannerImageTitle=$title;
	  }
	  public function setFbShareUrl($fb){
		  $this->fbShareUrl=$fb;
	  }
	  public function setTwitShareUrl($twit){
		  $this->twitShareUrl=$twit;
	  } 
	  public function setGoogleShareUrl($google){
		  $this->googleShareUrl=$google;
	  }
	  public function setReleaseId($relId){
		  $this->releaseId=$relId;
	  } 
	  
	  //get methods
	  
	  public function getSubBannerImageId(){
		  return $this->subBannerImageID;
	  }	
	  public function getSubBannerImageName(){
		  return $this->subBannerImageName;
	  }
	  public function getSubBannerImageTitle(){
		  return $this->subBannerImageTitle;
	  }
	  public function getFbShareUrl(){
		  return $this->fbShareUrl;
	  }
	  public function getTwitShareUrl(){
		  return $this->twitShareUrl;
	  } 
	  public function getGoogleShareUrl(){
		  return $this->googleShareUrl;
	  }
	  public function getReleaseId(){
		  return $this->releaseId;
	  } 
	  
	  //get sub banner image according to specific release id (only one banner image is retrieved through this)
	  
	  public function getSubBannerImage($releaseId){
	
		  try{
			  $conn = DBConnection::GetConnection();
			  $myquery= "SELECT sub_banner_image_id,sub_banner_image_name,sub_banner_image_title,fb_share_url,twit_share_url,google_share_url,release_id FROM sub_banner_image where release_id='".$releaseId."' ";
			  $result= $conn->query($myquery);
			  
			  $subBannerImageArray=array();
			  
			  foreach($result as $item){
				    $s1= new SubBannerImage();							  
					$s1->setSubBannerImageId($item["sub_banner_image_id"]);		
				    $s1->setSubBannerImageName($item["sub_banner_image_name"]);
					$s1->setSubBannerImageTitle($item["sub_banner_image_title"]);
					$s1->setFbShareUrl($item["fb_share_url"]);
					$s1->setTwitShareUrl($item["twit_share_url"]);
					$s1->setGoogleShareUrl($item["google_share_url"]);
					$s1->setReleaseId($item["release_id"]);
					array_push($subBannerImageArray,$s1);
					break;
			  }
			  $conn =null;//To close the connection 
			  return $subBannerImageArray;
		  }catch(PDOException $e){
			  echo 'Fail to connect';
			  echo $e->getMessage();
	      }	
		
	}	
	
	  
  }
?>