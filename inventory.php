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


  
$sqldiff=mysqli_query( $GLOBALS['con'] ,"select datediff(now(),'$fyear-07-01') as tot");
$rowdiff=mysqli_fetch_object($sqldiff);

$dgap= $rowdiff->tot - 40;
//echo $dgap;
$mgap= $rowdiff->tot - 15;

if($dgap>=360)
{
$monthrange="july+august+september+october+november+december+january+february+march+april+may+june";
$wpsel=("July to June");
}
else if($dgap>=300)
{
$monthrange="july+august+september+october+november+december+january+february+march+april+may";
$wpsel=("July to May");
}
else if($dgap>=270)
{
$monthrange="july+august+september+october+november+december+january+february+march+april";
$wpsel=("July to April");
}
else if($dgap>=240)
{
$monthrange="july+august+september+october+november+december+january+february+march";
$wpsel=("July to March");
}
else if($dgap>=210)
{
$monthrange="july+august+september+october+november+december+january+february";
$wpsel=("July to February");
}
else if($dgap>=180)
{
$monthrange="july+august+september+october+november+december+january";
$wpsel=("july to january");
}
else if($dgap>=150)
{
$monthrange="july+august+september+october+november+december";
$wpsel=("July to December");
}
else if($dgap>=120)
{
$monthrange="july+august+september+october+november";
$wpsel=("July to November");
}
else if($dgap>=90)
{
$monthrange="july+august+september+october";
$wpsel=("July to October");
}
else if($dgap>=60)
{
$monthrange="july+august+september";
$wpsel=("July to September");
}
else if($dgap>=30)
{
$monthrange="july+august";
$wpsel=("July to August");
}
else{
$monthrange="july";
$wpsel=("July");
}
//Costing Calculation


//Costing Calculation


$strStock="SELECT
				SPART AS id,
				division, 
				sum(if(product_type='HAWA',pv,0)) as pv ,
				sum(if(product_type='HAWA',pq,0)) as pq,
				sum(if(product_type='HALB',pv,0)) as sv,
				sum(if(product_type='HALB',pq,0)) as sq
			FROM stock_inventory
			WHERE
			SPART NOT IN (70)
				group by SPART
				ORDER BY SPART";

// Dead Stock Calculation For HAWA
$str_dead_stock_hawa = "SELECT
							SPART AS id,
							division, 
							product_type, 
							SUM(pv) as pv, 
							SUM(pq) as pq, 
							SalesVal as sv, 
							SalesQty as sq
						FROM stock_inventory
						WHERE
						SalesQty = 0.00 AND product_type = 'HAWA' AND SPART NOT IN (70)
							group by SPART, product_type
							ORDER BY SPART, product_type";

// Dead Stock Calculation For HALB
$str_dead_stock_halb = "SELECT
							SPART AS id,
							division, 
							product_type, 
							SUM(pv) as pv, 
							SUM(pq) as pq, 
							SalesVal as sv, 
							SalesQty as sq
						FROM stock_inventory
						WHERE
						SalesQty = 0.00 AND product_type = 'HALB' AND SPART NOT IN (70)
							group by SPART, product_type
							ORDER BY SPART, product_type";


// $strStock;

// array_column manual function
if (! function_exists('array_column')) {
    function array_column(array $input, $columnKey, $indexKey = null) {
        $array = array();
        foreach ($input as $value) {
            if ( !array_key_exists($columnKey, $value)) {
                trigger_error("Key \"$columnKey\" does not exist in array");
                return false;
            }
            if (is_null($indexKey)) {
                $array[] = $value[$columnKey];
            }
            else {
                if ( !array_key_exists($indexKey, $value)) {
                    trigger_error("Key \"$indexKey\" does not exist in array");
                    return false;
                }
                if ( ! is_scalar($value[$indexKey])) {
                    trigger_error("Key \"$indexKey\" does not contain scalar value");
                    return false;
                }
                $array[$value[$indexKey]] = $value[$columnKey];
            }
        }
        return $array;
    }
}



 
 
 




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




	
	





//-ITEM Growth


$str="select  sap_sales_process.spart,sum(  if(   FKDAT>='$osdate' and FKDAT<='$oedate'  ,FKIMG,0 )  ) as oldqty,
sum(  if(   FKDAT>='$csdate' and FKDAT<='$cedate'  ,FKIMG,0 )  ) as qty
from sap_sales_process 
inner join material_data on material_data.MATNR=sap_sales_process.MATNR 
where FKDAT>='$osdate' and CTAG in('CR','BD','SR')  and material_data.MTART='HAWA'
group by sap_sales_process.spart

";
//echo $str;

