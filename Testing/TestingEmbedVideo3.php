<!DOCTYPE html>
<html>
<body>
    <script src="http://code.jquery.com/jquery-1.8.3.min.js"></script>
    <script>
        var tag = document.createElement('script');

        tag.src = "https://www.youtube.com/iframe_api";
        var firstScriptTag = document.getElementsByTagName('script')[0];
        firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);

        var player;
        function onYouTubeIframeAPIReady() {
            player = new YT.Player('player', { // "player" id of youtube player container where video comes using youtube iframe api.
                height: '390',
                width: '640',
                videoId: 'M7lc1UVf-VE',
                events: {
                    'onReady': onPlayerReady, // on ready event below callback function "onPlayerReady" will be called.
                }
            });
        }

        function onPlayerReady(event) { // as youtube player will ready
            $('#play_vid').click(function() {  // it will wait to click on overlay/image
                event.target.playVideo();  // as overlay image clicked video plays.
            });
        }

        $(document).ready(function() {
            $('#player').hide(); // on document ready youtube player will be hiden.
            $('#play_vid').click(function() {  // as user click on overlay image.
                $('#player').show();    // player will be visible to user 
                $('#play_vid').hide(); // and overlay image will be hidden.
            });
        });
    </script>

    <div id="player"></div> <!-- Youtube player container -->
    <img id="play_vid" src="Image/American music awards pic-3.jpg" /> <!-- overlay image that comes in front of youtube video. when user click on this, image will be hidden and video plays using youtube api.-->
</body>
</html>