<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php include("meta.php"); ?>
</head>

<body>
    <div id="body">
        <div id="universal">
			<?php 
            if($_GET['menu']=='quiz'){
                include("quiz.php");
            }else if($_GET['menu']=='quiz2'){ 
                include("quiz2.php");
            }else if($_GET['menu']=='result'){ 
                include("result.php");
            }else if($_GET['menu']=='form'){ 
                include("form.php");
            }else if($_GET['menu']=='thanks'){ 
                include("thanks.php");
            }else if($_GET['menu']=='landing'){ 
                include("landing.php");
            }else{ 
                // include("home.php");
                include("landing.php");
            }?>
			<?php include("footer.php"); ?>
        </div><!-- end #universal -->
    </div><!-- end #body -->
</body>
</html>