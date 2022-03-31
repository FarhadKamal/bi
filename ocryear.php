
<?php
//33
include_once("db.php");



$str="

select  det.fyear,round(pedtotal/ped*100,2) as ped,
round(pratotal/pra*100,2) as pra,
round(pnltotal/pnl*100,2) as pnl,
round(ovtot/ov*100,2) as ovl


 from 
(select RYEAR as fyear,

sum(if(RBUKRS=1000,
Ycharge,0)) as pedtotal,
sum(if(RBUKRS=2000,
Ycharge,0)) as pratotal,
sum(if(RBUKRS=2000,
Ycharge,0)) as pnltotal,

sum(if(RBUKRS in(1000,2000,5000),
Ycharge,0)) as ovtot

from pep_faglflext 
inner join account_cost_center on account_cost_center.cost_id=pep_faglflext.RCNTR

where RYEAR in(2016,2017,2018,2019) and account_head in ('Administrative','Distribution','Marketing & Selling')
group by RYEAR) as det
inner join 
(select fyear,
sum(
if(company=1000,
july+august+september+october+november+december+january+february+march+april+may+june,0)) as ped,
sum(
if(company=2000,
july+august+september+october+november+december+january+february+march+april+may+june,0)) as pra,
sum(
if(company=5000,
july+august+september+october+november+december+january+february+march+april+may+june,0)) as pnl,
sum(
if(company in (1000,2000,5000),
july+august+september+october+november+december+january+february+march+april+may+june,0)) as ov

from sales_monthy 
 where   fyear in(2016,2017,2018) 
group by fyear) as det2 on det.fyear=det2.fyear";
 
 


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
  <body>
	  
	<table class="table table-striped" >	
		<tr>
								<td colspan=4 align="center">
									<font size="4" color="#294786"><b>Operating Cost Ratio</b><br/></font>
	
								</td>
		</tr>
		
		<tr>						
			<td><font size="4" color="#294786">Year</font></td>
			<td><font size="4" color="#294786">Pedrollo</font></td>
			<td><font size="4" color="#294786">Pragati</font></td>
			<td><font size="4" color="#294786">PNL</font></td>
			<td><font size="4" color="#294786">Overall</font></td>
		</tr>

			<?php 

			
		
			$sql=mysqli_query( $GLOBALS['con'] ,$str );
			while($row=mysqli_fetch_object($sql)){
			
			

			
			
		
		?>		

		<tr>	
	
			<td><font size="4" color="#CD8540"><?php echo $row->fyear; ?></font></td>
			<td><font size="4" color="#CD8540"><?php echo $row->ped; ?>%</font></td>
			<td><font size="4" color="#CD8540"><?php echo $row->pra; ?>%</font></td>
			<td><font size="4" color="#CD8540"><?php echo $row->pnl; ?>%</font></td>
			<td><font size="4" color="#CD8540"><?php echo $row->ovl; ?>%</font></td>
			
		</tr>
		<?php } ?>

	</table>	
	
  </body>
</html>	

  