$pedItmTotSales=0;
$hcpItmTotSales=0;
$bgItmTotSales=0;
$itapItmTotSales=0;
$saerItmTotSales=0;
$tefItmTotSales=0;
$pentItmTotSales=0;
$maxItmTotSales=0;
$muntItmTotSales=0;
$rovItmTotSales=0;
$panelliItmTotSales=0;
$purItmTotSales=0;

$pedItmOldTotSales=0;
$hcpItmOldTotSales=0;
$bgItmOldTotSales=0;
$itapItmOldTotSales=0;
$saerItmOldTotSales=0;
$tefItmOldTotSales=0;
$pentItmOldTotSales=0;
$maxItmOldTotSales=0;
$muntItmOldTotSales=0;
$rovItmOldTotSales=0;
$panelliItmOldTotSales=0;
$purItmOldTotSales=0;
$sql=mysqli_query( $GLOBALS['con'] ,$str );
while($rowItm=mysqli_fetch_object($sql))	
{

	if($rowItm->spart==20)
	{
		$pedItmTotSales= $rowItm->qty;
		$pedItmOldTotSales= $rowItm->oldqty;
	}	
	else if($rowItm->spart==30)
	{
		$hcpItmTotSales= $rowItm->qty;
		$hcpItmOldTotSales= $rowItm->oldqty;
	}
	else if($rowItm->spart==50)
	{
		$bgItmTotSales= $rowItm->qty;
		$bgItmOldTotSales= $rowItm->oldqty;
	}
	else if($rowItm->spart==60)
	{
		$itapItmTotSales= $rowItm->qty;
		$itapItmOldTotSales= $rowItm->oldqty;
	}
	else if($rowItm->spart==51)
	{
		$saerItmTotSales= $rowItm->qty;
		$saerItmOldTotSales= $rowItm->oldqty;
	}
	else if($rowItm->spart==90)
	{
		$tefItmTotSales= $rowItm->qty;
		$tefItmOldTotSales= $rowItm->oldqty;
	}
	else if($rowItm->spart==99)
	{
		$pentItmTotSales= $rowItm->qty;
		$pentItmOldTotSales= $rowItm->oldqty;
	}
	else if($rowItm->spart==95)
	{
		$maxItmTotSales= $rowItm->qty;
		$maxItmOldTotSales= $rowItm->oldqty;
	}
	else if($rowItm->spart==80)
	{
		$muntItmTotSales= $rowItm->qty;
		$muntItmOldTotSales= $rowItm->oldqty;
	}
	else if($rowItm->spart==40)
	{
		$rovItmTotSales= $rowItm->qty;
		$rovItmOldTotSales= $rowItm->oldqty;
	}
	else if($rowItm->spart==52)
	{
		$panelliItmTotSales= $rowItm->qty;
		$panelliItmOldTotSales= $rowItm->oldqty;
	}
	else if($rowItm->spart==81)
	{
		//echo $purItmTotSales;
		$purItmTotSales= $rowItm->qty;
		$purItmOldTotSales= $rowItm->oldqty;
	}
	
	//echo " ".$rowItm->spart;

}









	
	
	


	


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

	<table border=0 width="600" class="table table-striped" >
		<tr>
			<td align="center" colspan="5">
				<div  align="center" style="background-color:#FE7D00;width: 210px">
					<font size=3 color="#FFFFFF"><b>Current Stock Brand Wise</b></font>
					
					
				</div>
				<input type="radio" name='sqtm' value='1' checked /><font size="2" color="#404548">&nbsp;Quantity</font>
				<input type="radio" name='sqtm' value='2'  /><font size="2" color="#404548">&nbsp;Value</font>
				&#124;
				<input type="radio" name='product' value='1' checked /><font size="2" color="#404548">&nbsp;Water&nbsp;Pump</font>
				<input type="radio" name='product' value='2'  /><font size="2" color="#404548">&nbsp;Other</font>
				<input type="radio" name='product' value='3'  /><font size="2" color="#404548">&nbsp;All</font>
				 
			</td>	
			<td><button onClick="window.location.reload();">↻&nbsp;Refresh</button></td>

																		
		</tr>
		<tr bgcolor="#add1e2">
			<td><font size="4" color="#404548">&nbsp;Brand&nbsp;</font></td>
			<td class="sqty" align="center"><font size="4" color="#404548">&nbsp;Product Qty&nbsp;</font>
			<br/>
				<font size="2" color="#404548">												
					in stock
				</font>
			</td>
			</td>
			<td class="sqty"><font size="4" color="#404548">&nbsp;Dead Stock&nbsp;</font></td>
			<td class="sqtv"><font size="4" color="#404548">&nbsp;Product Value&nbsp;</font></td>
			<td class="sqtv"><font size="4" color="#404548">&nbsp;Dead Stock&nbsp;</font></td>
			<td class="sqty" align="center"><font size="4" color="#404548">&nbsp;Spare Qty&nbsp;</font>
			<br/>
				<font size="2" color="#404548">												
					in stock
				</font>
			</td>
			<td class="sqty"><font size="4" color="#404548">&nbsp;Dead Stock&nbsp;</font></td>
			<td class="sqtv"><font size="4" color="#404548">&nbsp;Spare Value&nbsp;</font></td>
			<td class="sqtv"><font size="4" color="#404548">&nbsp;Dead Stock&nbsp;</font></td>
			
			<td align="center"  ><font size="4" color="#404548">&nbsp;Sales Qty&nbsp;</font>
			<br/>
				<font size="2" color="#404548">
				2020 same period
				</font>
			</td>
			
			
			
			<td align="center"  ><font size="4" color="#404548">&nbsp;Sales Qty&nbsp;</font>
			<br/>
				<font size="2" color="#404548">												
				2021 till now
				</font>
			</td>	
			
		</tr>

		<tr class="<?php echo $classname; ?>">
			<td align="left"><font size="4" color="#404548">&nbsp;&nbsp;</font></td>
			<td class="sqtv" align="center" colspan = "6">
			<?php
				$total_rowStock_pq = 0; $total_rowStock_pv = 0; $total_DeadStock_hawa_pq = 0; $total_DeadStock_hawa_pv = 0; 
				$total_rowStock_sq = 0; $total_rowStock_sv = 0; $total_DeadStock_halb_sq = 0; $total_DeadStock_halb_sv = 0;

				$sql_dead_stock_hawa=mysqli_query($GLOBALS['con'] ,$str_dead_stock_hawa);
				$all_DeadStock_hawa = array();
				while ($row = mysqli_fetch_assoc($sql_dead_stock_hawa)) {
					$all_DeadStock_hawa[] = $row;
				}

				$sql_dead_stock_halb=mysqli_query($GLOBALS['con'] ,$str_dead_stock_halb);
				$all_DeadStock_halb = array();
				while ($row = mysqli_fetch_assoc($sql_dead_stock_halb)) {
					$all_DeadStock_halb[] = $row;
				}

				// $test_search = array_search("Munters", array_column($all_DeadStock_hawa, "division"));
				// $test_search2 = array_search("Munters", array_column($all_DeadStock_halb, "division"));
				
				
				// echo "<br />";
				// print_r ($all_DeadStock_halb);
				// echo "</pre>";
				
			?>
			</td>
		</tr>
	
		<?php  
			$classname="water";
			$sqlStock=mysqli_query($GLOBALS['con'] ,$strStock);
			while($rowStock=mysqli_fetch_object($sqlStock)){
				
				if($rowStock->division=="Pedrollo" OR $rowStock->division=="HCP" OR $rowStock->division=="Rovatti" OR $rowStock->division=="BGFlow" OR $rowStock->division=="SAER" OR $rowStock->division=="Panelli"){
					$classname="water";
				}
				elseif( $rowStock->division=="ITAP" OR $rowStock->division=="Munters" OR $rowStock->division=="Pureit" OR $rowStock->division=="Teflon" OR $rowStock->division=="Maxwell" OR $rowStock->division=="Pentagono"){
					$classname="other";	
				}
				else{
					$classname = "All";
				}

				

				if($rowStock->division=="Pedrollo" OR $rowStock->division=="HCP" OR $rowStock->division=="Rovatti" OR $rowStock->division=="BGFlow" OR $rowStock->division=="SAER" OR $rowStock->division=="Panelli" OR $rowStock->division=="ITAP" OR $rowStock->division=="Munters" OR $rowStock->division=="Pureit" OR $rowStock->division=="Teflon" OR $rowStock->division=="Maxwell" OR $rowStock->division=="Pentagono")
				{
					$classname2 = "All";
				}
		?>
		<tr class="<?php echo $classname; ?>">
			<td align="left"><font size="4" color="#404548">&nbsp;<?php echo $rowStock->division; ?>&nbsp;</font></td>
			<td class="sqty" align="right">
				<a href="dead_stock_data_report.php?division='<?php echo $rowStock->division; ?>'&product_type='HAWA'&status=1" target="_blank">
				<font size="4" color="#0F6DB7"><?php echo round($rowStock->pq,0) ; ?></font>&nbsp;
				</a>
			</td>
			<td class="sqty" align="right">
			<font size="4" color="#0F6DB7">
				<?php 
					$key_pq = array_search($rowStock->division, array_column($all_DeadStock_hawa, "division")); 
				?>
					<a href="dead_stock_data_report.php?division='<?php echo $rowStock->division; ?>'&product_type='HAWA'&status=2" target="_blank"><?php echo (isset($key_pq) AND $key_pq !== false)?$all_DeadStock_hawa[$key_pq]["pq"]:0; ?></a>
			</font>
			</td>
			<td class="sqtv" align="right">
				<a href="dead_stock_data_report.php?division='<?php echo $rowStock->division; ?>'&product_type='HAWA'&status=1" target="_blank">
				<font size="4" color="#0F6DB7"><?php echo round($rowStock->pv/10000000,2); ?></font>&nbsp;
				</a>
			</td>
			<td class="sqtv" align="right">
			<font size="4" color="#0F6DB7">
				<?php 
					$key_pv = array_search($rowStock->division, array_column($all_DeadStock_hawa, "division")); 
				?>
				<a href="dead_stock_data_report.php?division='<?php echo $rowStock->division; ?>'&product_type='HAWA'&status=2" target="_blank"><?php echo (isset($key_pv) AND $key_pv !== false)?round($all_DeadStock_hawa[$key_pv]["pv"]/10000000,2):0; ?></a>
			</font>
			</td>
			<td class="sqty" align="right"><font size="4" color="#0F6DB7">
				<a href="dead_stock_data_report.php?division='<?php echo $rowStock->division; ?>'&product_type='HALB'&status=1" target="_blank">
				<?php echo round($rowStock->sq,2); ?></font>&nbsp;
				</a>
			</td>
			<td class="sqty" align="right">
			<font size="4" color="#0F6DB7">
				<?php 
					$key_sq = array_search($rowStock->division, array_column($all_DeadStock_halb, "division"));
				?>
				<a href="dead_stock_data_report.php?division='<?php echo $rowStock->division; ?>'&product_type='HALB'&status=2" target="_blank"><?php echo sprintf("%.0f", (isset($key_sq) AND $key_sq !== false)?$all_DeadStock_halb[$key_sq]["pq"]:0); ?></a>
			</font>
			</td>
			<td class="sqtv" align="right">
			<a href="dead_stock_data_report.php?division='<?php echo $rowStock->division; ?>'&product_type='HALB'&status=1" target="_blank">
			<font size="4" color="#0F6DB7"><?php echo round($rowStock->sv/10000000,2); ?></font>&nbsp;
			</a>
			</td>
			<td class="sqtv" align="right">
			<font size="4" color="#0F6DB7">
				<?php 
					$key_sv = array_search($rowStock->division, array_column($all_DeadStock_halb, "division"));
				?>
				<a href="dead_stock_data_report.php?division='<?php echo $rowStock->division; ?>'&product_type='HALB'&status=2" target="_blank"><?php echo (isset($key_sv) AND $key_sv !== false)?round($all_DeadStock_halb[$key_sv]["pv"]/10000000,2):0; ?></a>
			</font>
			</td>
			
			<td align="right"><font size="4" color="#0F6DB7">
			<a href="comparesSalesQty.php?spart=<?php echo $rowStock->id; ?>&osdate=<?php echo $osdate; ?>&oedate=<?php echo $oedate; ?>&csdate=<?php echo $csdate; ?>'&cedate='<?php echo $cedate; ?>" target="_blank" rel="noopener noreferrer">
			<?php
			 if( $rowStock->division=="Pedrollo"){ 
				echo round($pedItmOldTotSales,0) ;
			 } 
			 else if( $rowStock->division=="HCP"){ 
				echo round($hcpItmOldTotSales,0) ;
			 } 
			 else if( $rowStock->division=="Panelli"){ 
				echo round($panelliItmOldTotSales,0) ;
			 } 
			 else if( $rowStock->division=="BGFlow"){ 
				echo round($bgItmOldTotSales,0) ;
			 } 
			 else if( $rowStock->division=="SAER"){ 
				echo round($saerItmOldTotSales,0) ;
			 } 
			 else if( $rowStock->division=="ITAP"){ 
				echo round($itapItmOldTotSales,0) ;
			 } 
			 else if( $rowStock->division=="Munters"){ 
				echo round($muntItmOldTotSales,0) ;
			 } 
			 else if( $rowStock->division=="Teflon"){ 
				echo round($tefItmOldTotSales,0) ;
			 } 
			 else if( $rowStock->division=="Pentagono"){ 
				echo round($pentItmOldTotSales,0) ;
			 }
			  else if( $rowStock->division=="Maxwell"){ 
				echo round($maxItmOldTotSales,0) ;
			 }
			 
			 else if( $rowStock->division=="Pureit"){ 
				echo round($purItmOldTotSales,0) ;
			 }
			 //echo round($maxItmOldTotSales,0) ;
			 //echo "Hello";
			 ?>	
			 </a>
			</font></td>
			
			
			<td align="right"><font size="4" color="#0F6DB7">
			<?php
			 if( $rowStock->division=="Pedrollo"){ 
				echo round($pedItmTotSales,0) ;
				
				if($pedItmTotSales>$pedItmOldTotSales){ ?> <img src="pic/up.png" height="20"  /><?php }else if($pedItmOldTotSales>$pedItmTotSales){ ?><img src="pic/down.gif" height="20"  /><?php } 
				
			 } 
			 else if( $rowStock->division=="HCP"){ 
				echo round($hcpItmTotSales,0) ;
				
				if($hcpItmTotSales>$hcpItmOldTotSales){ ?> <img src="pic/up.png" height="20"  /><?php }else if($hcpItmOldTotSales>$hcpItmTotSales){ ?><img src="pic/down.gif" height="20"  /><?php } 
			 } 
			 else if( $rowStock->division=="Panelli"){ 
				echo round($panelliItmTotSales,0) ;
				if($panelliItmTotSales>$panelliItmOldTotSales){ ?> <img src="pic/up.png" height="20"  /><?php }else if($panelliItmOldTotSales>$panelliItmTotSales){ ?><img src="pic/down.gif" height="20"  /><?php } 
			 } 
			 else if( $rowStock->division=="BGFlow"){ 
				echo round($bgItmTotSales,0) ;
				if($bgItmTotSales>$bgItmOldTotSales){ ?> <img src="pic/up.png" height="20"  /><?php }else if($bgItmOldTotSales>$bgItmTotSales){ ?><img src="pic/down.gif" height="20"  /><?php } 
			 } 
			 else if( $rowStock->division=="SAER"){ 
				echo round($saerItmTotSales,0) ;
				if($saerItmTotSales>$saerItmOldTotSales){ ?> <img src="pic/up.png" height="20"  /><?php }else if($saerItmOldTotSales>$saerItmTotSales){ ?><img src="pic/down.gif" height="20"  /><?php } 
		
			 } 
			 else if( $rowStock->division=="ITAP"){ 
				echo round($itapItmTotSales,0) ;
				if($itapItmTotSales>$itapItmOldTotSales){ ?> <img src="pic/up.png" height="20"  /><?php }else if($itapItmOldTotSales>$itapItmTotSales){ ?><img src="pic/down.gif" height="20"  /><?php } 
			 } 
			 else if( $rowStock->division=="Munters"){ 
				echo round($muntItmTotSales,0) ;
				if($muntItmTotSales>$muntItmOldTotSales){ ?> <img src="pic/up.png" height="20"  /><?php }else if($muntItmOldTotSales>$muntItmTotSales){ ?><img src="pic/down.gif" height="20"  /><?php } 
			 } 
			 else if( $rowStock->division=="Teflon"){ 
				echo round($tefItmTotSales,0) ;
				if($tefItmTotSales>$tefItmOldTotSales){ ?> <img src="pic/up.png" height="20"  /><?php }else if($tefItmOldTotSales>$tefItmTotSales){ ?><img src="pic/down.gif" height="20"  /><?php } 
			 } 
			 else if( $rowStock->division=="Pentagono"){ 
				echo round($pentItmTotSales,0) ;
				if($pentItmTotSales>$pentItmOldTotSales){ ?> <img src="pic/up.png" height="20"  /><?php }else if($pentItmOldTotSales>$pentItmTotSales){ ?><img src="pic/down.gif" height="20"  /><?php } 
			 }
			  else if( $rowStock->division=="Maxwell"){ 
				echo round($maxItmTotSales,0) ;
				if($maxItmTotSales>$maxItmOldTotSales){ ?> <img src="pic/up.png" height="20"  /><?php }else if($maxItmOldTotSales>$maxItmTotSales){ ?><img src="pic/down.gif" height="20"  /><?php } 
			 }
			 
			  else if( $rowStock->division=="Pureit"){ 
				
				echo round($purItmTotSales,0) ;
				if($purItmTotSales>$purItmOldTotSales){ ?> <img src="pic/up.png" height="20"  /><?php }else if($purItmOldTotSales>$purItmTotSales){ ?><img src="pic/down.gif" height="20"  /><?php } 
			 }
			 
			 ?>	
			</font></td>
			
			
			
			
			
			
		</tr>

		<?php 
			if(isset($classname2)){ 
		?>	 
			<tr class="<?php echo $classname2; ?>">
				<td align="left"><font size="4" color="#404548">&nbsp;<?php echo $rowStock->division; ?>&nbsp;</font></td>
				<td class="sqty" align="right"><font size="4" color="#0F6DB7"><?php echo round($rowStock->pq,0) ; $total_rowStock_pq += round($rowStock->pq,0); ?></font>&nbsp;</td>
				<td class="sqty" align="right">
				<font size="4" color="#0F6DB7">
					<?php 
						$key_pq = array_search($rowStock->division, array_column($all_DeadStock_hawa, "division")); 
					?>
						<a href="dead_stock_data_report.php?division='<?php echo $rowStock->division; ?>'&product_type='HAWA'" target="_blank"><?php echo (isset($key_pq) AND $key_pq !== false)?$all_DeadStock_hawa[$key_pq]["pq"]:0; $total_DeadStock_hawa_pq += (isset($key_pq) AND $key_pq !== false)?$all_DeadStock_hawa[$key_pq]["pq"]:0;  ?></a>
				</font>
				</td>
				<td class="sqtv" align="right"><font size="4" color="#0F6DB7"><?php echo round($rowStock->pv/10000000,2); $total_rowStock_pv += round($rowStock->pv/10000000,2);?></font>&nbsp;</td>
				<td class="sqtv" align="right">
				<font size="4" color="#0F6DB7">
					<?php 
						$key_pv = array_search($rowStock->division, array_column($all_DeadStock_hawa, "division")); 
					?>
					<a href="dead_stock_data_report.php?division='<?php echo $rowStock->division; ?>'&product_type='HAWA'" target="_blank"><?php echo (isset($key_pv) AND $key_pv !== false)?round($all_DeadStock_hawa[$key_pv]["pv"]/10000000,2):0; $total_DeadStock_hawa_pv += (isset($key_pv) AND $key_pv !== false)?round($all_DeadStock_hawa[$key_pv]["pv"]/10000000,2):0; ?></a>
				</font>
				</td>
				<td class="sqty" align="right"><font size="4" color="#0F6DB7"><?php echo round($rowStock->sq,2);  $total_rowStock_sq += round($rowStock->sq,2);  ?></font>&nbsp;</td>
				<td class="sqty" align="right">
				<font size="4" color="#0F6DB7">
					<?php 
						$key_sq = array_search($rowStock->division, array_column($all_DeadStock_halb, "division"));
					?>
					<a href="dead_stock_data_report.php?division='<?php echo $rowStock->division; ?>'&product_type='HALB'" target="_blank"><?php echo sprintf("%.0f", (isset($key_sq) AND $key_sq !== false)?$all_DeadStock_halb[$key_sq]["pq"]:0); $total_DeadStock_halb_sq += (isset($key_sq) AND $key_sq !== false)?$all_DeadStock_halb[$key_sq]["pq"]:0; ?></a>
				</font>
				</td>
				<td class="sqtv" align="right"><font size="4" color="#0F6DB7"><?php echo round($rowStock->sv/10000000,2); $total_rowStock_sv += round($rowStock->sv/10000000,2); ?></font>&nbsp;</td>
				<td class="sqtv" align="right">
				<font size="4" color="#0F6DB7">
					<?php 
						$key_sv = array_search($rowStock->division, array_column($all_DeadStock_halb, "division"));
					?>
					<a href="dead_stock_data_report.php?division='<?php echo $rowStock->division; ?>'&product_type='HALB'" target="_blank"><?php echo (isset($key_sv) AND $key_sv !== false)?round($all_DeadStock_halb[$key_sv]["pv"]/10000000,2):0; $total_DeadStock_halb_sv += (isset($key_sv) AND $key_sv !== false)?round($all_DeadStock_halb[$key_sv]["pv"]/10000000,2):0 ?></a>
				</font>
				</td>
				
				<td align="right"><font size="4" color="#0F6DB7">
				<a href="comparesSalesQty.php?spart=<?php echo $rowStock->id; ?>&osdate=<?php echo $osdate; ?>&oedate=<?php echo $oedate; ?>&csdate=<?php echo $csdate; ?>'&cedate='<?php echo $cedate; ?>" target="_blank" rel="noopener noreferrer">
				<?php
					if( $rowStock->division=="Pedrollo"){ 
					echo round($pedItmOldTotSales,0) ;
					} 
					else if( $rowStock->division=="HCP"){ 
					echo round($hcpItmOldTotSales,0) ;
					} 
					else if( $rowStock->division=="Panelli"){ 
					echo round($panelliItmOldTotSales,0) ;
					} 
					else if( $rowStock->division=="BGFlow"){ 
					echo round($bgItmOldTotSales,0) ;
					} 
					else if( $rowStock->division=="SAER"){ 
					echo round($saerItmOldTotSales,0) ;
					} 
					else if( $rowStock->division=="ITAP"){ 
					echo round($itapItmOldTotSales,0) ;
					} 
					else if( $rowStock->division=="Munters"){ 
					echo round($muntItmOldTotSales,0) ;
					} 
					else if( $rowStock->division=="Teflon"){ 
					echo round($tefItmOldTotSales,0) ;
					} 
					else if( $rowStock->division=="Pentagono"){ 
					echo round($pentItmOldTotSales,0) ;
					}
					else if( $rowStock->division=="Maxwell"){ 
					echo round($maxItmOldTotSales,0) ;
					}
					
					else if( $rowStock->division=="Pureit"){ 
					echo round($purItmOldTotSales,0) ;
					}
					//echo round($maxItmOldTotSales,0) ;
					//echo "Hello";
					?>	
				</a>
				</font></td>
				
				
				<td align="right"><font size="4" color="#0F6DB7">
				<?php
					if( $rowStock->division=="Pedrollo"){ 
					echo round($pedItmTotSales,0) ;
					
					if($pedItmTotSales>$pedItmOldTotSales){ ?> <img src="pic/up.png" height="20"  /><?php }else if($pedItmOldTotSales>$pedItmTotSales){ ?><img src="pic/down.gif" height="20"  /><?php } 
					
					} 
					else if( $rowStock->division=="HCP"){ 
					echo round($hcpItmTotSales,0) ;
					
					if($hcpItmTotSales>$hcpItmOldTotSales){ ?> <img src="pic/up.png" height="20"  /><?php }else if($hcpItmOldTotSales>$hcpItmTotSales){ ?><img src="pic/down.gif" height="20"  /><?php } 
					} 
					else if( $rowStock->division=="Panelli"){ 
					echo round($panelliItmTotSales,0) ;
					if($panelliItmTotSales>$panelliItmOldTotSales){ ?> <img src="pic/up.png" height="20"  /><?php }else if($panelliItmOldTotSales>$panelliItmTotSales){ ?><img src="pic/down.gif" height="20"  /><?php } 
					} 
					else if( $rowStock->division=="BGFlow"){ 
					echo round($bgItmTotSales,0) ;
					if($bgItmTotSales>$bgItmOldTotSales){ ?> <img src="pic/up.png" height="20"  /><?php }else if($bgItmOldTotSales>$bgItmTotSales){ ?><img src="pic/down.gif" height="20"  /><?php } 
					} 
					else if( $rowStock->division=="SAER"){ 
					echo round($saerItmTotSales,0) ;
					if($saerItmTotSales>$saerItmOldTotSales){ ?> <img src="pic/up.png" height="20"  /><?php }else if($saerItmOldTotSales>$saerItmTotSales){ ?><img src="pic/down.gif" height="20"  /><?php } 
			
					} 
					else if( $rowStock->division=="ITAP"){ 
					echo round($itapItmTotSales,0) ;
					if($itapItmTotSales>$itapItmOldTotSales){ ?> <img src="pic/up.png" height="20"  /><?php }else if($itapItmOldTotSales>$itapItmTotSales){ ?><img src="pic/down.gif" height="20"  /><?php } 
					} 
					else if( $rowStock->division=="Munters"){ 
					echo round($muntItmTotSales,0) ;
					if($muntItmTotSales>$muntItmOldTotSales){ ?> <img src="pic/up.png" height="20"  /><?php }else if($muntItmOldTotSales>$muntItmTotSales){ ?><img src="pic/down.gif" height="20"  /><?php } 
					} 
					else if( $rowStock->division=="Teflon"){ 
					echo round($tefItmTotSales,0) ;
					if($tefItmTotSales>$tefItmOldTotSales){ ?> <img src="pic/up.png" height="20"  /><?php }else if($tefItmOldTotSales>$tefItmTotSales){ ?><img src="pic/down.gif" height="20"  /><?php } 
					} 
					else if( $rowStock->division=="Pentagono"){ 
					echo round($pentItmTotSales,0) ;
					if($pentItmTotSales>$pentItmOldTotSales){ ?> <img src="pic/up.png" height="20"  /><?php }else if($pentItmOldTotSales>$pentItmTotSales){ ?><img src="pic/down.gif" height="20"  /><?php } 
					}
					else if( $rowStock->division=="Maxwell"){ 
					echo round($maxItmTotSales,0) ;
					if($maxItmTotSales>$maxItmOldTotSales){ ?> <img src="pic/up.png" height="20"  /><?php }else if($maxItmOldTotSales>$maxItmTotSales){ ?><img src="pic/down.gif" height="20"  /><?php } 
					}
					
					else if( $rowStock->division=="Pureit"){ 
					
					echo round($purItmTotSales,0) ;
					if($purItmTotSales>$purItmOldTotSales){ ?> <img src="pic/up.png" height="20"  /><?php }else if($purItmOldTotSales>$purItmTotSales){ ?><img src="pic/down.gif" height="20"  /><?php } 
					}
					
					?>	
				</font></td>
			</tr>
		<?php  } ?>
		<?php } ?>
		<tr class="<?php echo $classname2; ?>">
		
			<td align="left"><font size="4" color="#404548">&nbsp;Total&nbsp;</font></td>
			<td class="sqty" align="right"><font size="4" color="#0F6DB7"><?php echo $total_rowStock_pq ; ?></font>&nbsp;</td>
			<td class="sqty" align="right"><font size="4" color="#0F6DB7"><?php echo $total_DeadStock_hawa_pq; ?></font></td>
			<td class="sqtv" align="right"><font size="4" color="#0F6DB7"><?php echo $total_rowStock_pv; ?></font>&nbsp;</td>
			<td class="sqtv" align="right"><font size="4" color="#0F6DB7"><?php echo $total_DeadStock_hawa_pv; ?></font></td>
			<td class="sqty" align="right"><font size="4" color="#0F6DB7"><?php echo $total_rowStock_sq; ?></font>&nbsp;</td>
			<td class="sqty" align="right"><font size="4" color="#0F6DB7"><?php echo $total_DeadStock_halb_sq; ?></font>&nbsp;</td>
			<td class="sqtv" align="right"><font size="4" color="#0F6DB7"><?php echo $total_rowStock_sv; ?></font>&nbsp;</td>
			<td class="sqtv" align="right"><font size="4" color="#0F6DB7"><?php echo $total_DeadStock_halb_sv; ?></font>&nbsp;</td>
			<td class="sqtv" align="right"><font size="4" color="#0F6DB7">&nbsp;</font>&nbsp;</td>
			<td class="sqtv" align="right"><font size="4" color="#0F6DB7">&nbsp;</font>&nbsp;</td>
			<td class="sqty" align="right"><font size="4" color="#0F6DB7">&nbsp;</font>&nbsp;</td>
			<td class="sqty" align="right"><font size="4" color="#0F6DB7">&nbsp;</font>&nbsp;</td>
		</tr>
	</table>	

