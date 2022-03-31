<?php

include_once("db.php"); 
error_reporting(E_ALL ^ E_NOTICE); 

$spart= $_GET['spart'];

$osdate= date('Y-m-d', strtotime($_GET['osdate']));
$oedate= date('Y-m-d', strtotime($_GET['oedate']));
$csdate= date('Y-m-d', strtotime($_GET['csdate']));
$cedate= date('Y-m-d', strtotime($_GET['cedate']));


$group=$_GET['group'];

if ($spart == "20") $spart="$spart,30";


$str="select material_data.MATNR,MAKTX,
sum( if( FKDAT>='$osdate' and FKDAT<='$oedate' ,FKIMG,0 ) ) as oldqty,
sum( if( FKDAT>='$csdate' and FKDAT<='$cedate' ,FKIMG,0 ) ) as newqty, 
 sum( if( FKDAT>='$osdate' and FKDAT<='$oedate' ,NETWR,0 ) ) as oldprice,
sum( if( FKDAT>='$csdate' and FKDAT<='$cedate' ,NETWR,0 ) ) as newprice
 
 from sap_sales_process 
inner join material_data on material_data.MATNR=sap_sales_process.MATNR where FKDAT>='$osdate' and CTAG in('CR','BD','SR')
and sap_sales_process.spart in($spart) and sap_sales_process.CTAG='$group'
 and material_data.MTART='HAWA' group by material_data.MATNR ";



  //echo "<pre>";
 // var_dump ($str);
  //echo "</pre>";

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
			
			<input 
					type="button" class="btn btn-sm" 
					onclick="tableToExcel('table', 'a', 'data.xls')" 
					value="Export to Excel"
				>	
	


			<div class="bs-example container" data-example-id="striped-table">

			<table class="table table-striped table-bordered table-hover" style="width: 90%;" id="table">
				<thead>
					<tr>
								
						<td class="text-center"><font  color="#101b9d"><b>MatNo</b></font></td>
						<td class="text-center"><font  color="#101b9d"><b>Name</b></font></td>
						<td class="text-center"><font  color="#101b9d"><b>Prev Qty</b></font></td>
						<td class="text-center"><font  color="#101b9d"><b>Prev Price</b></font></td>
						<td class="text-center"><font  color="#101b9d"><b>Current Qty</b></font></td>
						<td class="text-center">&nbsp;</td>
						<td class="text-center"><font  color="#101b9d"><b>Current Price</b></font></td>
									

					</tr>
				</thead>
				<tbody>
					<?php
					$sql=mysqli_query( $GLOBALS['con'] ,$str);
					$totoldqty=0;
					$totnewqty=0;
					
					while($row=mysqli_fetch_object($sql)){ 
					
					$totoldqty=$totoldqty+ $row->oldqty;
					$totnewqty=$totnewqty+ $row->newqty;
					?>
					<tr>			
						<td><font  color="#000000"><?php echo $row->MATNR; ?></font></td>
						<td><font  color="#000000"><?php echo $row->MAKTX; ?></font></td>
						<td><font  color="#000000"><span><?php echo $row->oldqty; ?></span></font></td>
						<td><font  color="#000000"><span><?php echo $row->oldprice; ?></span></font></td>
						<td><font  color="#000000">
							<span 
							class="<?php echo ($row->newqty >= $row->oldqty)?'text-success':'text-danger'; ?>">
							       <?php echo $row->newqty; ?>&nbsp;
							</span>
						<td>
							<?php 
							if($row->newqty > $row->oldqty)
								$class= 'fa fa-long-arrow-up';
							elseif($row->newqty < $row->oldqty)
								$class= 'fa fa-long-arrow-down';
							else
								$class = '';
							?>
							<i class="<?php echo $class; ?>"></i>
						</td>
						<td><font  color="#000000"><span><?php echo $row->newprice; ?></span></font></td>
						</font></td>
	
					</tr>
					<?php } ?>
					
					<tr>			
						<td colspan=2><font  color="#000000">Total</font></td>
					
						<td><font  color="#000000"><?php echo $totoldqty; ?></font></td>
						<td></td>
						<td><font  color="#000000"><?php echo $totnewqty; ?></font></td>
						<td></td>
					</tr>
				</tbody>
				</table>	
            </div>

		</div>
	</div>
	</div>
	


<script type="text/javascript">
	function tableToExcel(table, name, filename) {
			let uri = 'data:application/vnd.ms-excel;base64,', 
			template = '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40"><title></title><head><!--[if gte mso 9]><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet><x:Name>{worksheet}</x:Name><x:WorksheetOptions><x:DisplayGridlines/></x:WorksheetOptions></x:ExcelWorksheet></x:ExcelWorksheets></x:ExcelWorkbook></xml><![endif]--><meta http-equiv="content-type" content="text/plain; charset=UTF-8"/></head><body><table>{table}</table></body></html>', 
			base64 = function(s) { 
				return window.btoa(unescape(encodeURIComponent(s))) 
				},         format = function(s, c) { return s.replace(/{(\w+)}/g, function(m, p) { return c[p]; })}
			
			if (!table.nodeType) table = document.getElementById(table)
			var ctx = {worksheet: name || 'Worksheet', table: table.innerHTML}

			var link = document.createElement('a');
			link.download = filename;
			link.href = uri + base64(format(template, ctx));
			link.click();
	}
</script>	
</body>

</html>



