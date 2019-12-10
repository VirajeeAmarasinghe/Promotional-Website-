<?php
  require_once('config/DBConnection.php');
  
  class Comment{
	  private $comment_id;
	  private $comment_description;
	  private $news_id;
	  private $user_name;
	  private $comment_date;
	  
	  //set methods
	  
	  public function setCommentId($commentId){
		  $this->comment_id=$commentId;
	  }
	  public function setCommentDescription($commentDes){
		  $this->comment_description=$commentDes;
	  }
	  public function setNewsId($newsId){
		  $this->news_id=$newsId;
	  }
	  public function setUserName($userName){
		  $this->user_name=$userName;
	  }
	  public function setCommentDate($commentDate){
		  $this->comment_date=$commentDate;
	  }
	  
	  //get methods
	  
	  public function getCommentId(){
		  return $this->comment_id;
	  }
	  public function getCommentDescription(){
		  return $this->comment_description;
	  }
	  public function getNewsId(){
		  return $this->news_id;
	  }
	  public function getUserName(){
		  return $this->user_name;
	  }
	  public function getCommentDate(){
		  return $this->comment_date;
	  }
	  
	  //get top 5 comments according to the news id
	  
	  public function getTopFiveCommentsAccordingToNewsId($newsId,$offset,$comments_per_page){
		  try{
			$conn = DBConnection::GetConnection();	
			$myquery= "SELECT comment_id,comment_description,comment_date,news_id,user_name from comment where news_id=".$newsId." LIMIT $offset,$comments_per_page";
			$result= $conn->query($myquery);
			$comments=array();
			foreach($result as $comment){
				$c1=new Comment();
				$c1->setCommentId($comment["comment_id"]);
				$c1->setCommentDescription($comment["comment_description"]);
				$c1->setCommentDate($comment["comment_date"]);
				$c1->setNewsId($comment["news_id"]);
				$c1->setUserName($comment["user_name"]);
				array_push($comments,$c1);				
			}
			$conn =null;
			return $comments;
		}catch(PDOException $e){
			echo 'Fail to connect';
			echo $e->getMessage();
		}	
	  }
	  
	  //get total number of comments for each news
	  
	  public function getTotalNumberOfCommentsForANews($newsId){
		  try{
			 $conn=DBConnection::GetConnection();
			 $queryForGetTotal="SELECT COUNT(comment_id) AS total_value FROM comment where news_id=".$newsId."";
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
	  
	  //get all the comments for each news
	  
	  public function getAllTheCommentsForANews($newsId){
		  try{
			 $conn=DBConnection::GetConnection();
			 $myquery="SELECT comment_id,comment_description,comment_date,news_id,user_name FROM comment where news_id='".$newsId."'";
			 $result= $conn->query($myquery);
			 $comments=array();
			 foreach($result as $comment){
				$c1=new Comment();
				$c1->setCommentId($comment["comment_id"]);
				$c1->setCommentDescription($comment["comment_description"]);
				$c1->setCommentDate($comment["comment_date"]);
				$c1->setNewsId($comment["news_id"]);
				$c1->setUserName($comment["user_name"]);
				array_push($comments,$c1);				
			 }
			$conn =null;
			return $comments;
		  }catch(PDOException $p){
			  echo 'Fail to connect';
			  echo $p->getMessage();
		  }
	  }
	  
	  //insert new comment into the database
	  
	  public function addComment(){
		  try{
			  $conn=DBConnection::getConnection();			  
			  			  
			  $insertQuery="INSERT INTO comment(comment_description,comment_date,news_id,user_name)VALUES(:des,:com_date,:newsId,:user)";
			  $cmd=$conn->prepare($insertQuery);
			  
			  $cmd->bindValue(':des',$this->getCommentDescription(),PDO::PARAM_STR);
			  $cmd->bindValue(':com_date',$this->getCommentDate(),PDO::PARAM_STR);
			  $cmd->bindValue(':newsId',$this->getNewsId(),PDO::PARAM_INT);
			  $cmd->bindValue(':user',$this->getUserName(),PDO::PARAM_STR);
			  
			  $returnedValue=$cmd->execute(); //Returns TRUE on success or FALSE on failure
			  return $returnedValue;
		  }catch(PDOException $p){
			  echo 'Fail to connect';
			  echo $p->getMessage();
		  }
	  }
	  
	  //get all the comments
	  
	  public function getAllTheComments(){
		  try{
			 $conn=DBConnection::GetConnection();
			 $myquery="SELECT comment_id,comment_description,comment_date,news_id,user_name FROM comment";
			 $result= $conn->query($myquery);
			 $comments=array();
			 foreach($result as $comment){
				$c1=new Comment();
				$c1->setCommentId($comment["comment_id"]);
				$c1->setCommentDescription($comment["comment_description"]);
				$c1->setCommentDate($comment["comment_date"]);
				$c1->setNewsId($comment["news_id"]);
				$c1->setUserName($comment["user_name"]);
				array_push($comments,$c1);				
			 }
			$conn =null;
			return $comments;
		  }catch(PDOException $p){
			  echo 'Fail to connect';
			  echo $p->getMessage();
		  }
	  }
	  
	  //delete comment 
	  public function deleteComment($commentID){
		  try{
			  $conn=DBConnection::GetConnection();
			  $myQuery="DELETE FROM comment where comment_id='".$commentID."'";
			  $cmd=$conn->query($myQuery);
			  
			  return $cmd;
		  }catch(PDOException $p){
			  echo 'Fail to connect';
			  echo $p->getMessage();
		  }
	  } 
	  
	  //get comment according to comment id
	  
	  public function getCommentAccordingToCommentId($commentID){
		  try{
			 $conn=DBConnection::GetConnection();
			 $myquery="SELECT comment_id,comment_description,comment_date,news_id,user_name FROM comment where comment_id='".$commentID."'";
			 $result= $conn->query($myquery);
			 $c1=new Comment();
			 foreach($result as $comment){				
				$c1->setCommentId($comment["comment_id"]);
				$c1->setCommentDescription($comment["comment_description"]);
				$c1->setCommentDate($comment["comment_date"]);
				$c1->setNewsId($comment["news_id"]);
				$c1->setUserName($comment["user_name"]);
								
			 }
			$conn =null;
			return $c1;
		  }catch(PDOException $p){
			  echo 'Fail to connect';
			  echo $p->getMessage();
		  }
	  }
	  
	  //this method is for updating commnet description
	  public function updateComment($commentID){
		  try{
			  $conn=DBConnection::getConnection();
			  $updateQuery="UPDATE comment SET comment_description=:comment_description WHERE comment_id='".$commentID."'";
			  $cmd=$conn->prepare($updateQuery);
			  $cmd->bindValue(':comment_description',$this->getCommentDescription(),PDO::PARAM_STR);
			  
			  return $cmd->execute();
		  }catch(PDOException $p){
			  echo 'Fail to connect';
			  echo $p->getMessage();
		  }
	  } 
  }
?>