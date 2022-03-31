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
		<?php
		include_once("sidebar.php");
		?>
		<div class="container">
			<div class="row"><br />
				<div class="col-md-12">

					<label class="control-label">Sales vs Stock Yearly</label>
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
							<td colspan="4">
								<select style="width: 250px;" name="ProductId" id="mat" class="flexselect">
									<?php
									$sql_spare = mysqli_query($con, "select * from material_data where MTART='HAWA' order by MAKTX");

									while ($row_spare = mysqli_fetch_object($sql_spare)) {
										if ($row_spare->MATNR == 102732)
											echo "<option selected value='" . $row_spare->MATNR . "'>" . $row_spare->MAKTX . "</option>";
										else echo "<option value='" . $row_spare->MATNR . "'>" . $row_spare->MAKTX . "</option>";
									}
									?>
								</select>
							</td>
						</tr>

						<tr>
							<td><input type="radio" name='vbar' value='bar' checked />Bar</td>
							<td><input type="radio" name='vbar' value='line' />Line</td>
							<td><input type="button" class="btn btn-default" value="Run >>" id="run"></td>
							<!--<td><input type="button"  class="btn btn-default" value="Export>>" id="cbl"></td>-->
						</tr>

					</table>
					<div id="loading" align="center">
						<img src="pic/loading.gif" />
					</div>
					<table>
						<tr>
							<td valign="top" style="width:600px">
								<div class="chart">
									<canvas id="mycanvas"></canvas>
								</div>
							</td>
							<td valign="top">
								<table class="table table-bordered" id="stab">
									<thead>
										<tr>
											<td align="center" colspan=5><b>What-If Scenario</b></td>
										</tr>
										<tr>
											<td><b>Month</b></td>
											<td><b>Sales QTY</b></td>
											<td><b>Import QTY</b></td>
											<td><b>Closing Stock</b></td>
											<td><b>Stock Value</b></td>
											<td align="center"><b>Change Import</b></td>
											<td align="center"><b>Change Sales</b></td>

										</tr>
									</thead>
									<tbody>
										<tr>
											<td align="left" id="m0"><b>-</b></td>
											<td align="right" id="sl0"></td>
											<td align="right" id="im0"></td>
											<td align="right" id="st0"></td>
											<td align="right" id="sv0"></td>
											<td align="center"><input size="10" type="number" data-bind="value:cim0"  min="0" style="text-align: right; " type="text" id="cim0" /></td>
											<td align="center"><input size="10" type="number" data-bind="value:csl0"  min="0" style="text-align: right; " type="text" id="csl0" /></td>
										</tr>
										<tr>
											<td align="left" id="m1"><b>-</b></td>
											<td align="right" id="sl1"></td>
											<td align="right" id="im1"></td>
											<td align="right" id="st1"></td>
											<td align="right" id="sv1"></td>
											<td align="center"><input size="10" type="number" data-bind="value:cim1" min="0" style="text-align: right; " id="cim1" /></td>
											<td align="center"><input size="10" type="number" data-bind="value:csl1"  min="0" style="text-align: right; " type="text" id="csl1" /></td>
										</tr>
										<tr>
											<td align="left" id="m2"><b>-</b></td>
											<td align="right" id="sl2"></td>
											<td align="right" id="im2"></td>
											<td align="right" id="st2"></td>
											<td align="right" id="sv2"></td>
											<td align="center"><input size="10" type="number" data-bind="value:cim2" min="0" style="text-align: right; " id="cim2" /></td>
											<td align="center"><input size="10" type="number" data-bind="value:csl2"  min="0" style="text-align: right; " type="text" id="csl2" /></td>
										</tr>
										<tr>
											<td align="left" id="m3"><b>-</b></td>
											<td align="right" id="sl3"></td>
											<td align="right" id="im3"></td>
											<td align="right" id="st3"></td>
											<td align="right" id="sv3"></td>
											<td align="center"><input size="10" type="number" data-bind="value:cim3" min="0" style="text-align: right; " id="cim3" /></td>
											<td align="center"><input size="10" type="number" data-bind="value:csl3"  min="0" style="text-align: right; " type="text" id="csl3" /></td>
										</tr>
										<tr>
											<td align="left" id="m4"><b>-</b></td>
											<td align="right" id="sl4"></td>
											<td align="right" id="im4"></td>
											<td align="right" id="st4"></td>
											<td align="right" id="sv4"></td>
											<td align="center"><input size="10" type="number" data-bind="value:cim4" min="0" style="text-align: right; " id="cim4" /></td>
											<td align="center"><input size="10" type="number" data-bind="value:csl4"  min="0" style="text-align: right; " type="text" id="csl4" /></td>
										</tr>
										<tr>
											<td align="left" id="m5"><b>-</b></td>
											<td align="right" id="sl5"></td>
											<td align="right" id="im5"></td>
											<td align="right" id="st5"></td>
											<td align="right" id="sv5"></td>
											<td align="center"><input size="10" type="number" data-bind="value:cim5" min="0" style="text-align: right; " id="cim5" /></td>
											<td align="center"><input size="10" type="number" data-bind="value:csl5"  min="0" style="text-align: right; " type="text" id="csl5" /></td>
										</tr>
										<tr>
											<td align="left" id="m6"><b>-</b></td>
											<td align="right" id="sl6"></td>
											<td align="right" id="im6"></td>
											<td align="right" id="st6"></td>
											<td align="right" id="sv6"></td>
											<td align="center"><input size="10" type="number" data-bind="value:cim6" min="0" style="text-align: right; " id="cim6" /></td>
											<td align="center"><input size="10" type="number" data-bind="value:csl6"  min="0" style="text-align: right; " type="text" id="csl6" /></td>
										</tr>
										<tr>
											<td align="left" id="m7"><b>-</b></td>
											<td align="right" id="sl7"></td>
											<td align="right" id="im7"></td>
											<td align="right" id="st7"></td>
											<td align="right" id="sv7"></td>
											<td align="center"><input size="10" type="number" data-bind="value:cim7" min="0" style="text-align: right; " id="cim7" /></td>
											<td align="center"><input size="10" type="number" data-bind="value:csl7"  min="0" style="text-align: right; " type="text" id="csl7" /></td>
										</tr>
										<tr>
											<td align="left" id="m8"><b>-</b></td>
											<td align="right" id="sl8"></td>
											<td align="right" id="im8"></td>
											<td align="right" id="st8"></td>
											<td align="right" id="sv8"></td>
											<td align="center"><input size="10" type="number" data-bind="value:cim8" min="0" style="text-align: right; " id="cim8" /></td>
											<td align="center"><input size="10" type="number" data-bind="value:csl8"  min="0" style="text-align: right; " type="text" id="csl8" /></td>
										</tr>
										<tr>
											<td align="left" id="m9"><b>-</b></td>
											<td align="right" id="sl9"></td>
											<td align="right" id="im9"></td>
											<td align="right" id="st9"></td>
											<td align="right" id="sv9"></td>
											<td align="center"><input size="10" type="number" data-bind="value:cim9" min="0" style="text-align: right; " id="cim9" /></td>
											<td align="center"><input size="10" type="number" data-bind="value:csl9"  min="0" style="text-align: right; " type="text" id="csl9" /></td>
										</tr>
										<tr>
											<td align="left" id="m10"><b>-</b></td>
											<td align="right" id="sl10"></td>
											<td align="right" id="im10"></td>
											<td align="right" id="st10"></td>
											<td align="right" id="sv10"></td>
											<td align="center"><input size="10" type="number" data-bind="value:cim10" min="0" style="text-align: right; " id="cim10" /></td>
											<td align="center"><input size="10" type="number" data-bind="value:csl10"  min="0" style="text-align: right; " type="text" id="csl10" /></td>
										</tr>
										<tr>
											<td align="left" id="m11"><b>-</b></td>
											<td align="right" id="sl11"></td>
											<td align="right" id="im11"></td>
											<td align="right" id="st11"></td>
											<td align="right" id="sv11"></td>
											<td align="center"><input size="10" type="number" data-bind="value:cim11"  min="0" style="text-align: right; " id="cim11" /></td>
											<td align="center"><input size="10" type="number" data-bind="value:csl11"  min="0" style="text-align: right; " type="text" id="csl11" /></td>
										</tr>
									</tbody>
								</table>
								<b>Current Stock Price:</b> <input id="stval" type="text" />
							</td>
						</tr>

					</table>



				</div>
			</div>
		</div>
		<p id="xd1"></p>
		<p id="xd2"></p>
		<p id="xd3"></p>
		<p id="xd4"></p>


		<!-- Custom Script -->
		<script>
			$(document).ready(function() {
				$("select.flexselect").flexselect();

				Chart.defaults.global.defaultFontColor = '#294786';
				Chart.defaults.global.defaultFontFamily = "'Roboto Condensed', sans-serif";

				var barchk = "";

				$(function() {
					$.loadShow = function() {
						$("#run").attr("disabled", "disabled");
						$("#mycanvas").hide();
						$("#loading").show();
					};
				});

				$(function() {
					$.loadHide = function() {
						$("#run").removeAttr("disabled");
						$("#mycanvas").show();

						$("#loading").hide();
					};
				});






				$("#cim0,#cim1,#cim2,#cim3,#cim4,#cim5,#cim6,#cim7,#cim8,#cim9,#cim10,#cim11,#stval,#csl0,#csl1,#csl2,#csl3,#csl4,#csl5,#csl6,#csl7,#csl8,#csl9,#csl10,#csl11").bind("keyup change", function(e) {
					$.changeShow();
				});


				$(function() {
					$.changeShow = function() {


						var sto = parseInt($("#stab #st0").text());
						var im0 = parseInt($("#stab #im0").text());
						var sl0 = parseInt($("#stab #sl0").text());
						var scv = $('#stval').val();
						//alert( im0);	
						for (xy = 0; xy < 12; xy++) {












							$('#im' + xy).empty();
							$('#im' + xy).append($('#cim' + xy).val());


							$('#sl' + xy).empty();
							$('#sl' + xy).append($('#csl' + xy).val());

							//parseInt($("#stab #sl" + xy).text()) 

							if (xy > 0)
								sto = parseInt(sto) -  parseInt($('#csl' + xy).val()) + parseInt($('#cim' + xy).val());

							$('#st' + xy).empty();
							$('#st' + xy).append(sto);




							$('#sv' + xy).empty();
							scvm = parseInt(sto) * scv;

							$('#sv' + xy).append(scvm.toLocaleString('en-IN'));

						}

						$.remakeChart();


					};
				});


				$(function() {
					$.remakeChart = function() {


						var vyear = $('input[name=vyear]:checked').val();


						var vbar = $('input[name=vbar]:checked').val();

						vfill = true;

						if (vbar == 'line')
							vfill = false;

						var amt = [];
						var amt2 = [];
						var amt3 = [];
						var MONTHS = ['Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec', 'Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'];
						for (xy = 0; xy < 12; xy++) {

							amt[xy] = parseInt($("#stab #sl" + xy).text());
							amt2[xy] = parseInt($("#stab #st" + xy).text());
							amt3[xy] = parseInt($("#stab #im" + xy).text());

						}



						var chartdata = {
							labels: MONTHS,
							datasets: [


								{
									label: 'Sales',
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
									label: 'Stock',
									type: vbar,
									backgroundColor: '#9AD0F5',
									borderColor: '#9AD0F5',
									hoverBackgroundColor: '#9AD0F5, 1',
									hoverBorderColor: '#9AD0F5, 1',
									fill: vfill,
									data: amt2
								}

								,

								{
									label: 'Import',
									type: vbar,
									backgroundColor: '#1D1257',
									borderColor: '#1D1257',
									hoverBackgroundColor: '#1D1257, 1',
									hoverBorderColor: '#1D1257, 1',
									fill: vfill,
									data: amt3
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
												return label + ' qty';
											}
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

					};
				});



				$(function() {
					$.runShow = function() {


						var vyear = $('input[name=vyear]:checked').val();


						var vbar = $('input[name=vbar]:checked').val();

						var mat = $("#mat").val();


						vfill = true;

						if (vbar == 'line')
							vfill = false;



						$.post('modal.php?call=3', {
								'vyear': vyear,
								'mat': mat
							},

							// when the Web server responds to the request
							function(result) {
								// if the result is TRUE write a message return by the request
								if (result) {


									//alert(result);

									dtx = JSON.parse(result);


									xd1 = dtx[0];
									
									xd2 = dtx[1];

									xd3 = dtx[2];

									xd4 = dtx[3];
								

									// $('#xd1').text(xd1);

									// $('#xd2').text(xd2);

									// $('#xd3').text(xd3);

									// $('#xd4').text(xd4);

									test = JSON.parse(xd1);

									/*console.log(test);*/
									var MONTHS = ['Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec', 'Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'];
									var amt = [];
									var amt2 = [];
									var amt3 = [];

									var totpie = [];



									test2 = JSON.parse(xd2);


									var stval = JSON.parse(xd4);
									var mstval = parseInt(stval.val);
									$("#stval").val(mstval.toFixed(2));



									//	alert(test2.qty);
									//$('#xd1').text(test2.qty);





									for (var m in MONTHS) {


										var subyear = vyear.substring(2);
										var subextyear = parseInt(subyear) + 1;
										$('#m' + m).empty();
										if (m < 6) {
											$('#m' + m).append(MONTHS[m] + '-' + subyear);

										} else {
											$('#m' + m).append(MONTHS[m] + '-' + subextyear);

										}

									}



									var x = 0;
									track = test2.qty;
									imptrack=track;
									//$('#xd1').text(track);
									var prev = 0;
									for (var i in test) {
										//sales.push(test[i].january);			


										amt.push(test[i]);
										
								
									

									


									}



									test3 = JSON.parse(xd3);

									x = 0;
									track = imptrack;
									prev = 0;
									for (var i in test3) {
									
										if(x==666)
										{
											$('#xd2').text(track);
											$('#xd3').text(test3[i]);
											$('#xd4').text(test[i]);

										}

										if (x==0){

											track =  parseInt(imptrack) + parseInt(test3[i])- test[i];
											//alert(track);

										}
										else
										{ 
											track = parseInt(track) + parseInt(test3[i])- test[i];
										}
									
											

										amt2[x] = parseInt(track);





										amt3.push(test3[i]);

										x = x + 1;
										//alert(x);

									}

									//alert(track);





									for (var xy in amt) {

										var scv = $('#stval').val();


										$('#sl' + xy).empty();
										$('#sl' + xy).append(parseInt(amt[xy]));

										$('#st' + xy).empty();
										$('#st' + xy).append(parseInt(amt2[xy]));

										$('#sv' + xy).empty();
										scvm = parseInt(amt2[xy]) * scv;

										$('#sv' + xy).append(scvm.toLocaleString('en-IN'));



										$('#im' + xy).empty();
										$('#im' + xy).append(parseInt(amt3[xy]));

										$('#cim' + xy).val(0);
										$('#cim' + xy).val(parseInt(amt3[xy]));


										$('#csl' + xy).val(0);
										$('#csl' + xy).val(parseInt(amt[xy]));

									}





									//Creating Bar Sales vs Target
									//-------------------------------------------------------------------------------------------------------------------------------
									var chartdata = {
										labels: MONTHS,
										datasets: [


											{
												label: 'Sales',
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
												label: 'Stock',
												type: vbar,
												backgroundColor: '#9AD0F5',
												borderColor: '#9AD0F5',
												hoverBackgroundColor: '#9AD0F5, 1',
												hoverBorderColor: '#9AD0F5, 1',
												fill: vfill,
												data: amt2
											}

											,

											{
												label: 'Import',
												type: vbar,
												backgroundColor: '#1D1257',
												borderColor: '#1D1257',
												hoverBackgroundColor: '#1D1257, 1',
												hoverBorderColor: '#1D1257, 1',
												fill: vfill,
												data: amt3
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
															return label + ' qty';
														}
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






								}
							}
						);
					};
				});



				//Here it works! when you hit the run button.
				$("#cbl").click(function() {

					var vyear = $('input[name=vyear]:checked').val();
					var mat = $("#mat").val();

					var url = 'cbl.php?vyear=' + vyear + '&mat=' + mat;

					target = '_blank'

					window.open(url, target);


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