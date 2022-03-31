<?php

include_once("db.php"); 


$stdata=			"select Last_pull_time from sap_sales_process order by Last_pull_time desc limit 1";
$sqldata=			 mysqli_query( $GLOBALS['con'] ,$stdata );
$rowdata			=mysqli_fetch_object($sqldata);
$last_pull_date=	 $rowdata->Last_pull_time;


$fyear=2021;

$oYear=$fyear-1;

$nxtYear=$fyear+1;

$nyear=date('Y');

$ndatesegment= date('-m-d');

$today= date('Y-m-d');

/*temp
$nyear=2019;

$ndatesegment= '-06-30';

$today= '2019-06-30';
temp */

//$date1=date_create("$fyear-07-02");
//echo $date1;
//908220
//908081
// 


 




/*  TESTING
$nyear=2018;

$ndatesegment= '-01-07';

$today= '2018-01-07';
*/



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




	
	





//-Business Growth

$str="select ifnull(sum(NETWR),0) as tot from sap_sales_process where FKDAT>='$osdate' and FKDAT<='$oedate' and CTAG in('CR','BD','SR')";
$sql=mysqli_query( $GLOBALS['con'] ,$str );
$rowOldtot=mysqli_fetch_object($sql);	

$str="select ifnull(sum(NETWR),0) as tot from sap_sales_process where FKDAT>='$csdate' and FKDAT<='$cedate' and CTAG in('CR','BD','SR')";	
$sql=mysqli_query( $GLOBALS['con'] ,$str );
$rowCurtot=mysqli_fetch_object($sql);

$prevSales	=$rowOldtot->tot;
$curSales	=$rowCurtot->tot;
$diffSales	=$curSales-$prevSales;
$growthPercent=  round(($diffSales/$prevSales)*100,2);


//CR Growth

$str="select ifnull(sum(NETWR),0) as tot from sap_sales_process where FKDAT>='$osdate' and FKDAT<='$oedate' and CTAG in('CR')";
$sql=mysqli_query( $GLOBALS['con'] ,$str );
$rowOldtotCR=mysqli_fetch_object($sql);	

$str="select ifnull(sum(NETWR),0) as tot from sap_sales_process where FKDAT>='$csdate' and FKDAT<='$cedate' and CTAG in('CR')";	
$sql=mysqli_query( $GLOBALS['con'] ,$str );
$rowCurtotCR=mysqli_fetch_object($sql);

$prevSalesCR		=$rowOldtotCR->tot;
$curSalesCR			=$rowCurtotCR->tot;
$diffSalesCR		=$curSalesCR-$prevSalesCR;
$growthPercentCR	=  round(($diffSalesCR/$prevSalesCR)*100,2);



//BD Growth

$str="select ifnull(sum(NETWR),0) as tot from sap_sales_process where FKDAT>='$osdate' and FKDAT<='$oedate' and CTAG in('BD')";
$sql=mysqli_query( $GLOBALS['con'] ,$str );
$rowOldtotBD=mysqli_fetch_object($sql);	

$str="select ifnull(sum(NETWR),0) as tot from sap_sales_process where FKDAT>='$csdate' and FKDAT<='$cedate' and CTAG in('BD')";	
$sql=mysqli_query( $GLOBALS['con'] ,$str );
$rowCurtotBD=mysqli_fetch_object($sql);

$prevSalesBD		=$rowOldtotBD->tot;
$curSalesBD			=$rowCurtotBD->tot;
$diffSalesBD		=$curSalesBD-$prevSalesBD;
$growthPercentBD	=  round(($diffSalesBD/$prevSalesBD)*100,2);



//SR Growth

$str="select ifnull(sum(NETWR),0) as tot from sap_sales_process where FKDAT>='$osdate' and FKDAT<='$oedate' and CTAG in('SR')";
$sql=mysqli_query( $GLOBALS['con'] ,$str );
$rowOldtotSR=mysqli_fetch_object($sql);	

