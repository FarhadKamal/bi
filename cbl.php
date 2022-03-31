<?php
include_once("db.php");
header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=CBL.xls;");
header("Content-Type: application/ms-excel");
header("Pragma: no-cache");
header("Expires: 0");


	
	$vyear=		$_GET['vyear'];
	
	$syr= 		substr($vyear,2);

	$mat=		$_GET['mat']; 
	
	
	
	$stock=[];
	
	$sales=[];
	$imp=[];
	$str="select 
	
				sum(if(month(FKDAT)=7,FKIMG,0)) as july,
				sum(if(month(FKDAT)=8,FKIMG,0))as august,
				sum(if(month(FKDAT)=9,FKIMG,0)) as september,
				sum(if(month(FKDAT)=10,FKIMG,0)) as october,
				sum(if(month(FKDAT)=11,FKIMG,0)) as november,
				sum(if(month(FKDAT)=12,FKIMG,0)) as december,
				sum(if(month(FKDAT)=1,FKIMG,0)) as january,
				sum(if(month(FKDAT)=2,FKIMG,0))as february,
				sum(if(month(FKDAT)=3,FKIMG,0))  as march,
				sum(if(month(FKDAT)=4,FKIMG,0)) as april,
				sum(if(month(FKDAT)=5,FKIMG,0))as may,
				sum(if(month(FKDAT)=6,FKIMG,0)) as june
				from sap_sales_process 
				where   fyear=$vyear and MATNR=$mat";
				
				$sql=mysqli_query( $GLOBALS['con'] ,$str );
				while($row=mysqli_fetch_object($sql)){
					$sales[0]	= $row->july;
					$sales[1]	= $row->august;
					$sales[2]	= $row->september;
					$sales[3]	= $row->october;
					$sales[4]	= $row->november;
					$sales[5]	= $row->december;
					$sales[6]	= $row->january;
					$sales[7]	= $row->february;
					$sales[8]	= $row->march;
					$sales[9]	= $row->april;
					$sales[10]	= $row->may;
					$sales[11]	= $row->june;
				}
	
	
	
	$str="select (LABST+TRAME-imp+sales ) as qty     from
	(
	(SELECT  ifnull(SUM(LABST),0) AS LABST  FROM stock_process_mard_one where MATNR=$mat) as LABST,

	(SELECT  ifnull(SUM(TRAME),0) AS TRAME  FROM stock_process_marc_two where MATNR=$mat) as TRAME,

	(SELECT ifnull(SUM( MENGE ),0) AS imp  FROM stock_process_mseg_three

	WHERE MATNR = $mat and BUDAT >='$vyear-07-01') as imp,

	(SELECT ifnull(SUM( MENGE ),0) AS sales  FROM stock_process_mseg_four

	WHERE MATNR = $mat and BUDAT >='$vyear-07-01')  as sales

	)
	";
	
	$sql=mysqli_query( $GLOBALS['con'] ,$str );
	$result=mysqli_fetch_object($sql);
	$clqty = $result->qty;
	
	
	$nyear=$vyear+1;
	
	$str="select 
	
	ifnull(sum(if(month(BUDAT)=7,if(BWART=101,MENGE,-1*MENGE),0)),0) as july,
	ifnull(sum(if(month(BUDAT)=8,if(BWART=101,MENGE,-1*MENGE),0)),0)as august,
	ifnull(sum(if(month(BUDAT)=9,if(BWART=101,MENGE,-1*MENGE),0)),0) as september,
	ifnull(sum(if(month(BUDAT)=10,if(BWART=101,MENGE,-1*MENGE),0)),0) as october,
	ifnull(sum(if(month(BUDAT)=11,if(BWART=101,MENGE,-1*MENGE),0)),0) as november,
	ifnull(sum(if(month(BUDAT)=12,if(BWART=101,MENGE,-1*MENGE),0)),0) as december,
	ifnull(sum(if(month(BUDAT)=1,if(BWART=101,MENGE,-1*MENGE),0)),0) as january,
	ifnull(sum(if(month(BUDAT)=2,if(BWART=101,MENGE,-1*MENGE),0)),0)as february,
	ifnull(sum(if(month(BUDAT)=3,if(BWART=101,MENGE,-1*MENGE),0)),0)  as march,
	ifnull(sum(if(month(BUDAT)=4,if(BWART=101,MENGE,-1*MENGE),0)),0) as april,
	ifnull(sum(if(month(BUDAT)=5,if(BWART=101,MENGE,-1*MENGE),0)),0) as may,
	ifnull(sum(if(month(BUDAT)=6,if(BWART=101,MENGE,-1*MENGE),0)),0) as june
	from track_inbound where BUDAT>='$vyear-07-01' and BUDAT<='$nyear-06-30'
	and MATNR=$mat
	";
	
	$sql=mysqli_query( $GLOBALS['con'] ,$str );
	while($row=mysqli_fetch_object($sql)){
		$imp[0]	= $row->july;
		$imp[1]	= $row->august;
		$imp[2]	= $row->september;
		$imp[3]	= $row->october;
		$imp[4]	= $row->november;
		$imp[5]	= $row->december;
		$imp[6]	= $row->january;
		$imp[7]	= $row->february;
		$imp[8]	= $row->march;
		$imp[9]	= $row->april;
		$imp[10]	= $row->may;
		$imp[11]	= $row->june;
	}
	
	$track=0;
	for($i=0;$i<12;$i++ ){

		
		if($i==0){
			
			$track=$clqty;
		
		}else{
		
			$track=$track-$sales[$i];
		}
		$stock[$i]=$track;
		
	}
	
	
	$track=0;
	for($i=0;$i<12;$i++ ){

		
		if($i==0){
			
			$track=0;
		
		}else{
			$track=$track+$imp[$i];
		}
		
		$stock[$i]=  $stock[$i]+$track;
		
	}
	

