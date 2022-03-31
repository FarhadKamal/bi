<?php

include_once("db.php"); 
error_reporting(E_ALL ^ E_NOTICE); 

$year = $_POST['year'];

$month = $_POST['month'];

//$con =	mysqli_connect("192.168.1.226","king","Prince@007","bi");

//$month
//january+february+march+april+may+june+july+august+september+october+november+december
if(isset($year))
{
	
	// $year=$_POST['year'];

	$str_sales="SELECT '&nbsp;','Sales',
				sum(if( PRCTR='PC04',($month),0)) as 'Jubilee_Road_Ctg',
				sum(if( PRCTR='PC05',($month),0)) as 'Halisahar_Ctg',
				sum(if( PRCTR='PC07',($month),0)) as 'Magbazar_Dh',
				sum(if( PRCTR='PC08',($month),0)) as 'Monipuripara_Dhk',
				sum(if( PRCTR='PC09',($month),0)) as 'Khulna',
				sum(if( PRCTR='PC10',($month),0)) as 'Rajshahi',
				sum(if( PRCTR='PC11',($month),0)) as 'Sylhet',
				sum(if( PRCTR='PC15',($month),0)) as 'Gazipur',
				sum(if( PRCTR='PC16',($month),0)) as 'Comilla',
				sum(if( PRCTR='PC17',($month),0)) as 'Bogra',
				sum(if( PRCTR='PC19',($month),0)) as 'Mirpur_Dhaka',
				sum(if( PRCTR='PC20',($month),0)) as 'Muradpur_Ctg',
				sum(if( PRCTR='PC21',($month),0)) as 'Uttara_Dhaka',
				sum(if( PRCTR='PC22',($month),0)) as 'Barisal_Barisal',
				sum(if( PRCTR='PC23',($month),0)) as 'Kuril_Dhaka',
				sum(if( PRCTR='PC24',($month),0)) as 'Rangpur_Rajshahi',
				sum(if( PRCTR='PC25',($month),0)) as 'Segunbagicha_Dhaka',
				sum(if( PRCTR='PC26',($month),0)) as 'Jessore',
				sum(if( PRCTR='PC27',($month),0)) as 'Feni',
				sum(if( PRCTR='PC31',($month),0)) as 'Farmgate',
				sum(if( PRCTR='PC32',($month),0)) as 'Coxs_Bazar',
				sum(if( PRCTR='PC34',($month),0)) as 'Pabna',
				sum(if( PRCTR='PC35',($month),0)) as 'Keranigonj',
				sum(if( PRCTR='PC36',($month),0)) as 'Narayangonj',
				sum(if( PRCTR='PC37',($month),0)) as 'Mymensingh',
				sum(if( PRCTR='PC38',($month),0)) as 'Fatickchari',
				sum(if( PRCTR='PC39',($month),0)) as 'SiddikBazar',
				sum(if( PRCTR='PC40',($month),0)) as 'Moulvibazar',
				sum(if( PRCTR='PC41',($month),0)) as 'Savar',
				
				
				
				sum($month) as total
					from pep_faglflext 
					
					 where RYEAR= $year and PRCTR in(select pid from profit_center where zone is not null)
					 and  RACCT in (800000,800001,800005)
				";

	$str_cogs="select 
				'&nbsp;','COGS',

				sum(if( PRCTR='PC04',    ($month),0)) as ' Jubilee_Road_Ctg',
				sum(if( PRCTR='PC05',    ($month),0)) as ' Halisahar_Ctg',

				sum(if( PRCTR='PC07',    ($month),0)) as ' Magbazar_Dh',
				sum(if( PRCTR='PC08',    ($month),0)) as ' Monipuripara_Dhk',
				sum(if( PRCTR='PC09',    ($month),0)) as ' Khulna',
				sum(if( PRCTR='PC10',    ($month),0)) as ' Rajshahi',
				sum(if( PRCTR='PC11',    ($month),0)) as '  Sylhet',
				sum(if( PRCTR='PC15',    ($month),0)) as ' Gazipur',
				sum(if( PRCTR='PC16',    ($month),0)) as ' Comilla',
				sum(if( PRCTR='PC17',    ($month),0)) as '  Bogra',
				sum(if( PRCTR='PC19',    ($month),0)) as ' Mirpur_Dhaka',
				sum(if( PRCTR='PC20',    ($month),0)) as ' Muradpur_Ctg',
				sum(if( PRCTR='PC21',    ($month),0)) as ' Uttara_Dhaka',
				sum(if( PRCTR='PC22',    ($month),0)) as ' Barisal_Barisal',
				sum(if( PRCTR='PC23',    ($month),0)) as ' Kuril_Dhaka',
				sum(if( PRCTR='PC24',    ($month),0)) as ' Rangpur_Rajshahi',

				sum(if( PRCTR='PC25',    ($month),0)) as ' Segunbagicha_Dhaka',
				sum(if( PRCTR='PC26',    ($month),0)) as ' Jessore',
				sum(if( PRCTR='PC27',    ($month),0)) as ' Feni',
				sum(if( PRCTR='PC31',    ($month),0)) as '  Farmgate',
				sum(if( PRCTR='PC32',    ($month),0)) as ' Coxs_Bazar',
				sum(if( PRCTR='PC34',    ($month),0)) as ' Pabna',
				sum(if( PRCTR='PC35',    ($month),0)) as ' Keranigonj',
				sum(if( PRCTR='PC36',    ($month),0)) as ' Narayangonj',
				sum(if( PRCTR='PC37',    ($month),0)) as ' Mymensingh',
				sum(if( PRCTR='PC38',    ($month),0)) as ' Fatickchari',
				sum(if( PRCTR='PC39',    ($month),0)) as ' SiddikBazar',
				sum(if( PRCTR='PC40',	 ($month),0)) as ' Moulvibazar',
				sum(if( PRCTR='PC41',    ($month),0)) as ' Savar',
				sum($month) as total

			from pep_faglflext 
			
			 where RYEAR= $year  and  PRCTR in(select pid from profit_center where zone is not null )
			and  RACCT=908220";


	$str_result ="select hcode, account_head.head_name,


					sum(if( PRCTR='PC04',    ($month),0)) as ' Jubilee_Road_Ctg',
					sum(if( PRCTR='PC05',    ($month),0)) as ' Halisahar_Ctg',

					sum(if( PRCTR='PC07',    ($month),0)) as ' Magbazar_Dh',
					sum(if( PRCTR='PC08',    ($month),0)) as ' Monipuripara_Dhk',
					sum(if( PRCTR='PC09',    ($month),0)) as ' Khulna',
					sum(if( PRCTR='PC10',    ($month),0)) as ' Rajshahi',
					sum(if( PRCTR='PC11',    ($month),0)) as '  Sylhet',
					sum(if( PRCTR='PC15',    ($month),0)) as ' Gazipur',
					sum(if( PRCTR='PC16',    ($month),0)) as ' Comilla',
					sum(if( PRCTR='PC17',    ($month),0)) as '  Bogra',
					sum(if( PRCTR='PC19',    ($month),0)) as ' Mirpur_Dhaka',
					sum(if( PRCTR='PC20',    ($month),0)) as ' Muradpur_Ctg',
					sum(if( PRCTR='PC21',    ($month),0)) as ' Uttara_Dhaka',
					sum(if( PRCTR='PC22',    ($month),0)) as ' Barisal_Barisal',
					sum(if( PRCTR='PC23',    ($month),0)) as ' Kuril_Dhaka',
					sum(if( PRCTR='PC24',    ($month),0)) as ' Rangpur_Rajshahi',

					sum(if( PRCTR='PC25',    ($month),0)) as ' Segunbagicha_Dhaka',
					sum(if( PRCTR='PC26',    ($month),0)) as ' Jessore',
					sum(if( PRCTR='PC27',    ($month),0)) as ' Feni',
					sum(if( PRCTR='PC31',    ($month),0)) as '  Farmgate',
					sum(if( PRCTR='PC32',    ($month),0)) as ' Coxs_Bazar',
					sum(if( PRCTR='PC34',    ($month),0)) as ' Pabna',
					sum(if( PRCTR='PC35',    ($month),0)) as ' Keranigonj',
					sum(if( PRCTR='PC36',    ($month),0)) as ' Narayangonj',
					sum(if( PRCTR='PC37',    ($month),0)) as ' Mymensingh',
					sum(if( PRCTR='PC38',    ($month),0)) as ' Fatickchari',
					sum(if( PRCTR='PC39',    ($month),0)) as ' SiddikBazar',
					sum(if( PRCTR='PC40',    ($month),0)) as ' Moulvibazar',
				    sum(if( PRCTR='PC41',    ($month),0)) as ' Savar',
					sum($month) as total

						from pep_faglflext 
						inner join account_cost_center on account_cost_center.cost_id=pep_faglflext.RCNTR
						inner join account_head on account_head.hcode=pep_faglflext.RACCT
						 where RYEAR= $year  and  PRCTR in(select pid from profit_center where zone is not null )
						and account_head in ('Administrative','Distribution','Marketing & Selling')
						group by pep_faglflext.RACCT
						
					
union

				select hcode, account_head.head_name,


					sum(if( PRCTR='PC04',    ($month),0)) as ' Jubilee_Road_Ctg',
					sum(if( PRCTR='PC05',    ($month),0)) as ' Halisahar_Ctg',

					sum(if( PRCTR='PC07',    ($month),0)) as ' Magbazar_Dh',
					sum(if( PRCTR='PC08',    ($month),0)) as ' Monipuripara_Dhk',
					sum(if( PRCTR='PC09',    ($month),0)) as ' Khulna',
					sum(if( PRCTR='PC10',    ($month),0)) as ' Rajshahi',
					sum(if( PRCTR='PC11',    ($month),0)) as '  Sylhet',
					sum(if( PRCTR='PC15',    ($month),0)) as ' Gazipur',
					sum(if( PRCTR='PC16',    ($month),0)) as ' Comilla',
					sum(if( PRCTR='PC17',    ($month),0)) as '  Bogra',
					sum(if( PRCTR='PC19',    ($month),0)) as ' Mirpur_Dhaka',
					sum(if( PRCTR='PC20',    ($month),0)) as ' Muradpur_Ctg',
					sum(if( PRCTR='PC21',    ($month),0)) as ' Uttara_Dhaka',
					sum(if( PRCTR='PC22',    ($month),0)) as ' Barisal_Barisal',
					sum(if( PRCTR='PC23',    ($month),0)) as ' Kuril_Dhaka',
					sum(if( PRCTR='PC24',    ($month),0)) as ' Rangpur_Rajshahi',

					sum(if( PRCTR='PC25',    ($month),0)) as ' Segunbagicha_Dhaka',
					sum(if( PRCTR='PC26',    ($month),0)) as ' Jessore',
					sum(if( PRCTR='PC27',    ($month),0)) as ' Feni',
					sum(if( PRCTR='PC31',    ($month),0)) as '  Farmgate',
					sum(if( PRCTR='PC32',    ($month),0)) as ' Coxs_Bazar',
					sum(if( PRCTR='PC34',    ($month),0)) as ' Pabna',
					sum(if( PRCTR='PC35',    ($month),0)) as ' Keranigonj',
					sum(if( PRCTR='PC36',    ($month),0)) as ' Narayangonj',
					sum(if( PRCTR='PC37',    ($month),0)) as ' Mymensingh',
					sum(if( PRCTR='PC38',    ($month),0)) as ' Fatickchari',
					sum(if( PRCTR='PC39',    ($month),0)) as ' SiddikBazar',
					sum(if( PRCTR='PC40',    ($month),0)) as ' Moulvibazar',
				    sum(if( PRCTR='PC41',    ($month),0)) as ' Savar',
					sum($month) as total

						from pep_faglflext 
						inner join account_head on account_head.hcode=pep_faglflext.RACCT
						 where RYEAR= $year  and  PRCTR in(select pid from profit_center where zone is not null )
						and RACCT in (800002)
						group by pep_faglflext.RACCT					
						
						
						";


}
//echo $str_result;