<script>
    $(document).ready(function(){	
	
		
				

		
		
		$( 'input[name="sqtm"]:radio' ).change(function(){
			
		
			var sqtm = $("input[name='sqtm']:checked").val(); 

			if(sqtm==1)
			{
				   $('.sqty').show();
				   $('.sqtv').hide();
			
		    }else{
				
				$('.sqtv').show();
				$('.sqty').hide();
			}		
			
	
		}); 
		$('.sqtv').hide();
		
		
		
		
		$( 'input[name="product"]:radio' ).change(function(){
			
		
			var product = $("input[name='product']:checked").val(); 

			if(product==1)
			{
				   $('.water').show();
				   $('.other').hide();
				   $('.All').hide();
			
		    }
			else if(product==2)
			{
				$('.water').hide();
				$('.other').show();
				$('.All').hide();
			}
			else
			{
				
				$('.water').hide();
				$('.other').hide();
				$('.All').show();
			}			
	
		}); 
		$('.other').hide();
		$('.All').hide();
	
		
		
	});
</script>	


<?php



function bd_money_format($num){
        $nums = explode(".",$num);
        if(count($nums)>2){
            return "0";
        }else{
        if(count($nums)==1){
            $nums[1]="00";
        }
        $num = $nums[0];
        $explrestunits = "" ;
        if(strlen($num)>3){
            $lastthree = substr($num, strlen($num)-3, strlen($num));
            $restunits = substr($num, 0, strlen($num)-3); 
            $restunits = (strlen($restunits)%2 == 1)?"0".$restunits:$restunits; 
            $expunit = str_split($restunits, 2);
            for($i=0; $i<sizeof($expunit); $i++){

                if($i==0)
                {
                    $explrestunits .= (int)$expunit[$i].","; 
                }else{
                    $explrestunits .= $expunit[$i].",";
                }
            }
            $thecash = $explrestunits.$lastthree;
        } else {
            $thecash = $num;
        }
        return $thecash.".".$nums[1]; 
        }
    }
?>

</body>
</html>