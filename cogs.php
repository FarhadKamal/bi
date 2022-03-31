<?php

include_once("db.php");

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


  
$sqldiff=mysqli_query($GLOBALS['con'], "select datediff(now(),'$fyear-07-01') as tot");
$rowdiff=mysqli_fetch_object($sqldiff);

$dgap= $rowdiff->tot - 30;
//echo $dgap;
$mgap= $rowdiff->tot - 15;

if ($dgap>=360) {
    $monthrange="july+august+september+october+november+december+january+february+march+april+may+june";
    $wpsel=("July to June");
} elseif ($dgap>=300) {
    $monthrange="july+august+september+october+november+december+january+february+march+april+may";
    $wpsel=("July to May");
} elseif ($dgap>=270) {
    $monthrange="july+august+september+october+november+december+january+february+march+april";
    $wpsel=("July to April");
} elseif ($dgap>=240) {
    $monthrange="july+august+september+october+november+december+january+february+march";
    $wpsel=("July to March");
} elseif ($dgap>=210) {
    $monthrange="july+august+september+october+november+december+january+february";
    $wpsel=("July to February");
} elseif ($dgap>=180) {
    $monthrange="july+august+september+october+november+december+january";
    $wpsel=("july to january");
} elseif ($dgap>=150) {
    $monthrange="july+august+september+october+november+december";
    $wpsel=("July to December");
} elseif ($dgap>=120) {
    $monthrange="july+august+september+october+november";
    $wpsel=("July to November");
} elseif ($dgap>=90) {
    $monthrange="july+august+september+october";
    $wpsel=("July to October");
} elseif ($dgap>=60) {
    $monthrange="july+august+september";
    $wpsel=("July to September");
} elseif ($dgap>=30) {
    $monthrange="july+august";
    $wpsel=("July to August");
} else {
    $monthrange="july";
    $wpsel=("July");
}
//Costing Calculation




$strcostYearCur="select
sum(
if(RBUKRS=1000,
$monthrange,0)) as pedtotalCurYear,
sum(
if(RBUKRS=2000,
$monthrange,0)) as pratotalCurYear,
sum(
if(RBUKRS=5000,
$monthrange,0)) as pnltotalCurYear
from pep_faglflext 
inner join account_cost_center on account_cost_center.cost_id=pep_faglflext.RCNTR
 where account_head in ('Administrative','Distribution','Marketing & Selling') and RYEAR=$fyear";
 
 
$strCogsYearCur="select fyear,
sum(
if(burks=1000,
$monthrange,0)) as pedCOGS,
sum(
if(burks=2000,
$monthrange,0)) as praCOGS,
sum(
if(burks=5000,
$monthrange,0)) as pnlCOGS
from cost_yearly 
inner join account_cost_area on account_cost_area.area_id=cost_yearly.area_id where fyear= $fyear
and cost_yearly.area_id in(6) 

";




//echo $strcostYearCur;
//echo "<br>";
//echo $strCogsYearCur;

$strcostYearOld="select
sum(
if(RBUKRS=1000,
$monthrange,0)) as pedtotalOldYear,
sum(
if(RBUKRS=2000,
$monthrange,0)) as pratotalOldYear,
sum(
if(RBUKRS=5000,
$monthrange,0)) as pnltotalOldYear
from pep_faglflext 
inner join account_cost_center on account_cost_center.cost_id=pep_faglflext.RCNTR
 where account_head in ('Administrative','Distribution','Marketing & Selling') and RYEAR=$oYear";


 $strCogsYearOld="select fyear,
sum(
if(burks=1000,
$monthrange,0)) as pedCOGS,
sum(
if(burks=2000,
$monthrange,0)) as praCOGS,
sum(
if(burks=5000,
$monthrange,0)) as pnlCOGS
from cost_yearly 
inner join account_cost_area on account_cost_area.area_id=cost_yearly.area_id where fyear= $oYear
and cost_yearly.area_id in(6) 
";
 
 
 
 
$strSalesTotYearCur="select
sum(
if(company=1000,
$monthrange,0)) as ped,
sum(
if(company=2000,
$monthrange,0)) as pra,
sum(
if(company=5000,
$monthrange,0)) as pnl
from sales_monthy 

 where  fyear=$fyear";
 
 
