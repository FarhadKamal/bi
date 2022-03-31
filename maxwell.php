<?php

include_once("db.php"); 
error_reporting(E_ALL ^ E_NOTICE); 

if(isset($_GET['logout']))
{		

	session_destroy();

	if($_GET['logout']=="yes")
		header("Location: index.php?msg=logout");
	else if($_GET['logout']=="fail")
		header("Location: index.php?msg=failLog");
	else if($_GET['logout']=="relog")
		header("Location: login.php?msg=relog");
}



	//echo $monthrange;
$costList="901110,902010,902011,902013,902040,902050,902060,902090,902012,902030,902100,902110,902140,902150,902161,902290,902321,903020,903021,903080,901090,902020,902021,902240,800002,800004,903010,903060,904070,904080,904081,904082,901030,901170,901190,902120,901020,901040,901070,901180,902360,
902370,902380,902390,902400,902190,902300,901060,901100,902170,902180,902200,902210,902230,902250,902260,902270,902280,902320,902420,904104,906010,
906020,907020,901120,901130,902181,990010,990020,800003,801030,801051,801085,805010,805025,805060,805061";

if(isset($_POST['pid']))
{

	$checkboxes = isset($_POST['months']) ? $_POST['months'] : array();
	
	$monthrange="";
	$i=0;
	foreach($checkboxes as $value) {
		if($i==0)$monthrange=$value;
		else $monthrange=$monthrange." + ".$value;
		$i++;
	}
	$year=$_POST["year"];
	$oYear=$year-1;

	$pid=$_POST['pid'];
	$str="select pep_faglflext.rbusa,division,product_division.id,
	sum(if(  RACCT=908220 and RYEAR=$oYear ,$monthrange,0    ) )as ocogs,
	sum(if(  RACCT=908220 and RYEAR=$year ,$monthrange,0    ) )as ncogs,
	-1*sum(if(  RACCT in (800000,800001,800005)  and RYEAR=$oYear ,$monthrange,0    ) )as osales,
	-1*sum(if(  RACCT in (800000,800001,800005)  and RYEAR=$year ,$monthrange,0    ) )as nsales
	from pep_faglflext 
	inner join  product_division on product_division.rbusa=pep_faglflext.rbusa
	where PRCTR='$pid' 
	group by rbusa";


	$str2="select 
	sum(if(  RACCT in ($costList)  and RYEAR=$oYear ,$monthrange,0    ) )as ocost,
	sum(if(  RACCT in ($costList)  and RYEAR=$year ,$monthrange,0    ) )as ncost,
	sum(if(  RACCT=908220 and RYEAR=$oYear ,$monthrange,0    ) )as ocogs,
	sum(if(  RACCT=908220 and RYEAR=$year ,$monthrange,0    ) )as ncogs,
	-1*sum(if(  RACCT in (800000,800001,800005)  and RYEAR=$oYear ,$monthrange,0    ) )as osales,
	-1*sum(if(  RACCT in (800000,800001,800005)  and RYEAR=$year ,$monthrange,0    ) )as nsales
	from pep_faglflext 
	where PRCTR='$pid'";


	$str3="select head_name,
	sum(if(  RACCT in ($costList)  and RYEAR=$year ,$monthrange,0    ) )as ncost


	from pep_faglflext 
	inner join gl_head on gl_head.hcode=pep_faglflext.RACCT
	where PRCTR='$pid'
	group by hcode having ncost>0
	";


	$str4="select head_name,

	sum(if(  RACCT in ($costList)  and RYEAR=$oYear ,$monthrange,0    ) )as ocost

	from pep_faglflext 
	inner join gl_head on gl_head.hcode=pep_faglflext.RACCT
	where PRCTR='$pid'
	group by hcode having ocost>0
	";




	



	
	
}
?>
<?php 
if(isset($_SESSION['logged'])){ 
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


  <link rel="stylesheet" href="script/flexselect.css" type="text/css" media="screen" />
  <script src="script/liquidmetal.js" type="text/javascript"></script>
  <script src="script/jquery.flexselect.js" type="text/javascript"></script>

</head>
<body>
	<div class="container">
		<div class="row"><br/>
			<div class="col-md-12">
				
				<label class="control-label">Showroom wise COGS & Operating Cost</label>
				<form method="POST" action="showroom_cogs.php">
					<table class="table table-striped"><tr><td>
					<table class="table table-striped">
						<tr>

							<td>
								<select  style="width: 250px;" name="pid" class="flexselect">
									<?php 
									$sql_pc=mysqli_query($con,"select * from profit_center where zone is not null");

									while($row_pc=mysqli_fetch_object($sql_pc)) {
										if($row_pc->pid==($_POST["pid"]))
											echo "<option selected value='".$row_pc->pid."'>".$row_pc->centerName."</option>";
										else echo "<option value='".$row_pc->pid."'>".$row_pc->centerName."</option>";
									} 
									?>
								</select>
							</td>								
							
						</tr>
						<tr>

							<td>
								
								<select name="year" required="">

									<option value='2019' <?php if($_POST["year"]==2019)echo "selected"; ?>>2019</option>
									<option value='2018' <?php if($_POST["year"]==2018)echo "selected"; ?>>2018</option>

								</select> 
								<br/>
								<input <?php if(isset($_POST["months"])){
								if(in_array("july", $_POST["months"]))echo "checked" ;}?> 
								type="checkbox"  class="checkBoxMonthClass"  name="months[]" value="july"/>July<br/>
								<input <?php if(isset($_POST["months"])){
								if(in_array("august", $_POST["months"]))echo "checked" ;}?> type="checkbox"  class="checkBoxMonthClass" name="months[]" value="august"/>August<br/>
								<input <?php if(isset($_POST["months"])){
								if(in_array("september", $_POST["months"]))echo "checked" ;}?> type="checkbox"  class="checkBoxMonthClass" name="months[]" value="september"/>September<br/>
								<input <?php if(isset($_POST["months"])){
								if(in_array("october", $_POST["months"]))echo "checked" ;}?> type="checkbox"  class="checkBoxMonthClass" name="months[]" value="october"/>October<br/>
								<input <?php if(isset($_POST["months"])){
								if(in_array("november", $_POST["months"]))echo "checked" ;}?> type="checkbox"  class="checkBoxMonthClass" name="months[]" value="november"/>November<br/>
								<input <?php if(isset($_POST["months"])){
								if(in_array("december", $_POST["months"]))echo "checked" ;}?> type="checkbox"  class="checkBoxMonthClass" name="months[]" value="december"/>December<br/>
								<input <?php if(isset($_POST["months"])){
								if(in_array("january", $_POST["months"]))echo "checked" ;}?> type="checkbox" class="checkBoxMonthClass" name="months[]" value="january"/>Janaury<br/>
								<input <?php if(isset($_POST["months"])){
								if(in_array("february", $_POST["months"]))echo "checked" ;}?> type="checkbox" class="checkBoxMonthClass" name="months[]" value="february"/>February<br/>
								<input <?php if(isset($_POST["months"])){
								if(in_array("march", $_POST["months"]))echo "checked" ;}?> type="checkbox" class="checkBoxMonthClass" name="months[]" value="march"/>March<br/>
								<input <?php if(isset($_POST["months"])){
								if(in_array("april", $_POST["months"]))echo "checked" ;}?> type="checkbox" class="checkBoxMonthClass" name="months[]" value="april"/>April<br/>
								<input <?php if(isset($_POST["months"])){
								if(in_array("may", $_POST["months"]))echo "checked" ;}?> type="checkbox" class="checkBoxMonthClass" name="months[]" value="may"/>May<br/>
								<input <?php if(isset($_POST["months"])){
								if(in_array("june", $_POST["months"]))echo "checked" ;}?> type="checkbox" class="checkBoxMonthClass" name="months[]" value="june"/>June
								<br/>
								<input type="checkbox" id="slms" value="0"  > All&nbsp;Months
								<br/>
								<input type="submit" value=">>"/>
							</td>								
							
						</tr>
						
						
					</table>
				</form></td><td>
				<?php
				if(isset($_POST['pid']))
				{ 

					$sql2=mysqli_query( $GLOBALS['con'] ,$str2);
					$row2=mysqli_fetch_object($sql2);
					$ocost="N/A";
					$ncost="N/A";

					if($row2->ocost>0 and $row2->osales>0)
						$ocost=round(($row2->ocost/$row2->osales)*100,2);
					if($row2->ncost>0 and $row2->nsales>0)
						$ncost=round(($row2->ncost/$row2->nsales)*100,2);
				
					?>
					
					<div  align="left" style="background-color:#59DDB5;width: 1000px">
						<font size=3 color="#FFFFFF"><b>&nbsp;Year: <?php echo $year; ?></b></font><br/>
						<font size=3 color="#FFFFFF"><b>&nbsp;Month: <?php echo $monthrange; ?></b></font>
					</div>	

					<table class="table table-striped" align="center"  >																


						<tr bgcolor="#FFB35F">											

						
							<td>
								<font size="2" color="#404548">&nbsp;<?php echo $year; ?>  Operating Cost%&nbsp;</font>	

								<?php 
									if($ocost!="N/A" and $ncost!="N/A"){
										if($ncost>$ocost){ ?> <img src="pic/downd.png" height="20"  /><?php }else if($ncost<$ocost){ ?><img src="pic/upd.png" height="20"  /><?php } 
									}
								?>

								<font size="2" color="#9b0c68">&nbsp;<?php echo $ncost; ?>&nbsp;</font>
								
						
								<table>
									<?php

									$sql3=mysqli_query($con,$str3);
									$t=0;
									while($row3=mysqli_fetch_object($sql3)){	
											$t+=$row3->ncost;
										?>

										<tr>
											<td><?php echo $row3->head_name; ?>&nbsp;&nbsp;&nbsp;</td>
											<td><?php echo $row3->ncost; ?></td>
										</tr>


									<?php
										}
									?>

									<tr>
										<td><font  color="#9b0c68"><b>Total Operating Cost</b></font></td>
										<td><font  color="#9b0c68"><b><?php echo $t; ?></b></font></td>
									</tr>

									<tr>
										<td><font  color="#9b0c68"><b>Total COGS</b></font></td>
										<td><font  color="#9b0c68"><b><?php echo $row2->ncogs; ?></b></font></td>
									</tr>

									<tr>
										<td><font  color="#19ad0a"><b>Total Sales</b></font></td>
										<td><font  color="#19ad0a"><b><?php echo $row2->nsales; ?></b></font></td>
									</tr>

									<tr>
										<td><font  color="#ef6957"><b>Net Profit</b></font></td>
										<td><font  color="#ef6957"><b><?php echo $row2->nsales-( $t+$row2->ncogs); ?></b></font></td>
									</tr>

								</table>	

							</td>
							<td>
								<font size="2" color="#404548">&nbsp;<?php echo $oYear; ?>  Operating Cost%&nbsp;</font>	
								

								<font size="2" color="#9b0c68">&nbsp;<?php echo $ocost; ?>&nbsp;</font>

								<table>
									<?php

									$sql4=mysqli_query($con,$str4);
									$t=0;
									while($row4=mysqli_fetch_object($sql4)){	
											$t+=$row4->ocost;
										?>

										<tr>
											<td><?php echo $row4->head_name; ?>&nbsp;&nbsp;&nbsp;</td>
											<td><?php echo $row4->ocost; ?></td>
										</tr>


									<?php
										}
									?>

									<tr>
										<td><font  color="#9b0c68"><b>Total Operating Cost</b></font></td>
										<td><font  color="#9b0c68"><b><?php echo $t; ?></b></font></td>
									</tr>

									<tr>
										<td><font  color="#9b0c68"><b>Total COGS</b></font></td>
										<td><font  color="#9b0c68"><b><?php echo $row2->ocogs; ?></b></font></td>
									</tr>

									<tr>
										<td><font  color="#19ad0a"><b>Total Sales</b></font></td>
										<td><font  color="#19ad0a"><b><?php echo $row2->osales; ?></b></font></td>
									</tr>

									<tr>
										<td><font  color="#ef6957"><b>Net Profit</b></font></td>
										<td><font  color="#ef6957"><b><?php echo $row2->osales-( $t+$row2->ocogs); ?></b></font></td>
									</tr>


										

								</table>


							</td>		
						</tr>
					</table>	

							<table class="table table-striped" align="center"  >																


								<tr bgcolor="#FFB35F">											

									<td><font size="2" color="#404548">&nbsp;ID&nbsp;</font></td>
									<td><font size="2" color="#404548">&nbsp;Division&nbsp;</font></td>
									<td><font size="2" color="#404548">&nbsp;<?php echo $oYear; ?> COGS%&nbsp;</font></td>
									<td><font size="2" color="#404548">&nbsp;<?php echo $year; ?> COGS%&nbsp;</font></td>						

								</tr>

								<?php 
							// echo "<pre>
							// 	$str
							// 	</pre>";


								$sql=mysqli_query( $GLOBALS['con'] ,$str);

								while($row=mysqli_fetch_object($sql)){	
									$ocsgs="N/A";
									$ncsgs="N/A";
									if($row->ocogs>0 and $row->osales>0)
										$ocsgs=round(($row->ocogs/$row->osales)*100,2);

									if($row->ncogs>0 and $row->nsales>0)
										$ncsgs=round(($row->ncogs/$row->nsales)*100,2)

									?>					
									<tr>	
										<td>
											<font size="2" color="#9b0c68">&nbsp;<?php echo $row->id; ?>&nbsp;</font>
										</td>	
										<td>
											<font size="2" color="#9b0c68">&nbsp;<?php echo $row->division; ?>&nbsp;</font>
										</td>	
										<td>
											<font size="2" color="#9b0c68">&nbsp;<?php echo $ocsgs; ?>&nbsp;</font>
										</td>	
										<td>


											<?php 
											if($ocsgs!="N/A" and $ncsgs!="N/A"){
												if($ncsgs>$ocsgs){ ?> <img src="pic/downd.png" height="20"  /><?php }else if($ncsgs<$ocsgs){ ?><img src="pic/upd.png" height="20"  /><?php } 
											}
										?>

										<font size="2" color="#9b0c68">&nbsp;<?php echo $ncsgs; ?>&nbsp;</font>

									</td>	
								</tr>
							<?php } ?>

						</table>
					</td>
				</tr>
			</table>



					<?php } ?>


				</div>
			</div>
		</div>



		<!-- Custom Script -->
		<script>
			$(document).ready(function(){
				$("select.flexselect").flexselect();



				$("#slms").click(function() {
						
					if ($("#slms").is(':checked')){
					
						$(".checkBoxMonthClass").prop('checked', true);	
			
					}else { 
						$(".checkBoxMonthClass").prop('checked', false);	
			
					}
				});




			});
		</script>




	</body>
	</html>
	<?php 

	include_once("footer.php"); 

}else{ include_once("login.php"); } ?>


