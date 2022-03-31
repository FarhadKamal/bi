<?php

include_once("db.php"); 
error_reporting(E_ALL ^ E_NOTICE); 


if(isset($_POST['pid']))
{


	$tsql=mysqli_query( $GLOBALS['con'] ,"select * from profit_center where pid='".$_POST['pid']."'");

	$trows=mysqli_fetch_object($tsql);
	
	$pid=$_POST['pid'];
	$year=$_POST['year'];
	$company=$_POST['company'];


	//and RBUKRS=$company
	if($pid!=123 ){
	$str="select hcode, account_head.head_name,
	sum(round(january,0))  as january,
	sum(round(february,0))  as february,
	sum(round(march,0))  as march,
	sum(round(april,0))  as april,
	sum(round(may,0))  as may,
	sum(round(june,0))  as june,
	sum(round(july,0))  as july,
	sum(round(august,0))  as august,
	sum(round(september,0))  as september,
	sum(round(october,0))  as october,
	sum(round(november,0))  as november,
	sum(round(december,0))  as december
	from pep_faglflext 
	inner join account_cost_center on account_cost_center.cost_id=pep_faglflext.RCNTR
	inner join account_head on account_head.hcode=pep_faglflext.RACCT
	 where RYEAR=$year  and  PRCTR='$pid' 
	and account_head in ('Administrative','Distribution','Marketing & Selling')
	group by pep_faglflext.RACCT
	";

	$str2="select 
	sum(round(january,0))  as january,
	sum(round(february,0))  as february,
	sum(round(march,0))  as march,
	sum(round(april,0))  as april,
	sum(round(may,0))  as may,
	sum(round(june,0))  as june,
	sum(round(july,0))  as july,
	sum(round(august,0))  as august,
	sum(round(september,0))  as september,
	sum(round(october,0))  as october,
	sum(round(november,0))  as november,
	sum(round(december,0))  as december
	from pep_faglflext 

	 where RYEAR=$year  and  PRCTR='$pid'  and  RACCT in (800000,800001,800005)
";


	$str3="select 
	sum(round(january,0))  as january,
	sum(round(february,0))  as february,
	sum(round(march,0))  as march,
	sum(round(april,0))  as april,
	sum(round(may,0))  as may,
	sum(round(june,0))  as june,
	sum(round(july,0))  as july,
	sum(round(august,0))  as august,
	sum(round(september,0))  as september,
	sum(round(october,0))  as october,
	sum(round(november,0))  as november,
	sum(round(december,0))  as december
	from pep_faglflext 

	 where RYEAR=$year  and  PRCTR='$pid'  and  RACCT=908220
";

	}else
		{
	$str="select hcode, account_head.head_name,
	sum(round(january,0))  as january,
	sum(round(february,0))  as february,
	sum(round(march,0))  as march,
	sum(round(april,0))  as april,
	sum(round(may,0))  as may,
	sum(round(june,0))  as june,
	sum(round(july,0))  as july,
	sum(round(august,0))  as august,
	sum(round(september,0))  as september,
	sum(round(october,0))  as october,
	sum(round(november,0))  as november,
	sum(round(december,0))  as december
	from pep_faglflext 
	inner join account_cost_center on account_cost_center.cost_id=pep_faglflext.RCNTR
	inner join account_head on account_head.hcode=pep_faglflext.RACCT
	 where RYEAR=$year  and  PRCTR in(select pid from profit_center)
	and account_head in ('Administrative','Distribution','Marketing & Selling')
	group by pep_faglflext.RACCT
	";

	$str2="select 
	sum(round(january,0))  as january,
	sum(round(february,0))  as february,
	sum(round(march,0))  as march,
	sum(round(april,0))  as april,
	sum(round(may,0))  as may,
	sum(round(june,0))  as june,
	sum(round(july,0))  as july,
	sum(round(august,0))  as august,
	sum(round(september,0))  as september,
	sum(round(october,0))  as october,
	sum(round(november,0))  as november,
	sum(round(december,0))  as december
	from pep_faglflext 

	 where RYEAR=$year  and  PRCTR in(select pid from profit_center)  and  RACCT in (800000,800001,800005)
";


	$str3="select 
	sum(round(january,0))  as january,
	sum(round(february,0))  as february,
	sum(round(march,0))  as march,
	sum(round(april,0))  as april,
	sum(round(may,0))  as may,
	sum(round(june,0))  as june,
	sum(round(july,0))  as july,
	sum(round(august,0))  as august,
	sum(round(september,0))  as september,
	sum(round(october,0))  as october,
	sum(round(november,0))  as november,
	sum(round(december,0))  as december
	from pep_faglflext 

	 where RYEAR=$year  and PRCTR in(select pid from profit_center)  and  RACCT=908220
";

	}


	//echo "<pre>";
	//echo $str;
	//echo "</pre>";



}


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