$strSalesTotYearOld="select
sum(
if(company=1000,
$monthrange,0)) as ped,
sum(
if(company=2000,
$monthrange,0)) as pra,
sum(
if(company=5000,
$monthrange,0)) as pnl
from sales_monthy 

 where  fyear=$oYear";
 





/*  TESTING
$nyear=2018;

$ndatesegment= '-01-07';

$today= '2018-01-07';
*/



$olastday=$fyear."-06-30";

$flastday=$nxtYear."-06-30";


$osdate=$oYear."-07-01";

$oedate=$fyear.$ndatesegment;

if ($fyear==$nyear) {
    $oedate=$oYear.$ndatesegment;
}

if ($today>$flastday) {
    $oedate=$olastday;
}


$csdate=$fyear."-07-01";

$cedate=$nyear.$ndatesegment;

if ($today>$flastday) {
    $cedate=$flastday;
}

//echo $osdate." ".$oedate;
//echo "<br/>";
//echo $csdate." ".$cedate;
//Calculating Achievement




    
    
//Year wise COGS calculation
    

$strCOGSYear="

select  det.fyear,round(pedtotal/ped*100,2) as ped,
round(pratotal/pra*100,2) as pra,
round(pnltotal/pnl*100,2) as pnl,
round(ovtot/ov*100,2) as ovl,

round(pedCOGS/ped*100,2) as pedCOGS,
round(praCOGS/pra*100,2) as praCOGS,
round(pnlCOGS/pnl*100,2) as pnlCOGS,
round(ovCOGS/ov*100,2) as ovlCOGS,

round(pedCOGS/10000000,2) as pedCGV,
round(praCOGS/10000000,2) as praCGV,
round(pnlCOGS/10000000,2) as pnlCGV,
round(ovCOGS/10000000,2) as  ovCGV,

round(ped/10000000,2) as pedSV,
round(pra/10000000,2) as praSV,
round(pnl/10000000,2) as pnlSV,
round(ov/10000000,2) as  ovSV,


round(pedtotal/10000000,2) as pedOV,
round(pratotal/10000000,2) as praOV,
round(pnltotal/10000000,2) as pnlOV,
round(ovtot/10000000,2) as  ovOV

 from 
(select RYEAR as fyear,

sum(if(RBUKRS=1000,
Ycharge,0)) as pedtotal,
sum(if(RBUKRS=2000,
Ycharge,0)) as pratotal,
sum(if(RBUKRS=5000,
Ycharge,0)) as pnltotal,

sum(if(RBUKRS in(1000,2000,5000),
Ycharge,0)) as ovtot

from pep_faglflext 
inner join account_cost_center on account_cost_center.cost_id=pep_faglflext.RCNTR

where RYEAR in(2018,2019,2020,2021) and account_head in ('Administrative','Distribution','Marketing & Selling')
group by RYEAR) as det
inner join 
(select fyear,
sum(
if( BUKRS=1000 ,
NETWR,0)) as ped,
sum(
if( BUKRS=2000,
NETWR,0)) as pra,
sum(
if( BUKRS=5000 ,
NETWR,0)) as pnl,
sum(
if(BUKRS in (1000,2000,5000),
NETWR,0)) as ov

from sap_sales_process 
 where   fyear in(2018,2019,2020,2021) 
group by fyear) as det2 on det.fyear=det2.fyear

inner join
(select fyear,
sum(
if(burks=1000,
july+august+september+october+november+december+january+february+march+april+may+june,0)) as pedCOGS,
sum(
if(burks=2000,
july+august+september+october+november+december+january+february+march+april+may+june,0)) as praCOGS,
sum(
if(burks=5000,
july+august+september+october+november+december+january+february+march+april+may+june,0)) as pnlCOGS,
sum(
if(burks in (1000,2000,5000),
july+august+september+october+november+december+january+february+march+april+may+june,0)) as ovCOGS
from cost_yearly 
inner join account_cost_area on account_cost_area.area_id=cost_yearly.area_id
 where cost_yearly.area_id in(6) and fyear in(2018,2019,2020,2021) 
 group by fyear) as det3 on det.fyear=det3.fyear