$str="select ifnull(sum(NETWR),0) as tot from sap_sales_process where FKDAT>='$csdate' and FKDAT<='$cedate' and CTAG in('SR')";	
$sql=mysqli_query( $GLOBALS['con'] ,$str );
$rowCurtotSR=mysqli_fetch_object($sql);

$prevSalesSR		=$rowOldtotSR->tot;
$curSalesSR			=$rowCurtotSR->tot;
$diffSalesSR		=$curSalesSR-$prevSalesSR;
$growthPercentSR	=  round(($diffSalesSR/$prevSalesSR)*100,2);









//PED Growth

$str="select ifnull(sum(NETWR),0) as tot from sap_sales_process where FKDAT>='$osdate' and FKDAT<='$oedate' and CTAG in('CR') and BUKRS=1000";
$sql=mysqli_query( $GLOBALS['con'] ,$str );
$rowOldtotPED=mysqli_fetch_object($sql);	

$str="select ifnull(sum(NETWR),0) as tot from sap_sales_process where FKDAT>='$csdate' and FKDAT<='$cedate' and CTAG in('CR') and BUKRS=1000";	
$sql=mysqli_query( $GLOBALS['con'] ,$str );
$rowCurtotPED=mysqli_fetch_object($sql);

$prevSalesPED		=$rowOldtotPED->tot;
$curSalesPED		=$rowCurtotPED->tot;
$diffSalesPED		=$curSalesPED-$prevSalesPED;
$growthPercentPED	=  round(($diffSalesPED/$prevSalesPED)*100,2);


//PRA Growth

$str="select ifnull(sum(NETWR),0) as tot from sap_sales_process where FKDAT>='$osdate' and FKDAT<='$oedate'  and ((CTAG='CR' and BUKRS=2000) or CTAG='SR')";
$sql=mysqli_query( $GLOBALS['con'] ,$str );
$rowOldtotPRA=mysqli_fetch_object($sql);	

$str="select ifnull(sum(NETWR),0) as tot from sap_sales_process where FKDAT>='$csdate' and FKDAT<='$cedate' and ((CTAG='CR' and BUKRS=2000) or CTAG='SR')";	
$sql=mysqli_query( $GLOBALS['con'] ,$str );
$rowCurtotPRA=mysqli_fetch_object($sql);

$prevSalesPRA		=$rowOldtotPRA->tot;
$curSalesPRA		=$rowCurtotPRA->tot;
$diffSalesPRA		=$curSalesPRA-$prevSalesPRA;
$growthPercentPRA	=round(($diffSalesPRA/$prevSalesPRA)*100,2);



//PNL Growth

$str="select ifnull(sum(NETWR),0) as tot from sap_sales_process where FKDAT>='$osdate' and FKDAT<='$oedate' and CTAG in('BD')";
$sql=mysqli_query( $GLOBALS['con'] ,$str );
$rowOldtotPNL=mysqli_fetch_object($sql);	

$str="select ifnull(sum(NETWR),0) as tot from sap_sales_process where FKDAT>='$csdate' and FKDAT<='$cedate' and CTAG in('BD')";	
$sql=mysqli_query( $GLOBALS['con'] ,$str );
$rowCurtotPNL=mysqli_fetch_object($sql);

$prevSalesPNL		=$rowOldtotPNL->tot;
$curSalesPNL		=$rowCurtotPNL->tot;
$diffSalesPNL		=$curSalesPNL-$prevSalesPNL;
$growthPercentPNL	=  round(($diffSalesPNL/$prevSalesPNL)*100,2);










///total Calculation-----------------------------------------------------------------------------------------

$str="select 
	sum( st.january+st.february+st.march+st.april+st.may+st.june+st.july+
	st.august+st.september+st.october+st.november+st.december) as TargetTot
	from sales_target st where st.fyear=$fyear";
$sql=mysqli_query( $GLOBALS['con'] ,$str );
$rowTargettot=mysqli_fetch_object($sql);	

