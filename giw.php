
<?php
include_once("db.php");


$giwv	=	$_GET['giwv'];

$csdate	=	$_GET['csdate'];

$cedate	=	$_GET['cedate'];

$osdate	=	$_GET['osdate'];

$oedate	=	$_GET['oedate'];


$BUKRS="1000,2000,5000";

$TEAM="'CR','BD','SR'";

if($giwv==1)
{
$BUKRS="1000";

$TEAM="'CR'";	
	
}

else if($giwv==2)
{
$BUKRS="2000";

$TEAM="'CR'";	
	
}

else if($giwv==3)
{
$BUKRS="1000,2000,5000";

$TEAM="'BD','SR'";
	
}	

//-ITEM Growth
//PEDROLLO
$str="select
(select ifnull(sum(NETWR),0) as tot from sap_sales_process where FKDAT>='$csdate' and FKDAT<='$cedate'
and SPART=20 and CTAG in($TEAM) and BUKRS in ($BUKRS)
) as newtot,
(select ifnull(sum(NETWR),0) as tot from sap_sales_process where FKDAT>='$osdate' and FKDAT<='$oedate'
and SPART=20 and CTAG in($TEAM) and BUKRS in ($BUKRS) ) as oldtot";
//echo $str;

$sql=mysqli_query( $GLOBALS['con'] ,$str );
$rowItm=mysqli_fetch_object($sql);	

$pedGrv	=	$rowItm->newtot-$rowItm->oldtot;
if($pedGrv==0 or $rowItm->oldtot==0) $pedGrp=0;
else
$pedGrp=  round(($pedGrv/$rowItm->oldtot)*100,2);

//echo $str;


//HCP

$str="select
(select ifnull(sum(NETWR),0) as tot from sap_sales_process where FKDAT>='$csdate' and FKDAT<='$cedate'
and SPART=30 and CTAG in($TEAM)  and BUKRS in ($BUKRS)
) as newtot,
(select ifnull(sum(NETWR),0) as tot from sap_sales_process where FKDAT>='$osdate' and FKDAT<='$oedate'
and SPART=30 and CTAG in($TEAM) and BUKRS in ($BUKRS)) as oldtot";

//echo $str;
$sql=mysqli_query( $GLOBALS['con'] ,$str );
$rowItm=mysqli_fetch_object($sql);	

$hcpGrv	=	$rowItm->newtot-$rowItm->oldtot;
if($hcpGrv==0 or $rowItm->oldtot==0) $hcpGrp=0;
else
$hcpGrp=  round(($hcpGrv/$rowItm->oldtot)*100,2);





//BGFLOW

$str="select
(select ifnull(sum(NETWR),0) as tot from sap_sales_process where FKDAT>='$csdate' and FKDAT<='$cedate'
and SPART=50 and CTAG in($TEAM) and BUKRS in ($BUKRS)
) as newtot,
(select ifnull(sum(NETWR),0) as tot from sap_sales_process where FKDAT>='$osdate' and FKDAT<='$oedate'
and SPART=50 and CTAG in($TEAM) and BUKRS in ($BUKRS)) as oldtot";
$sql=mysqli_query( $GLOBALS['con'] ,$str );
$rowItm=mysqli_fetch_object($sql);	

$bgGrv	=	$rowItm->newtot-$rowItm->oldtot;
if($bgGrv==0 or $rowItm->oldtot==0) $bgGrp=0;
else
$bgGrp=  round(($bgGrv/$rowItm->oldtot)*100,2);



//ITAP

$str="select
(select ifnull(sum(NETWR),0) as tot from sap_sales_process where FKDAT>='$csdate' and FKDAT<='$cedate'
and SPART=60 and CTAG in($TEAM) and BUKRS in ($BUKRS)
) as newtot,
(select ifnull(sum(NETWR),0) as tot from sap_sales_process where FKDAT>='$osdate' and FKDAT<='$oedate'
and SPART=60 and CTAG in($TEAM) and BUKRS in ($BUKRS)) as oldtot";
$sql=mysqli_query( $GLOBALS['con'] ,$str );
$rowItm=mysqli_fetch_object($sql);	

$itapGrv	=	$rowItm->newtot-$rowItm->oldtot;
if($itapGrv==0 or $rowItm->oldtot==0) $itapGrp=0;
else
$itapGrp=  round(($itapGrv/$rowItm->oldtot)*100,2);




//SAER

$str="select
(select ifnull(sum(NETWR),0) as tot from sap_sales_process where FKDAT>='$csdate' and FKDAT<='$cedate'
and SPART=51 and CTAG in($TEAM) and BUKRS in ($BUKRS)
) as newtot,
(select ifnull(sum(NETWR),0) as tot from sap_sales_process where FKDAT>='$osdate' and FKDAT<='$oedate'
and SPART=51 and CTAG in($TEAM) and BUKRS in ($BUKRS)) as oldtot";
$sql=mysqli_query( $GLOBALS['con'] ,$str );
$rowItm=mysqli_fetch_object($sql);	

