<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>jQuery Get Selected Option Value</title>
<script type="text/javascript" src="http://code.jquery.com/jquery.min.js"></script>
<script type="text/javascript">
$(document).ready(function(){
    $("select.country").change(function(){
        var selectedCountry = $(".country option:selected").val();
        alert("You have selected the country - " + selectedCountry);
    });
});
</script>
</head> 
<body>
    <form>
        <label>Select Country:</label>
        <select class="country">
            <option value="usa">United States</option>
            <option value="india">India</option>
            <option value="uk">United Kingdom</option>
        </select>
    </form>
</body>
</html>
If the value for