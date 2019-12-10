<?php
  require_once('config/DBConnection.php');
  
  class Member{
	  private $user_name;
	  private $password;
	  private $email;
	  private $name;
	  private $image;
	  private $country;
	  private $dob;
	  private $gender;
	  private $address;
	  private $profession;
	  private $short_bio;
	  
	  public function __construct(){
		  $this->user_name="";
		  $this->password="";
		  $this->email="";
		  $this->name="";
		  $this->image="";
		  $this->country="";
		  $this->dob="0000-00-00";
		  $this->gender="";
		  $this->address="";
		  $this->profession="";
		  $this->short_bio="";
	  }
	  
	  //set methods
	  
	  public function setUserName($userName){
		  $this->user_name=$userName;
	  }
	  public function setPassword($pass){
		  $this->password=$pass;
	  }
	  public function setEmail($email){
		  $this->email=$email;
	  }
	  public function setName($name){
		  $this->name=$name;
	  }
	  public function setImage($image){
		  $this->image=$image;
	  }
	  public function setCountry($country){
		  $this->country=$country;
	  }
	  public function setDOB($dob){
		  $this->dob=$dob;
	  }
	  public function setGender($gender){
		  $this->gender=$gender;
	  }
	  public function setAddress($address){
		  $this->address=$address;
	  }
	  public function setProfession($profession){
		  $this->profession=$profession;
	  }
	  public function setShortBio($bio){
		  $this->short_bio=$bio;
	  }
	  
	  //get methods
	  
	  public function getUserName(){
		  return $this->user_name;
	  }
	  public function getPassword(){
		  return $this->password;
	  }
	  public function getEmail(){
		  return $this->email;
	  }
	  public function getName(){
		  return $this->name;
	  }
	  public function getImage(){
		  return $this->image;
	  }
	  public function getCountry(){
		  return $this->country;
	  }
	  public function getDOB(){
		  return $this->dob;
	  }
	  public function getGender(){
		  return $this->gender;
	  }
	  public function getAddress(){
		  return $this->address;
	  }
	  public function getProfession(){
		  return $this->profession;
	  }
	  public function getShortBio(){
		  return $this->short_bio;
	  }
	  
	  //get name and profile pic according to username
	  
	  public function getNameAndProfilePicAccordingToUsername($userName){
		  try{
			  $conn=DBConnection::GetConnection();
			  $myQuery="SELECT name,profile_pic FROM member WHERE user_name='".$userName."'";
			  $result=$conn->query($myQuery);
			  $m=new Member();
			  foreach($result as $member){
				  $m->setName($member["name"]);
				  $m->setImage($member["profile_pic"]);
			  }
			  $conn=null;
			  return $m;
		  }catch(PDOException $p){
			  echo 'Fail to connect';
			  echo $p->getMessage();
		  }
	  }
	  
	  //get member details according to username
	  
	  public function getMemberDetailsAccordingToUsername($userName){
		  try{
			  $conn=DBConnection::GetConnection();
			  $myQuery="SELECT user_name,password,email,name,profile_pic FROM member WHERE user_name='".$userName."'";
			  $result=$conn->query($myQuery);
			  $m=new Member();
			  foreach($result as $member){
				  $m->setUserName($member["user_name"]);
				  $m->setPassword($member["password"]);
				  $m->setEmail($member["email"]);
				  $m->setName($member["name"]);
				  $m->setImage($member["profile_pic"]);
			  }
			  $conn=null;
			  return $m;
		  }catch(PDOException $p){
			  echo 'Fail to connect';
			  echo $p->getMessage();
		  }
	  }
	  
	  //check there is already a member account in same user name
	  public function checkUserAccount($userName){
		  $thereIsAlreadyAccount=false;
		  try{
			 $conn=DBConnection::GetConnection();
			 $myQuery="SELECT * from member where user_name='".$userName."'"; 
			 $result=$conn->query($myQuery);
			 foreach($result as $row){
				$thereIsAlreadyAccount=true; 
		     }
		  }catch(PDOException $p){
			  echo 'Fail to connect';
			  echo $p->getMessage();
		  }
		  return $thereIsAlreadyAccount;
	  }
	  
	  //check there is already a member account in same email
	  public function checkUserAccountOnEmail($email){
		  $thereIsAlreadyAccount=false;
		  try{
			 $conn=DBConnection::GetConnection();
			 $myQuery="SELECT * from member where email='".$email."'"; 
			 $result=$conn->query($myQuery);
			 foreach($result as $row){
				$thereIsAlreadyAccount=true; 
		     }
		  }catch(PDOException $p){
			  echo 'Fail to connect';
			  echo $p->getMessage();
		  }
		  return $thereIsAlreadyAccount;
	  }
	  
	  //get email address according to the user name
	  public function getEmailAddressAccordingToUsername($username){
		  $email="";		  
		  try{
			 $conn=DBConnection::GetConnection();
			 $myQuery="SELECT email from member where user_name='".$username."'"; 
			 $result=$conn->query($myQuery);
			 foreach($result as $row){
				$email=$row["email"]; 
		     }
		  }catch(PDOException $p){
			  echo 'Fail to connect';
			  echo $p->getMessage();
		  }
		  return $email;
	  }
	  
	  //this method is for inserting new member details to the database
	  public function addNewMember(){
		  try{
			  $conn=DBConnection::getConnection();			  
			  			  
			  $insertQuery="INSERT INTO member(user_name,password,email,name,profile_pic)VALUES(:userName,password(:pass),:email,:name,:profile)";
			  $cmd=$conn->prepare($insertQuery);
			  
			  $cmd->bindValue(':userName',$this->getUserName(),PDO::PARAM_STR);
			  $cmd->bindValue(':pass',$this->getPassword(),PDO::PARAM_STR);
			  $cmd->bindValue(':email',$this->getEmail(),PDO::PARAM_STR);
			  $cmd->bindValue(':name',$this->getName(),PDO::PARAM_STR);
			  $cmd->bindValue(':profile',$this->getImage(),PDO::PARAM_STR);
			  
			  $returnedValue=$cmd->execute(); //Returns TRUE on success or FALSE on failure
			  return $returnedValue;
		  }catch(PDOException $p){
			  echo 'Fail to connect';
			  echo $p->getMessage();
		  }
	  }
	  
	  //this method is for updating password
	  public function changePassword(){
		  try{
			  $conn=DBConnection::getConnection();
			  
			  $updateQuery="UPDATE member set password=password(:password) where user_name=:uname and email=:email";
			  
			  //set the values for parameters
			  $cmd = $conn->prepare($updateQuery);			  
			  $cmd->bindValue(':password',$this->getPassword(),PDO::PARAM_STR);
			  $cmd->bindValue(':uname',$this->getUserName(),PDO::PARAM_STR);
			  $cmd->bindValue(':email',$this->getEmail(),PDO::PARAM_STR);
			  
			  //run the statment
			  return $cmd->execute();
		  }catch(PDOException $p){
			  echo 'Fail to connect';
			  echo $p->getMessage();
		  }
      }
	  
	  //this method is for updating general member details
	  public function changeMemberGeneralDetails(){
		  try{
			  $conn=DBConnection::getConnection();
			  
			  $updateQuery="UPDATE member set name=:name,profile_pic=:pic where user_name=:uname and email=:email";
			  
			  //set the values for parameters
			  $cmd = $conn->prepare($updateQuery);	
			  		  
			  $cmd->bindValue(':name',$this->getName(),PDO::PARAM_STR);
			  $cmd->bindValue(':pic',$this->getImage(),PDO::PARAM_STR);
			  $cmd->bindValue(':uname',$this->getUserName(),PDO::PARAM_STR);
			  $cmd->bindValue(':email',$this->getEmail(),PDO::PARAM_STR);
			  
			  //run the statment
			  return $cmd->execute();
		  }catch(PDOException $p){
			  echo 'Fail to connect';
			  echo $p->getMessage();
		  }
      }
	  
	  //this method is for updating personal details
	  public function updatePersonalDetails($username){
		  try{
			  $conn=DBConnection::getConnection();
			  $updateQuery="UPDATE member set country=:country,dob=:dob,gender=:gender,address=:add,profession=:prof,short_bio=:bio where user_name='".$username."'";
			  $cmd=$conn->prepare($updateQuery);
			  $cmd->bindValue(':country',$this->getCountry(),PDO::PARAM_STR);
			  $cmd->bindValue(':dob',$this->getDOB(),PDO::PARAM_STR);
			  $cmd->bindValue(':gender',$this->getGender(),PDO::PARAM_STR);
			  $cmd->bindValue(':add',$this->getAddress(),PDO::PARAM_STR);
			  $cmd->bindValue(':prof',$this->getProfession(),PDO::PARAM_STR);
			  $cmd->bindValue(':bio',$this->getShortBio(),PDO::PARAM_STR);
			  return $cmd->execute();
		  }catch(PDOException $p){
			  echo 'Fail to connect';
			  echo $p->getMessage();
		  }
	  }
	  
	  //get member personal details according to username
	  
	  public function getMemberPersonalDetailsAccordingToUsername($userName){
		  try{
			  $conn=DBConnection::GetConnection();
			  $myQuery="SELECT country,dob,gender,address,profession,short_bio FROM member WHERE user_name='".$userName."'";
			  $result=$conn->query($myQuery);
			  $m=new Member();
			  foreach($result as $member){
				  $m->setCountry($member["country"]);
				  $m->setDOB($member["dob"]);
				  $m->setGender($member["gender"]);
				  $m->setAddress($member["address"]);
				  $m->setProfession($member["profession"]);
				  $m->setShortBio($member["short_bio"]);
			  }
			  $conn=null;
			  return $m;
		  }catch(PDOException $p){
			  echo 'Fail to connect';
			  echo $p->getMessage();
		  }
	  }
	  
	  //get all the members details
	  public function getAllMembers(){
		  try{
			  $conn=DBConnection::GetConnection();
			  $myQuery="SELECT profile_pic,user_name,password,email,name,country,dob,gender,address FROM member";
			  $result=$conn->query($myQuery);
			  $mArray=array();
			  foreach($result as $member){
				  $m=new Member();
				  $m->setCountry($member["country"]);
				  $m->setDOB($member["dob"]);
				  $m->setGender($member["gender"]);
				  $m->setAddress($member["address"]);				  
				  $m->setName($member["name"]);
				  $m->setEmail($member["email"]);
				  $m->setPassword($member["password"]);
				  $m->setUserName($member["user_name"]);
				  $m->setImage($member["profile_pic"]);
				  array_push($mArray,$m);
			  }
			  $conn=null;
			  return $mArray;
		  }catch(PDOException $p){
			  echo 'Fail to connect';
			  echo $p->getMessage();
		  }
	  }
	  
	  //delete specific member
	  public function deleteMember($username){
		  try{
			  $conn=DBConnection::GetConnection();
			  $myQuery="DELETE FROM member where user_name='".$username."'";
			  $cmd=$conn->query($myQuery);
			  
			  return $cmd;
		  }catch(PDOException $p){
			  echo 'Fail to connect';
			  echo $p->getMessage();
		  }
	  }
  }
?>