";












    
    
    


    


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






	<table border=2 bordercolor="#9B9EA3">

		<tr>
			<td colspan=3 bgcolor="#FFB35F" height="50">
				<font size="4">
					<table width="100%">
						<tr>
							<td width="50%">
								<font color="#404548"><b>&nbsp;COGS & Operating expenses</b></font>
							</td>
							<td>
								<font color="#404548">&#124;</font>

							</td>
							<td>
								<b>
									<font color="#404548">Company Wise</font>
								</b>

							</td>
							<td>
								<button onClick="window.location.reload();">↻ Refresh</button>
							</td>
						</tr>
					</table>
				</font>
			</td>
		</tr>


		<tr>
			<td valign="top" colspan=3 align="center">
				<font size="4">


					<table class="table table-striped">

						<tr>

							<td colspan=2>

								<table class="table table-striped">


									<tr>
										<td></td>
										<td colspan=4 align="center"><b>
												<font size="4" color="#0A236F">Pedrollo</font><b /></td>
										<td style="border-left: 1px solid #9B9EA3;" colspan=4 align="center"><b>
												<font size="4" color="#125b46">Pragati</font><b /></td>
										<td style="border-left: 1px solid #9B9EA3;" colspan=4 align="center"><b>
												<font size="4" color="#7c4100">PNL</font><b /></td>

									</tr>

									<tr bgcolor="#FFB35F">
										<td><b>
												<font size="4" color="#404548">&nbsp;Year&nbsp;</font>
											</b></td>
										<td>
											<font size="4" color="#404548">&nbsp;Turnover&nbsp;</font>
										</td>
										<td>
											<font size="4" color="#404548">&nbsp;COGS&nbsp;</font>
										</td>

										<td>
											<font size="4" color="#404548">&nbsp;Op&nbsp;Cost&nbsp;</font>
										</td>
										<td>
											<font size="4" color="#404548">&nbsp;GP&nbsp;</font>
										</td>


										<td style="border-left: 1px solid #9B9EA3;">
											<font size="4" color="#404548">&nbsp;Turnover&nbsp;</font>
										</td>
										<td>
											<font size="4" color="#404548">&nbsp;COGS&nbsp;</font>
										</td>

										<td>
											<font size="4" color="#404548">&nbsp;Op&nbsp;Cost&nbsp;</font>
										</td>
										<td>
											<font size="4" color="#404548">&nbsp;GP&nbsp;</font>
										</td>


										<td style="border-left: 1px solid #9B9EA3;">
											<font size="4" color="#404548">&nbsp;Turnover&nbsp;</font>
										</td>
										<td>
											<font size="4" color="#404548">&nbsp;COGS&nbsp;</font>
										</td>

										<td>
											<font size="4" color="#404548">&nbsp;Op&nbsp;Cost&nbsp;</font>
										</td>
										<td>
											<font size="4" color="#404548">&nbsp;GP&nbsp;</font>
										</td>





									</tr>

									<?php

                                                                
                                                                $x=0;
                                                                $sqlCGS=mysqli_query($GLOBALS['con'], $strCOGSYear);
                                                                while ($row=mysqli_fetch_object($sqlCGS)) {
                                                                    $ACGS[$x][0]=$row->fyear;
                                                                    $ACGS[$x][1]=$row->pedCOGS;
                                                                    $ACGS[$x][2]=$row->ped;
                                                                    $ACGS[$x][3]=$row->praCOGS;
                                                                    $ACGS[$x][4]=$row->pra;
                                                                    $ACGS[$x][5]=$row->pnlCOGS;
                                                                    $ACGS[$x][6]=$row->pnl;
                                                                    $x++; ?>

									<tr>

										<td bgcolor="#FFB35F"> <b>
												<font size="4" color="#404548">&nbsp;<?php echo $row->fyear; ?>&nbsp;
												</font>
											</b></td>

										<td>
											<font size="4" color="#0A236F">&nbsp;<?php echo $row->pedSV; ?>&nbsp;
											</font>
										</td>
										<td>
											<font size="4" color="#0A236F">&nbsp;<?php echo $row->pedCGV; ?>&nbsp;
											</font>
										</td>

										<td><a href="costdetails.php?year=<?php echo $row->fyear; ?>"
												target="about_blank">
												<font size="4" color="#0A236F">&nbsp;<?php echo $row->pedOV; ?>&nbsp;
												</font>
											</a></td>

										<td>
											<font size="4" color="#0A236F">&nbsp;<?php echo $row->pedSV-($row->pedCGV+$row->pedOV); ?>&nbsp;
											</font>
										</td>


										<td style="border-left: 1px solid #9B9EA3;">
											<font size="4" color="#125b46">&nbsp;<?php echo $row->praSV; ?>&nbsp;
											</font>
										</td>
										<td>
											<font size="4" color="#125b46">&nbsp;<?php echo $row->praCGV; ?>&nbsp;
											</font>
										</td>

										<td><a href="costdetails.php?year=<?php echo $row->fyear; ?>"
												target="about_blank">
												<font size="4" color="#125b46">&nbsp;<?php echo $row->praOV; ?>&nbsp;
												</font>
											</a></td>

										<td>
											<font size="4" color="#125b46">&nbsp;<?php echo $row->praSV-($row->praCGV+$row->praOV); ?>&nbsp;
											</font>
										</td>


										<td style="border-left: 1px solid #9B9EA3;">
											<font size="4" color="#800000">&nbsp;<?php echo $row->pnlSV; ?>&nbsp;
											</font>
										</td>
										<td>
											<font size="4" color="#800000">&nbsp;<?php echo $row->pnlCGV; ?>&nbsp;
											</font>
										</td>

										<td><a href="costdetails.php?year=<?php echo $row->fyear; ?>"
												target="about_blank">
												<font size="4" color="#800000">&nbsp;<?php echo $row->pnlOV; ?>&nbsp;
												</font>
											</a></td>
										<td>
											<font size="4" color="#800000">&nbsp;<?php echo $row->pnlSV-($row->pnlCGV+$row->pnlOV); ?>&nbsp;
											</font>
										</td>




									</tr>
									<?php
                                                                } ?>
									<tr>
										<td></td>

										<td colspan=3>

											<div class="chart">
												<canvas id="pedCGS"></canvas>
											</div>
										</td>



										<td colspan=3>

											<div class="chart">
												<canvas id="praCGS"></canvas>
											</div>
										</td>


										<td colspan=3>

											<div class="chart">
												<canvas id="pnlCGS"></canvas>
											</div>
										</td>
									</tr>

								</table>

							</td>


						</tr>
					</table>



					<div align="center">
						<font size="2" color="#404548">COGS & Operating Cost Percentage is calculated based on Turnover.
						</font>
					</div>


					<table class="table table-striped">

						<tr>

							<td>

								<table class="table table-striped" align="center">


									<tr>


										<td colspan=5 align="center"><b>
												<font size="2" color="#9b0c68">Overall</font>
											</b></td>
									</tr>

									<tr bgcolor="#FFB35F">



										<td>
											<font size="2" color="#404548">&nbsp;Year&nbsp;</font>
										</td>
										<td>
											<font size="2" color="#404548">&nbsp;Turnover&nbsp;</font>
										</td>
										<td>
											<font size="2" color="#404548">&nbsp;COGS&nbsp;</font>
										</td>

										<td>
											<font size="2" color="#404548">&nbsp;Op&nbsp;Cost&nbsp;</font>
										</td>

										<td>
											<font size="2" color="#404548">&nbsp;O.&nbsp;Profit&nbsp;</font>
										</td>

									</tr>

									<?php

                                                                
                                                                $x=0;
                                                                $sql=mysqli_query($GLOBALS['con'], $strCOGSYear);
                                                                while ($row=mysqli_fetch_object($sql)) {
                                                                    $ACGS[$x][7]=$row->ovlCOGS;
                                                                    $ACGS[$x][8]=$row->ovl;
                                                                    $x++; ?>

									<tr>

										<td bgcolor="#FFB35F">
											<font size="2" color="#404548">&nbsp;<?php echo $row->fyear; ?>&nbsp;
											</font>
										</td>



										<td>
											<font size="2" color="#9b0c68">&nbsp;<?php echo $row->ovSV; ?>&nbsp;
											</font>
										</td>
										<td>
											<font size="2" color="#9b0c68">&nbsp;<?php echo $row->ovCGV; ?>&nbsp;
											</font>
										</td>

										<td>
											<font size="2" color="#9b0c68">&nbsp;<?php echo $row->ovOV; ?>&nbsp;
											</font>
										</td>



										<td>
											<font size="2" color="#9b0c68">&nbsp;<?php echo $row->ovSV-($row->ovCGV+$row->ovOV); ?>&nbsp;
											</font>
										</td>

									</tr>
									<?php
                                                                } ?>

								</table>

							</td>

							<td>
								<br />
								<br />
								<div class="chart">
									<canvas id="ovCGS"></canvas>
								</div>
							</td>

							<td>
								<table class="table table-striped">
									<tr>
										<td colspan=7 align="center">

											<b>
												<font size="2" color="#0F6DB7">(<?php echo $wpsel; ?>)
												</font>
											</b>


										</td>
									</tr>


									<?php
                                                            $sqlcostYearCur=mysqli_query($GLOBALS['con'], $strcostYearCur);
                                                            $rowcostYearCur=mysqli_fetch_object($sqlcostYearCur);
                                                            
                                                            
                                                            
                                                            $sqlCogsYearCur=mysqli_query($GLOBALS['con'], $strCogsYearCur);
                                                            $rowCogsYearCur=mysqli_fetch_object($sqlCogsYearCur);
                                                            
                                                            $sqlCogsYearOld=mysqli_query($GLOBALS['con'], $strCogsYearOld);
                                                            $rowCogsYearOld=mysqli_fetch_object($sqlCogsYearOld);
                                                    
                                                            
                                                            
                                                            $sqlcostYearOld=mysqli_query($GLOBALS['con'], $strcostYearOld);
                                                            $rowcostYearOld=mysqli_fetch_object($sqlcostYearOld);
                                                            
                                                            
                                                            $sqlSalesTotYearCur=mysqli_query($GLOBALS['con'], $strSalesTotYearCur);
                                                            $rowSalesTotYearCur=mysqli_fetch_object($sqlSalesTotYearCur);
                                                    
                                                    
                                                            
                                                            $sqlSalesTotYearOld=mysqli_query($GLOBALS['con'], $strSalesTotYearOld);
                                                            $rowSalesTotYearOld=mysqli_fetch_object($sqlSalesTotYearOld);
                                                    
                                                            ?>
									<tr bgcolor="#FFB35F">
										<td>
											<font size="2" color="#404548">&nbsp;Company&nbsp;</font>
										</td>
										<td>
											<font size="2" color="#404548">&nbsp;Last&nbsp;Year&nbsp;COGS&nbsp;</font>
										</td>
										<td colspan=2>
											<font size="2" color="#404548">&nbsp;Cur&nbsp;COGS&nbsp;</font>
										</td>
										<td>
											<font size="2" color="#404548">&nbsp;Last&nbsp;Year&nbsp;OpCost&nbsp;</font>
										</td>
										<td colspan=2>
											<font size="2" color="#404548">&nbsp;Cur&nbsp;OpCost&nbsp;</font>
										</td>
									</tr>
									<?php
                                                            $pedoop=round(($rowcostYearOld->pedtotalOldYear/$rowSalesTotYearOld->ped)*100, 2);
                                                            $pednop=round(($rowcostYearCur->pedtotalCurYear/$rowSalesTotYearCur->ped)*100, 2);
                                            
                                                            $pedocgs=round(($rowCogsYearOld->pedCOGS/$rowSalesTotYearOld->ped)*100, 2);
                                                            $pedncgs=round(($rowCogsYearCur->pedCOGS/$rowSalesTotYearCur->ped)*100, 2);
                                                            
                                                            
                                                            
                                                            $pnloop=round(($rowcostYearOld->pnltotalOldYear/$rowSalesTotYearOld->pnl)*100, 2);
                                                            $pnlnop=round(($rowcostYearCur->pnltotalCurYear/$rowSalesTotYearCur->pnl)*100, 2);
                                                            
                                                            $pnlocgs=round(($rowCogsYearOld->pnlCOGS/$rowSalesTotYearOld->pnl)*100, 2);
                                                            $pnlncgs=round(($rowCogsYearCur->pnlCOGS/$rowSalesTotYearCur->pnl)*100, 2);
                                                            
                                                            
                                                            $praoop=round(($rowcostYearOld->pratotalOldYear/$rowSalesTotYearOld->pra)*100, 2);
                                                            $pranop=round(($rowcostYearCur->pratotalCurYear/$rowSalesTotYearCur->pra)*100, 2);
                                                            
                                                            $praocgs=round(($rowCogsYearOld->praCOGS/$rowSalesTotYearOld->pra)*100, 2);
                                                            $prancgs=round(($rowCogsYearCur->praCOGS/$rowSalesTotYearCur->pra)*100, 2);
                                                        ?>
									<tr>
										<td>
											<font size="2" color="#404548">&nbsp;Pedrollo:&nbsp;</font>
										</td>


										<td>
											<font size="2" color="#0F6DB7">&nbsp;<?php echo $pedocgs; ?>%
											</font>
										</td>
										<td>
											<font size="2" color="#0F6DB7">&nbsp;<?php echo $pedncgs ; ?>%
											</font>
										</td>
										<td>
											<?php if ($pedocgs>$pedncgs) { ?>
											<img src="pic/upd.png" height="20" /><?php } else { ?><img
												src="pic/downd.gif" height="20" /><?php } ?>
										</td>


										<td>
											<font size="2" color="#0F6DB7">&nbsp;<?php echo $pedoop; ?>%
											</font>
										</td>
										<td>
											<font size="2" color="#0F6DB7">&nbsp;<?php echo $pednop ; ?>%
											</font>
										</td>
										<td>
											<?php if ($pedoop>$pednop) { ?>
											<img src="pic/upd.png" height="20" /><?php } else { ?><img
												src="pic/downd.gif" height="20" /><?php } ?>
										</td>

									</tr>
									<tr>
										<td>
											<font size="2" color="#404548">&nbsp;PNL:</font>
										</td>
										<td>
											<font size="2" color="#0F6DB7">&nbsp;<?php echo $pnlocgs; ?>%
											</font>
										</td>
										<td>
											<font size="2" color="#0F6DB7">&nbsp;<?php echo $pnlncgs ; ?>%
											</font>
										</td>
										<td>
											<?php if ($pnlocgs>$pnlncgs) { ?>
											<img src="pic/upd.png" height="20" /><?php } else { ?><img
												src="pic/downd.gif" height="20" /><?php } ?>
										</td>

										<td>
											<font size="2" color="#0F6DB7">&nbsp;<?php echo $pnloop;?>%
											</font>
										</td>
										<td>
											<font size="2" color="#0F6DB7">&nbsp;<?php echo $pnlnop; ?>%
											</font>
										</td>
										<td>
											<?php if ($pnloop>$pnlnop) { ?>
											<img src="pic/upd.png" height="20" /><?php } else { ?><img
												src="pic/downd.gif" height="20" /><?php } ?>
										</td>

									</tr>
									<tr>
										<td>
											<font size="2" color="#404548">&nbsp;Pragati:&nbsp;</font>
										</td>

										<td>
											<font size="2" color="#0F6DB7">&nbsp;<?php echo $praocgs; ?>%
											</font>
										</td>
										<td>
											<font size="2" color="#0F6DB7">&nbsp;<?php echo $prancgs ; ?>%
											</font>
										</td>
										<td>
											<?php if ($praocgs>$prancgs) { ?>
											<img src="pic/upd.png" height="20" /><?php } else { ?><img
												src="pic/downd.gif" height="20" /><?php } ?>
										</td>


										<td>
											<font size="2" color="#0F6DB7">&nbsp;<?php echo $praoop; ?>%
											</font>
										</td>
										<td>
											<font size="2" color="#0F6DB7">&nbsp;<?php echo $pranop; ?>%
											</font>
										</td>
										<td>
											<?php if ($praoop>$pranop) { ?>
											<img src="pic/upd.png" height="20" /><?php } else { ?><img
												src="pic/downd.gif" height="20" /><?php } ?>
										</td>

									</tr>


								</table>


							</td>


						</tr>
					</table>






				</font>


			</td>
		</tr>
	</table>

	</div>






	<script>
		$(document).ready(function() {

			Chart.defaults.global.defaultFontColor = '#404548';
			Chart.defaults.global.defaultFontFamily = "'Roboto Condensed', sans-serif";






			//PedrolloCGS

			var cgsdata = {
				labels: [

					[
						['COGS',
						' OpCost'], <?php echo $ACGS[0][0]; ?>
					],
					[
						['COGS',
						' OpCost'], <?php echo $ACGS[1][0]; ?>
					],
					[
						['COGS',
						' OpCost'], <?php echo $ACGS[2][0]; ?>
					]

				],
				datasets: [


					{
						label: 'COGS',
						type: 'bar',
						backgroundColor: ['#0A236F', '#0A236F', '#0A236F'],

						data: [ <?php echo $ACGS[0][1]; ?> , <?php echo $ACGS[1][1]; ?> , <?php echo $ACGS[2][1]; ?> ]
					},


					{
						label: 'OpCost',
						type: 'bar',
						backgroundColor: ['#0A236F', '#0A236F', '#0A236F'],

						data: [ <?php echo $ACGS[0][2]; ?> , <?php echo $ACGS[1][2]; ?> , <?php echo $ACGS[2][2]; ?> ]
					}




				]

			};







			var ctxpedCGS = $("#pedCGS");



			new Chart(ctxpedCGS, {
				type: 'bar',
				data: cgsdata,
				options: {
					scales: {
						yAxes: [{
							ticks: {
								callback: function(label, index, labels) {
									return '';
								},

								min: 0,
								max: 100,
								stepSize: 10
							}

						}]
					},
					legend: {
						display: false

					},

					tooltips: {
						enabled: false

					},




					animation: {
						duration: 0,
						onComplete: function() {
							var chartInstance = this.chart,
								ctx = chartInstance.ctx;

							ctx.font = Chart.helpers.fontString(Chart.defaults.global.defaultFontSize,
								Chart.defaults.global.defaultFontStyle, Chart.defaults.global
								.defaultFontFamily);
							ctx.textAlign = 'center';
							ctx.textBaseline = 'bottom';

							this.data.datasets.forEach(function(dataset, i) {
								var meta = chartInstance.controller.getDatasetMeta(i);
								meta.data.forEach(function(bar, index) {
									var data = dataset.data[index] + '%';
									ctx.fillText(data, bar._model.x, bar._model.y - 5);
								});
							});
						}
					}



				}
			});








			//Pragati CGS

			var cgsPradata = {
				labels: [

					[
						['COGS',
						' OpCost'], <?php echo $ACGS[0][0]; ?>
					],
					[
						['COGS',
						' OpCost'], <?php echo $ACGS[1][0]; ?>
					],
					[
						['COGS',
						' OpCost'], <?php echo $ACGS[2][0]; ?>
					]

				],
				datasets: [


					{
						label: 'COGS',
						type: 'bar',
						backgroundColor: ['#077B43', '#077B43', '#077B43'],

						data: [ <?php echo $ACGS[0][3]; ?> , <?php echo $ACGS[1][3]; ?> , <?php echo $ACGS[2][3]; ?> ]
					},


					{
						label: 'OpCost',
						type: 'bar',
						backgroundColor: ['#077B43', '#077B43', '#077B43'],

						data: [ <?php echo $ACGS[0][4]; ?> , <?php echo $ACGS[1][4]; ?> , <?php echo $ACGS[2][4]; ?> ]
					}




				]

			};







			var ctxpraCGS = $("#praCGS");



			new Chart(ctxpraCGS, {
				type: 'bar',
				data: cgsPradata,
				options: {
					scales: {
						yAxes: [{
							ticks: {
								callback: function(label, index, labels) {
									return '';
								},

								min: 0,
								max: 100,
								stepSize: 10
							}

						}]
					},
					legend: {
						display: false

					},

					tooltips: {
						enabled: false

					},




					animation: {
						duration: 0,
						onComplete: function() {
							var chartInstance = this.chart,
								ctx = chartInstance.ctx;

							ctx.font = Chart.helpers.fontString(Chart.defaults.global.defaultFontSize,
								Chart.defaults.global.defaultFontStyle, Chart.defaults.global
								.defaultFontFamily);
							ctx.textAlign = 'center';
							ctx.textBaseline = 'bottom';

							this.data.datasets.forEach(function(dataset, i) {
								var meta = chartInstance.controller.getDatasetMeta(i);
								meta.data.forEach(function(bar, index) {
									var data = dataset.data[index] + '%';
									ctx.fillText(data, bar._model.x, bar._model.y - 5);
								});
							});
						}
					}



				}
			});











			//PNL CGS

			var cgsPnldata = {
				labels: [

					[
						['COGS',
						' OpCost'], <?php echo $ACGS[0][0]; ?>
					],
					[
						['COGS',
						' OpCost'], <?php echo $ACGS[1][0]; ?>
					],
					[
						['COGS',
						' OpCost'], <?php echo $ACGS[2][0]; ?>
					]

				],
				datasets: [


					{
						label: 'COGS',
						type: 'bar',
						backgroundColor: ['#800000', '#800000', '#800000'],

						data: [ <?php echo $ACGS[0][5]; ?> , <?php echo $ACGS[1][5]; ?> , <?php echo $ACGS[2][5]; ?> ]
					},


					{
						label: 'OpCost',
						type: 'bar',
						backgroundColor: ['#800000', '#800000', '#800000'],

						data: [ <?php echo $ACGS[0][6]; ?> , <?php echo $ACGS[1][6]; ?> , <?php echo $ACGS[2][6]; ?> ]
					}




				]

			};







			var ctxpnlCGS = $("#pnlCGS");



			new Chart(ctxpnlCGS, {
				type: 'bar',
				data: cgsPnldata,
				options: {
					scales: {
						yAxes: [{
							ticks: {
								callback: function(label, index, labels) {
									return '';
								},

								min: 0,
								max: 100,
								stepSize: 10
							}

						}]
					},
					legend: {
						display: false

					},

					tooltips: {
						enabled: false

					},




					animation: {
						duration: 0,
						onComplete: function() {
							var chartInstance = this.chart,
								ctx = chartInstance.ctx;

							ctx.font = Chart.helpers.fontString(Chart.defaults.global.defaultFontSize,
								Chart.defaults.global.defaultFontStyle, Chart.defaults.global
								.defaultFontFamily);
							ctx.textAlign = 'center';
							ctx.textBaseline = 'bottom';

							this.data.datasets.forEach(function(dataset, i) {
								var meta = chartInstance.controller.getDatasetMeta(i);
								meta.data.forEach(function(bar, index) {
									var data = dataset.data[index] + '%';
									ctx.fillText(data, bar._model.x, bar._model.y - 5);
								});
							});
						}
					}



				}
			});








			//Overall CGS

			var cgsOvdata = {
				labels: [

					[
						['COGS',
						' OpCost'], <?php echo $ACGS[0][0]; ?>
					],
					[
						['COGS',
						' OpCost'], <?php echo $ACGS[1][0]; ?>
					],
					[
						['COGS',
						' OpCost'], <?php echo $ACGS[2][0]; ?>
					]

				],
				datasets: [


					{
						label: 'COGS',
						type: 'bar',
						backgroundColor: ['#9b0c68', '#9b0c68', '#9b0c68'],

						data: [ <?php echo $ACGS[0][7]; ?> , <?php echo $ACGS[1][7]; ?> , <?php echo $ACGS[2][7]; ?> ]
					},


					{
						label: 'OpCost',
						type: 'bar',
						backgroundColor: ['#9b0c68', '#9b0c68', '#9b0c68'],

						data: [ <?php echo $ACGS[0][8]; ?> , <?php echo $ACGS[1][8]; ?> , <?php echo $ACGS[2][8]; ?> ]
					}




				]

			};







			var ctxovCGS = $("#ovCGS");



			new Chart(ctxovCGS, {
				type: 'bar',
				data: cgsOvdata,
				options: {
					scales: {
						yAxes: [{
							ticks: {
								callback: function(label, index, labels) {
									return '';
								},

								min: 0,
								max: 100,
								stepSize: 10
							}

						}]
					},
					legend: {
						display: false

					},

					tooltips: {
						enabled: false

					},




					animation: {
						duration: 0,
						onComplete: function() {
							var chartInstance = this.chart,
								ctx = chartInstance.ctx;

							ctx.font = Chart.helpers.fontString(Chart.defaults.global.defaultFontSize,
								Chart.defaults.global.defaultFontStyle, Chart.defaults.global
								.defaultFontFamily);
							ctx.textAlign = 'center';
							ctx.textBaseline = 'bottom';

							this.data.datasets.forEach(function(dataset, i) {
								var meta = chartInstance.controller.getDatasetMeta(i);
								meta.data.forEach(function(bar, index) {
									var data = dataset.data[index] + '%';
									ctx.fillText(data, bar._model.x, bar._model.y - 5);
								});
							});
						}
					}



				}
			});




















		});
	</script>



</body>

</html>