$str="
	
	
	select sum(NETWR) as SalesTot
		from sap_sales_process
		
		where FYEAR = $fyear 
		   and BUKRS in(1000,2000,5000)
	
	
	
	";	
$sql=mysqli_query( $GLOBALS['con'] ,$str );
$rowSalestot=mysqli_fetch_object($sql);		
	
	
	$targetTot=$rowTargettot->TargetTot;

	$salesTot=$rowSalestot->SalesTot;
	
	$achieveNotTot=$targetTot-$salesTot;
	if($achieveNotTot<0)$achieveNotTot=0;
		
	$totPercentAchieved	= round(($salesTot/$targetTot)*100,2);
	


$str="select 
	sum( st.january+st.february+st.march+st.april+st.may+st.june+st.july+
	st.august+st.september+st.october+st.november+st.december) as TargetTot
	from sales_target st where st.fyear=$oYear";
	
	//echo $str;
$sql=mysqli_query( $GLOBALS['con'] ,$str );
$rowTargetoldtot=mysqli_fetch_object($sql);	

$str="select sum(NETWR) as SalesTot
		from sap_sales_process
		
		where FYEAR = $oYear and NETWR>0
		 and CTAG in('CR','SR','BD')";	
$sql=mysqli_query( $GLOBALS['con'] ,$str );
$rowSalesoldtot=mysqli_fetch_object($sql);		
	
	
	$targetOldTot=$rowTargetoldtot->TargetTot;

	$salesOldTot=$rowSalesoldtot->SalesTot;

	
	$achieveNotOldTot=$targetOldTot-$salesOldTot;
	if($achieveNotOldTot<0)$achieveNotOldTot=0;
		
	$totOldPercentAchieved	= round(($salesOldTot/$targetOldTot)*100,2);	
	
	

	

	
	
	
	
//PNL Achievement

$str="select 
	sum( st.january+st.february+st.march+st.april+st.may+st.june+st.july+
	st.august+st.september+st.october+st.november+st.december) as TargetTot
	from sales_target st where st.fyear=$fyear and  company=5000";
$sql=mysqli_query( $GLOBALS['con'] ,$str );
$rowTargettotPNL=mysqli_fetch_object($sql);	

$str="
	
	
	select sum(NETWR) as SalesTot
		from sap_sales_process
		
		where FKDAT>='$csdate' and FKDAT<='$cedate' 
		and BUKRS=5000 
	
	
	
	";	
$sql=mysqli_query( $GLOBALS['con'] ,$str );
$rowSalestotPNL=mysqli_fetch_object($sql);		
	
	
	$targetTotPNL=$rowTargettotPNL->TargetTot;

	$salesTotPNL=$rowSalestotPNL->SalesTot;
	
	$achieveDifTotPNL=$targetTotPNL-$salesTotPNL;
	
	if($targetTotPNL>0)
	
	$totPercentAchievedPNL = round(($salesTotPNL/$targetTotPNL)*100,2);
	
	else $totPercentAchievedPNL=0;
		

	
	
	

	
	
//PED Achievement


$str="select 
	sum( st.january+st.february+st.march+st.april+st.may+st.june+st.july+
	st.august+st.september+st.october+st.november+st.december) as TargetTot
	from sales_target st where st.fyear=$fyear and  company=1000";
$sql=mysqli_query( $GLOBALS['con'] ,$str );
$rowTargettotPED=mysqli_fetch_object($sql);	

$str="
	
	
	select sum(NETWR) as SalesTot
		from sap_sales_process
		
		where FKDAT>='$csdate' and FKDAT<='$cedate' 
		and  BUKRS=1000 
	
	
	
	";	
$sql=mysqli_query( $GLOBALS['con'] ,$str );
$rowSalestotPED=mysqli_fetch_object($sql);		
	
	
	$targetTotPED=$rowTargettotPED->TargetTot;

	$salesTotPED=$rowSalestotPED->SalesTot;
	
	$achieveDifTotPED=$targetTotPED-$salesTotPED;
	$totPercentAchievedPED = round(($salesTotPED/$targetTotPED)*100,2);
	
	
	
	
