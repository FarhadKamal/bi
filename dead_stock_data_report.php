<?php


function lakh($amt)
{
 
	return 	sprintf("%.2f", round($amt/100000,2));
}	

include_once("db.php");
error_reporting(E_ALL ^ E_NOTICE);

if (isset($_POST['logout'])) {

	session_destroy();

	if ($_POST['logout'] == "yes")
		header("Location: index.php?msg=logout");
	else if ($_POST['logout'] == "fail")
		header("Location: index.php?msg=failLog");
	else if ($_POST['logout'] == "relog")
		header("Location: login.php?msg=relog");
}

    $division = str_replace("'", "", $_GET["division"]);
	$product_type = str_replace("'", "", $_GET["product_type"]);
	$status = $_GET["status"];

	if($status == 1){
		$query = "SELECT 	
				MATNR, 
				MAKTX, 
				division, 
				SPART, 
				product_type, 
				pv, 
				pq, 
				ifnull(salesVal,0) as sv, 
				ifnull(SalesQty,0) as sq
				 
				FROM stock_inventory
				WHERE division = '$division' AND product_type = '$product_type'
				GROUP BY MATNR";
	}elseif ($status == 2) {
		$query = "SELECT 	
				MATNR, 
				MAKTX, 
				division, 
				SPART, 
				product_type, 
				pv, 
				pq, 
				ifnull(salesVal,0) as sv, 
				ifnull(SalesQty,0) as sq
				 
				FROM stock_inventory
				WHERE SalesQty=0.00 AND division = '$division' AND product_type = '$product_type'
				GROUP BY MATNR";
	}else {
		$query = "SELECT 	
				MATNR, 
				MAKTX, 
				division, 
				SPART, 
				product_type, 
				pv, 
				pq, 
				ifnull(salesVal,0) as sv, 
				ifnull(SalesQty,0) as sq
				 
				FROM stock_inventory
				WHERE division = '$division' AND product_type = '$product_type'
				GROUP BY MATNR";
	}


?>

<?php
if (isset($_SESSION['logged'])) {
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
		<?php
		// include_once("sidebar.php");
		?>
		<div class="container">
			<div class="row"><br />
				<div class="col-md-12">

					<!-- <label class="control-label">Target Vs Achivement (Values)</label> -->
					<input 
					type="button" class="btn btn-sm" 
					onclick="tableToExcel('table', 'a', 'data.xls')" 
					value="Export to Excel" />	

                    <?php 
                        echo "<br />";
						
                    ?>
                    <div class="bs-example container" data-example-id="striped-table">
                        <table class="table table-striped table-bordered table-hover" style="width: 90%;" id="table">
                            <thead>
                                <tr>
									 
                                    <th colspan="4" class="text-center text-info"><span class="text-info"> Dead Stock Report For <?php echo $division; ?> <?php echo $product_type; ?> Type Product </span></th>
                                </tr>
                                <tr>
                                    <th class="text-center">MATNR</th>
                                    <th class="text-center">Material</th>
                                    <th class="text-center">Product Value</th>
                                    <th class="text-center">Product Quantity</th>
                                </tr>
                            </thead>
                            <tbody class="text-center">
                                <?php 
                                $sql =mysqli_query($GLOBALS['con'] ,$query);
                                $total_pv = 0;
                                $total_pq = 0;
                                while($row = mysqli_fetch_object($sql)){
                                    $total_pv = ROUND($total_pv+$row->pv);
                                    $total_pq = round($total_pq+$row->pq);
                                ?>
                                <tr>
                                    <td><?php echo $row->MATNR; ?></td>
                                    <td><?php echo $row->MAKTX; ?></td>
                                    <td><?php echo ROUND($row->pv); ?></td>
                                    <td><?php echo round($row->pq); ?></td>
                                </tr>
                                <?php } ?>
                                <tr>
                                    <td colspan="2" align="left"> Total</td>
                                    <td><?php echo $total_pv; ?></td>
                                    <td><?php echo $total_pq; ?></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <?php
                    echo "<br />";
                    ?>




				</div>
			</div>
		</div>
		
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
<?php

	// include_once("footer.php");

} 
else {
	include_once("login.php");
} ?>
