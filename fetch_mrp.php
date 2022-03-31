
<?php
include_once("db.php");



$pid	=	$_POST['pid'];

if( $pid==0){echo "please select material";}
else{
	$sql=mysqli_query( $GLOBALS['con'] ,"select *, substring(MATKL,1,3) as com  from material_data where MATNR=".$pid );
	$row=mysqli_fetch_object($sql);
	
	// file_get_contents("http://192.168.1.227/query/ped_target_sales.php?user=".$_SESSION['username']);
	$msq="Not Found!";
	$price=0;
	if ($row->com=="PED")
	{
		$price=	file_get_contents("http://192.168.1.227/query/api_moving_price.php?mid=$pid&com=1000");
	}else if ($row->com=="PRA"){
		
		$price=	file_get_contents("http://192.168.1.227/query/api_moving_price.php?mid=$pid&com=2000");
	}
	
	if($price>0){$msq=" Price:<b>".$price."</b>";}
	echo $msq;
}


  