$sheet_name = $year." All Showroom Income Statement";
?>
<!DOCTYPE html>
<html lang="en">
<head>

	<meta charset="utf-8">
	<meta http-equiv="content-type" content="text/plain; charset=UTF-8"/>
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

				<input 
					type="button" class="btn btn-sm" 
					onclick="tableToExcel('table', '<?php echo $sheet_name; ?>', 'ShowRoom.xls')" 
					value="Export to Excel"
				>

				<table class="table table-striped" id="table">
					<tr>
						<td colspan="31">
							<div  align="left">
								<font size=2><b>All Showroom Income Statement, Financial Year- <?php echo $year; ?></b></font><br/>
							</div>	
						</td>
					</tr>	
					<tr valign="top">
						<td>
							<table style="font-size: 12px;">

								<tr style="text-align: center;">
									<td style="border: 1px solid black; padding: 20px;" colspan="2"><font  color="#101b9d"><b></b></font></td>
									<td style="border: 1px solid black; padding: 20px;"><font  color="#101b9d"><b><a href="showroom_cogs_rpt_2.php?pid=PC04&year=<?php echo $year ?>" target="_blank">Jubilee Road,Ctg</a></b></font></td>
									<td style="border: 1px solid black; padding: 20px;"><font  color="#101b9d"><b><a href="showroom_cogs_rpt_2.php?pid=PC05&year=<?php echo $year ?>" target="_blank">Halisahar,Ctg</a></b></font></td>
									<td style="border: 1px solid black; padding: 20px;"><font  color="#101b9d"><b><a href="showroom_cogs_rpt_2.php?pid=PC07&year=<?php echo $year ?>" target="_blank">Magbazar,Dh.</a></b></font></td>
									<td style="border: 1px solid black; padding: 20px;"><font  color="#101b9d"><b><a href="showroom_cogs_rpt_2.php?pid=PC08&year=<?php echo $year ?>" target="_blank">Monipuripara, Dhk.</a></b></font></td>
									<td style="border: 1px solid black; padding: 20px;"><font  color="#101b9d"><b><a href="showroom_cogs_rpt_2.php?pid=PC09&year=<?php echo $year ?>" target="_blank">Khulna</a></b></font></td>
									<td style="border: 1px solid black; padding: 20px;"><font  color="#101b9d"><b><a href="showroom_cogs_rpt_2.php?pid=PC10&year=<?php echo $year ?>" target="_blank">Rajshahi</a></b></font></td>							
									<td style="border: 1px solid black; padding: 20px;"><font  color="#101b9d"><b><a href="showroom_cogs_rpt_2.php?pid=PC11&year=<?php echo $year ?>" target="_blank">Sylhet</a></b></font></td>
									<td style="border: 1px solid black; padding: 20px;"><font  color="#101b9d"><b><a href="showroom_cogs_rpt_2.php?pid=PC15&year=<?php echo $year ?>" target="_blank">Gazipur</a></b></font></td>
									<td style="border: 1px solid black; padding: 20px;"><font  color="#101b9d"><b><a href="showroom_cogs_rpt_2.php?pid=PC16&year=<?php echo $year ?>" target="_blank">Comilla</a></b></font></td>
									<td style="border: 1px solid black; padding: 20px;"><font  color="#101b9d"><b><a href="showroom_cogs_rpt_2.php?pid=PC17&year=<?php echo $year ?>" target="_blank">Bogra</a></b></font></td>
									<td style="border: 1px solid black; padding: 20px;"><font  color="#101b9d"><b><a href="showroom_cogs_rpt_2.php?pid=PC19&year=<?php echo $year ?>" target="_blank">Mirpur, Dhaka</a></b></font></td>
									<td style="border: 1px solid black; padding: 20px;"><font  color="#101b9d"><b><a href="showroom_cogs_rpt_2.php?pid=PC20&year=<?php echo $year ?>" target="_blank">Muradpur,Ctg</a></b></font></td>
									<td style="border: 1px solid black; padding: 20px;"><font  color="#101b9d"><b><a href="showroom_cogs_rpt_2.php?pid=PC21&year=<?php echo $year ?>" target="_blank">Uttara, Dhaka</a></b></font></td>
									<td style="border: 1px solid black; padding: 20px;"><font  color="#101b9d"><b><a href="showroom_cogs_rpt_2.php?pid=PC22&year=<?php echo $year ?>" target="_blank">Barisal, Barisal</a></b></font></td>
									<td style="border: 1px solid black; padding: 20px;"><font  color="#101b9d"><b><a href="showroom_cogs_rpt_2.php?pid=PC23&year=<?php echo $year ?>" target="_blank">Kuril, Dhaka</a></b></font></td>
									<td style="border: 1px solid black; padding: 20px;"><font  color="#101b9d"><b><a href="showroom_cogs_rpt_2.php?pid=PC24&year=<?php echo $year ?>" target="_blank">Rangpur,Rajshahi</a></b></font></td>
									<td style="border: 1px solid black; padding: 20px;"><font  color="#101b9d"><b><a href="showroom_cogs_rpt_2.php?pid=PC25&year=<?php echo $year ?>" target="_blank">Segunbagicha,Dhaka</a></b></font></td>
									<td style="border: 1px solid black; padding: 20px;"><font  color="#101b9d"><b><a href="showroom_cogs_rpt_2.php?pid=PC26&year=<?php echo $year ?>" target="_blank">Jessore</a></b></font></td>
									<td style="border: 1px solid black; padding: 20px;"><font  color="#101b9d"><b><a href="showroom_cogs_rpt_2.php?pid=PC27&year=<?php echo $year ?>" target="_blank">Feni</a></b></font></td>
									<td style="border: 1px solid black; padding: 20px;"><font  color="#101b9d"><b><a href="showroom_cogs_rpt_2.php?pid=PC31&year=<?php echo $year ?>" target="_blank">Farmgate</a></b></font></td>
									<td style="border: 1px solid black; padding: 20px;"><font  color="#101b9d"><b><a href="showroom_cogs_rpt_2.php?pid=PC32&year=<?php echo $year ?>" target="_blank">Cox's Bazar</a></b></font></td>
									<td style="border: 1px solid black; padding: 20px;"><font  color="#101b9d"><b><a href="showroom_cogs_rpt_2.php?pid=PC34&year=<?php echo $year ?>" target="_blank">Pabna</a></b></font></td>
									<td style="border: 1px solid black; padding: 20px;"><font  color="#101b9d"><b><a href="showroom_cogs_rpt_2.php?pid=PC35&year=<?php echo $year ?>" target="_blank">Keranigonj</a></b></font></td>
									<td style="border: 1px solid black; padding: 20px;"><font  color="#101b9d"><b><a href="showroom_cogs_rpt_2.php?pid=PC36&year=<?php echo $year ?>" target="_blank">Narayangonj</a></b></font></td>
									<td style="border: 1px solid black; padding: 20px;"><font  color="#101b9d"><b><a href="showroom_cogs_rpt_2.php?pid=PC37&year=<?php echo $year ?>" target="_blank">Mymensingh</a></b></font></td>
									<td style="border: 1px solid black; padding: 20px;"><font  color="#101b9d"><b><a href="showroom_cogs_rpt_2.php?pid=PC38&year=<?php echo $year ?>" target="_blank">Fatickchari</a></b></font></td>
									<td style="border: 1px solid black; padding: 20px;"><font  color="#101b9d"><b><a href="showroom_cogs_rpt_2.php?pid=PC39&year=<?php echo $year ?>" target="_blank">SiddikBazar</a></b></font></td>
									<td style="border: 1px solid black; padding: 20px;"><font  color="#101b9d"><b><a href="showroom_cogs_rpt_2.php?pid=PC40&year=<?php echo $year ?>" target="_blank">Moulvibazar</a></b></font></td>
									<td style="border: 1px solid black; padding: 20px;"><font  color="#101b9d"><b><a href="showroom_cogs_rpt_2.php?pid=PC41&year=<?php echo $year ?>" target="_blank">Savar</a></b></font></td>
															
									<td style="border: 1px solid black; padding: 20px;"><font  color="#101b9d"><b>Total</b></font></td>
									<td style="border: 1px solid black; padding: 20px;"><font  color="#101b9d"><b>In %</b></font></td>
								</tr>

								<?php
								
								$sales1=0;
								$sales2=0;
								$sales3=0;
								$sales4=0;
								$sales5=0;
								$sales6=0;
								$sales7=0;
								$sales8=0;
								$sales9=0;
								$sales10=0;
								$sales11=0;
								$sales12=0;
								$sales13=0;
								$sales14=0;
								$sales15=0;
								$sales16=0;
								$sales17=0;
								$sales18=0;
								$sales19=0;
								$sales20=0;
								$sales21=0;
								$sales22=0;
								$sales23=0;
								$sales24=0;
								$sales25=0;
								$sales26=0;
								$sales27=0;
								$sales28=0;
								$sales29=0;
								
								$sql2=mysqli_query( $con ,$str_sales);
								while($row2=mysqli_fetch_object($sql2)){ 

								$sales1= $sales1+ ($row2->Jubilee_Road_Ctg*-1);
								$sales2= $sales2+ ($row2->Halisahar_Ctg*-1);
								$sales3= $sales3+ ($row2->Magbazar_Dh*-1);
								$sales4= $sales4+ ($row2->Monipuripara_Dhk*-1);
								$sales5= $sales5+ ($row2->Khulna*-1);
								$sales6= $sales6+ ($row2->Rajshahi*-1);
								$sales7= $sales7+ ($row2->Sylhet*-1);
								$sales8= $sales8+ ($row2->Gazipur*-1);
								$sales9= $sales9+ ($row2->Comilla*-1);
								$sales10= $sales10+ ($row2->Bogra*-1);
								$sales11= $sales11+ ($row2->Mirpur_Dhaka*-1);
								$sales12= $sales12+ ($row2->Muradpur_Ctg*-1);
								$sales13= $sales13+ ($row2->Uttara_Dhaka*-1);
								$sales14= $sales14+ ($row2->Barisal_Barisal*-1);
								$sales15= $sales15+ ($row2->Kuril_Dhaka*-1);
								$sales16= $sales16+ ($row2->Rangpur_Rajshahi*-1);
								$sales17= $sales17+ ($row2->Segunbagicha_Dhaka*-1);
								$sales18= $sales18+ ($row2->Jessore*-1);
								$sales19= $sales19+ ($row2->Feni*-1);
								$sales20= $sales20+ ($row2->Farmgate*-1);
								$sales21= $sales21+ ($row2->Coxs_Bazar*-1);
								$sales22= $sales22+ ($row2->Pabna*-1);
								$sales23= $sales23+ ($row2->Keranigonj*-1);
								$sales24= $sales24+ ($row2->Narayangonj*-1);
								$sales25= $sales25+ ($row2->Mymensingh*-1);
								$sales26= $sales26+ ($row2->Fatickchari*-1);
								$sales27= $sales27+ ($row2->SiddikBazar*-1);
								$sales28= $sales28+ ($row2->Moulvibazar*-1);
								$sales29= $sales29+ ($row2->Savar*-1);


									?>
									<tr style="text-align: center;">
									<td style="border: 1px solid black;"><font  ><b></b></font></td>	
									<td style="border: 1px solid black;"><font  ><b>Sales</b></font></td>
									<td style="border: 1px solid black;"><font  ><b><?php echo $row2->Jubilee_Road_Ctg*-1; ?></b></font></td>
									<td style="border: 1px solid black;"><font  ><b><?php echo $row2->Halisahar_Ctg*-1; ?></b></font></td>
									<td style="border: 1px solid black;"><font  ><b><?php echo $row2->Magbazar_Dh*-1; ?></b></font></td>
									<td style="border: 1px solid black;"><font  ><b><?php echo $row2->Monipuripara_Dhk*-1; ?></b></font></td>
									<td style="border: 1px solid black;"><font  ><b><?php echo $row2->Khulna*-1; ?></b></font></td>
									<td style="border: 1px solid black;"><font  ><b><?php echo $row2->Rajshahi*-1; ?></b></font></td>
									<td style="border: 1px solid black;"><font  ><b><?php echo $row2->Sylhet*-1; ?></b></font></td>
									<td style="border: 1px solid black;"><font  ><b><?php echo $row2->Gazipur*-1; ?></b></font></td>
									<td style="border: 1px solid black;"><font  ><b><?php echo $row2->Comilla*-1; ?></b></font></td>
									<td style="border: 1px solid black;"><font  ><b><?php echo $row2->Bogra*-1; ?></b></font></td>
									<td style="border: 1px solid black;"><font  ><b><?php echo $row2->Mirpur_Dhaka*-1; ?></b></font></td>
									<td style="border: 1px solid black;"><font  ><b><?php echo $row2->Muradpur_Ctg*-1; ?></b></font></td>
									<td style="border: 1px solid black;"><font  ><b><?php echo $row2->Uttara_Dhaka*-1; ?></b></font></td>
									<td style="border: 1px solid black;"><font  ><b><?php echo $row2->Barisal_Barisal*-1; ?></b></font></td>
									<td style="border: 1px solid black;"><font  ><b><?php echo $row2->Kuril_Dhaka*-1; ?></b></font></td>
									<td style="border: 1px solid black;"><font  ><b><?php echo $row2->Rangpur_Rajshahi*-1; ?></b></font></td>
									<td style="border: 1px solid black;"><font  ><b><?php echo $row2->Segunbagicha_Dhaka*-1; ?></b></font></td>
									<td style="border: 1px solid black;"><font  ><b><?php echo $row2->Jessore*-1; ?></b></font></td>
									<td style="border: 1px solid black;"><font  ><b><?php echo $row2->Feni*-1; ?></b></font></td>
									<td style="border: 1px solid black;"><font  ><b><?php echo $row2->Farmgate*-1; ?></b></font></td>
									<td style="border: 1px solid black;"><font  ><b><?php echo $row2->Coxs_Bazar*-1; ?></b></font></td>
									<td style="border: 1px solid black;"><font  ><b><?php echo $row2->Pabna*-1; ?></b></font></td>
									<td style="border: 1px solid black;"><font  ><b><?php echo $row2->Keranigonj*-1; ?></b></font></td>
									<td style="border: 1px solid black;"><font  ><b><?php echo $row2->Narayangonj*-1; ?></b></font></td>
									<td style="border: 1px solid black;"><font  ><b><?php echo $row2->Mymensingh*-1; ?></b></font></td>
									<td style="border: 1px solid black;"><font  ><b><?php echo $row2->Fatickchari*-1; ?></b></font></td>
									<td style="border: 1px solid black;"><font  ><b><?php echo $row2->SiddikBazar*-1; ?></b></font></td>
									<td style="border: 1px solid black;"><font  ><b><?php echo $row2->Moulvibazar*-1; ?></b></font></td>
									<td style="border: 1px solid black;"><font  ><b><?php echo $row2->Savar*-1; ?></b></font></td>
									

									<td style="border: 1px solid black;"><font  ><b>
										<?php 

										$totSales=($row2->Jubilee_Road_Ctg+$row2->Halisahar_Ctg+$row2->Magbazar_Dh+$row2->Monipuripara_Dhk+
										$row2->Khulna+$row2->Rajshahi+$row2->Sylhet+$row2->Gazipur+$row2->Comilla+$row2->Bogra+
										$row2->Mirpur_Dhaka+$row2->Muradpur_Ctg+$row2->Uttara_Dhaka+$row2->Barisal_Barisal+$row2->Kuril_Dhaka+$row2->Rangpur_Rajshahi+
										$row2->Segunbagicha_Dhaka+$row2->Jessore+$row2->Feni+$row2->Farmgate+$row2->Coxs_Bazar+$row2->Pabna+
										$row2->Keranigonj+$row2->Narayangonj+$row2->Mymensingh+$row2->Fatickchari+$row2->SiddikBazar+$row2->Moulvibazar+$row2->Savar)*-1;
										echo $totSales; ?>
											
									</b></font></td>

									<td style="border: 1px solid black;"><font  color="#000"><b>
										<?php 

										echo ROUND(($totSales/$totSales)*100,3); ?>%
											
									</b></font></td>
									</tr>
								
								<?php }
								?>	


								<?php
								$cogs1=0;
								$cogs2=0;
								$cogs3=0;
								$cogs4=0;
								$cogs5=0;
								$cogs6=0;
								$cogs7=0;
								$cogs8=0;
								$cogs9=0;
								$cogs10=0;
								$cogs11=0;
								$cogs12=0;
								$cogs13=0;
								$cogs14=0;
								$cogs15=0;
								$cogs16=0;
								$cogs17=0;
								$cogs18=0;
								$cogs19=0;
								$cogs20=0;
								$cogs21=0;
								$cogs22=0;
								$cogs23=0;
								$cogs24=0;
								$cogs25=0;
								$cogs26=0;
								$cogs27=0;
								$cogs28=0;
								$cogs29=0;
								
								$sql3=mysqli_query( $GLOBALS['con'] ,$str_cogs);
								while($row3=mysqli_fetch_object($sql3)){ 

								$cogs1= $cogs1+ ($row3->Jubilee_Road_Ctg);
								$cogs2= $cogs2+ ($row3->Halisahar_Ctg);
								$cogs3= $cogs3+ ($row3->Magbazar_Dh);
								$cogs4= $cogs4+ ($row3->Monipuripara_Dhk);
								$cogs5= $cogs5+ ($row3->Khulna);
								$cogs6= $cogs6+ ($row3->Rajshahi);
								$cogs7= $cogs7+ ($row3->Sylhet);
								$cogs8= $cogs8+ ($row3->Gazipur);
								$cogs9= $cogs9+ ($row3->Comilla);
								$cogs10= $cogs10+ ($row3->Bogra);
								$cogs11= $cogs11+ ($row3->Mirpur_Dhaka);
								$cogs12= $cogs12+ ($row3->Muradpur_Ctg);
								$cogs13= $cogs13+ ($row3->Uttara_Dhaka);
								$cogs14= $cogs14+ ($row3->Barisal_Barisal);
								$cogs15= $cogs15+ ($row3->Kuril_Dhaka);
								$cogs16= $cogs16+ ($row3->Rangpur_Rajshahi);
								$cogs17= $cogs17+ ($row3->Segunbagicha_Dhaka);
								$cogs18= $cogs18+ ($row3->Jessore);
								$cogs19= $cogs19+ ($row3->Feni);
								$cogs20= $cogs20+ ($row3->Farmgate);
								$cogs21= $cogs21+ ($row3->Coxs_Bazar);
								$cogs22= $cogs22+ ($row3->Pabna);
								$cogs23= $cogs23+ ($row3->Keranigonj);
								$cogs24= $cogs24+ ($row3->Narayangonj);
								$cogs25= $cogs25+ ($row3->Mymensingh);
								$cogs26= $cogs26+ ($row3->Fatickchari);
								$cogs27= $cogs27+ ($row3->SiddikBazar);
								$cogs28= $cogs28+ ($row3->Moulvibazar);
								$cogs29= $cogs29+ ($row3->Savar);

									?>

									
									<tr style="text-align: center;">
									<td style="border: 1px solid black;"><font  color="#101b9d"><b></b></font></td>	
									<td style="border: 1px solid black;"><font  color="#101b9d"><b>COGS</b></font></td>
									<td style="border: 1px solid black;"><font  ><b><?php echo $row3->Jubilee_Road_Ctg; ?></b></font></td>
									<td style="border: 1px solid black;"><font  ><b><?php echo $row3->Halisahar_Ctg; ?></b></font></td>
									<td style="border: 1px solid black;"><font  ><b><?php echo $row3->Magbazar_Dh; ?></b></font></td>
									<td style="border: 1px solid black;"><font  ><b><?php echo $row3->Monipuripara_Dhk; ?></b></font></td>
									<td style="border: 1px solid black;"><font  ><b><?php echo $row3->Khulna; ?></b></font></td>
									<td style="border: 1px solid black;"><font  ><b><?php echo $row3->Rajshahi; ?></b></font></td>
									<td style="border: 1px solid black;"><font  ><b><?php echo $row3->Sylhet; ?></b></font></td>
									<td style="border: 1px solid black;"><font  ><b><?php echo $row3->Gazipur; ?></b></font></td>
									<td style="border: 1px solid black;"><font  ><b><?php echo $row3->Comilla; ?></b></font></td>
									<td style="border: 1px solid black;"><font  ><b><?php echo $row3->Bogra; ?></b></font></td>
									<td style="border: 1px solid black;"><font  ><b><?php echo $row3->Mirpur_Dhaka; ?></b></font></td>
									<td style="border: 1px solid black;"><font  ><b><?php echo $row3->Muradpur_Ctg; ?></b></font></td>
									<td style="border: 1px solid black;"><font  ><b><?php echo $row3->Uttara_Dhaka; ?></b></font></td>
									<td style="border: 1px solid black;"><font  ><b><?php echo $row3->Barisal_Barisal; ?></b></font></td>
									<td style="border: 1px solid black;"><font  ><b><?php echo $row3->Kuril_Dhaka; ?></b></font></td>
									<td style="border: 1px solid black;"><font  ><b><?php echo $row3->Rangpur_Rajshahi; ?></b></font></td>
									<td style="border: 1px solid black;"><font  ><b><?php echo $row3->Segunbagicha_Dhaka; ?></b></font></td>
									<td style="border: 1px solid black;"><font  ><b><?php echo $row3->Jessore; ?></b></font></td>
									<td style="border: 1px solid black;"><font  ><b><?php echo $row3->Feni; ?></b></font></td>
									<td style="border: 1px solid black;"><font  ><b><?php echo $row3->Farmgate; ?></b></font></td>
									<td style="border: 1px solid black;"><font  ><b><?php echo $row3->Coxs_Bazar; ?></b></font></td>
									<td style="border: 1px solid black;"><font  ><b><?php echo $row3->Pabna; ?></b></font></td>
									<td style="border: 1px solid black;"><font  ><b><?php echo $row3->Keranigonj; ?></b></font></td>
									<td style="border: 1px solid black;"><font  ><b><?php echo $row3->Narayangonj; ?></b></font></td>
									<td style="border: 1px solid black;"><font  ><b><?php echo $row3->Mymensingh; ?></b></font></td>
									<td style="border: 1px solid black;"><font  ><b><?php echo $row3->Fatickchari; ?></b></font></td>
									<td style="border: 1px solid black;"><font  ><b><?php echo $row3->SiddikBazar; ?></b></font></td>
									<td style="border: 1px solid black;"><font  ><b><?php echo $row3->Moulvibazar; ?></b></font></td>
									<td style="border: 1px solid black;"><font  ><b><?php echo $row3->Savar; ?></b></font></td>
								

									<td style="border: 1px solid black;"><font  color="#FF0000"><b>
										<?php 
										$totCOGS=($row3->Jubilee_Road_Ctg+$row3->Halisahar_Ctg+$row3->Magbazar_Dh+$row3->Monipuripara_Dhk+
										$row3->Khulna+$row3->Rajshahi+$row3->Sylhet+$row3->Gazipur+$row3->Comilla+$row3->Bogra+
										$row3->Mirpur_Dhaka+$row3->Muradpur_Ctg+$row3->Uttara_Dhaka+$row3->Barisal_Barisal+$row3->Kuril_Dhaka+$row3->Rangpur_Rajshahi+
										$row3->Segunbagicha_Dhaka+$row3->Jessore+$row3->Feni+$row3->Farmgate+$row3->Coxs_Bazar+$row3->Pabna+
										$row3->Keranigonj+$row3->Narayangonj+$row3->Mymensingh+$row3->Fatickchari+$row3->SiddikBazar+$row3->Moulvibazar+$row3->Savar);

										echo $totCOGS; ?>
											
									</b></font></td>

									<td style="border: 1px solid black;"><font  color="#000"><b>
										<?php 

										echo ROUND(($totCOGS/$totSales)*100,3); ?>%
											
									</b></font></td>
									</tr>
								
								<?php }
								?>	






								<?php
								$gross1=0;
								$gross2=0;
								$gross3=0;
								$gross4=0;
								$gross5=0;
								$gross6=0;
								$gross7=0;
								$gross8=0;
								$gross9=0;
								$gross10=0;
								$gross11=0;
								$gross12=0;
								$gross13=0;
								$gross14=0;
								$gross15=0;
								$gross16=0;
								$gross17=0;
								$gross18=0;
								$gross19=0;
								$gross20=0;
								$gross21=0;
								$gross22=0;
								$gross23=0;
								$gross24=0;
								$gross25=0;
								$gross26=0;
								$gross27=0;
								$gross28=0;
								$gross29=0;
							

								$gross1= $sales1 - $cogs1;
								$gross2= $sales2 - $cogs2;
								$gross3= $sales3 - $cogs3;
								$gross4= $sales4 - $cogs4;
								$gross5= $sales5 - $cogs5;
								$gross6= $sales6 - $cogs6;
								$gross7= $sales7 - $cogs7;
								$gross8= $sales8 - $cogs8;
								$gross9= $sales9 - $cogs9;
								$gross10= $sales10 - $cogs10;
								$gross11= $sales11 - $cogs11;
								$gross12= $sales12 - $cogs12;
								$gross13= $sales13 - $cogs13;
								$gross14= $sales14 - $cogs14;
								$gross15= $sales15 - $cogs15;
								$gross16= $sales16 - $cogs16;
								$gross17= $sales17 - $cogs17;
								$gross18= $sales18 - $cogs18;
								$gross19= $sales19 - $cogs19;
								$gross20= $sales20 - $cogs20;
								$gross21= $sales21 - $cogs21;
								$gross22= $sales22 - $cogs22;
								$gross23= $sales23 - $cogs23;
								$gross24= $sales24 - $cogs24;
								$gross25= $sales25 - $cogs25;
								$gross26= $sales26 - $cogs26;
								$gross27= $sales27 - $cogs27;
								$gross28= $sales28 - $cogs28;
								$gross29= $sales29 - $cogs29;

									?>

									
									<tr style="text-align: center;">
									<td style="border: 1px solid black;"><font  ><b></b></font></td>	
									<td style="border: 1px solid black;"><font  ><b>Gross Profit</b></font></td>
									<td style="border: 1px solid black;"><font  ><b><?php echo $gross1; ?></b></font></td>
									<td style="border: 1px solid black;"><font  ><b><?php echo $gross2; ?></b></font></td>
									<td style="border: 1px solid black;"><font  ><b><?php echo $gross3; ?></b></font></td>
									<td style="border: 1px solid black;"><font  ><b><?php echo $gross4; ?></b></font></td>
									<td style="border: 1px solid black;"><font  ><b><?php echo $gross5; ?></b></font></td>
									<td style="border: 1px solid black;"><font  ><b><?php echo $gross6; ?></b></font></td>
									<td style="border: 1px solid black;"><font  ><b><?php echo $gross7; ?></b></font></td>
									<td style="border: 1px solid black;"><font  ><b><?php echo $gross8; ?></b></font></td>
									<td style="border: 1px solid black;"><font  ><b><?php echo $gross9; ?></b></font></td>
									<td style="border: 1px solid black;"><font  ><b><?php echo $gross10; ?></b></font></td>
									<td style="border: 1px solid black;"><font  ><b><?php echo $gross11; ?></b></font></td>
									<td style="border: 1px solid black;"><font  ><b><?php echo $gross12; ?></b></font></td>
									<td style="border: 1px solid black;"><font  ><b><?php echo $gross13; ?></b></font></td>
									<td style="border: 1px solid black;"><font  ><b><?php echo $gross14; ?></b></font></td>
									<td style="border: 1px solid black;"><font  ><b><?php echo $gross15; ?></b></font></td>
									<td style="border: 1px solid black;"><font  ><b><?php echo $gross16; ?></b></font></td>
									<td style="border: 1px solid black;"><font  ><b><?php echo $gross17; ?></b></font></td>
									<td style="border: 1px solid black;"><font  ><b><?php echo $gross18; ?></b></font></td>
									<td style="border: 1px solid black;"><font  ><b><?php echo $gross19; ?></b></font></td>
									<td style="border: 1px solid black;"><font  ><b><?php echo $gross20; ?></b></font></td>
									<td style="border: 1px solid black;"><font  ><b><?php echo $gross21; ?></b></font></td>
									<td style="border: 1px solid black;"><font  ><b><?php echo $gross22; ?></b></font></td>
									<td style="border: 1px solid black;"><font  ><b><?php echo $gross23; ?></b></font></td>
									<td style="border: 1px solid black;"><font  ><b><?php echo $gross24; ?></b></font></td>
									<td style="border: 1px solid black;"><font  ><b><?php echo $gross25; ?></b></font></td>
									<td style="border: 1px solid black;"><font  ><b><?php echo $gross26; ?></b></font></td>
									<td style="border: 1px solid black;"><font  ><b><?php echo $gross27; ?></b></font></td>
									<td style="border: 1px solid black;"><font  ><b><?php echo $gross28; ?></b></font></td>
									<td style="border: 1px solid black;"><font  ><b><?php echo $gross29; ?></b></font></td>
									

									<td style="border: 1px solid black;"><font  ><b>
										<?php 
										$totGross=($gross1+$gross2+$gross3+$gross4+$gross5+$gross6+$gross7+
										$gross8+$gross9+$gross10+$gross11+$gross12+$gross13+$gross14+$gross15+$gross16+$gross17+$gross18+$gross19+$gross20+
										$gross21+$gross22+$gross23+$gross24+$gross25+$gross26+$gross27+$gross28+$gross29);

										echo $totGross; ?>
											
									</b></font></td>


									<td style="border: 1px solid black;"><font  color="#000"><b>
										<?php 

										echo ROUND(($totGross/$totSales)*100,3); ?>%
											
									</b></font></td>
									</tr>
								
							




								<tr style="text-align: center;">
									<td style="border: 1px solid black;"><font  color="#101b9d"><b>Code</b></font></td>
									<td style="border: 1px solid black;" ><font  color="#101b9d"><b>Operating&nbsp;Cost</b></font></td>
									<td style="border: 1px solid black;"><font  color="#101b9d"><b></b></font></td>
									<td style="border: 1px solid black;"><font  color="#101b9d"><b></b></font></td>
									<td style="border: 1px solid black;"><font  color="#101b9d"><b></b></font></td>
									<td style="border: 1px solid black;"><font  color="#101b9d"><b></b></font></td>
									<td style="border: 1px solid black;"><font  color="#101b9d"><b></b></font></td>
									<td style="border: 1px solid black;"><font  color="#101b9d"><b></b></font></td>
									<td style="border: 1px solid black;"><font  color="#101b9d"><b></b></font></td>
									<td style="border: 1px solid black;"><font  color="#101b9d"><b></b></font></td>
									<td style="border: 1px solid black;"><font  color="#101b9d"><b></b></font></td>
									<td style="border: 1px solid black;"><font  color="#101b9d"><b></b></font></td>
									<td style="border: 1px solid black;"><font  color="#101b9d"><b></b></font></td>
									<td style="border: 1px solid black;"><font  color="#101b9d"><b></b></font></td>
									<td style="border: 1px solid black;"><font  color="#101b9d"><b></b></font></td>
									<td style="border: 1px solid black;"><font  color="#101b9d"><b></b></font></td>
									<td style="border: 1px solid black;"><font  color="#101b9d"><b></b></font></td>
									<td style="border: 1px solid black;"><font  color="#101b9d"><b></b></font></td>
									<td style="border: 1px solid black;"><font  color="#101b9d"><b></b></font></td>
									<td style="border: 1px solid black;"><font  color="#101b9d"><b></b></font></td>
									<td style="border: 1px solid black;"><font  color="#101b9d"><b></b></font></td>
									<td style="border: 1px solid black;"><font  color="#101b9d"><b></b></font></td>
									<td style="border: 1px solid black;"><font  color="#101b9d"><b></b></font></td>
									<td style="border: 1px solid black;"><font  color="#101b9d"><b></b></font></td>
									<td style="border: 1px solid black;"><font  color="#101b9d"><b></b></font></td>
									<td style="border: 1px solid black;"><font  color="#101b9d"><b></b></font></td>
									<td style="border: 1px solid black;"><font  color="#101b9d"><b></b></font></td>
									<td style="border: 1px solid black;"><font  color="#101b9d"><b></b></font></td>
									<td style="border: 1px solid black;"><font  color="#101b9d"><b></b></font></td>
									<td style="border: 1px solid black;"><font  color="#101b9d"><b></b></font></td>
									<td style="border: 1px solid black;"><font  color="#101b9d"><b></b></font></td>
									<td style="border: 1px solid black;"><font  color="#101b9d"><b></b></font></td>
								</tr>

								<?php
								$result1=0;
								$result2=0;
								$result3=0;
								$result4=0;
								$result5=0;
								$result6=0;
								$result7=0;
								$result8=0;
								$result9=0;
								$result10=0;
								$result11=0;
								$result12=0;
								$result13=0;
								$result14=0;
								$result15=0;
								$result16=0;
								$result17=0;
								$result18=0;
								$result19=0;
								$result20=0;
								$result21=0;
								$result22=0;
								$result23=0;
								$result24=0;
								$result25=0;
								$result26=0;
								$result27=0;	
								$result28=0;	
								$result29=0;	

								$sql=mysqli_query( $GLOBALS['con'] ,$str_result);
								while($row=mysqli_fetch_object($sql)){  

								$result1= $result1+ ($row->Jubilee_Road_Ctg);
								$result2= $result2+ ($row->Halisahar_Ctg);
								$result3= $result3+ ($row->Magbazar_Dh);
								$result4= $result4+ ($row->Monipuripara_Dhk);
								$result5= $result5+ ($row->Khulna);
								$result6= $result6+ ($row->Rajshahi);
								$result7= $result7+ ($row->Sylhet);
								$result8= $result8+ ($row->Gazipur);
								$result9= $result9+ ($row->Comilla);
								$result10= $result10+ ($row->Bogra);
								$result11= $result11+ ($row->Mirpur_Dhaka);
								$result12= $result12+ ($row->Muradpur_Ctg);
								$result13= $result13+ ($row->Uttara_Dhaka);
								$result14= $result14+ ($row->Barisal_Barisal);
								$result15= $result15+ ($row->Kuril_Dhaka);
								$result16= $result16+ ($row->Rangpur_Rajshahi);
								$result17= $result17+ ($row->Segunbagicha_Dhaka);
								$result18= $result18+ ($row->Jessore);
								$result19= $result19+ ($row->Feni);
								$result20= $result20+ ($row->Farmgate);
								$result21= $result21+ ($row->Coxs_Bazar);
								$result22= $result22+ ($row->Pabna);
								$result23= $result23+ ($row->Keranigonj);
								$result24= $result24+ ($row->Narayangonj);
								$result25= $result25+ ($row->Mymensingh);
								$result26= $result26+ ($row->Fatickchari);
								$result27= $result27+ ($row->SiddikBazar);
								$result28= $result28+ ($row->Moulvibazar);
								$result29= $result29+ ($row->Savar);
								?>
									<tr style="text-align: center;">
									<td style="border: 1px solid black;"><font  color="#000000"><b><?php echo $row->hcode; ?>&nbsp;</b></font></td>
									<td style="border: 1px solid black;"><font  color="#000000"><b><?php echo $row->head_name; ?>&nbsp;</b></font></td>
									<td style="border: 1px solid black;"><font  ><b><?php echo $row->Jubilee_Road_Ctg; ?></b></font></td>
									<td style="border: 1px solid black;"><font  ><b><?php echo $row->Halisahar_Ctg; ?></b></font></td>
									<td style="border: 1px solid black;"><font  ><b><?php echo $row->Magbazar_Dh; ?></b></font></td>
									<td style="border: 1px solid black;"><font  ><b><?php echo $row->Monipuripara_Dhk; ?></b></font></td>
									<td style="border: 1px solid black;"><font  ><b><?php echo $row->Khulna; ?></b></font></td>
									<td style="border: 1px solid black;"><font  ><b><?php echo $row->Rajshahi; ?></b></font></td>
									<td style="border: 1px solid black;"><font  ><b><?php echo $row->Sylhet; ?></b></font></td>
									<td style="border: 1px solid black;"><font  ><b><?php echo $row->Gazipur; ?></b></font></td>
									<td style="border: 1px solid black;"><font  ><b><?php echo $row->Comilla; ?></b></font></td>
									<td style="border: 1px solid black;"><font  ><b><?php echo $row->Bogra; ?></b></font></td>
									<td style="border: 1px solid black;"><font  ><b><?php echo $row->Mirpur_Dhaka; ?></b></font></td>
									<td style="border: 1px solid black;"><font  ><b><?php echo $row->Muradpur_Ctg; ?></b></font></td>
									<td style="border: 1px solid black;"><font  ><b><?php echo $row->Uttara_Dhaka; ?></b></font></td>
									<td style="border: 1px solid black;"><font  ><b><?php echo $row->Barisal_Barisal; ?></b></font></td>
									<td style="border: 1px solid black;"><font  ><b><?php echo $row->Kuril_Dhaka; ?></b></font></td>
									<td style="border: 1px solid black;"><font  ><b><?php echo $row->Rangpur_Rajshahi; ?></b></font></td>
									<td style="border: 1px solid black;"><font  ><b><?php echo $row->Segunbagicha_Dhaka; ?></b></font></td>
									<td style="border: 1px solid black;"><font  ><b><?php echo $row->Jessore; ?></b></font></td>
									<td style="border: 1px solid black;"><font  ><b><?php echo $row->Feni; ?></b></font></td>
									<td style="border: 1px solid black;"><font  ><b><?php echo $row->Farmgate; ?></b></font></td>
									<td style="border: 1px solid black;"><font  ><b><?php echo $row->Coxs_Bazar; ?></b></font></td>
									<td style="border: 1px solid black;"><font  ><b><?php echo $row->Pabna; ?></b></font></td>
									<td style="border: 1px solid black;"><font  ><b><?php echo $row->Keranigonj; ?></b></font></td>
									<td style="border: 1px solid black;"><font  ><b><?php echo $row->Narayangonj; ?></b></font></td>
									<td style="border: 1px solid black;"><font  ><b><?php echo $row->Mymensingh; ?></b></font></td>
									<td style="border: 1px solid black;"><font  ><b><?php echo $row->Fatickchari; ?></b></font></td>
									<td style="border: 1px solid black;"><font  ><b><?php echo $row->SiddikBazar; ?></b></font></td>
									<td style="border: 1px solid black;"><font  ><b><?php echo $row->Moulvibazar; ?></b></font></td>
									<td style="border: 1px solid black;"><font  ><b><?php echo $row->Savar; ?></b></font></td>
									

									<td style="border: 1px solid black;"><font  color="#000000"><b>
										<?php 
										$total1 = $row->Jubilee_Road_Ctg+$row->Halisahar_Ctg+$row->Magbazar_Dh+$row->Monipuripara_Dhk+
										$row->Khulna+$row->Rajshahi+$row->Sylhet+$row->Gazipur+$row->Comilla+$row->Bogra+
										$row->Mirpur_Dhaka+$row->Muradpur_Ctg+$row->Uttara_Dhaka+$row->Barisal_Barisal+$row->Kuril_Dhaka+$row->Rangpur_Rajshahi+
										$row->Segunbagicha_Dhaka+$row->Jessore+$row->Feni+$row->Farmgate+$row->Coxs_Bazar+$row->Pabna+
										$row->Keranigonj+$row->Narayangonj+$row->Mymensingh+$row->Fatickchari+$row->SiddikBazar+$row->Moulvibazar+$row->Savar; 

										echo $total1;
										?>
											
									</b></font></td>

									

									<td style="border: 1px solid black;"><font  color="#000"><b>
										<?php 

										echo ROUND(($total1/$totSales)*100,3); ?>%
											
									</b></font></td>
								</tr>	

								<?php

								}	
								?>


								

								<tr style="text-align: center;">
									<td style="border: 1px solid black;" colspan="2"><font  color=""><b>Total Operating Cost</b></font></td>

									<td style="border: 1px solid black;"><font  color="<?php echo ($result1<0)?'#FF0000':'#339966'; ?>"><b><?php echo $result1; ?></b></font></td>
									<td style="border: 1px solid black;"><font  color="<?php echo ($result2<0)?'#FF0000':'#339966'; ?>"><b><?php echo $result2; ?></b></font></td>
									<td style="border: 1px solid black;"><font  color="<?php echo ($result3<0)?'#FF0000':'#339966'; ?>"><b><?php echo $result3; ?></b></font></td>
									<td style="border: 1px solid black;"><font  color="<?php echo ($result4<0)?'#FF0000':'#339966'; ?>"><b><?php echo $result4; ?></b></font></td>
									<td style="border: 1px solid black;"><font  color="<?php echo ($result5<0)?'#FF0000':'#339966'; ?>"><b><?php echo $result5; ?></b></font></td>
									<td style="border: 1px solid black;"><font  color="<?php echo ($result6<0)?'#FF0000':'#339966'; ?>"><b><?php echo $result6; ?></b></font></td>
									<td style="border: 1px solid black;"><font  color="<?php echo ($result7<0)?'#FF0000':'#339966'; ?>"><b><?php echo $result7; ?></b></font></td>
									<td style="border: 1px solid black;"><font  color="<?php echo ($result8<0)?'#FF0000':'#339966'; ?>"><b><?php echo $result8; ?></b></font></td>
									<td style="border: 1px solid black;"><font  color="<?php echo ($result9<0)?'#FF0000':'#339966'; ?>"><b><?php echo $result9; ?></b></font></td>
									<td style="border: 1px solid black;"><font  color="<?php echo ($result10<0)?'#FF0000':'#339966'; ?>"><b><?php echo $result10; ?></b></font></td>
									<td style="border: 1px solid black;"><font  color="<?php echo ($result11<0)?'#FF0000':'#339966'; ?>"><b><?php echo $result11; ?></b></font></td>
									<td style="border: 1px solid black;"><font  color="<?php echo ($result12<0)?'#FF0000':'#339966'; ?>"><b><?php echo $result12; ?></b></font></td>
									<td style="border: 1px solid black;"><font  color="<?php echo ($result13<0)?'#FF0000':'#339966'; ?>"><b><?php echo $result13; ?></b></font></td>
									<td style="border: 1px solid black;"><font  color="<?php echo ($result14<0)?'#FF0000':'#339966'; ?>"><b><?php echo $result14; ?></b></font></td>
									<td style="border: 1px solid black;"><font  color="<?php echo ($result15<0)?'#FF0000':'#339966'; ?>"><b><?php echo $result15; ?></b></font></td>
									<td style="border: 1px solid black;"><font  color="<?php echo ($result16<0)?'#FF0000':'#339966'; ?>"><b><?php echo $result16; ?></b></font></td>
									<td style="border: 1px solid black;"><font  color="<?php echo ($result17<0)?'#FF0000':'#339966'; ?>"><b><?php echo $result17; ?></b></font></td>
									<td style="border: 1px solid black;"><font  color="<?php echo ($result18<0)?'#FF0000':'#339966'; ?>"><b><?php echo $result18; ?></b></font></td>
									<td style="border: 1px solid black;"><font  color="<?php echo ($result19<0)?'#FF0000':'#339966'; ?>"><b><?php echo $result19; ?></b></font></td>
									<td style="border: 1px solid black;"><font  color="<?php echo ($result20<0)?'#FF0000':'#339966'; ?>"><b><?php echo $result20; ?></b></font></td>
									<td style="border: 1px solid black;"><font  color="<?php echo ($result21<0)?'#FF0000':'#339966'; ?>"><b><?php echo $result21; ?></b></font></td>
									<td style="border: 1px solid black;"><font  color="<?php echo ($result22<0)?'#FF0000':'#339966'; ?>"><b><?php echo $result22; ?></b></font></td>
									<td style="border: 1px solid black;"><font  color="<?php echo ($result23<0)?'#FF0000':'#339966'; ?>"><b><?php echo $result23; ?></b></font></td>
									<td style="border: 1px solid black;"><font  color="<?php echo ($result24<0)?'#FF0000':'#339966'; ?>"><b><?php echo $result24; ?></b></font></td>
									<td style="border: 1px solid black;"><font  color="<?php echo ($result25<0)?'#FF0000':'#339966'; ?>"><b><?php echo $result25; ?></b></font></td>
									<td style="border: 1px solid black;"><font  color="<?php echo ($result26<0)?'#FF0000':'#339966'; ?>"><b><?php echo $result26; ?></b></font></td>
									<td style="border: 1px solid black;"><font  color="<?php echo ($result27<0)?'#FF0000':'#339966'; ?>"><b><?php echo $result27; ?></b></font></td>
									<td style="border: 1px solid black;"><font  color="<?php echo ($result27<0)?'#FF0000':'#339966'; ?>"><b><?php echo $result28; ?></b></font></td>
									<td style="border: 1px solid black;"><font  color="<?php echo ($result27<0)?'#FF0000':'#339966'; ?>"><b><?php echo $result29; ?></b></font></td>
									

									<td style="border: 1px solid black;">
										<?php 
										$totOpCost=($result1+$result2+$result3+$result4+$result5+$result6+$result7+
										$result8+$result9+$result10+$result11+$result12+$result13+$result14+$result15+$result16+$result17+$result18+$result19+$result20+
										$result21+$result22+$result23+$result24+$result25+$result26+$result27+$result28+$result29);
										?>
										<font  color="<?php echo ($totOpCost<0)?'#FF0000':'#b64bac'; ?>"><b>
										<?php
										echo $totOpCost; ?>
											
									</b></font></td>
									

									<td style="border: 1px solid black;"><font  color="#000"><b>
										<?php 

										echo ROUND(($totOpCost/$totSales)*100,3); ?>%
											
									</b></font></td>
								</tr>

								<?php
								$td1=0;
								$td2=0;
								$td3=0;
								$td4=0;
								$td5=0;
								$td6=0;
								$td7=0;
								$td8=0;
								$td9=0;
								$td10=0;
								$td11=0;
								$td12=0;
								$td13=0;
								$td14=0;
								$td15=0;
								$td16=0;
								$td17=0;
								$td18=0;
								$td19=0;
								$td20=0;
								$td21=0;
								$td22=0;
								$td23=0;
								$td24=0;
								$td25=0;
								$td26=0;
								$td27=0;
								$td28=0;
								$td29=0;
								
								$td1= $gross1 - $result1;
								$td2= $gross2 - $result2;
								$td3= $gross3 - $result3;
								$td4= $gross4 - $result4;
								$td5= $gross5 - $result5;
								$td6= $gross6 - $result6;
								$td7= $gross7 - $result7;
								$td8= $gross8 - $result8;
								$td9= $gross9 - $result9;
								$td10= $gross10 - $result10;
								$td11= $gross11 - $result11;
								$td12= $gross12 - $result12;
								$td13= $gross13 - $result13;
								$td14= $gross14 - $result14;
								$td15= $gross15 - $result15;
								$td16= $gross16 - $result16;
								$td17= $gross17 - $result17;
								$td18= $gross18 - $result18;
								$td19= $gross19 - $result19;
								$td20= $gross20 - $result20;
								$td21= $gross21 - $result21;
								$td22= $gross22 - $result22;
								$td23= $gross23 - $result23;
								$td24= $gross24 - $result24;
								$td25= $gross25 - $result25;
								$td26= $gross26 - $result26;
								$td27= $gross27 - $result27;
								$td28= $gross28 - $result28;
								$td29= $gross29 - $result29;

									?>

									
									<tr style="text-align: center;">
									<td style="border: 1px solid black;" colspan="2"><font  ><b>Trading Profit</b></font></td>

									<td style="border: 1px solid black;"><font  color="<?php echo ($td1<0)?'#FF0000':'#339966'; ?>"><b><?php echo $td1; ?></b></font></td>
									<td style="border: 1px solid black;"><font  color="<?php echo ($td2<0)?'#FF0000':'#339966'; ?>"><b><?php echo $td2; ?></b></font></td>
									<td style="border: 1px solid black;"><font  color="<?php echo ($td3<0)?'#FF0000':'#339966'; ?>"><b><?php echo $td3; ?></b></font></td>
									<td style="border: 1px solid black;"><font  color="<?php echo ($td4<0)?'#FF0000':'#339966'; ?>"><b><?php echo $td4; ?></b></font></td>
									<td style="border: 1px solid black;"><font  color="<?php echo ($td5<0)?'#FF0000':'#339966'; ?>"><b><?php echo $td5; ?></b></font></td>
									<td style="border: 1px solid black;"><font  color="<?php echo ($td6<0)?'#FF0000':'#339966'; ?>"><b><?php echo $td6; ?></b></font></td>
									<td style="border: 1px solid black;"><font  color="<?php echo ($td7<0)?'#FF0000':'#339966'; ?>"><b><?php echo $td7; ?></b></font></td>
									<td style="border: 1px solid black;"><font  color="<?php echo ($td8<0)?'#FF0000':'#339966'; ?>"><b><?php echo $td8; ?></b></font></td>
									<td style="border: 1px solid black;"><font  color="<?php echo ($td9<0)?'#FF0000':'#339966'; ?>"><b><?php echo $td9; ?></b></font></td>
									<td style="border: 1px solid black;"><font  color="<?php echo ($td10<0)?'#FF0000':'#339966'; ?>"><b><?php echo $td10; ?></b></font></td>
									<td style="border: 1px solid black;"><font  color="<?php echo ($td11<0)?'#FF0000':'#339966'; ?>"><b><?php echo $td11; ?></b></font></td>
									<td style="border: 1px solid black;"><font  color="<?php echo ($td12<0)?'#FF0000':'#339966'; ?>"><b><?php echo $td12; ?></b></font></td>
									<td style="border: 1px solid black;"><font  color="<?php echo ($td13<0)?'#FF0000':'#339966'; ?>"><b><?php echo $td13; ?></b></font></td>
									<td style="border: 1px solid black;"><font  color="<?php echo ($td14<0)?'#FF0000':'#339966'; ?>"><b><?php echo $td14; ?></b></font></td>
									<td style="border: 1px solid black;"><font  color="<?php echo ($td15<0)?'#FF0000':'#339966'; ?>"><b><?php echo $td15; ?></b></font></td>
									<td style="border: 1px solid black;"><font  color="<?php echo ($td16<0)?'#FF0000':'#339966'; ?>"><b><?php echo $td16; ?></b></font></td>
									<td style="border: 1px solid black;"><font  color="<?php echo ($td17<0)?'#FF0000':'#339966'; ?>"><b><?php echo $td17; ?></b></font></td>
									<td style="border: 1px solid black;"><font  color="<?php echo ($td18<0)?'#FF0000':'#339966'; ?>"><b><?php echo $td18; ?></b></font></td>
									<td style="border: 1px solid black;"><font  color="<?php echo ($td19<0)?'#FF0000':'#339966'; ?>"><b><?php echo $td19; ?></b></font></td>
									<td style="border: 1px solid black;"><font  color="<?php echo ($td20<0)?'#FF0000':'#339966'; ?>"><b><?php echo $td20; ?></b></font></td>
									<td style="border: 1px solid black;"><font  color="<?php echo ($td21<0)?'#FF0000':'#339966'; ?>"><b><?php echo $td21; ?></b></font></td>
									<td style="border: 1px solid black;"><font  color="<?php echo ($td22<0)?'#FF0000':'#339966'; ?>"><b><?php echo $td22; ?></b></font></td>
									<td style="border: 1px solid black;"><font  color="<?php echo ($td23<0)?'#FF0000':'#339966'; ?>"><b><?php echo $td23; ?></b></font></td>
									<td style="border: 1px solid black;"><font  color="<?php echo ($td24<0)?'#FF0000':'#339966'; ?>"><b><?php echo $td24; ?></b></font></td>
									<td style="border: 1px solid black;"><font  color="<?php echo ($td25<0)?'#FF0000':'#339966'; ?>"><b><?php echo $td25; ?></b></font></td>
									<td style="border: 1px solid black;"><font  color="<?php echo ($td26<0)?'#FF0000':'#339966'; ?>"><b><?php echo $td26; ?></b></font></td>
									<td style="border: 1px solid black;"><font  color="<?php echo ($td27<0)?'#FF0000':'#339966'; ?>"><b><?php echo $td27; ?></b></font></td>
									<td style="border: 1px solid black;"><font  color="<?php echo ($td28<0)?'#FF0000':'#339966'; ?>"><b><?php echo $td28; ?></b></font></td>
									<td style="border: 1px solid black;"><font  color="<?php echo ($td29<0)?'#FF0000':'#339966'; ?>"><b><?php echo $td29; ?></b></font></td>
									

									<td style="border: 1px solid black;">
										<?php 
										$totNet=($td1+$td2+$td3+$td4+$td5+$td6+$td7+
										$td8+$td9+$td10+$td11+$td12+$td13+$td14+$td15+$td16+$td17+$td18+$td19+$td20+
										$td21+$td22+$td23+$td24+$td25+$td26+$td27+$td28+$td29);
										?>
										<font  color="<?php echo ($totNet<0)?'#FF0000':'#b64bac'; ?>"><b>
										<?php
										echo $totNet; ?>
											
									</b></font></td>
									

									<td style="border: 1px solid black;"><font  color="#000"><b>
										<?php 

										echo ROUND(($totNet/$totSales)*100,3); ?>%
											
									</b></font></td>
									</tr>




							</table>


						</td>		
					</tr>
				</table>	

				




	


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



