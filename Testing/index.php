<?php
   // *** Include the class
include("resize.php");
 
// *** 1) Initialize / load image
$resizeObj = new resize('Image/American music awards pic-3.jpg');
 
// *** 2) Resize image (options: exact, portrait, landscape, auto, crop)
$resizeObj -> resizeImage(440,320, 'landscape');
 
// *** 3) Save image
$resizeObj -> saveImage('Image/sample-resized.gif', 100);
?>