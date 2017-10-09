<?php
    if(!isset($_POST['error_info']) && !isset($_POST['route'])){
        echo '禁止访问';exit;
    }
    $error_info = $_POST['error_info'];
    $route = $_POST['route'];
?>
<!DOCTYPE>
<html lang="it">
<head>
<meta content="text/html; charset=UTF-8" http-equiv="content-type">
<title>ERROR</title>

<link href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/6.9.1/sweetalert2.css" rel="stylesheet" type="text/css">
<script src="http://code.jquery.com/jquery-1.10.2.js" integrity="sha256-it5nQKHTz+34HijZJQkpNBIHsjpV8b6QzMJs9tmOBSo=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/6.9.1/sweetalert2.js" charset="gbk"></script>
<script>
$(function(){
    swal("ERROR","<?=$error_info?>","error");
    setTimeout(function(){
        window.location.href = "<?=$route?>"+".php";
    },3000);
});
</script>
</head>
<body>
<div id="page">
    
</div>
</body></html>



 


 




