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

    $selected_year = str_replace("'", "", $_GET["year"]);
    $SPART = str_replace("'", "", $_GET["SPART"]);
    $searching_parameters_for_achivements_trimed_edition = str_replace("'", "", $_GET["searching_parameters_for_achivements_trimed_edition"]);

    $date_list = explode('/',$searching_parameters_for_achivements_trimed_edition);
	//print_r($date_list);
    $date = "";
    $target = "";

    IF(!empty($date_list[0]) AND !empty($date_list[1])){
        $date .= "(FKDAT >= '$date_list[0]' and  FKDAT<= '$date_list[1]') OR ";
        $target .= " sales_target.july+sales_target.august+sales_target.september";
    }
    IF(!empty($date_list[2]) AND !empty($date_list[3])){
        $date .= "(FKDAT >= '$date_list[2]' and  FKDAT<= '$date_list[3]') OR ";
        $target .= " sales_target.october+sales_target.november+sales_target.december";
    }
    IF(!empty($date_list[4]) AND !empty($date_list[5])){
        $date .= "(FKDAT >= '$date_list[4]' and  FKDAT<= '$date_list[5]') OR ";
        $target .= " sales_target.january+sales_target.february+sales_target.march";
    }
    IF(!empty($date_list[6]) AND !empty($date_list[7])){
        $date .= "(FKDAT >= '$date_list[6]' and  FKDAT<= '$date_list[7]') OR ";
        $target .= " sales_target.april+sales_target.may+sales_target.june";
    }

    $date_query = preg_replace('/\W\w+\s*(\W*)$/', '$1', $date);
    
    $target_trim_query = str_replace(' ', '+', $target);
    $target_trim_query = ltrim($target_trim_query, '+');
    
    $target_query = "round(SUM(".$target_trim_query."),2) AS target ,";

    $query ="SELECT
            final.zone AS zone, IFNULL(SUM(final.target),0) AS total_target, IFNULL(SUM(final.sales),0) AS total_achivement
            FROM
                (
                SELECT * FROM
                    (
                    select sales_target.dealer, sales_target.zone,IFNULL(sum($target_trim_query),0) AS target
                    from sales_target 
                    
                    where sales_target.product_division in ($SPART) and fyear='$selected_year' and group_tag='CR'
                    GROUP BY sales_target.dealer
                    ) AS target
                    LEFT jOIN
                    (
                    select sap_sales_process.KUNAG,IFNULL(SUM(sap_sales_process.NETWR),0) AS sales
                    from sap_sales_process
                    where 
                    sap_sales_process.FYEAR = '$selected_year' AND CTAG='CR' AND SPART in($SPART)
                    and (
                        $date_query
                    )
                    GROUP BY sap_sales_process.KUNAG
                    ) AS sales ON sales.KUNAG = target.dealer
                ) AS final
            GROUP BY final.zone";

	$query_old = "SELECT 
                zone.ZZONE AS zone,
                SUM(master_sales.NETWR) AS total_achivement
                FROM
                (
                SELECT 
                *
                from sap_sales_process 
                where 
                FYEAR = '$selected_year' AND CTAG='CR' AND SPART in($SPART)
                and (
                    $date_query
                )) AS master_sales 
                LEFT JOIN (SELECT * FROM kna1 GROUP BY kna1.KUNNR) zone
                ON zone.KUNNR = master_sales.KUNAG
                GROUP BY zone.ZZONE";
    
    // echo "<pre>";
    // var_dump ($query);
    // echo "</pre>";

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
									 
                                    <th colspan="4" class="text-center text-info"><span class="text-info"> Achivement Report (All Monetary value is Lakh) </span></th>
                                </tr>
                                <tr>
                                    <th class="text-center">#SL</th>
                                    <th class="text-center">Zone</th>
                                    <th class="text-center">Target</th>
                                    <th class="text-center">Achivement</th>
                                </tr>
                            </thead>
                            <tbody class="text-center">
                                <?php 
                                $sql =mysqli_query($GLOBALS['con'] ,$query);
                                $total_achivement = 0;
                                $total_target = 0;
                                $i = 0;
                                while($row = mysqli_fetch_object($sql)){
                                    $i++;
                                    $total_achivement = $total_achivement+$row->total_achivement;
                                    $total_target = $total_target+$row->total_target;
                                ?>
                                <tr>
                                    <td><?php echo $i; ?></td>
                                    <td><?php echo $row->zone; ?></td>
                                    <td><?php echo round(lakh($row->total_target),2); ?></td>
                                    <td><?php echo round(lakh($row->total_achivement),2); ?></td>
                                </tr>
                                <?php } ?>
                                <tr>
                                    <td colspan="2" align="right"> Total</td>
                                    <td><?php echo ROUND(lakh($total_target),2); ?></td>
                                    <td><?php echo ROUND(lakh($total_achivement),2); ?></td>
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