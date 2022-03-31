<?php

include_once("db.php");
error_reporting(E_ALL ^ E_NOTICE);

$year=$_GET['year'];

$str="select  account_head,account_cost_center.cost_id,cost_name,

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
left join cost_name on account_cost_center.cost_id=cost_name.id
where RYEAR =$year and account_head in ('Administrative','Distribution','Marketing & Selling')
group by account_head,account_cost_center.cost_id 
 ";



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
		<div class="row"><br />
			<div class="col-md-12">

				<input type="button" class="btn btn-sm" onclick="tableToExcel('table', 'a', 'data.xls')"
					value="Export to Excel">



				<div class="bs-example container" data-example-id="striped-table">

					<table class="table table-striped table-bordered table-hover" style="width: 90%;" id="table">
						<thead>
							<tr>

								<td class="text-center">
									<font color="#101b9d"><b>Account Head</b></font>
								</td>
								<td class="text-center">
									<font color="#101b9d"><b>Cost ID</b></font>
								</td>
								<td class="text-center">
									<font color="#101b9d"><b>Cost Name</b></font>
								</td>
								<td class="text-center">
									<font color="#101b9d"><b>Pedrollo</b></font>
								</td>
								<td class="text-center">
									<font color="#101b9d"><b> Pragati</b></font>
								</td>
								<td class="text-center">
									<font color="#101b9d"><b> PNL</b></font>
								</td>
								<td class="text-center">
									<font color="#101b9d"><b> ALL</b></font>
								</td>

							</tr>
						</thead>
						<tbody>
							<?php
                    $sql=mysqli_query($GLOBALS['con'], $str);
                    $pedtotal=0;
                    $pratotal=0;
                    $pnltotal=0;
                    $alltotal=0;
                    
                    while ($row=mysqli_fetch_object($sql)) {
                        $pedtotal+= $row->pedtotal;
                        $pratotal+= $row->pratotal;
                        $pnltotal+= $row->pnltotal;
                        $alltotal+= $row->ovtot; ?>
							<tr>
								<td>
									<font color="#000000"><?php echo $row->account_head; ?>
									</font>
								</td>
								<td>
									<font color="#000000"><?php echo $row->cost_id; ?>
									</font>
								</td>


								<td>
									<font color="#000000"><span><?php echo $row->cost_name; ?></span>
									</font>
								</td>

								<td>
									<font color="#000000"><span><?php echo number_format($row->pedtotal); ?></span>
									</font>
								</td>

								<td>
									<font color="#000000"><span><?php echo number_format($row->pratotal); ?></span>
									</font>
								</td>

								<td>
									<font color="#000000"><span><?php echo number_format($row->pnltotal); ?></span>
									</font>
								</td>

								<td>
									<font color="#000000"><span><?php echo number_format($row->ovtot); ?></span>
									</font>
								</td>

								</td>

							</tr>
							<?php
                    } ?>

							<tr>
								<td colspan=3>
									<font color="#000000">Total</font>
								</td>

								<td>
									<font color="#000000"><?php echo number_format($pedtotal); ?>
									</font>
								</td>
								<td>
									<font color="#000000"><?php echo number_format($pratotal); ?>
									</font>
								</td>
								<td>
									<font color="#000000"><?php echo number_format($pnltotal); ?>
									</font>
								</td>
								<td>
									<font color="#000000"><?php echo number_format($alltotal); ?>
									</font>
								</td>

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
				template =
				'<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40"><title></title><head><!--[if gte mso 9]><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet><x:Name>{worksheet}</x:Name><x:WorksheetOptions><x:DisplayGridlines/></x:WorksheetOptions></x:ExcelWorksheet></x:ExcelWorksheets></x:ExcelWorkbook></xml><![endif]--><meta http-equiv="content-type" content="text/plain; charset=UTF-8"/></head><body><table>{table}</table></body></html>',
				base64 = function(s) {
					return window.btoa(unescape(encodeURIComponent(s)))
				},
				format = function(s, c) {
					return s.replace(/{(\w+)}/g, function(m, p) {
						return c[p];
					})
				}

			if (!table.nodeType) table = document.getElementById(table)
			var ctx = {
				worksheet: name || 'Worksheet',
				table: table.innerHTML
			}

			var link = document.createElement('a');
			link.download = filename;
			link.href = uri + base64(format(template, ctx));
			link.click();
		}
	</script>
</body>

</html>