<?php
$id=$_GET['id'];

if($id==20)
$lbl='Pedrollo';
else if($id==30)
$lbl='HCP';
else if($id==50)
$lbl='BGFlow';
else if($id==60)
$lbl='ITAP';
else if($id==51)
$lbl='SAER';

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
	<script>
		$(document).ready(function(){
			Chart.defaults.global.defaultFontColor = '#294786';	
			Chart.defaults.global.defaultFontFamily = "'Roboto Condensed', sans-serif";	
		

		
			$.post('profit_query.php?id=<?php echo $id; ?>',
				  { 'x':0 },
				 function(result) { 
				
				   if (result) {
				   dtx= JSON.parse(result);
		
				   var amt = [];	
				   var year = [];
				   
				   
				   var colour = [];	
						    
					for(var i in dtx){	
					
						amt.push(dtx[i][2]);	
						colour.push('#2980b9');	
					
						
						year.push(dtx[i][0]+' '+dtx[i][1]);
						

					}
				
				   
					var chartdata = {
						labels: year,
						datasets : [              								
							
							
							{                       
		
								type: 'bar',
								backgroundColor: colour,
								borderColor: 'rgba(200, 200, 200, 0.75)',
								hoverBorderColor: 'rgba(200, 200, 200, 1)',
								data: amt
							}
							
									
							
						]
				   
					};
					
						

					var ctxgrSegment = $("#cogsSegment");
					
					new Chart(ctxgrSegment, {
						type: 'bar',
						data: chartdata,
						options: {
									scales: {
										yAxes: [{
										   ticks: {
												callback: function(label, index, labels) {
													return label+'%';
												},
												min: 0,
												max: 100,
												stepSize: 10
											}
					
										}]
									},
									 legend: {
										display: false
									}
								}

					});	
					
					$("#loading").hide();
					
					}
				}		
			);				
						
		});
	</script>			
  </head>
  <body>
	<div class="container" align="center" >
		<div class="row" ><br/>
			<div class="col-md-12">				
				<font size="4" color="#294786"><b>Month Wise <?php echo $lbl; ?> COGS Ratio</b></font>
				<div class="chart">
					<canvas id="cogsSegment"></canvas>	
				</div>
				<div id="loading" align="center">
					<img src="pic/loading.gif"/>
				</div>
							
			</div>
		</div>
	</div>
	
	
	
	<!-- Custom Script -->

  </body>
</html>



