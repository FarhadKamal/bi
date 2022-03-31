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

					<label class="control-label">Showroom wise COGS & Operating Cost</label>
					<label class="control-label pull-right"><a class="btn" href="showroom_cogs_all.php">Export All Showroom Cost</a></label>
					<form>
						<table class="table table-striped">
							<tr>
								<td>
									<table class="table table-striped">
										<tr>

											<td>
												<select style="width: 250px;" name="pid" id="pid" class="flexselect">
													<?php
													$sql_pc = mysqli_query($con, "select * from profit_center where zone is not null ");

													while ($row_pc = mysqli_fetch_object($sql_pc)) {

														echo "<option value='" . $row_pc->pid . "'>" . $row_pc->centerName . "</option>";
													}
													?>
													
													<option value='123'>ALL</option>;
												</select>
											</td>

										</tr>
										<!--
						<tr>

							<td>
								
								<select name="company" >
									<option value='2000'>	Pragati		</option>
									<option value='1000'>	Pedrollo	</option>
									
									<option value='5000'>	PNL 		</option>

								</select> 
								
				
							</td>								
							
						</tr> -->
										<tr>

											<td>

												<select name="year" id="year" required="">

													
<option value='2020' <?php if ($_POST["year"] == 2019) echo "selected"; ?>>2020</option>													
<option value='2019' <?php if ($_POST["year"] == 2019) echo "selected"; ?>>2019</option>
													<option value='2018' <?php if ($_POST["year"] == 2018) echo "selected"; ?>>2018</option>

												</select>

												<input type="button" id="sub" value=">>" />
											</td>

										</tr>


									</table>
					</form>
					</td>
					</tr>
					</table>


					<div id="dataPrint">
						
					</div>




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
            var year = $('#year').val();

            // Fetch User Name
            if (pid) {
                $.ajax({
                    url: "showroom_cogs_rpt.php",
                    method: "POST",
                    data: {
                        pid: pid,
                        year: year,
                    },
                    success: function(data) {
                        $('#dataPrint').html(data);
                    }
                });
            } 
        });
    });
</script>