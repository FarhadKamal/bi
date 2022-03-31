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
					<div id="loading">
						
					</div>
					<table class="table table-striped">
				
						<tr>
							<td><label>Offer&nbsp;List</label>&nbsp;&nbsp;&nbsp;<select id="olist" ></select></td>
							<!--
							<td>
							<button onClick="window.location.reload();">Refresh</button>
							</td>
							-->
						</tr>
									
				
					</table>
					
					<div id="matList">
					
					</div>
						
						

				</div>
			</div>
		</div>



		<!-- Custom Script -->
		<script>
			$(document).ready(function() {
					
					$("select.flexselect").flexselect();
					orderList();
					
				


				

				function orderList(){

					  $.post('offmodel.php?call=2', {
									
								},
					
								function(result) {
		
									if (result) {
									
										$( "#olist" ).empty();									
										$( "#olist" ).append(result );
										list_mat();

									}
								}
								);
						
				 }
				 
				 
				 
				



				
				function list_mat(){

					  $( "#loading" ).append('<img src="pic/loading.gif"  />');
					  $( "#matList" ).empty();
					  var olist = $("#olist").val(); 
					  //alert(olist);
					  $.post('offmodel.php?call=7', {
									'olist': olist
								},
					
								function(result) {
		
									
									if (result) {
									
										
																	
										$( "#matList" ).append(result );
										$( "#loading" ).empty();
									
										//alert(result);

									}
								}
								);
						
				 }
				 
				 
				 $('#olist').change(function(){	
					list_mat();
					
				});	
				 		
				
			
			
			
	
	
	
			
			
				
				


			});
		</script>




	</body>

	</html>
<?php

	// include_once("footer.php"); 

} else {
	include_once("login.php");
} ?>