?>
<table border=1>
	<tr>
		<td style="background-color: FCFF00;"><b>Month</b></td>
		<td style="background-color: FCFF00;"><b>Sales QTY</b></td>
		<td style="background-color: FCFF00;"><b>Import</b></td>
		<td style="background-color: FCFF00;"><b>Closing Stock</b></td>
	</tr>
	
				
				<tr>
					<td style="background-color: FCFF00;"><b><?php echo	  "July".$syr;	?></b></td>
					<td style="background-color: FCFF00;"><b><?php echo	$sales[0];	?></b></td>
					<td style="background-color: FCFF00;"><b><?php echo	$imp[0];	?></b></td>
					<td style="background-color: FCFF00;"><b><?php echo	$stock[0];	?></b></td>
				</tr>
				<tr>	
					<td style="background-color: FCFF00;"><b><?php echo	"August".$syr;	?></b></td>
					<td style="background-color: FCFF00;"><b><?php echo	$sales[1];	?></b></td>
					<td style="background-color: FCFF00;"><b><?php echo	$imp[1];	?></b></td>
					<td style="background-color: FCFF00;"><b><?php echo	$stock[1];	?></b></td>
				</tr>
				<tr>
					<td style="background-color: FCFF00;"><b><?php echo	"September".$syr;	?></b></td>
					<td style="background-color: FCFF00;"><b><?php echo	$sales[2];	?></b></td>
					<td style="background-color: FCFF00;"><b><?php echo	$imp[2];	?></b></td>
					<td style="background-color: FCFF00;"><b><?php echo	$stock[2];	?></b></td>
				</tr>
				<tr>
					<td style="background-color: FCFF00;"><b><?php echo	"October".$syr;	?></b></td>
					<td style="background-color: FCFF00;"><b><?php echo	$sales[3];	?></b></td>
					<td style="background-color: FCFF00;"><b><?php echo	$imp[3];	?></b></td>
					<td style="background-color: FCFF00;"><b><?php echo	$stock[3];	?></b></td>
				</tr>
				<tr>
					<td style="background-color: FCFF00;"><b><?php echo	"November".$syr;	?></b></td>
					<td style="background-color: FCFF00;"><b><?php echo	$sales[4];	?></b></td>
					<td style="background-color: FCFF00;"><b><?php echo	$imp[4];	?></b></td>
					<td style="background-color: FCFF00;"><b><?php echo	$stock[4];	?></b></td>
				</tr>
				<tr>
					<td style="background-color: FCFF00;"><b><?php echo	"December".$syr;	?></b></td>
					<td style="background-color: FCFF00;"><b><?php echo	$sales[5];	?></b></td>
					<td style="background-color: FCFF00;"><b><?php echo	$imp[5];	?></b></td>
					<td style="background-color: FCFF00;"><b><?php echo	$stock[5];	?></b></td>
				</tr>
				<tr>
					<td style="background-color: FCFF00;"><b><?php echo	"January".$syr;	?></b></td>
					<td style="background-color: FCFF00;"><b><?php echo	$sales[6];	?></b></td>
					<td style="background-color: FCFF00;"><b><?php echo	$imp[6];	?></b></td>
					<td style="background-color: FCFF00;"><b><?php echo	$stock[6];	?></b></td>
				</tr>
				<tr>
					<td style="background-color: FCFF00;"><b><?php echo	"February".$syr;	?></b></td>
					<td style="background-color: FCFF00;"><b><?php echo	$sales[7];	?></b></td>
					<td style="background-color: FCFF00;"><b><?php echo	$imp[7];	?></b></td>
					<td style="background-color: FCFF00;"><b><?php echo	$stock[7];	?></b></td>
				</tr>
				<tr>
					<td style="background-color: FCFF00;"><b><?php echo	"March".$syr;	?></b></td>
					<td style="background-color: FCFF00;"><b><?php echo	$sales[8];	?></b></td>
					<td style="background-color: FCFF00;"><b><?php echo	$imp[8];	?></b></td>
					<td style="background-color: FCFF00;"><b><?php echo	$stock[8];	?></b></td>
				</tr>
				<tr>
					<td style="background-color: FCFF00;"><b><?php echo	"April".$syr;	?></b></td>
					<td style="background-color: FCFF00;"><b><?php echo	$sales[9];	?></b></td>	
					<td style="background-color: FCFF00;"><b><?php echo	$imp[9];	?></b></td>
					<td style="background-color: FCFF00;"><b><?php echo	$stock[9];	?></b></td>
				</tr>
				<tr>		
					<td style="background-color: FCFF00;"><b><?php echo	"May".$syr;	?></b></td>
					<td style="background-color: FCFF00;"><b><?php echo	$sales[10];	?></b></td>
					<td style="background-color: FCFF00;"><b><?php echo	$imp[10];	?></b></td>
					<td style="background-color: FCFF00;"><b><?php echo	$stock[10];	?></b></td>
				</tr>
				<tr>
					<td style="background-color: FCFF00;"><b><?php echo	"June".$syr;	?></b></td>
					<td style="background-color: FCFF00;"><b><?php echo	$sales[11];	?></b></td>	
					<td style="background-color: FCFF00;"><b><?php echo	$imp[11];	?></b></td>
					<td style="background-color: FCFF00;"><b><?php echo	$stock[11];	?></b></td>
				</tr>	
						
		
	
</table>
