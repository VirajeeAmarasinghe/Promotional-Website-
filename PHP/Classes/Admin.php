<?php
require_once('config/DBConnection.php');

  class Admin{
	  private $userName;
	  private $pass;
	  
	  //set methods
	  public function setUserName($user){
		  $this->userName=$user;
	  }
	  public function setPass($pass){
		  $this->pass=$pass;
	  }
	  
	  //get methods
	  public function getUserName(){
		  return $this->userName;
	  }
	  public function getPassword(){
		  return $this->pass;
	  }
	  
	  //get password according to username
	  
	  public function getPasswordAccordingToUsername($userName){
		  try{
			  $conn=DBConnection::GetConnection();
			  $myQuery="SELECT password FROM admin_login WHERE user_name='".$userName."'";
			  $result=$conn->query($myQuery);
			  $pass="";
			  foreach($result as $member){
				  $pass=$member["password"];
			  }
			  $conn=null;
			  return $pass;
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
			 $myQuery="SELECT * from admin_login where user_name='".$userName."'"; 
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
	  
	  //this method is for inserting new admin details to the database
	  public function addNewAdmin(){
		  try{
			  $conn=DBConnection::getConnection();			  
			  			  
			  $insertQuery="INSERT INTO admin_login(user_name,password)VALUES(:userName,password(:pass))";
			  $cmd=$conn->prepare($insertQuery);
			  
			  $cmd->bindValue(':userName',$this->getUserName(),PDO::PARAM_STR);
			  $cmd->bindValue(':pass',$this->getPassword(),PDO::PARAM_STR);			  
			  
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
			  
			  $updateQuery="UPDATE admin_login set password=password(:password) where user_name=:uname";
			  
			  //set the values for parameters
			  $cmd = $conn->prepare($updateQuery);			  
			  $cmd->bindValue(':password',$this->getPassword(),PDO::PARAM_STR);
			  $cmd->bindValue(':uname',$this->getUserName(),PDO::PARAM_STR);
			  
			  
			  //run the statment
			  return $cmd->execute();
		  }catch(PDOException $p){
			  echo 'Fail to connect';
			  echo $p->getMessage();
		  }
      }
  }
?>