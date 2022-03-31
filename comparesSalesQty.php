<?php

include_once("db.php"); 
error_reporting(E_ALL ^ E_NOTICE); 

$spart= $_GET['spart'];

$osdate=$_GET['osdate'];
$oedate=$_GET['oedate'];

$csdate=$_GET['csdate'];
$cedate=$_GET['cedate'];


$str="select material_data.MATNR,MAKTX,sum( if( FKDAT>='$osdate' and FKDAT<='$oedate' ,FKIMG,0 ) ) as oldqty,
 sum( if( FKDAT>='$csdate' and FKDAT<='$cedate' ,FKIMG,0 ) ) as newqty from sap_sales_process 
inner join material_data on material_data.MATNR=sap_sales_process.MATNR where FKDAT>='$osdate' and CTAG in('CR','BD','SR')
and sap_sales_process.spart=$spart
 and material_data.MTART='HAWA' group by material_data.MATNR ";

//echo $str;

?>
<!DOCTYPE html>
<html lang="en">
<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="icon" href="pic/icon.png" />
		<title>BI</title>
		<link rel="stylesheet" href="script/bootstrap.min.css">
		<link rel="stylesheet" href="script/bootstrap-theme.css">
		<link rel="stylesheet" href="script/bootstrap-theme.min.css">
        <link href="https://netdna.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.css" rel="stylesheet">
		<script src="script/Chart.min.js" type="text/javascript"></script>
		<script src="script/jquery-1.11.2.min.js"></script>
		<script src="script/bootstrap.min.js"></script>
		<link rel="stylesheet" href="script/flexselect.css" type="text/css" media="screen" />
		<script src="script/liquidmetal.js" type="text/javascript"></script>
		<script src="script/jquery.flexselect.js" type="text/javascript"></script>

	</head>
<body>
	<div class="container">
		<div class="row"><br/>
			<div class="col-md-12">


			<div class="bs-example container" data-example-id="striped-table">

			<table class="table table-striped table-bordered table-hover" style="width: 90%;">
				<thead>
					<tr>
								
						<td class="text-center"><font  color="#101b9d"><b>MatNo</b></font></td>
						<td class="text-center"><font  color="#101b9d"><b>Name</b></font></td>
						<td class="text-center"><font  color="#101b9d"><b>Prev</b></font></td>
						<td class="text-center"><font  color="#101b9d"><b>Current</b></font></td>
									

					</tr>
				</thead>
				<tbody>
					<?php
					$sql=mysqli_query( $GLOBALS['con'] ,$str);
					while($row=mysqli_fetch_object($sql)){ 
					?>
					<tr>			
						<td><font  color="#000000"><?php echo $row->MATNR; ?></font></td>
						<td><font  color="#000000"><?php echo $row->MAKTX; ?></font></td>
						<td><font  color="#000000"><?php echo $row->oldqty; ?></font></td>
						<td><font  color="#000000"><?php echo $row->newqty; ?></font></td>
	
					</tr>
					<?php } ?>
				</tbody>
				</table>	
            </div>

		</div>
	</div>
	</div>
</body>

</html>



