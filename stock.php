<?php

 $fyear=2021;

$oYear=$fyear-1;

$nxtYear=$fyear+1;

$nyear=date('Y');

$ndatesegment= date('-m-d');

$today= date('Y-m-d');




$olastday=$fyear."-06-30";

$flastday=$nxtYear."-06-30";


$osdate=$oYear."-07-01";

$oedate=$fyear.$ndatesegment;

if($fyear==$nyear)
$oedate=$oYear.$ndatesegment;

if($today>$flastday)
$oedate=$olastday;


$csdate=$fyear."-07-01";

$cedate=$nyear.$ndatesegment;

if($today>$flastday)
$cedate=$flastday;

//echo $osdate." ".$oedate;
//echo "<br/>";
//echo $csdate." ".$cedate;
//Calculating Achievement




	
	

	


	


?>

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
  <body >
	<table border=2 bordercolor="#9B9EA3" >
		<tr>
			
			<td colspan=3 bgcolor="#add1e2" height="50">
			
				<font size=4 color="#404548">&nbsp;<b>Inventory</b></font>
				
				
			</td>		
		</tr>		
		<tr>
		
		
			<td align="center" colspan=3>
				<table >
					<tr>
						<td>								
							<table class="table table-striped" >
								<tr>
									<td align="center">
										<div  align="center" style="background-color:#108C08;width: 200px">
											<font size=3 color="#FFFFFF"><b>Growth Value Item Wise</b></font>
										</div>
									</td>								
								</tr>
								<tr>
									<td>
									
										<input type="radio" name='giwv' value='1' /><font size="2" color="#404548">&nbsp;Pedrollo</font>
										<input type="radio" name='giwv' value='2'  /><font size="2" color="#404548">&nbsp;Pragati</font>
										<input type="radio" name='giwv' value='3'  /><font size="2" color="#404548">&nbsp;PNL</font>	
										<input type="radio" name='giwv' value='4' checked /><font size="2" color="#404548">&nbsp;All</font>	
									
									</td>
								</tr>	
								<tr>
									<td>
										<div id="giw">
										
											<iframe scrolling="no" style="border: 0; width: 100%; height: 280px;" src="giw.php?giwv=4&csdate=<?php echo $csdate; ?>&cedate=<?php echo $cedate; ?>&osdate=<?php echo $osdate; ?>&oedate=<?php echo $oedate; ?>" ></iframe>
											
										</div>
									</td>
								</tr>
								
								</table>
							
							
							
						</td>	
						<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
						<td align="center" style="width: 800px">	
							<iframe scrolling="yes" style="border: 0; width: 100%; height: 500px; " src="inventory.php"></iframe>
						</td>
					</tr>			
				</table>
			</td>
				

		</tr>
	</table>
	

<script>
    $(document).ready(function(){	
	
		$( 'input[name="giwv"]:radio' ).change(function(){
			
			//$( "#btchart" ).empty();
			//$( "#btchart" ).append("<h1>Loading.......<\/h1>");
			var baseUrl = document.location.origin;
			//var rootUrl = baseUrl+'\/bi\/';
			//alert(rootUrl);
			var giwv = $("input[name='giwv']:checked").val(); 
			//alert(giwv);
			$( "#giw" ).empty();
			$( "#giw" ).append('<img src="pic/loading.gif" id="giwl" />');
			
			var iframe= '<iframe scrolling="no" style="border: 0; width: 100%; height: 280px;" src="giw.php?giwv='+giwv+'&csdate=<?php echo $csdate; ?>&cedate=<?php echo $cedate; ?>&osdate=<?php echo $osdate; ?>&oedate=<?php echo $oedate; ?>" ></iframe>';
			//alert(iframe);
			//$( "#giw" ).empty();
			
			
			$( "#giw" ).append(iframe);
			$('#giw iframe').load(function() { $( "#giwl" ).remove();});
	
		});
		
		
		
	});
</script>	



</body>
</html>