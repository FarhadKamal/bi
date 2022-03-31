<?php

include_once("db.php");
$fyear=2021;


$str="select trim(mt.zone) as zone,mt.dealer_code,mt.dealer_name,mt.target_amount,ifnull(sum(NETWR),0) as sales from maxwell_target mt
left join sap_sales_process sp on (sp.KUNAG=mt.dealer_code   and sp.SPART=95 and sp.FYEAR=$fyear   )
where mt.fyear=$fyear group by dealer_code order by zone,dealer_code";
	
$sql=mysqli_query( $GLOBALS['con'] ,$str );

$tot_target=0;
$tot_sales=0;

$sub_target=0;
$prev_sub_target=0;
$sub_sales=0;
$start_zone="B.B-1";
$prev_sub_sales=0;
$prev_zone="";


?>

<html>
<body>

<input 
type="button"
onclick="tableToExcel('table', 'a', 'data.xls')" 
value="Export to Excel" />	

	
<table border=1 cellspacing=0  id="table">

<tr bgcolor="#68d3f9">
<td colspan=6 align="center"><b>Maxwell, 2021 Target vs Achievement</b></td>

</tr>

<tr bgcolor="#68d3f9">
<td><b>Zone</b></td>
<td><b>Dealer&nbsp;Code</b></td>
<td><b>Dealer Name</b></td>
<td><b>Target</b></td>
<td><b>Sales</b></td>
<td><b>Achievement</b></td>

</tr>
<?php
while($row=mysqli_fetch_object($sql)){
	
	
$tot_target=$tot_target+$row->target_amount;
$tot_sales=$tot_sales+$row->sales;
$open=false;

if($start_zone==$row->zone){
	$sub_sales = $sub_sales + $row->sales;
	$sub_target = $sub_target + $row->target_amount;
}
else {
	$prev_sub_sales=$sub_sales; 
	$prev_sub_target=$sub_target;
	$prev_zone=$start_zone;
	$start_zone=$row->zone; 
	$sub_target= $row->target_amount; 
	$sub_sales= $row->sales; 
	$open=true;  
	}


if($open==true){
?>	
	
<tr bgcolor="#68d3f9">
<td colspan=3 align="right"><b><?php echo $prev_zone; ?>&nbsp;Sub Total</b></td>

<td><b><?php echo $prev_sub_target; ?></b></td>
<td><b><?php echo $prev_sub_sales; ?></b></td>
<td><?php echo round(($prev_sub_sales/$prev_sub_target)*100,2); ?>%</td>
</tr>
	
<?php		
}





?>	
	
<tr >
<td><?php echo $row->zone; ?></td>
<td><?php echo $row->dealer_code; ?></td>
<td><?php echo $row->dealer_name; ?></td>
<td><?php echo $row->target_amount; ?></td>
<td><?php echo $row->sales; ?></td>
<td><?php echo round(($row->sales/$row->target_amount)*100,2); ?>%</td>
</tr>	
	
	
	
	
<?php 
}
?>

<tr bgcolor="#68d3f9">
<td colspan=3 align="right"><b><?php echo $start_zone; ?>&nbsp;Sub Total</b></td>

<td><b><?php echo $sub_target; ?></b></td>
<td><b><?php echo $sub_sales; ?></b></td>
<td><?php echo round(($sub_sales/$sub_target)*100,2); ?>%</td>
</tr>

<tr bgcolor="#68d3f9">
<td colspan=3 align="right"><b>Total</b></td>

<td><b><?php echo $tot_target; ?></b></td>
<td><b><?php echo $tot_sales; ?></b></td>
<td><?php echo round(($tot_sales/$tot_target)*100,2); ?>%</td>
</tr>

</table>


<script type="text/javascript">
	function tableToExcel(table, name, filename) {
			let uri = 'data:application/vnd.ms-excel;base64,', 
			template = '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40"><title></title><head><!--[if gte mso 9]><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet><x:Name>{worksheet}</x:Name><x:WorksheetOptions><x:DisplayGridlines/></x:WorksheetOptions></x:ExcelWorksheet></x:ExcelWorksheets></x:ExcelWorkbook></xml><![endif]--><meta http-equiv="content-type" content="text/plain; charset=UTF-8"/></head><body><table>{table}</table></body></html>', 
			base64 = function(s) { return window.btoa(unescape(encodeURIComponent(s))) },         format = function(s, c) { return s.replace(/{(\w+)}/g, function(m, p) { return c[p]; })}
			
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