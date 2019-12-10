<!doctype html>
<html>
<head></head>

   <body>
    <form  action="" method="POST" enctype="multipart/form-data">
    <input type="hidden" name="action" value="submit">
    Your name:<br>
    <input name="name" type="text" value="" size="30"/><br>
    Your email:<br>
    <input name="email" type="text" value="" size="30"/><br>
    Your message:<br>
    <textarea name="message" rows="7" cols="30"></textarea><br>
    <input type="submit" value="Send email" name="btn_sub"/>
    </form>
    
    
    <?php
                    /* send the submitted data */
    if(isset($_POST["btn_sub"])){
		$name=$_POST['name'];
    $email=$_POST['email'];
    $message=$_POST['message'];
    if (($name=="")||($email=="")||($message==""))
        {
        echo "All fields are required, please fill <a href=\"\">the form</a> again.";
        }
    else{        
        $from="From: $name<$email>\r\nReturn-path: $email";
        $subject="Message sent using your contact form";
        mail("virajee.hiranthika@gmail.com", $subject, $message, $from);
        echo "Email sent!";
        }
    }
    
      
?>
</body>
</html>