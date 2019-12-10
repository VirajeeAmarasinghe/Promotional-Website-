<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Untitled Document</title>
<script>
  $(document).ready(function () {
    $("#openDialogButton").click(function () {
        $('html, body').animate({
            scrollTop: $("#Box3").offset().top
        }, 1000, function () {
            $("#dialogbox").dialog({
                width: 300,
                modal: false,
                position: {
                    my: "center",
                    at: "center",
                    of: $('#Box3')
                },
                buttons: {
                    "Submit": function () {
                        $(this).dialog("close");
                    }
                }
            });
        });
    });
});
</script>
</head>

<body>
<div id="Box1"><input id="openDialogButton" type="button" value="Open Dialog"></div>
<div id="Box2"></div>
<div id="Box3"></div>
<div id="dialogbox" title="Dialog Heading">
<p>Test Message</p>
</div>
<form method="post">
<input type="submit" name="Submit" id="Submit" value="Submit">
</form>
</body>
</html>