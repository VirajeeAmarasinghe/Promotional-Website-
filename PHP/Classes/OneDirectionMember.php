<?php
  require_once('config/DBConnection.php');
  class OneDirectionMember{
	  private $member_id;
	  private $name;
	  private $description;
	  private $url_twitter;
	  private $url_instagram;
	  private $image;
	  private $oneImage;
	  
	  public function __construct(){		  
		  $this->member_id="";
		  $this->name="";
		  $this->description="";
		  $this->url_twitter="";
		  $this->url_instagram="";
		  $this->image=array();		  
	  }
	  
	  //set methods
	  public function setMemberId($id){
		  $this->member_id=$id;
	  }
	  public function setName($name){
		  $this->name=$name;
	  }
	  public function setDescription($des){
		  $this->description=$des;
	  }
	  public function setUrlTwitter($twit){
		  $this->url_twitter=$twit;
	  }
	  public function setUrlInstagram($inst){
		  $this->url_instagram=$inst;
	  }
	  public function setImage($image){
		  array_push($this->image,$image);
	  }
	  public function setOneImage($image){
		  $this->oneImage=$image;
	  }
	  
	  //get methods
	  public function getMemberId(){
		  return $this->member_id;
	  }
	  public function getName(){
		  return $this->name;
	  }
	  public function getDescription(){
		  return $this->description;
	  }
	  public function getUrlTwitter(){
		  return $this->url_twitter;
	  }
	  public function getUrlInstagram(){
		  return $this->url_instagram;
	  }
	  public function getImage($index){
		  return $this->image[$index];
	  }
	  public function getOneImage(){
		  return $this->oneImage;
	  }
	  
	  //get all the one direction member details
	  public function getAllOneDirectionMemberDetails(){		  
		  try{
			  $conn=DBConnection::GetConnection();
			  $myQuery="SELECT member_id,name,description,url_twitter,url_instagram from one_direction_member";
			  $result=$conn->query($myQuery);
			  $members=array();
			  foreach($result as $member){				  
				  $o=new OneDirectionMember();
				  $o->setMemberId($member["member_id"]);
				  $o->setName($member["name"]);
				  $o->setDescription($member["description"]);
				  $o->setUrlTwitter($member["url_twitter"]);
				  $o->setUrlInstagram($member["url_instagram"]);				  
				  
				  //getting all the member images
				  $myQuery2="SELECT member_id,image from one_direction_member_image where member_id='".$member["member_id"]."'";
				  $result2=$conn->query($myQuery2);
				  foreach($result2 as $memberImage){
					  $o->setImage($memberImage["image"]);
				  }
				  array_push($members,$o);
			  }
			  $conn=null;
			  return $members;
		  }catch(PDOException $p){
			  echo 'Fail to connect';
			  echo $p->getMessage();
		  }
	  }	 
	  
	  //get one direction member details according to member id
	  public function getOneDirectionMemberDetails($memberID){		  
		  try{
			  $conn=DBConnection::GetConnection();
			  $myQuery="SELECT member_id,name,description,url_twitter,url_instagram from one_direction_member where member_id='".$memberID."'";
			  $result=$conn->query($myQuery);
			  $o=new OneDirectionMember();
			  foreach($result as $member){		  
				  
				  $o->setMemberId($member["member_id"]);
				  $o->setName($member["name"]);
				  $o->setDescription($member["description"]);
				  $o->setUrlTwitter($member["url_twitter"]);
				  $o->setUrlInstagram($member["url_instagram"]);				  
				  
			  }
			  $conn=null;
			  return $o;
		  }catch(PDOException $p){
			  echo 'Fail to connect';
			  echo $p->getMessage();
		  }
	  }	
	  
	  //get member photos according to member id
	  public function getphotosAccordingToId($memberID){		  
		  try{
			  $conn=DBConnection::GetConnection();
			  $myQuery="SELECT image from one_direction_member_image where member_id='".$memberID."'";
			  $result=$conn->query($myQuery);
			  $photoArray=array();
			  foreach($result as $member){		  
				  $o=new OneDirectionMember();
				  array_push($photoArray,$member["image"]);			  				  
				  
			  }
			  $conn=null;
			  return $photoArray;
		  }catch(PDOException $p){
			  echo 'Fail to connect';
			  echo $p->getMessage();
		  }
	  }	   
	     
	  //get max id from the databse
	 public function getMaxID(){
		 try{
			$conn = DBConnection::GetConnection();	
			$queryForGetMaxId="SELECT MAX(member_id) AS max_value FROM one_direction_member";
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
	 
	 //delete specific member
	  public function deleteMember($memberID){
		  try{
			  $conn=DBConnection::GetConnection();
			  $myQuery="DELETE FROM one_direction_member where member_id='".$memberID."'";
			  $cmd=$conn->query($myQuery);
			  
			  return $cmd;
		  }catch(PDOException $p){
			  echo 'Fail to connect';
			  echo $p->getMessage();
		  }
	  }
	  
	  
	  //insert new member to the database
	 public function addNewMember(){
		 try{
			  $conn=DBConnection::getConnection();			  
			  			  
			  $insertQuery="INSERT INTO one_direction_member(name,description,url_twitter,url_instagram) VALUES (:name,:description,:url_twitter,:url_instagram)";
			  $cmd=$conn->prepare($insertQuery);
			  
			  $cmd->bindValue(':name',$this->getName(),PDO::PARAM_STR);
			  $cmd->bindValue(':description',$this->getDescription(),PDO::PARAM_STR);
			  $cmd->bindValue(':url_twitter',$this->getUrlTwitter(),PDO::PARAM_STR);
			  $cmd->bindValue(':url_instagram',$this->getUrlInstagram(),PDO::PARAM_STR);
			  			  
			  $returnedValue=$cmd->execute(); //Returns TRUE on success or FALSE on failure
			  return $returnedValue;
		  }catch(PDOException $p){
			  echo 'Fail to connect';
			  echo $p->getMessage();
		  }
     } 
	 
	 //insert new member images to the database
	 public function addNewMemberPhotos(){
		 try{
			  $conn=DBConnection::getConnection();			  
			  			  
			  $insertQuery="INSERT INTO one_direction_member_image(member_id,image) VALUES (:member_id,:image)";
			  $cmd=$conn->prepare($insertQuery);
			  
			  $cmd->bindValue(':member_id',$this->getMemberId(),PDO::PARAM_INT);
			  $cmd->bindValue(':image',$this->getOneImage(),PDO::PARAM_STR);			 
			  			  
			  $returnedValue=$cmd->execute(); //Returns TRUE on success or FALSE on failure
			  return $returnedValue;
		  }catch(PDOException $p){
			  echo 'Fail to connect';
			  echo $p->getMessage();
		  }
     }
	 
	 //this method is for updating member details
	  public function updateMemberDetails($memberID){
		  try{
			  $conn=DBConnection::getConnection();
			  $updateQuery="UPDATE one_direction_member SET name=:name,description=:description,url_twitter=:url_twitter,url_instagram=:url_instagram WHERE member_id='".$memberID."'";
			  $cmd=$conn->prepare($updateQuery);
			  
			  $cmd->bindValue(':name',$this->getName(),PDO::PARAM_STR);
			  $cmd->bindValue(':description',$this->getDescription(),PDO::PARAM_STR);
			  $cmd->bindValue(':url_twitter',$this->getUrlTwitter(),PDO::PARAM_STR);
			  $cmd->bindValue(':url_instagram',$this->getUrlInstagram(),PDO::PARAM_STR);
			  
			  return $cmd->execute();
		  }catch(PDOException $p){
			  echo 'Fail to connect';
			  echo $p->getMessage();
		  }
	  }
	  
	  //delete member photos
	  public function deleteMemberPhotos($memberID){
		  try{
			  $conn=DBConnection::GetConnection();
			  $myQuery="DELETE FROM one_direction_member_image where member_id='".$memberID."'";
			  $cmd=$conn->query($myQuery);
			  
			  return $cmd;
		  }catch(PDOException $p){
			  echo 'Fail to connect';
			  echo $p->getMessage();
		  }
	  }  
  }
?>