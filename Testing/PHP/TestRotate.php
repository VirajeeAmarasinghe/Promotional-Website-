<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Untitled Document</title>
<link rel="stylesheet" href="../CSS/FormatTestRotate.css">
</head>

<body>
<div id="tweet" class="tweet">
             <img src="../Image/Four.jpg" id="rotator">
             <div class="text_on_tweet_image">
               <h2 id="a">LOUIS TOMLINSON</h2>
               <p><a href="#"><b>VIEW LOUIS'S TWITTER</b></a></p>
             </div>
           </div>
 
</div>

<!--Problem-Image is changed,but image is not loaded.-->

<script type="text/javascript">
(function() {
    var rotator = document.getElementById('rotator');  // change to match image ID
    var imageDir = "../Image/";                          // change to match images folder
    var delayInSeconds = 5;                            // set number of seconds delay
    // list image names
    var images = ["NightChangesSongCover.jpg"];
	

    // don't change below this line
    var num = 0;
	
    var changeImage= function() {
        var len = images.length;
        rotator.src = imageDir + images[num++];
		
        if (num == len) {
            num = 0;
        }
    };
    setInterval(changeImage, delayInSeconds * 1000);
})();

</script>
</body>
</html>