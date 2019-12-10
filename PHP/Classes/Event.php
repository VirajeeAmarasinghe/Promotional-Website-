<?php
  require_once('config/DBConnection.php');
  
  class Event{
	  private $event_id;
	  private $event_date;
	  private $venue;
	  private $location;
	  
	  
	  //set methods
	  public function setEventId($eventID){
		  $this->event_id=$eventID;
	  }
	  
	  public function setEventDate($eventDate){
		  $this->event_date=$eventDate;
	  }
	  
	  public function setVenue($venue){
		  $this->venue=$venue;
	  }
	  
	  public function setLocation($location){
		  $this->location=$location;
	  }
	  
	  //get methods
	  public function getEventId(){
		  return $this->event_id;
	  }
	  public function getEventDate(){
		  return $this->event_date;
	  }
	  public function getVenue(){
		  return $this->venue;
	  } 
	  public function getLocation(){
		  return $this->location;
	  }
	  
	  
	  //get event according to the specific event id
	 
	 public function GetEventAccordingToId($eventId){	
	  
		try{
			$conn = DBConnection::GetConnection();	
			$myquery= "SELECT event_id,event_date,venue,location FROM event WHERE event_id='".$eventId."'";
			$result= $conn->query($myquery);
			$ev=new Event();
			foreach($result as $release){
				$ev->setEventId($release["event_id"]);
				$ev->setEventDate($release["event_date"]);
				$ev->setVenue($release["venue"]);	
				$ev->setLocation($release["location"]);		
			}
			$conn =null;//To close the connection 
			return $ev;
		}catch(PDOException $e){
			echo 'Fail to connect';
			echo $e->getMessage();
		}	
		  
     }
	 
	 //get max id from the databse
	 public function getMaxID(){
		 try{
			$conn = DBConnection::GetConnection();	
			$queryForGetMaxId="SELECT MAX(event_id) AS max_value FROM event";
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
	   
	 //delete specific event
	  public function deleteEvent($eventID){
		  try{
			  $conn=DBConnection::GetConnection();
			  $myQuery="DELETE FROM event where event_id='".$eventID."'";
			  $cmd=$conn->query($myQuery);
			  
			  return $cmd;
		  }catch(PDOException $p){
			  echo 'Fail to connect';
			  echo $p->getMessage();
		  }
	  } 
	  
	  //insert new event to the database
	 public function addNewEvent(){
		 try{
			  $conn=DBConnection::getConnection();			  
			  			  
			  $insertQuery="INSERT INTO event(event_date,venue,location) VALUES (:event_date,:venue,:location)";
			  $cmd=$conn->prepare($insertQuery);
			  
			  $cmd->bindValue(':event_date',$this->getEventDate(),PDO::PARAM_STR);
			  $cmd->bindValue(':venue',$this->getVenue(),PDO::PARAM_STR);
			  $cmd->bindValue(':location',$this->getLocation(),PDO::PARAM_STR);
			  			  
			  $returnedValue=$cmd->execute(); //Returns TRUE on success or FALSE on failure
			  return $returnedValue;
		  }catch(PDOException $p){
			  echo 'Fail to connect';
			  echo $p->getMessage();
		  }
     }
	 
	 //this method is for updating event details
	  public function updateNewsDetails($eventID){
		  try{
			  $conn=DBConnection::getConnection();
			  $updateQuery="UPDATE event SET event_date=:event_date,venue=:venue,location=:location WHERE event_id='".$eventID."'";
			  $cmd=$conn->prepare($updateQuery);
			  $cmd->bindValue(':event_date',$this->getEventDate(),PDO::PARAM_STR);
			  $cmd->bindValue(':venue',$this->getVenue(),PDO::PARAM_STR);
			  $cmd->bindValue(':location',$this->getLocation(),PDO::PARAM_STR);			  
			  
			  return $cmd->execute();
		  }catch(PDOException $p){
			  echo 'Fail to connect';
			  echo $p->getMessage();
		  }
	  }
	  
	  //get all the events
	 
	 public function GetAllEvents(){	
	  
		try{
			$conn = DBConnection::GetConnection();	
			$myquery= "SELECT event_id,event_date,venue,location FROM event";
			$result= $conn->query($myquery);
			$evArray=array();
			foreach($result as $release){
				$ev=new Event();
				$ev->setEventId($release["event_id"]);
				$ev->setEventDate($release["event_date"]);
				$ev->setVenue($release["venue"]);	
				$ev->setLocation($release["location"]);	
				array_push($evArray,$ev);	
			}
			$conn =null;//To close the connection 
			return $evArray;
		}catch(PDOException $e){
			echo 'Fail to connect';
			echo $e->getMessage();
		}	
		  
     }
  }
?>