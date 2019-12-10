<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Triggering a Youtube Video from Clicking a Button Image and Replacing when Ended</title>
</head>
<body>
<style type="text/css">
    #head {
        background-color: #aaa;
        width:100%;
    }
    #container {
        cursor:pointer;
        width:320px;
        height:180px;

        margin:auto;
        position:relative;
    }
   
    .inactive-state {
        background-repeat: no-repeat;
        background-size: 100%;
        background-image: url('data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAFUAAAAwCAIAAADvrqHkAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAAVxJREFUeNpivD5DnmEEAyaGkQ1G/T/q/1H/j/p/1P+j/h/1/6j/RxpgoZ3RGmn3qWXUjVmKo/E/1OKfKlFHxUQ0iOKfU8xgRJd/0m4zOUR0R67/WbjEZDxmD4YgGLDyj4VLHBQEonojt/4HBYE7MAh0R6j/oRnBbRaHiM7Ibf+xcEuAUsEAlQWDov0DDIKBqhEGS/uPlUdSxn0W/YNgELV/QRnBYzafSsDI7f8BawReJc9h1f4nCXy4vvzt+Skj1P8fb615ebTu/78/IzH9f7y56sWhCjp7frDE/4drS16eaP3/7+9IrP+Aef7Vifb/f34MTIk7wMn+9nr65/nB4n9ggff8YDnD/38DWeMOYJ5/daJtYD0/YPkflOdPdf37833AS5+B8f+bsxP//fo8KFqctLaA1gO4w6r9T3/AOLr+iWHU/6P+H/X/qP9H/T/q/1H/j/p/1P8jBwAEGAAZsV2KaXSD7AAAAABJRU5ErkJggg==');
    }
    .hover-state {
        background-image: url('data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAFUAAAAwCAIAAADvrqHkAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAAU1JREFUeNrsmV1qwkAUhVOJ9b8PUZ+UFp+MW+iLuo8uzAW4FhFEBREsWsVSQZO2oM/WGYdB360k3jH33AVM8p0758yd5GHSerEYV8ziXeAHP/jBD37wgx/83MoOb2n39S2opd47bfT/3vofSOsC3EQG9T+VK7DOv1K1nsw6fPntx1TZbZogAVn+nSXI8z3/tQQNWgmIzz8tQT2ZcZjyawnS5VqDKguMmH+UBKUqjQSmzH/xRFpngcOU/2QEt/lUrPC9/6k4zOWfIzX//6u23ux3NWbKv/Pn3qInpeDIr+A3866UMmr334u2/WbqLfu3hzci/5Tn/c+BFAeaxCXe9t+L23veFH7l+fVH17Ik4TvYhJ73lwNaeDL/a88PhfgjTx8a/p+vkTjsjZg4w35A2B9wIzX/R6r/4f20Qf/BD37wgx/84Ac/+MF/ZR0FGAAHJFtR2l1ELgAAAABJRU5ErkJggg==');
    }
</style>
<section id="head">
    <div id="container" class="click-to-play-video inactive-state">
        <div id="player" class="home-player"></div>
    </div>
</div>

<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js"></script>
<script type="text/javascript">
    $("#container").mouseenter(function(){
        $(this).addClass('hover-state');
    }).mouseleave(function(){
        $(this).removeClass('hover-state');
    });

    $("#container.click-to-play-video").click(function(){
        $('#head').css({"background-color":"black"});

        player = new YT.Player('player', {
            width : '320',
            height : '180',
            videoId : 'qlEUrEVqDbo',
            playerVars: { 'autoplay': 1 },
            events : {
                'onReady' : onPlayerReady,
                'onStateChange' : onPlayerStateChange
            }
        });
    });

    var tag = document.createElement('script');
    tag.src = "https://www.youtube.com/iframe_api";
    var firstScriptTag = document.getElementsByTagName('script')[0];
    firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);

    var player;
    function onPlayerReady(event) {
        //event.target.playVideo();
    }
    function onPlayerStateChange(event) {
        if(event.data == YT.PlayerState.ENDED) {
            player.destroy();
            $('#head').css({"background-color":"#aaa"});
        }
    }
</script>
</body>
</html>