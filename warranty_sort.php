<?php

include_once("db.php");

if (isset($_GET['logout'])) {

	session_destroy();

	if ($_GET['logout'] == "yes")
		header("Location: index.php?msg=logout");
	else if ($_GET['logout'] == "fail")
		header("Location: index.php?msg=failLog");
	else if ($_GET['logout'] == "relog")
		header("Location: login.php?msg=relog");
}




?>
<?php
if (isset($_SESSION['logged'])) {
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
		
		
		<link rel="stylesheet" href="script/flexselect.css" type="text/css" media="screen" />
		<script src="script/liquidmetal.js" type="text/javascript"></script>
		<script src="script/jquery.flexselect.js" type="text/javascript"></script>


	</head>

	<body>
	
		<div class="container">
			<div class="row"><br />
				<div class="col-md-12">
					<div id="loading"></div>

					<?php
                    
                    if($_GET["stat"] == 1){
                        $result =mysqli_query($GLOBALS['oms'],"select 
                        batch_registered.id, batch_registered.batch_id, batch_registered.mat_no, product.ProductName,
                        batch_registered.phone_no, batch_registered.created_date, batch_registered.zone
                        from batch_registered
                        LEFT JOIN product ON product.ProductId = batch_registered.mat_no");
                    }
                    elseif($_GET["stat"] == 2){
                        
                        $result =mysqli_query($GLOBALS['oms'],"select 
                        batch_registered.id, batch_registered.batch_id, batch_registered.mat_no, product.ProductName,
                        batch_registered.phone_no, batch_registered.created_date, batch_registered.zone
                        from batch_registered
                        LEFT JOIN product ON product.ProductId = batch_registered.mat_no
                        WHERE date(created_date)=date(now())");  
                        
                    
                    }
                    elseif($_GET["stat"] == 3){
                        
                        $result =mysqli_query($GLOBALS['oms'],"select 
                        batch_registered.id, batch_registered.batch_id, batch_registered.mat_no, product.ProductName,
                        batch_registered.phone_no, batch_registered.created_date, batch_registered.zone
                        from batch_registered
                        LEFT JOIN product ON product.ProductId = batch_registered.mat_no
                        WHERE month(created_date)=month(now()) and year(created_date)=year(now())");
                    
                    }
                    else{
                        
                        $result =mysqli_query($GLOBALS['oms'],"select 
                        batch_registered.id, batch_registered.batch_id, batch_registered.mat_no, product.ProductName,
                        batch_registered.phone_no, batch_registered.created_date, batch_registered.zone
                        from batch_registered
                        LEFT JOIN product ON product.ProductId = batch_registered.mat_no");
                    
                    }
                    $i = 1;
                    ?>
					<div>
                        <table class='table table-striped'>
                            <thead>
                                <th>#SL</th>
                                <th>Batch ID</th>
                                <th>Material No.</th>
                                <th>Material Name</th>
                                <th>Phone No.</th>
                                <th>Entry Date</th>
                                <th>Zone</th>
                            </thead>
                            <tbody>
                            <?php while ($row = $result->fetch_assoc()) { ?>
                            <tr>
                                <td><?php echo $i; ?></td>
                                <td><?php echo $row["batch_id"]; ?></td>
                                <td><?php echo $row["mat_no"]; ?></td>
                                <td><?php echo $row["ProductName"]; ?></td>
                                <td><?php echo $row["phone_no"]; ?></td>
                                <td><?php echo $row["created_date"]; ?></td>
                                <td><?php echo $row["zone"]; ?></td>
                            </tr>
                            <?php $i++; } ?>
                            </tbody>
                        </table>
					</div>
						
						

				</div>
			</div>
		</div>



	</body>

	</html>
<?php

	// include_once("footer.php"); 

} else {
	include_once("login.php");
} ?>