//PRA Achievement


$str="select 
	sum( st.january+st.february+st.march+st.april+st.may+st.june+st.july+
	st.august+st.september+st.october+st.november+st.december) as TargetTot
	from sales_target st where st.fyear=$fyear and company=2000";
$sql=mysqli_query( $GLOBALS['con'] ,$str );
$rowTargettotPRA=mysqli_fetch_object($sql);	

$str="
	select sum(NETWR) as SalesTot
		from sap_sales_process
		
		where FKDAT>='$csdate' and FKDAT<='$cedate'
		and  BUKRS=2000

	
	";	
$sql=mysqli_query( $GLOBALS['con'] ,$str );
$rowSalestotPRA=mysqli_fetch_object($sql);		
	
	
	$targetTotPRA=$rowTargettotPRA->TargetTot;

	$salesTotPRA=$rowSalestotPRA->SalesTot;	
	
	$achieveDifTotPRA=$targetTotPRA-$salesTotPRA;
	$totPercentAchievedPRA = round(($salesTotPRA/$targetTotPRA)*100,2);

			
	




	
//CR Achievement

$str="select 
	sum( st.january+st.february+st.march+st.april+st.may+st.june+st.july+
	st.august+st.september+st.october+st.november+st.december) as TargetTot
	from sales_target st where st.fyear=$fyear and group_tag='CR'";
$sql=mysqli_query( $GLOBALS['con'] ,$str );
$rowTargettotCR=mysqli_fetch_object($sql);	

$str="
	
		select sum(NETWR) as SalesTot
		from sap_sales_process
		
		where FYEAR = $fyear 
		 and CTAG in('CR')
	
	";	
$sql=mysqli_query( $GLOBALS['con'] ,$str );
$rowSalestotCR=mysqli_fetch_object($sql);		
	
	
	$targetTotCR=$rowTargettotCR->TargetTot;

	$salesTotCR=$rowSalestotCR->SalesTot;
	
	$achieveDifTotCR=$targetTotCR-$salesTotCR;
	
	
	$totPercentAchievedCR = round(($salesTotCR/$targetTotCR)*100,2);
		
	

	
//BD Achievement

$str="select 
	sum( st.january+st.february+st.march+st.april+st.may+st.june+st.july+
	st.august+st.september+st.october+st.november+st.december) as TargetTot
	from sales_target st where st.fyear=$fyear and group_tag='BD'";
$sql=mysqli_query( $GLOBALS['con'] ,$str );
$rowTargettotBD=mysqli_fetch_object($sql);	

$str="select sum(NETWR) as SalesTot
		from sap_sales_process
		
		where FYEAR = $fyear 
		 and CTAG in('BD')";	
$sql=mysqli_query( $GLOBALS['con'] ,$str );
$rowSalestotBD=mysqli_fetch_object($sql);		
	
	
	$targetTotBD=$rowTargettotBD->TargetTot;

	$salesTotBD=$rowSalestotBD->SalesTot;
	
	$achieveDifTotBD=$targetTotBD-$salesTotBD;

	if($targetTotBD>0)
	$totPercentAchievedBD = round(($salesTotBD/$targetTotBD)*100,2);
	else 
	$totPercentAchievedBD = 0;	
	
	
	
	
//SR Achievement

$str="select 
	sum( st.january+st.february+st.march+st.april+st.may+st.june+st.july+
	st.august+st.september+st.october+st.november+st.december) as TargetTot
	from sales_target st where st.fyear=$fyear and group_tag='SR'";
$sql=mysqli_query( $GLOBALS['con'] ,$str );
$rowTargettotSR=mysqli_fetch_object($sql);	

$str="select sum(NETWR) as SalesTot
		from sap_sales_process
		
		where FYEAR = $fyear 
		 and CTAG in('SR')";	
