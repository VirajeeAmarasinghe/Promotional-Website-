<?php
   class Errors{
	   //to avoid the incomplete object error
	
	function fixObject(&$object){
	  if (!is_object ($object) && gettype ($object) == 'object')
		return ($object = unserialize (serialize ($object)));
	  return $object;
    }
   }
?>