</head>
<body>
	<div class="container">
		<div class="row"><br/>
			<div class="col-md-12">




				<table class="table table-striped">
					<tr>
						<td colspan="2">
							<div  align="left" style="background-color:#59DDB5;width: 1000px">
								<font size=3 color="#FFFFFF"><b><?php if($pid==123)echo "ALL ShowRoom"; else echo $trows->centerName; ?></b></font>
								<font size=2 color="#FFFFFF"><b>Year: <?php echo $year; ?></b></font><br/>
							</div>	
						</td>
					</tr>	
					<tr valign="top">
						<td>
							


							<table style="font-size: 12px;">

								<tr>
									<td style="border: 1px solid black;" colspan="2"><font  color="#101b9d"><b></b></font></td>
									<td style="border: 1px solid black;"><font  color="#101b9d"><b>July</b></font></td>
									<td style="border: 1px solid black;"><font  color="#101b9d"><b>August</b></font></td>
									<td style="border: 1px solid black;"><font  color="#101b9d"><b>September</b></font></td>
									<td style="border: 1px solid black;"><font  color="#101b9d"><b>October</b></font></td>
									<td style="border: 1px solid black;"><font  color="#101b9d"><b>November</b></font></td>
									<td style="border: 1px solid black;"><font  color="#101b9d"><b>December</b></font></td>							
									<td style="border: 1px solid black;"><font  color="#101b9d"><b>January</b></font></td>
									<td style="border: 1px solid black;"><font  color="#101b9d"><b>February</b></font></td>
									<td style="border: 1px solid black;"><font  color="#101b9d"><b>March</b></font></td>
									<td style="border: 1px solid black;"><font  color="#101b9d"><b>April</b></font></td>
									<td style="border: 1px solid black;"><font  color="#101b9d"><b>May</b></font></td>
									<td style="border: 1px solid black;"><font  color="#101b9d"><b>June</b></font></td>
									<td style="border: 1px solid black;"><font  color="#101b9d"><b>Total</b></font></td>
								</tr>

								<?php
								$sljanuary=0;
								$slfebruary=0;
								$slmarch=0;
								$slapril=0;
								$slmay=0;
								$sljune=0;
								$sljuly=0;
								$slaugust=0;
								$slseptember=0;
								$sloctober=0;
								$slnovember=0;
								$sldecember=0;
								$sql2=mysqli_query( $GLOBALS['con'] ,$str2);
								while($row2=mysqli_fetch_object($sql2)){ 

								$sljanuary		=$row2->january*-1;
								$slfebruary		=$row2->february*-1;
								$slmarch		=$row2->march*-1;
								$slapril		=$row2->april*-1;
								$slmay			=$row2->may*-1;
								$sljune			=$row2->june*-1;
								$sljuly			=$row2->july*-1;
								$slaugust		=$row2->august*-1;
								$slseptember	=$row2->september*-1;
								$sloctober		=$row2->october*-1;
								$slnovember		=$row2->november*-1;
								$sldecember		=$row2->december*-1;	


									?>
									<tr>
									<td style="border: 1px solid black;"><font  color="#3b8c45"><b></b></font></td>	
									<td style="border: 1px solid black;"><font  color="#3b8c45"><b>Sales</b></font></td>
									<td style="border: 1px solid black;"><font  color="#3b8c45"><b><?php echo $row2->july*-1; ?></b></font></td>
									<td style="border: 1px solid black;"><font  color="#3b8c45"><b><?php echo $row2->august*-1; ?></b></font></td>
									<td style="border: 1px solid black;"><font  color="#3b8c45"><b><?php echo $row2->september*-1; ?></b></font></td>
									<td style="border: 1px solid black;"><font  color="#3b8c45"><b><?php echo $row2->october*-1; ?></b></font></td>
									<td style="border: 1px solid black;"><font  color="#3b8c45"><b><?php echo $row2->november*-1; ?></b></font></td>
									<td style="border: 1px solid black;"><font  color="#3b8c45"><b><?php echo $row2->december*-1; ?></b></font></td>
									<td style="border: 1px solid black;"><font  color="#3b8c45"><b><?php echo $row2->january*-1; ?></b></font></td>
									<td style="border: 1px solid black;"><font  color="#3b8c45"><b><?php echo $row2->february*-1; ?></b></font></td>
									<td style="border: 1px solid black;"><font  color="#3b8c45"><b><?php echo $row2->march*-1; ?></b></font></td>
									<td style="border: 1px solid black;"><font  color="#3b8c45"><b><?php echo $row2->april*-1; ?></b></font></td>
									<td style="border: 1px solid black;"><font  color="#3b8c45"><b><?php echo $row2->may*-1; ?></b></font></td>
									<td style="border: 1px solid black;"><font  color="#3b8c45"><b><?php echo $row2->june*-1; ?></b></font></td>
									

									<td style="border: 1px solid black;"><font  color="#3b8c45"><b>
										<?php 

										$totSales=($row2->january+$row2->february+$row2->march+$row2->april+$row2->may+$row2->june+$row2->july+
										$row2->august+$row2->september+$row2->october+$row2->november+$row2->december)*-1;
										echo $totSales; ?>
											
									</b></font></td>
									</tr>
								
								<?php }
								?>	


								<?php
								$cgjanuary=0;
								$cgfebruary=0;
								$cgmarch=0;
								$cgapril=0;
								$cgmay=0;
								$cgjune=0;
								$cgjuly=0;
								$cgaugust=0;
								$cgseptember=0;
								$cgoctober=0;
								$cgnovember=0;
								$cgdecember=0;
								$sql3=mysqli_query( $GLOBALS['con'] ,$str3);
								while($row3=mysqli_fetch_object($sql3)){ 

								$cgjanuary		=$row3->january;
								$cgfebruary		=$row3->february;
								$cgmarch		=$row3->march;
								$cgapril		=$row3->april;
								$cgmay			=$row3->may;
								$cgjune			=$row3->june;
								$cgjuly			=$row3->july;
								$cgaugust		=$row3->august;
								$cgseptember	=$row3->september;
								$cgoctober		=$row3->october;
								$cgnovember		=$row3->november;
								$cgdecember		=$row3->december;	


									?>

									
									<tr>
									<td style="border: 1px solid black;"><font  color="#101b9d"><b></b></font></td>	
									<td style="border: 1px solid black;"><font  color="#101b9d"><b>COGS</b></font></td>
									<td style="border: 1px solid black;"><font  color="#101b9d"><b><?php echo $row3->july; ?></b></font></td>
									<td style="border: 1px solid black;"><font  color="#101b9d"><b><?php echo $row3->august; ?></b></font></td>
									<td style="border: 1px solid black;"><font  color="#101b9d"><b><?php echo $row3->september; ?></b></font></td>
									<td style="border: 1px solid black;"><font  color="#101b9d"><b><?php echo $row3->october; ?></b></font></td>
									<td style="border: 1px solid black;"><font  color="#101b9d"><b><?php echo $row3->november; ?></b></font></td>
									<td style="border: 1px solid black;"><font  color="#101b9d"><b><?php echo $row3->december; ?></b></font></td>
									<td style="border: 1px solid black;"><font  color="#101b9d"><b><?php echo $row3->january; ?></b></font></td>
									<td style="border: 1px solid black;"><font  color="#101b9d"><b><?php echo $row3->february; ?></b></font></td>
									<td style="border: 1px solid black;"><font  color="#101b9d"><b><?php echo $row3->march; ?></b></font></td>
									<td style="border: 1px solid black;"><font  color="#101b9d"><b><?php echo $row3->april; ?></b></font></td>
									<td style="border: 1px solid black;"><font  color="#101b9d"><b><?php echo $row3->may; ?></b></font></td>
									<td style="border: 1px solid black;"><font  color="#101b9d"><b><?php echo $row3->june; ?></b></font></td>
								

									<td style="border: 1px solid black;"><font  color="#FF0000"><b>
										<?php 
										$totCOGS=($row3->january+$row3->february+$row3->march+$row3->april+$row3->may+$row3->june+$row3->july+
										$row3->august+$row3->september+$row3->october+$row3->november+$row3->december);

										echo $totCOGS; ?>
											
									</b></font></td>
									</tr>
								
								<?php }
								?>	






								<?php
								$gpjanuary=0;
								$gpfebruary=0;
								$gpmarch=0;
								$gpapril=0;
								$gpmay=0;
								$gpjune=0;
								$gpjuly=0;
								$gpaugust=0;
								$gpseptember=0;
								$gpoctober=0;
								$gpnovember=0;
								$gpdecember=0;
							

								$gpjanuary		=$sljanuary-$cgjanuary	;
								$gpfebruary		=$slfebruary-$cgfebruary	;
								$gpmarch		=$slmarch-$cgmarch	;
								$gpapril		=$slapril-$cgapril	;
								$gpmay			=$slmay-$cgmay;
								$gpjune			=$sljune-$cgjune	;
								$gpjuly			=$sljuly-$cgjuly	;
								$gpaugust		=$slaugust-$cgaugust	;
								$gpseptember	=$slseptember-$cgseptember	;
								$gpoctober		=$sloctober-$cgoctober	;
								$gpnovember		=$slnovember-$cgnovember;
								$gpdecember		=$sldecember-$cgdecember;	

									?>

									
									<tr>
									<td style="border: 1px solid black;"><font  color="#3b8c45"><b></b></font></td>	
									<td style="border: 1px solid black;"><font  color="#3b8c45"><b>Gross Profit</b></font></td>
									<td style="border: 1px solid black;"><font  color="#3b8c45"><b><?php echo $gpjuly; ?></b></font></td>
									<td style="border: 1px solid black;"><font  color="#3b8c45"><b><?php echo $gpaugust; ?></b></font></td>
									<td style="border: 1px solid black;"><font  color="#3b8c45"><b><?php echo $gpseptember; ?></b></font></td>
									<td style="border: 1px solid black;"><font  color="#3b8c45"><b><?php echo $gpoctober; ?></b></font></td>
									<td style="border: 1px solid black;"><font  color="#3b8c45"><b><?php echo $gpnovember; ?></b></font></td>
									<td style="border: 1px solid black;"><font  color="#3b8c45"><b><?php echo $gpdecember; ?></b></font></td>
									<td style="border: 1px solid black;"><font  color="#3b8c45"><b><?php echo $gpjanuary; ?></b></font></td>
									<td style="border: 1px solid black;"><font  color="#3b8c45"><b><?php echo $gpfebruary; ?></b></font></td>
									<td style="border: 1px solid black;"><font  color="#3b8c45"><b><?php echo $gpmarch; ?></b></font></td>
									<td style="border: 1px solid black;"><font  color="#3b8c45"><b><?php echo $gpapril; ?></b></font></td>
									<td style="border: 1px solid black;"><font  color="#3b8c45"><b><?php echo $gpmay; ?></b></font></td>
									<td style="border: 1px solid black;"><font  color="#3b8c45"><b><?php echo $gpjune; ?></b></font></td>
									

									<td style="border: 1px solid black;"><font  color="#3b8c45"><b>
										<?php 
										$totGross=($gpjanuary+$gpfebruary+$gpmarch+$gpapril+$gpmay+$gpjune+$gpjuly+
										$gpaugust+$gpseptember+$gpoctober+$gpnovember+$gpdecember);

										echo $totGross; ?>
											
									</b></font></td>
									</tr>
								
							




								<tr>
									<td style="border: 1px solid black;"><font  color="#101b9d"><b>Code</b></font></td>
									<td style="border: 1px solid black;" ><font  color="#101b9d"><b>Operating&nbsp;Cost</b></font></td>
									<td style="border: 1px solid black;"><font  color="#101b9d"><b></b></font></td>
									<td style="border: 1px solid black;"><font  color="#101b9d"><b></b></font></td>
									<td style="border: 1px solid black;"><font  color="#101b9d"><b></b></font></td>
									<td style="border: 1px solid black;"><font  color="#101b9d"><b></b></font></td>
									<td style="border: 1px solid black;"><font  color="#101b9d"><b></b></font></td>
									<td style="border: 1px solid black;"><font  color="#101b9d"><b></b></font></td>
									<td style="border: 1px solid black;"><font  color="#101b9d"><b></b></font></td>
									<td style="border: 1px solid black;"><font  color="#101b9d"><b></b></font></td>
									<td style="border: 1px solid black;"><font  color="#101b9d"><b></b></font></td>
									<td style="border: 1px solid black;"><font  color="#101b9d"><b></b></font></td>
									<td style="border: 1px solid black;"><font  color="#101b9d"><b></b></font></td>
									<td style="border: 1px solid black;"><font  color="#101b9d"><b></b></font></td>
									<td style="border: 1px solid black;"><font  color="#101b9d"><b></b></font></td>
								</tr>

								<?php
								$january=0;
								$february=0;
								$march=0;
								$april=0;
								$may=0;
								$june=0;
								$july=0;
								$august=0;
								$september=0;
								$october=0;
								$november=0;
								$december=0;	

								$sql=mysqli_query( $GLOBALS['con'] ,$str);
								while($row=mysqli_fetch_object($sql)){ ?>
									<tr>
									<td style="border: 1px solid black;"><font  color="#000000"><b><?php echo $row->hcode; ?></b></font></td>
									<td style="border: 1px solid black;"><font  color="#000000"><b><?php echo $row->head_name; ?></b></font></td>
									<td style="border: 1px solid black;"><font  color="#000000"><b><?php echo $row->july; ?></b></font></td>
									<td style="border: 1px solid black;"><font  color="#000000"><b><?php echo $row->august; ?></b></font></td>
									<td style="border: 1px solid black;"><font  color="#000000"><b><?php echo $row->september; ?></b></font></td>
									<td style="border: 1px solid black;"><font  color="#000000"><b><?php echo $row->october; ?></b></font></td>
									<td style="border: 1px solid black;"><font  color="#000000"><b><?php echo $row->november; ?></b></font></td>
									<td style="border: 1px solid black;"><font  color="#000000"><b><?php echo $row->december; ?></b></font></td>
									<td style="border: 1px solid black;"><font  color="#000000"><b><?php echo $row->january; ?></b></font></td>
									<td style="border: 1px solid black;"><font  color="#000000"><b><?php echo $row->february; ?></b></font></td>
									<td style="border: 1px solid black;"><font  color="#000000"><b><?php echo $row->march; ?></b></font></td>
									<td style="border: 1px solid black;"><font  color="#000000"><b><?php echo $row->april; ?></b></font></td>
									<td style="border: 1px solid black;"><font  color="#000000"><b><?php echo $row->may; ?></b></font></td>
									<td style="border: 1px solid black;"><font  color="#000000"><b><?php echo $row->june; ?></b></font></td>
									

									<td style="border: 1px solid black;"><font  color="#000000"><b>
										<?php echo $row->january+$row->february+$row->march+$row->april+$row->may+$row->june+$row->july+
										$row->august+$row->september+$row->october+$row->november+$row->december; ?>
											
									</b></font></td>
								</tr>	

								<?php
									$january=$january+$row->january;
									$february=$february+$row->february;
									$march=$march+$row->march;
									$april=$april+$row->april;
									$may=$may+$row->may;
									$june=$june+$row->june;
									$july=$july+$row->july;
									$august=$august+$row->august;
									$september=$september+$row->september;
									$october=$october+$row->october;
									$november=$november+$row->november;
									$december=$december+$row->december;


								}	
								?>


								<tr>
									<td style="border: 1px solid black;" colspan="2"><font  color="#101b9d"><b>Total</b></font></td>

									<td style="border: 1px solid black;"><font  color="#101b9d"><b><?php echo $july; ?></b></font></td>
									<td style="border: 1px solid black;"><font  color="#101b9d"><b><?php echo $august; ?></b></font></td>
									<td style="border: 1px solid black;"><font  color="#101b9d"><b><?php echo $september; ?></b></font></td>
									<td style="border: 1px solid black;"><font  color="#101b9d"><b><?php echo $october; ?></b></font></td>
									<td style="border: 1px solid black;"><font  color="#101b9d"><b><?php echo $november; ?></b></font></td>
									<td style="border: 1px solid black;"><font  color="#101b9d"><b><?php echo $december; ?></b></font></td>
									<td style="border: 1px solid black;"><font  color="#101b9d"><b><?php echo $january; ?></b></font></td>
									<td style="border: 1px solid black;"><font  color="#101b9d"><b><?php echo $february; ?></b></font></td>
									<td style="border: 1px solid black;"><font  color="#101b9d"><b><?php echo $march; ?></b></font></td>
									<td style="border: 1px solid black;"><font  color="#101b9d"><b><?php echo $april; ?></b></font></td>
									<td style="border: 1px solid black;"><font  color="#101b9d"><b><?php echo $may; ?></b></font></td>
									<td style="border: 1px solid black;"><font  color="#101b9d"><b><?php echo $june; ?></b></font></td>
									


									<td style="border: 1px solid black;"><font  color="#FF0000"><b>
										<?php 
										$totOpCost=$january+$february+$march+$april+$may+$june+$july+$august+$september+
										$october+$november+$december;

										echo $totOpCost; ?>
											
										</b></font></td>
								</tr>






								<?php
								$tdjanuary=0;
								$tdfebruary=0;
								$tdmarch=0;
								$tdapril=0;
								$tdmay=0;
								$tdjune=0;
								$tdjuly=0;
								$tdaugust=0;
								$tdseptember=0;
								$tdoctober=0;
								$tdnovember=0;
								$tddecember=0;
							

								$tdjanuary		=$gpjanuary-$january	;
								$tdfebruary		=$gpfebruary-$february	;
								$tdmarch		=$gpmarch-$march	;
								$tdapril		=$gpapril-$april	;
								$tdmay			=$gpmay-$may;
								$tdjune			=$gpjune-$june	;
								$tdjuly			=$gpjuly-$july	;
								$tdaugust		=$gpaugust-$august	;
								$tdseptember	=$gpseptember-$september	;
								$tdoctober		=$gpoctober-$october	;
								$tdnovember		=$gpnovember-$november;
								$tddecember		=$gpdecember-$december;	

									?>

									
									<tr>
									<td style="border: 1px solid black;"><font  color="#3b8c45"><b></b></font></td>	
									<td style="border: 1px solid black;"><font  color="#3b8c45"><b>Trading Profit</b></font></td>
									<td style="border: 1px solid black;"><font  color="#3b8c45"><b><?php echo $tdjuly; ?></b></font></td>
									<td style="border: 1px solid black;"><font  color="#3b8c45"><b><?php echo $tdaugust; ?></b></font></td>
									<td style="border: 1px solid black;"><font  color="#3b8c45"><b><?php echo $tdseptember; ?></b></font></td>
									<td style="border: 1px solid black;"><font  color="#3b8c45"><b><?php echo $tdoctober; ?></b></font></td>
									<td style="border: 1px solid black;"><font  color="#3b8c45"><b><?php echo $tdnovember; ?></b></font></td>
									<td style="border: 1px solid black;"><font  color="#3b8c45"><b><?php echo $tddecember; ?></b></font></td>
									<td style="border: 1px solid black;"><font  color="#3b8c45"><b><?php echo $tdjanuary; ?></b></font></td>
									<td style="border: 1px solid black;"><font  color="#3b8c45"><b><?php echo $tdfebruary; ?></b></font></td>
									<td style="border: 1px solid black;"><font  color="#3b8c45"><b><?php echo $tdmarch; ?></b></font></td>
									<td style="border: 1px solid black;"><font  color="#3b8c45"><b><?php echo $tdapril; ?></b></font></td>
									<td style="border: 1px solid black;"><font  color="#3b8c45"><b><?php echo $tdmay; ?></b></font></td>
									<td style="border: 1px solid black;"><font  color="#3b8c45"><b><?php echo $tdjune; ?></b></font></td>
									

									<td style="border: 1px solid black;"><font  color="#b64bac"><b>
										<?php 
										$totNet=($tdjanuary+$tdfebruary+$tdmarch+$tdapril+$tdmay+$tdjune+$tdjuly+
										$tdaugust+$tdseptember+$tdoctober+$tdnovember+$tddecember);

										echo $totNet; ?>
											
									</b></font></td>
									</tr>




							</table>


						</td>		
					</tr>
				</table>	

				




	


	</div>
</div>
</div>







</body>

</html>



