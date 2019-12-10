<?php
  $url="https://www.youtube.com/watch?v=Ho32Oh6b4jc";
  
  $iparr = split ("\=", $url); 
   
   print "$iparr[0] <br />";
   print "$iparr[1] <br />" ;
   
   
   function isCurrency($number)
{
  return preg_match("/^-?[0-9]+(?:\.[0-9]{1,2})?$/", $number);
}

echo isCurrency("10.hdjs");
?>