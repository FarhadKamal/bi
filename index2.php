

<?php



include_once("db.php"); 

	if(isset($_GET['logout']))
	{		

		session_destroy();
		
		if($_GET['logout']=="yes")
		header("Location: index.php?msg=logout");
		else if($_GET['logout']=="fail")
		header("Location: index.php?msg=failLog");
		else if($_GET['logout']=="relog")
		header("Location: login.php?msg=relog");
	}
	
	
	
	
$stdata=			"select Last_pull_time from sap_sales_process order by Last_pull_time desc limit 1";
$sqldata=			 mysqli_query( $GLOBALS['con'] ,$stdata );
$rowdata			=mysqli_fetch_object($sqldata);
$last_pull_date=	 $rowdata->Last_pull_time;

?>
<?php 
if(isset($_SESSION['logged'])){ 
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="icon" href="pic/icon.png" />

    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>BI</title>

    <!-- Bootstrap -->
    <!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="script/bootstrap.min.css">
	<link rel="stylesheet" href="script/bootstrap-theme.css">

	<!-- Optional theme -->
	<link rel="stylesheet" href="script/bootstrap-theme.min.css">
	
	<!-- Chart JS Library -->
	<script src="script/Chart.min.js" type="text/javascript"></script>
	
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
	
	<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="script/jquery-1.11.2.min.js"></script>

	
	<!-- Include all compiled plugins (below), or include individual files as needed -->
    <!-- Latest compiled and minified JavaScript -->
	<script src="script/bootstrap.min.js"></script>

  </head>
  <body>
	<div class="container" align="center" >
		<div class="row" ><br/>
			<div class="col-md-12">
				
		
				<label class="control-label"><font size="4" color="#8DD2EF">&nbsp;&nbsp;&nbsp;Management&nbsp;Dashboard</font></label>  <br/><font size="2" color="#A6A6A6">(Last pulling sales data: <b><?php echo  $last_pull_date; ?></b>)</font> <br/>
				<label class="control-label"><font size="2" color="#A6A6A6">&nbsp;&nbsp;&nbsp;Data Source: Previous financial year 2018 & Current financial year 2019 data (Pedrollo, PNL & Pragati)</font></label>
				<?php	include_once("dashboard2.php");  ?>
				<br/>
				<?php include_once("footer.php"); ?>
			</div>
		</div>
	</div>
	
	
	
	<!-- Custom Script -->

  </body>
</html>
<?php 



}else{ include_once("login.php"); } ?>


