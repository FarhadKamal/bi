<?php

include_once("db.php");
error_reporting(E_ALL ^ E_NOTICE);

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
		<?php
		include_once("sidebar.php");
		?>
		<div class="container">
			<div class="row"><br />
				<div class="col-md-12">
					<br/>
					<br/>
					<form>
						<table class="table table-striped">
							<tr>
								<td>
									<table class="table table-striped">
										<tr>

											<td>
												<select style="width: 1000px;" name="pid" id="pid" class="flexselect">
												<option value='0'>Select</option>;
													<?php
													$sql_product = mysqli_query($con, "select * from material_data where SPART in
													(20,30,50) and MTART='HAWA' 
													order by MAKTX ");
													
													

													while ($row_product = mysqli_fetch_object($sql_product)) {

														echo "<option value='" . $row_product->MATNR . "'>" . $row_product->MATNR." ".$row_product->MAKTX . "</option>";
													}
													?>
													
													
												</select>
											</td>

										</tr>
		
										<tr>

											<td>
												<input type="button" id="sub" value="Search" />
												<br/><br/>
												<div id="dataPrint">
						
												</div>
											</td>

										</tr>


									</table>
					</form>
					</td>
					</tr>
					</table>


					




				</div>
			</div>
		</div>



		<script>
			$(document).ready(function() {
				$("select.flexselect").flexselect();

			});
		</script>





	</body>

	</html>
<?php

	// include_once("footer.php");
} else {
	include_once("login.php");
} ?>



<script>
    // Ajax Select Function List By Selecting a Controller
    $(document).ready(function() {
        $('#sub').click(function() {
            var pid = $('#pid').val();
       
			//alert(pid);
            // Fetch User Name
			
            if (pid) {
                $.ajax({
                    url: "fetch_mrp.php",
                    method: "POST",
                    data: {
                        pid: pid
                    
                    },
                    success: function(data) {
                        $('#dataPrint').html(data);
                    }
                });
            } 
        });
    });
</script>