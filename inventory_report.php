<?php

include_once("db.php"); 
error_reporting(E_ALL ^ E_NOTICE); 


$query = "select t.MATNR,MAKTX,substring_index(GROUP_CONCAT(BUDAT,'&nbsp;',MENGE  order by BUDAT desc SEPARATOR '\n' ),'\n',3) as details 
		  from track_inbound t
		inner join material_data m on m.MATNR=t.MATNR 
		where m.MTART='HAWA' and BUDAT>'2012-01-01' and SPART in (20,40,50,51,60,80,99,30,52,81)  
		group by t.MATNR";


?>


<!DOCTYPE html>
<html lang="en">
<head>

	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="icon" href="pic/icon.png" />
	<title>BI</title>

	<script src="script/jquery-1.11.2.min.js"></script>

</head>
<body>
	<div class="container">
		<div class="row"><br/>
			<div class="col-md-12">
				<table class="table table-striped" id="table">
					<tr>
						<td colspan="9">
							<div  align="left" style="background-color:#59DDB5;width: 1000px">
								<font size=2 color="#FFFFFF"><b>Inventory</b></font><br/>
							</div>	
						</td>
					</tr>
					<tr valign="top">
						<td style="border: 1px solid black;"><font  color="#101b9d"><b>#SL</b></font></td>
						<td style="border: 1px solid black;"><font  color="#101b9d"><b>Product Code</b></font></td>
						<td style="border: 1px solid black;"><font  color="#101b9d"><b>Material Name</b></font></td>
						<td style="border: 1px solid black;"><font  color="#101b9d"><b>Date</b></font></td>
						<td style="border: 1px solid black;"><font  color="#101b9d"><b>Stock</b></font></td>
						<td style="border: 1px solid black;"><font  color="#101b9d"><b>Date</b></font></td>
						<td style="border: 1px solid black;"><font  color="#101b9d"><b>Stock</b></font></td>
						<td style="border: 1px solid black;"><font  color="#101b9d"><b>Date</b></font></td>
						<td style="border: 1px solid black;"><font  color="#101b9d"><b>Stock</b></font></td>
					</tr>

					<?php
						$sql2=mysqli_query( $GLOBALS['con'] ,$query);
						$sl = 1;
						while($row2=mysqli_fetch_object($sql2)){
					?>
					<tr>
						<td style="border: 1px solid black;"><font  color="#101b9d"><b><?php echo $sl; ?></b></font></td>
						<td style="border: 1px solid black;"><font  color="#101b9d"><b><?php echo $row2->MATNR; ?></b></font></td>
						<td style="border: 1px solid black;"><font  color="#101b9d"><b><?php echo $row2->MAKTX; ?></b></font></td>
						<?php 
							$data = explode("\n",$row2->details); 
							$data1 = explode("&nbsp;",$data[0]); 
							$data2 = explode("&nbsp;",$data[1]); 
							$data3 = explode("&nbsp;",$data[2]); 

						?>
						<td style="border: 1px solid black;"><font  color="#101b9d"><b><?php echo (isset($data1) AND is_array($data1))? $data1[0]:""; ?></b></font></td>
						<td style="border: 1px solid black;"><font  color="#101b9d"><b><?php echo (isset($data1) AND is_array($data1))? $data1[1]:""; ?></b></font></td>
						<td style="border: 1px solid black;"><font  color="#101b9d"><b><?php echo (isset($data2) AND is_array($data2))? $data2[0]:""; ?></b></font></td>
						<td style="border: 1px solid black;"><font  color="#101b9d"><b><?php echo (isset($data2) AND is_array($data2))? $data2[1]:""; ?></b></font></td>
						<td style="border: 1px solid black;"><font  color="#101b9d"><b><?php echo (isset($data3) AND is_array($data3))? $data3[0]:""; ?></b></font></td>
						<td style="border: 1px solid black;"><font  color="#101b9d"><b><?php echo (isset($data3) AND is_array($data3))? $data3[1]:""; ?></b></font></td>
					</tr>
					<?php 
						$sl++;
						} 
					?>
				</table>
			<div>
		</div>
	</div>

	<script type="text/javascript">
			
	var uri = 'data:application/vnd.ms-excel;base64,'
	, template = '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40"><head><!--[if gte mso 9]><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet><x:Name>{worksheet}</x:Name><x:WorksheetOptions><x:DisplayGridlines/></x:WorksheetOptions></x:ExcelWorksheet></x:ExcelWorksheets></x:ExcelWorkbook></xml><![endif]--><meta http-equiv="content-type" content="text/plain; charset=UTF-8"/></head><body><table>{table}</table></body></html>'
	, base64 = function(s) { return window.btoa(unescape(encodeURIComponent(s))) }
	, format = function(s, c) { return s.replace(/{(\w+)}/g, function(m, p) { return c[p]; }) }
	$(document).ready(function() {
		var table = 'table';
		var name = 'Inventory';
		if (!table.nodeType) table = document.getElementById(table)
			var ctx = {worksheet: name || 'Worksheet', table: table.innerHTML}
			window.location.href = uri + base64(format(template, ctx))
	});
	
</script>