$sql=mysqli_query( $GLOBALS['con'] ,$str );
$rowSalestotSR=mysqli_fetch_object($sql);		
	
	
	$targetTotSR=$rowTargettotSR->TargetTot;

	$salesTotSR=$rowSalestotSR->SalesTot;
	
	$achieveDifTotSR=$targetTotSR-$salesTotSR;

	
	$totPercentAchievedSR = round(($salesTotSR/$targetTotSR)*100,2);
		

	
	
	



	
	
	


	


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
					<td colspan=3>
						<div  style="background-color:#59DDB5;text-align:left" >
							<table width="100%">
								<tr>
									<td>
										<font size="4" color="#404548"><b>&nbsp;Management&nbsp;Dashboard</b></font>
										<br/>
										<font size="2" color="#FFFFFF">&nbsp;Last pulling sales data: <b><?php echo  $last_pull_date; ?></b></font>
									</td>
								
									<td align="right">
										<table>
											<tr>
												<td align="right">	
													<font size="4" color="#FF0000">*</font><font size="2" color="#404548">&nbsp;Data Source: Previous financial year 2020 & Current financial year 2021 data (Pedrollo, PNL & Pragati)&nbsp;</font>					
												</td>
											</tr>
											<tr  >
												<td align="left">
													<font size="4" color="#FF0000">*</font><font size="2" color="#404548">&nbsp;All Monetary value is in Crore&nbsp;</font>	
													
												</td>
												<td align="right"><button onClick="window.location.reload();">↻ Refresh</button></td>
											</tr>
										</table>
									</td>
								</tr>
							</table>		
						</div>
					</td>	
				</tr>	
				<tr>
					
					
					<td valign="top" ><font size="4">
						<table class="table table-striped" >
							<tr bgcolor="B0D3E2">
								<td align="left" bgcolor="B0D3E2" ><font color="#404548"><b>Company&nbsp;wise&nbsp;achievement</b></font></td>						
							</tr>
							<tr>
								<td align="center">
									<table class="table table-striped">
									
										<tr>
											
											<td>
											
												<div  align="center" style="background-color:#59DDB5;width: 40px">
													<font size=3 color="#FFFFFF"><b>Unit</b></font>
												</div>	
								
											</td>
											
											<td>
											
												<div  align="center" style="background-color:#59DDB5;width: 60px">
													<font size=3 color="#FFFFFF"><b>Target</b></font>
												</div>	
												<font size="2" color="#404548">year&nbsp;2021</font>
											</td>
											<td>
											
												<div  align="center" style="background-color:#59DDB5;width: 70px">
													<font size=3 color="#FFFFFF"><b>Achieve</b></font>
												</div>	
											    <font size="2" color="#404548">till&nbsp;now</font>
											</td>
											<td>
											
												<div  align="center" style="background-color:#59DDB5;width: 130px">
													<font size=3 color="#FFFFFF"><b>Last Year Sales</b></font>
												</div>	
											    <font size="2" color="#404548">Same period 2020</font>
											</td>
											
										</tr>
					
										
										<tr>
											<td><font color="#404548">Pedrollo:</font></td>
											<td><font   color="#800000"><?php echo sprintf("%.2f",$targetTotPED/10000000) ?></font></td>							
											<td><font  color="#800000"><?php echo sprintf("%.2f",$salesTotPED/10000000) ?></font></td>
											<td><font  color="#800000"><?php echo sprintf("%.2f",$prevSalesPED/10000000) ?></font></td>
										</tr>
										
										<tr>
											<td><font color="#404548">Pragati:</font></td>
											<td><font   color="#800000"><?php echo sprintf("%.2f",$targetTotPRA/10000000) ?></font></td>							
											<td><font  color="#800000"><?php echo sprintf("%.2f",$salesTotPRA/10000000) ?></font></td>
											<td><font  color="#800000"><?php echo sprintf("%.2f",$prevSalesPRA/10000000) ?></font></td>
										</tr>
										
										<tr>
											<td><font color="#404548">PNL:</font></td>
											<td><font   color="#800000"><?php echo sprintf("%.2f",$targetTotPNL/10000000) ?></font></td>							
											<td><font  color="#800000"><?php echo sprintf("%.2f",$salesTotPNL/10000000) ?></font></td>
											<td><font  color="#800000"><?php echo sprintf("%.2f",$prevSalesPNL/10000000) ?></font></td>
										</tr>
								
									
									</table>
								
												<div  align="center" style="background-color:#59DDB5;width: 160px">
													<font size=3 color="#FFFFFF"><b>Target vs Achieve%</b></font>
												</div>	
												<br/>						
												<div class="chart">
													<canvas id="totSegment"></canvas>	
												</div>
											 	
								</td>
									
							</tr>
						</table></font>					
					</td>
					
					
					
					
					<td valign="top" colspan=2><font size="4">
						<table class="table table-striped" >
							<tr bgcolor="#B0D3E2">
								<td align="left" colspan=2  bgcolor="B0D3E2"><font color="#404548"><b>Overall</b></font></td>							
							</tr>
							<tr>
								<td  align="center">
									
									<table class="table table-striped" >
		
										<tr>
											<td>
											
												<div  align="center" style="background-color:#59DDB5;width: 60px">
													<font size=3 color="#FFFFFF"><b>Target</b></font>
												</div>	
												<font size="2" color="#404548">year&nbsp;2021</font>
											</td>
											<td>
											
												<div  align="center" style="background-color:#59DDB5;width: 70px">
													<font size=3 color="#FFFFFF"><b>Achieve</b></font>
												</div>	
											    <font size="2" color="#404548">till&nbsp;now</font>
											</td>
											<td>
											
												<div  align="center" style="background-color:#59DDB5;width: 130px">
													<font size=3 color="#FFFFFF"><b>Last Year Sales</b></font>
												</div>							
											    <font size="2" color="#404548">Same period 2020</font>
											</td>
										</tr>
										<tr>
										
											<td><font size="4"  color="#800000"> <?php echo sprintf("%.2f",$targetTot/10000000) ?> </font></td>
											<td><font size="4"  color="#800000"> <?php echo sprintf("%.2f",$salesTot/10000000) ?> </font></td>
											<td><font size="4" color="#800000"><?php echo sprintf("%.2f",$prevSales/10000000) ?> </font></td>											
										</tr>
										<!--
										<tr>
											<td><font size="4"  color="#FFB35F">  <?php echo round($targetOldTot/10000000,2) ?> crore</font></td>										
											<td><font size="4"  color="#FFB35F"> <?php echo round($achieveNotTot/10000000,2) ?> crore</font></td>
											<td><font size="4"  color="#FFB35F">  <?php echo round($achieveNotOldTot/10000000,2) ?> crore</font></td>
											<td><font size="4"  color="#FFB35F">  <?php echo round($salesOldTot/10000000,2) ?> crore</font></td>
										</tr>
										-->
							
									</table>
									
								</td>
								<td align="center">
									
								
									<table class="table table-striped" >
							
										
										<!--						
										<tr>
											<td><font size="4" color="#59DDB5">Current Year Sales:</font>
											<br/><font size="2" color="#404548"><?php echo $csdate." to ".$cedate; ?></font>
											</td><td><font size="4" color="#FFB35F"><?php echo round($curSales/10000000,2) ?> crore</font></td>						
										</tr>
										
										
										<tr>
											<td><font size="4" color="#59DDB5">Previous Year Sales:</font>
											<br/><font size="2" color="#404548"><?php echo $osdate." to ".$oedate; ?></font>
											</td><td><font size="4" color="#FFB35F"><?php echo round($prevSales/10000000,2) ?> crore</font></td>						
										</tr>
										-->
										<tr>
											<td>
											<div  align="center" style="background-color:#59DDB5;width: 160px">
												<font size=3 color="#FFFFFF"><b>Growth Value</b></font>
											</div>	
											<font size="2" color="#404548">Comparing with 2020</font>
											</td><td><font size="4" color="#800000"><?php echo sprintf("%.2f",$diffSales/10000000); ?> </font>
											<?php if($diffSales>0){ ?> <img src="pic/up.png" height="20"  /><?php }else if($diffSales<0){ ?><img src="pic/down.gif" height="20"  /><?php } ?>
											</td>						
										</tr>
										
										<tr>
											<td>
											<div  align="center" style="background-color:#59DDB5;width: 160px">
												<font size=3 color="#FFFFFF"><b>Growth Percentage</b></font>
											</div>
											</td><td><font size="4" color="#800000"><?php echo $growthPercent; ?>%</font>
											<?php if($growthPercent>0){ ?> <img src="pic/up.png" height="20"  /><?php }else if($growthPercent<0){ ?><img src="pic/down.gif" height="20"  /><?php } ?>
											</td>						
										</tr>
										
									</table>
									
								</td>		
								
							</tr>
							</table>
							<table width="100%">
						
							
							<tr>
								
							
								<td colspan=2 align="center">
									<div  align="center" style="background-color:#59DDB5;width: 160px">
										<font size=3 color="#FFFFFF"><b>Segment Wise</b></font>
									</div>
									<div class="chart" >
										<canvas id="segAchievement"></canvas>	
									</div>
									<div align="center"><font size="2" color="#404548">Sales & Target Values measured in Crore</font></div>
									
								</td>	
							</tr>	
							
							
						</table>
						</font>		

					
					
				</tr>
				<!-- First Tab End  -->
			</table>

