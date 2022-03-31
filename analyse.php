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


	</head>

	<body>
		<?php
		include_once("sidebar.php");
		?>
		<div class="container">
			<div class="row"><br />
				<div class="col-md-12">

					<label class="control-label">Sales vs Target Yearly</label>
					<table class="table table-striped">
						<tr>

							<?php $stryear = "select distinct fyear from sales_target order by  fyear";

							$sqlyear = mysqli_query($con, $stryear);

							while ($rowyear = mysqli_fetch_object($sqlyear)) {

							?>

								<td><input type="radio" name='vyear' value='<?php echo $rowyear->fyear; ?>' checked /><label><?php echo $rowyear->fyear; ?></label></td>

							<?php  } ?>


						</tr>
						<tr>
							<td><input type="checkbox" name="vgroup" value="CR" checked><label>CR</label></td>
							<td><input type="checkbox" name="vgroup" value="BD" checked><label>BD</label></td>
							<td><input type="checkbox" name="vgroup" value="SR" checked><label>SR</label></td>
						</tr>

						<tr>
							<td><input type="checkbox" name="vdivision" class="checkBoxDivClass" value="20" checked> Pedrollo</td>
							<td><input type="checkbox" name="vdivision" class="checkBoxDivClass" value="30" checked> HCP</td>
							<td><input type="checkbox" name="vdivision" class="checkBoxDivClass" value="40" checked> Rovatti</td>
							<td><input type="checkbox" name="vdivision" class="checkBoxDivClass" value="50" checked> BGFlow</td>
							<td><input type="checkbox" name="vdivision" class="checkBoxDivClass" value="51" checked> SAER</td>
							<td><input type="checkbox" name="vdivision" class="checkBoxDivClass" value="60" checked> ITAP</td>
							<td><input type="checkbox" name="vdivision" class="checkBoxDivClass" value="80" checked> Munters</td>
							<td><input type="checkbox" name="vdivision" class="checkBoxDivClass" value="90" checked> Teflon</td>
							<td><input type="checkbox" name="vdivision" class="checkBoxDivClass" value="99" checked> Pentagono</td>
							<td><input type="checkbox" name="vdivision" class="checkBoxDivClass" value="70" checked> Other</td>
							<td><input type="checkbox" id="sld" value="0"> Select&nbsp;All</td>
							<td><input type="button" class="btn btn-default" value="Run >>" id="run"></td>
						</tr>


						<tr>
							<td><input type="radio" name='vbar' value='bar' checked />Bar</td>
							<td><input type="radio" name='vbar' value='line' />Line</td>
						</tr>

					</table>
					<div id="loading" align="center">
						<img src="pic/loading.gif" />
					</div>
					<div class="chart">
						<canvas id="mycanvas" style="height:250px"></canvas>
					</div>

					<div class="chart">
						<canvas id="totcanvas" style="height:250px"></canvas>
					</div>


					<div class="chart">
						<canvas id="mycompareyear" style="height:250px"></canvas>
					</div>

					<div class="chart">
						<canvas id="myitemyear" style="height:250px"></canvas>
					</div>

				</div>
			</div>
		</div>



		<!-- Custom Script -->
		<script>
			$(document).ready(function() {
				Chart.defaults.global.defaultFontColor = '#294786';
				Chart.defaults.global.defaultFontFamily = "'Roboto Condensed', sans-serif";

				var barchk = "";
				var piechk = "";
				var yearbarchk = "";
				var yearitemchk = "";
				$(function() {
					$.loadShow = function() {
						$("#run").attr("disabled", "disabled");
						$("#mycanvas").hide();
						$("#totcanvas").hide();
						$("#mycompareyear").hide();
						$("#myitemyear").hide();
						$("#loading").show();
					};
				});

				$(function() {
					$.loadHide = function() {
						$("#run").removeAttr("disabled");
						$("#mycanvas").show();
						$("#totcanvas").show();
						$("#mycompareyear").show();
						$("#myitemyear").show();
						$("#loading").hide();
					};
				});



				$(function() {
					$.runShow = function() {


						var vgroup = ($("input[name=vgroup]:checked").map(
							function() {
								return "'" + this.value + "'";
							}).get().join(","));


						var vdivision = ($("input[name=vdivision]:checked").map(
							function() {
								return this.value;
							}).get().join(","));



						var vyear = $('input[name=vyear]:checked').val();


						var vbar = $('input[name=vbar]:checked').val();

						vfill = true;

						if (vbar == 'line')
							vfill = false;

						//alert(vgroup);
						//alert(vyear);
						//alert(vdivision);

						$.post('modal.php?call=2', {
								'vyear': vyear,
								'vgroup': vgroup,
								'vdivision': vdivision
							},

							// when the Web server responds to the request
							function(result) {
								// if the result is TRUE write a message return by the request
								if (result) {


									//alert(result);

									dtx = JSON.parse(result);


									xd1 = dtx[0];
									//alert(xd1)
									xd2 = dtx[1];

									xd3 = JSON.parse(dtx[2]);
									//alert(xd1)
									xd4 = JSON.parse(dtx[3]);
									xd5 = JSON.parse(dtx[4]);
									xd6 = JSON.parse(dtx[5]);;

									test = JSON.parse(xd1);

									/*console.log(test);*/
									var MONTHS = ['Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec', 'Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'];
									var amt = [];
									var amt2 = [];

									var totpie = [];

									/*console.log(data.length);*/
									for (var i in test) {
										//sales.push(test[i].january);			
										amt.push(test[i]);
									}


									test2 = JSON.parse(xd2);

									for (var i in test2) {
										//sales.push(test[i].january);

										amt2.push(test2[i]);
									}


									//Creating Bar Sales vs Target
									//-------------------------------------------------------------------------------------------------------------------------------
									var chartdata = {
										labels: MONTHS,
										datasets: [


											{
												label: 'Target',
												type: vbar,
												backgroundColor: '#FFB0C1',
												borderColor: '#FFB0C1',
												hoverBackgroundColor: '#FFB0C1, 1',
												hoverBorderColor: '#FFB0C1, 1',
												fill: vfill,
												data: amt
											}

											,

											{
												label: 'Sales',
												type: vbar,
												backgroundColor: '#9AD0F5',
												borderColor: '#9AD0F5',
												hoverBackgroundColor: '#9AD0F5, 1',
												hoverBorderColor: '#9AD0F5, 1',
												fill: vfill,
												data: amt2
											}


										]

									};

									var ctx2 = $("#mycanvas");


									//barGraph.destroy();
									if (barchk != "")
										barchk.destroy();
									var barGraph2 = new Chart(ctx2, {
										type: vbar,
										data: chartdata,
										options: {
											scales: {
												yAxes: [{
													ticks: {
														callback: function(label, index, labels) {
															return label / 10000000 + ' crore';
														}
													},
													scaleLabel: {
														display: true,
														labelString: '1 crore  = 10000000',
														fontSize: 16
													}
												}]
											},
											legend: {
												labels: {
													// This more specific font property overrides the global property
													fontSize: 14
												}
											}
										}
									});
									barchk = barGraph2;
									//barGraph.destroy();	








									//-------------------------------------------------------------------------------------------------------------------------------
									//Creating Pie Chart Achievment

									for (var i in xd3) {
										//sales.push(test[i].january);			
										totpie.push(xd3[i]);
									}

									for (var i in xd4) {
										//sales.push(test[i].january);			
										totpie.push(xd4[i]);
									}

									var totsales = totpie[1];
									var tottarget = totpie[0];

									var tottargetcore = (tottarget / 10000000).toFixed(2);


									var notachieved = tottarget - totsales;
									if (notachieved < 0)
										notachieved = 0;
									notachieved = notachieved.toFixed(2);

									var percentage = Math.round(totsales / tottarget * 100);

									var config = {
										type: 'pie',
										data: {
											datasets: [{
												data: [
													totsales,
													notachieved

												],
												backgroundColor: [
													'#4BF41E',
													'#FF0024'

												],
												label: 'Sales'
											}],
											labels: [
												'Achieved ',
												'Not Achieved '

											]
										},
										options: {
											responsive: true,
											legend: {
												position: 'top',
											},
											title: {
												display: true,
												text: percentage + '% Achievement on ' + tottargetcore + ' crore for year ' + vyear,
												fontSize: 14

											},
											animation: {
												animateScale: true,
												animateRotate: true
											},
											legend: {
												labels: {
													// This more specific font property overrides the global property
													fontSize: 14
												}
											}



										}


									};




									var ctx3 = $("#totcanvas");

									//barGraph.destroy();
									if (piechk != "")
										piechk.destroy();
									var pieGraph = new Chart(ctx3, config);

									piechk = pieGraph;






									//Creating Bar Yearly Business Grow check
									//-------------------------------------------------------------------------------------------------------------------------------



									var amtyearsalex = [];
									var amtyearsaley = [];

									for (var i in xd5) {
										amtyearsaley.push(xd5[i].tot);
										amtyearsalex.push(xd5[i].fyear);
									}





									var chartyeardata = {
										labels: amtyearsalex,
										datasets: [




											{
												label: 'Line',
												type: 'line',
												backgroundColor: '#FF000C',
												borderColor: '#FF000C',
												hoverBackgroundColor: '#FF000C, 1',
												hoverBorderColor: '#FF000C, 1',
												data: amtyearsaley,
												fill: false
											},


											{
												label: 'Comparing sales with each year',
												type: 'bar',
												backgroundColor: '#FFF82D',
												borderColor: '#FFF82D',
												hoverBackgroundColor: '#FFF82D, 1',
												hoverBorderColor: '#FFF82D, 1',
												data: amtyearsaley
											}


										]

									};

									var ctx4 = $("#mycompareyear");
									if (yearbarchk != "")
										yearbarchk.destroy();
									var barGraph3 = new Chart(ctx4, {
										type: 'bar',
										data: chartyeardata,
										options: {
											scales: {
												yAxes: [{
													ticks: {
														callback: function(label, index, labels) {
															return label / 10000000 + ' crore';
														}
													},
													scaleLabel: {
														display: true,
														labelString: '1 crore  = 10000000',
														fontSize: 16
													}
												}]
											},
											legend: {
												labels: {
													// This more specific font property overrides the global property
													fontSize: 14
												}
											}
										}
									});
									yearbarchk = barGraph3;























									//Creating Bar Yearly product sales compare.
									//-------------------------------------------------------------------------------------------------------------------------------

									var dynamicColors = function() {
										var r = Math.floor(Math.random() * 255);
										var g = Math.floor(Math.random() * 255);
										var b = Math.floor(Math.random() * 255);
										return "rgb(" + r + "," + g + "," + b + ")";
									};


									var itemSales = [];
									var itemName = [];
									var coloR = [];

									for (var i in xd6) {

										itemSales.push(xd6[i].Pedrollo);
										itemName.push('Pedrollo');
										itemSales.push(xd6[i].HCP);
										itemName.push('HCP');
										itemSales.push(xd6[i].Rovatti);
										itemName.push('Rovatti');
										itemSales.push(xd6[i].BGFlow);
										itemName.push('BGFlow');
										itemSales.push(xd6[i].SAER);
										itemName.push('SAER');
										itemSales.push(xd6[i].ITAP);
										itemName.push('ITAP');
										itemSales.push(xd6[i].Munters);
										itemName.push('Munters');
										itemSales.push(xd6[i].Teflon);
										itemName.push('Teflon');
										itemSales.push(xd6[i].Pentagono);
										itemName.push('Pentagono');
										itemSales.push(xd6[i].Other);
										itemName.push('Other');
										coloR.push(dynamicColors());
										coloR.push(dynamicColors());
										coloR.push(dynamicColors());
										coloR.push(dynamicColors());
										coloR.push(dynamicColors());
										coloR.push(dynamicColors());
										coloR.push(dynamicColors());
										coloR.push(dynamicColors());
										coloR.push(dynamicColors());
										coloR.push(dynamicColors());

									}




									var chartitemdata = {
										labels: itemName,
										datasets: [

											{
												label: 'Product Sales Compare ' + vyear,
												type: 'bar',
												backgroundColor: coloR,
												borderColor: 'rgba(200, 200, 200, 0.75)',
												hoverBorderColor: 'rgba(200, 200, 200, 1)',
												data: itemSales
											}


										]

									};



									var ctx5 = $("#myitemyear");
									if (yearitemchk != "")
										yearitemchk.destroy();
									var barGraph4 = new Chart(ctx5, {
										type: 'bar',
										data: chartitemdata,
										options: {
											scales: {
												yAxes: [{
													ticks: {
														callback: function(label, index, labels) {
															return label / 10000000 + ' crore';
														}
													},
													scaleLabel: {
														display: true,
														labelString: '1 crore  = 10000000',
														fontSize: 16
													}
												}]
											},
											legend: {
												labels: {
													// This more specific font property overrides the global property
													fontSize: 14
												}
											}
										}
									});
									yearitemchk = barGraph4;




								}
							}
						);
					};
				});







				$("#sld").click(function() {


					if ($("#sld").is(':checked')) {
						$(".checkBoxDivClass").prop('checked', true);
					} else $(".checkBoxDivClass").prop('checked', false);
				});

				//Here it works! when you hit the run button.
				$("#run").click(function() {


					$.loadShow();
					$.runShow();
					$.loadHide();



				});


				$.ajax({
					url: "<?php echo 'hello.php'; ?>",
					method: "GET",
					success: function(data) {

						$.loadShow();
						$.runShow();
						$.loadHide();

					},
					error: function(data) {
						console.log(data);
					}
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