$saerGrv	=	$rowItm->newtot-$rowItm->oldtot;
if($saerGrv==0 or $rowItm->oldtot==0) $saerGrp=0;
else
$saerGrp=  round(($saerGrv/$rowItm->oldtot)*100,2);





//Other

$str="select
(select ifnull(sum(NETWR),0) as tot from sap_sales_process where FKDAT>='$csdate' and FKDAT<='$cedate'
and SPART not in(20,30,50,60,51) and CTAG in($TEAM) and BUKRS in ($BUKRS)
) as newtot,
(select ifnull(sum(NETWR),0) as tot from sap_sales_process where FKDAT>='$osdate' and FKDAT<='$oedate'
and SPART not in(20,30,50,60,51) and CTAG in($TEAM) and BUKRS in ($BUKRS)) as oldtot";
$sql=mysqli_query( $GLOBALS['con'] ,$str );
$rowItm=mysqli_fetch_object($sql);	

$othGrv	=	$rowItm->newtot-$rowItm->oldtot;
if($othGrv==0 or $rowItm->oldtot==0) $othGrp=0;
else
$othGrp=  round(($othGrv/$rowItm->oldtot)*100,2);




?>


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

  </head>
  <body>
	  
		
	<table class="table table-striped" >		
		
		<?php if($giwv!=2){ ?>
		<tr>
			<td><font size="4" color="#404548">Pedrollo:</font></td>
			<td><font  color="#108C08"><?php echo round($pedGrv/10000000,2) ?> </font></td>
			<td align="right"><font size="4" color="#108C08"><?php echo $pedGrp; ?>%</font><?php if($pedGrp>0){ ?> <img src="pic/up.png" height="20"  /><?php }else if($pedGrp<0){ ?><img src="pic/down.gif" height="20"  /><?php } ?></td>						
		</tr>
		<?php } ?>
		<?php if($giwv!=2){ ?>
		<tr>
			<td><font size="4" color="#404548">HCP:</font></td>
			<td ><font  color="#108C08"><?php echo round($hcpGrv/10000000,2) ?> </font></td>									
			<td align="right"><font size="4" color="#108C08"><?php echo $hcpGrp; ?>%</font><?php if($hcpGrp>0){ ?> <img src="pic/up.png" height="20"  /><?php }else if($hcpGrp<0){ ?><img src="pic/down.gif" height="20"  /><?php } ?></td>						
		</tr>
		<?php } ?>
		
		<?php if($giwv!=1){ ?>
		<tr>
			<td><font size="4" color="#404548">BGFlow:</font></td>
			<td><font  color="#108C08"><?php echo round($bgGrv/10000000,2) ?> </font></td>
			<td align="right"><font size="4" color="#108C08"><?php echo $bgGrp; ?>%</font><?php if($bgGrp>0){ ?> <img src="pic/up.png" height="20"  /><?php }else if($bgGrp<0){ ?><img src="pic/down.gif" height="20"  /><?php } ?></td>						
		</tr>
		<?php } ?>
		<?php if($giwv!=2){ ?>
		<tr>
			<td><font size="4" color="#404548">SAER:</font></td>
			<td><font  color="#108C08"><?php echo round($saerGrv/10000000,2) ?> </font></td>
			
			<td align="right"><font size="4" color="#108C08"><?php echo $saerGrp; ?>%</font><?php if($saerGrp>0){ ?> <img src="pic/up.png" height="20"  /><?php }else if($saerGrp<0){ ?><img src="pic/down.gif" height="20"  /><?php } ?></td>						
		</tr>
		<?php } ?>
		<?php if($giwv!=1){ ?>
		<tr>
			<td><font size="4" color="#404548">ITAP:</font></td>
			<td><font  color="#108C08"><?php echo round($itapGrv/10000000,2) ?> </font></td>
			<td align="right"><font size="4" color="#108C08"><?php echo $itapGrp; ?>%</font><?php if($itapGrp>0){ ?> <img src="pic/up.png" height="20"  /><?php }else if($itapGrp<0){ ?><img src="pic/down.gif" height="20"  /><?php } ?></td>						
		</tr>
		<?php } ?> 
		<?php if($giwv!=1){ ?>
		<tr>
			<td><font size="4" color="#404548">Other:</font></td>
			<td><font  color="#108C08"><?php echo round($othGrv/10000000,2) ?> </font></td>
			<td align="right"><font size="4" color="#108C08"><?php echo $othGrp; ?>%</font><?php if($othGrp>0){ ?> <img src="pic/up.png" height="20"  /><?php }else if($othGrp<0){ ?><img src="pic/down.gif" height="20"  /><?php } ?></td>						
		</tr>
		<?php } ?>
	</table>
  </body>
</html>	

  