<script>
    $(document).ready(function(){	
	
		
		Chart.defaults.global.defaultFontColor = '#404548';	
		Chart.defaults.global.defaultFontFamily = "'Roboto Condensed', sans-serif";	
	
		 var segAchievement = $("#segAchievement");

		 segAchievement.attr('height',100);
			var CR=<?php echo $totPercentAchievedCR; ?>;
			var BD=<?php echo $totPercentAchievedBD; ?>;
			var SR=<?php echo $totPercentAchievedSR; ?>;
			CR="CR "+CR+"%";
			BD="BD "+BD+"%";
			SR="SR "+SR+"%";
			var segdata = {
				labels: [
					CR,
					BD,
					SR
				],
				datasets: [
					
				
					
					{
						label: "Sales",
						data: [<?php echo round($salesTotCR/10000000,2) ?> , <?php echo round($salesTotBD/10000000,2) ?> ,<?php echo round($salesTotSR/10000000,2) ?> ],
						backgroundColor: 'rgba(37,135,190, 1)'
						
					},
					{
						label: "Target",
						data: [<?php echo round($targetTotCR/10000000,2) ?> , <?php echo round($targetTotBD/10000000,2) ?> ,<?php echo round($targetTotSR/10000000,2) ?> ],
					
						
						
						backgroundColor: 'rgba(173,209,226, 1)'
						
						
						
					}
					
					
					]
			};
			
			
		
		 new Chart(segAchievement, {
			type: 'horizontalBar',
			data: segdata,
			options: {
				scales: {
					 xAxes: [{
			
						ticks: {
							callback: function(label, index, labels) {
									return '';
								},
							beginAtZero: true,
							max: 110,
							
				
						}
					}],
					yAxes: [{
						stacked: true,
						barPercentage: 0.4
					}]
				},
				
				tooltips: {
								   enabled: false
							  }	
				,
				
				
			animation: {
            duration: 0,
            onComplete: function () {
                var chartInstance = this.chart,
                ctx = chartInstance.ctx;
				
                ctx.font = Chart.helpers.fontString(Chart.defaults.global.defaultFontSize, Chart.defaults.global.defaultFontStyle, Chart.defaults.global.defaultFontFamily);
                ctx.textAlign = 'left';
                ctx.textBaseline = 'bottom';

                this.data.datasets.forEach(function (dataset, i) {
                    var meta = chartInstance.controller.getDatasetMeta(i);
                    meta.data.forEach(function (bar, index) {
				//+'cr';
						
                        var data = dataset.data[index];                            
                        ctx.fillText(data, bar._model.x, bar._model.y );
                    });
                });
            }
        },	
				
				
			legend: { 
				//display: false
				
			}	

			}
		});
		
		var doughnutCenterText={
				  beforeDraw: function(chart) {
					var width = chart.chart.width,
						height = chart.chart.height,
						ctx = chart.chart.ctx;

					ctx.restore();
					var fontSize = (height /171).toFixed(2);
					ctx.font = fontSize + "em sans-serif";
					ctx.textBaseline = "middle";
					ctx.fillStyle = '#404548';

					var text = <?php echo $totPercentAchieved; ?>+"%",
						textX = Math.round((width - ctx.measureText(text).width) / 2),
						textY = height / 2;

					ctx.fillText(text, textX, textY);
					ctx.save();
				  }
				};		
		
		
		var config = {
					type: 'doughnut',
					data: {
						datasets: [{
							data: [
								<?php echo round(($salesTotPED/$targetTot)*100,2); ?>,
								<?php echo round(($salesTotPRA/$targetTot)*100,2); ?>,
								<?php echo round(($salesTotPNL/$targetTot)*100,2);  ?>,
								<?php echo round(($achieveNotTot/$targetTot)*100,2); ?>
								
					],
							backgroundColor: [
								'#0A236F',
								'#077B43',
								'#800000',
								'#EEEEEE'
							]
						}],
						labels: [
							'Pedrollo ',
							'Pragati',
							'PNL',	
							'Pending'
						] 
					},
					 plugins: [doughnutCenterText]
					,
					options: {
							 
							 cutoutPercentage: 80,
							 rotation: 3,
							 legend: {
								position: 'bottom', 
								labels: {
										filter: function(item, config) {

											return !item.text.includes('Pending');
										}
								
									}
            
								},
								
								tooltips: {
								  callbacks: {
									label: function(tooltipItem, data) {
									 
									
									 var dataset = data.datasets[tooltipItem.datasetIndex];
									
									  var currentValue = dataset.data[tooltipItem.index];
								       
								       
									  return currentValue + "%";
									},
									
									title: function(tooltipItem, data) {
										return data.labels[tooltipItem[0].index];
									  }
								  }
							  }	
						
				
						
						
					}
					
			
				};
				
				
				
				
				var ctxAchievement = $("#totAchievement");
				
								
				new Chart(ctxAchievement, config);
				
				
				



							
	var chartdata = {
                    labels: ['Pedrollo','Pragati','PNL'],
                    datasets : [              								
						
						
						{                          
							type: 'bar',
							backgroundColor: ['#0A236F','#077B43','#800000'],
							borderColor: 'rgba(200, 200, 200, 0.75)',
							hoverBorderColor: 'rgba(200, 200, 200, 1)',
                            data: [
                            <?php echo $totPercentAchievedPED; ?>,<?php echo $totPercentAchievedPRA; ?>,<?php echo $totPercentAchievedPNL; ?>
                            ]
                        }
						
		
								
						
                    ]
               
				};
				
				

	var ctxtotSegment = $("#totSegment");
	
	new Chart(ctxtotSegment, {
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
			 legend: { display: false
				
			},
			
			tooltips: {
								  callbacks: {
									label: function(tooltipItem, data) {
									 
									
									 var dataset = data.datasets[tooltipItem.datasetIndex];
									
									  var currentValue = dataset.data[tooltipItem.index];
								       
								       
									  return currentValue + "%";
									},
									
									title: function(tooltipItem, data) {
										return data.labels[tooltipItem[0].index];
									  }
								  }
							  }
		}
	});
		
				
				

		
		
	});
</script>	



</body>
</html>