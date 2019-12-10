<?php
  require_once('config/DBConnection.php');
  class Paginator{
	  private $_conn;
	  private $_limit;
	  private $_page;
	  private $_query;
	  private $_total;
	  
	  //constructor
	  
	  public function __construct($conn,$query){
		  try{
			$this->_conn=$conn;
			$this->_query=$query;
			
			$rs=$this->_conn->query($this->_query);
			/* calculates the total number of rows retrieved by that query */
			$num_rows=0;
			foreach($rs as $item){
				$num_rows++;
		    }
			
			$this->_total=$num_rows;
		  }catch(PDOException $e){
			echo 'Fail to connect';
			echo $e->getMessage();	  
          }
	  }
	  
	  //paginate the data and return the results
	  
	  public function getData($limit=10, $page = 1 ) {
     
		$this->_limit= $limit;
		$this->_page= $page;
	 
		if($this->_limit == 'all'){
			$query      = $this->_query;
		}else{
			$query      = $this->_query . " LIMIT " . ( ( $this->_page - 1 ) * $this->_limit ) . ", $this->_limit";
		}
		
		$rs             = $this->_conn->query( $query );
	 
		while($row = $rs->fetch(PDO::FETCH_ASSOC)){
			$results[]  = $row;
		}
	 
		$result         = new stdClass();
		$result->page   = $this->_page;
		$result->limit  = $this->_limit;
		$result->total  = $this->_total;
		$result->data   = $results;
	 
		return $result;
     }
	 
	 //get the pagination links
	 
	 public function createLinks( $links, $list_class ) {
		 /*First we evaluate if the user is requiring a given number of links or all of them, in the second case we simply return an empty string since no pagination is required.*/
		if ( $this->_limit == 'all' ) {
			return '';
		}
	 /*After this we calculate the last page based on the total number of rows available and the items required per page.*/
		$last       = ceil( $this->_total / $this->_limit );
	 
	 /*Then we take the links parameter which represents the number of links to display below and above the current page, and calculate the start and end link to create.*/
		$start      = ( ( $this->_page - $links ) > 0 ) ? $this->_page - $links : 1;
		$end        = ( ( $this->_page + $links ) < $last ) ? $this->_page + $links : $last;
	 
		$html       = '<ul class="' . $list_class . '">';
	 
		$class      = ( $this->_page == 1 ) ? "disabled" : "";
		$html       .= '<li class="' . $class . '"><a href="?limit=' . $this->_limit . '&page=' . ( $this->_page - 1 ) . '">&laquo;</a></li>';
	 
		if ( $start > 1 ) {
			$html   .= '<li><a href="?limit=' . $this->_limit . '&page=1">1</a></li>';
			$html   .= '<li class="disabled"><span>...</span></li>';
		}
	 
		for ( $i = $start ; $i <= $end; $i++ ) {
			$class  = ( $this->_page == $i ) ? "active" : "";
			$html   .= '<li class="' . $class . '"><a href="?limit=' . $this->_limit . '&page=' . $i . '">' . $i . '</a></li>';
		}
	 
		if ( $end < $last ) {
			$html   .= '<li class="disabled"><span>...</span></li>';
			$html   .= '<li><a href="?limit=' . $this->_limit . '&page=' . $last . '">' . $last . '</a></li>';
		}
	 
		$class      = ( $this->_page == $last ) ? "disabled" : "";
		$html       .= '<li class="' . $class . '"><a href="?limit=' . $this->_limit . '&page=' . ( $this->_page + 1 ) . '">&raquo;</a></li>';
	 
		$html       .= '</ul>';
	 
		return $html;
     }
  }
?>