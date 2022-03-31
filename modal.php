<?php

include_once("db.php");
$zyear = 2021; 

?>

<?php

if($_GET['call']==1) total_sales_target($zyear);
else if($_GET['call']==2) search_sales_target();
else if($_GET['call']==3) stock_analyse();
function total_sales_target($year)
{
	//$data=[];
	$str="select 
	
	sum(st.july) as july,
	sum(st.august)as august,
	sum(st.september) as september,
	sum(st.october) as october,
	sum(st.november) as november,
	sum(st.december)  as december,
	
	
	sum( st.january) as january,
	sum(st.february) as february,
	sum(st.march)  as march,
	sum(st.april) as april,
	sum(st.may) as may,
	sum(st.june) as june
	
	from sales_target st
	where   st.fyear=$year";
	 
	$sql=mysqli_query( $GLOBALS['con'] ,$str );
	$result=mysqli_fetch_object($sql);
	$data[0] = json_encode($result);
	
	
	
	$str="select 
	
	sum(sp.july) as july,
	sum(sp.august)as august,
	sum(sp.september) as september,
	sum(sp.october) as october,
	sum(sp.november) as november,
	sum(sp.december)  as december,
	
	
	sum(sp.january) as january,
	sum(sp.february) as february,
	sum(sp.march)  as march,
	sum(sp.april) as april,
	sum(sp.may) as may,
	sum(sp.june) as june
	
	from sales_monthy sp
	where   sp.fyear=$year";

	$sql=mysqli_query( $GLOBALS['con'] ,$str );
	$result=mysqli_fetch_object($sql);
	$data[1] = json_encode($result);
	
	print json_encode($data);
}




function search_sales_target()
{
	

	
	$vyear=		$_POST['vyear'];
	$vgroup=	$_POST['vgroup'];
	$vdivision=	$_POST['vdivision'];
	$tdivision=	$vdivision;
	
	if (strpos($vgroup, 'BD') == True)
	$tdivision=$vdivision.",0";
	
	
	if (strpos($vgroup, 'CR') == True && $vyear==2012)
	$tdivision=$vdivision.",0";
	
	
	
	
	//$data=[];
	$str="select 
	
	sum(st.july) as july,
	sum(st.august)as august,
	sum(st.september) as september,
	sum(st.october) as october,
	sum(st.november) as november,
	sum(st.december)  as december,
	
	sum( st.january) as january,
	sum(st.february) as february,
	sum(st.march)  as march,
	sum(st.april) as april,
	sum(st.may) as may,
	sum(st.june) as june
	
	from sales_target st
	where   st.fyear=$vyear and group_tag in($vgroup) and product_division in($tdivision)";
	//echo $str;echo "<br/>";
	$sql=mysqli_query( $GLOBALS['con'] ,$str );
	$result=mysqli_fetch_object($sql);
	$data[0] = json_encode($result);
	
	
	
	$str="select 
	sum(sp.july) as july,
	sum(sp.august)as august,
	sum(sp.september) as september,
	sum(sp.october) as october,
	sum(sp.november) as november,
	sum(sp.december)  as december,
	
	
	
	sum(sp.january) as january,
	sum(sp.february) as february,
	sum(sp.march)  as march,
	sum(sp.april) as april,
	sum(sp.may) as may,
	sum(sp.june) as june
	
	from sales_monthy sp
	where   sp.fyear=$vyear  and group_tag in($vgroup) and product_division in($vdivision)";
	//echo $str;echo "<br/>";
	$sql=mysqli_query( $GLOBALS['con'] ,$str );
	$result=mysqli_fetch_object($sql);	
	$data[1] = json_encode($result);
	
	
	
	
	$str="select 
	sum( st.january+st.february+st.march+st.april+st.may+st.june+st.july+
	st.august+st.september+st.october+st.november+st.december) as TargetTot
	from sales_target st
	where   st.fyear=$vyear and group_tag in($vgroup) and product_division in($tdivision)";
	//echo $str;echo "<br/>";
	$sql=mysqli_query( $GLOBALS['con'] ,$str );
	$result=mysqli_fetch_object($sql);	
	$data[2] = json_encode($result);
	
	
	
	$str="select 
	sum( sp.january+sp.february+sp.march+sp.april+sp.may+sp.june+sp.july+
	sp.august+sp.september+sp.october+sp.november+sp.december) as SalesTot
	from sales_monthy sp where   sp.fyear=$vyear and sp.group_tag in($vgroup) and product_division in($vdivision)";
	//echo $str;echo "<br/>";
	$sql=mysqli_query( $GLOBALS['con'] ,$str );
	$result=mysqli_fetch_object($sql);	
	$data[3] = json_encode($result);
	
	
	
	$str="select 
	sum(january+february+march+april+may+june+july+august+september+october+november+december) as tot,fyear
	from sales_monthy 
	where  group_tag in($vgroup) and product_division in($vdivision)
	group by fyear";
	//echo $str;echo "<br/>";
	$sql=mysqli_query( $GLOBALS['con'] ,$str );
	//$result=mysqli_fetch_object($sql);	
	$result=mysqli_fetch_all($sql, MYSQLI_ASSOC);
	$data[4] = json_encode($result);

	
	
	$str="select 

	sum(if(product_division=20,january+february+march+april+may+june+july+august+september+october+november+december,0)) as Pedrollo,
	sum(if(product_division=30,january+february+march+april+may+june+july+august+september+october+november+december,0)) as HCP,
	sum(if(product_division=40,january+february+march+april+may+june+july+august+september+october+november+december,0)) as Rovatti,
	sum(if(product_division=50,january+february+march+april+may+june+july+august+september+october+november+december,0)) as BGFlow,
	sum(if(product_division=51,january+february+march+april+may+june+july+august+september+october+november+december,0)) as SAER,
	sum(if(product_division=60,january+february+march+april+may+june+july+august+september+october+november+december,0)) as ITAP,
	sum(if(product_division=80,january+february+march+april+may+june+july+august+september+october+november+december,0)) as Munters,
	sum(if(product_division=90,january+february+march+april+may+june+july+august+september+october+november+december,0)) as Teflon,
	sum(if(product_division=99,january+february+march+april+may+june+july+august+september+october+november+december,0)) as Pentagono,
	sum(if(product_division=70,january+february+march+april+may+june+july+august+september+october+november+december,0)) as Other
	FROM sales_monthy where fyear=$vyear and group_tag in ($vgroup)";

	//echo $str;echo "<br/>";
	$sql=mysqli_query( $GLOBALS['con'] ,$str );
	//$result=mysqli_fetch_object($sql);	
	$result=mysqli_fetch_all($sql, MYSQLI_ASSOC);
	$data[5] = json_encode($result);

	
	print json_encode($data);
}








































function stock_analyse()
{
	

	
	$vyear=		$_POST['vyear'];

	$mat=		$_POST['mat']; 
	
	
	
	//$data=[];
	$str="select 
	
	sum(if(month(FKDAT)=7,FKIMG,0)) as july,
	sum(if(month(FKDAT)=8,FKIMG,0))as august,
	sum(if(month(FKDAT)=9,FKIMG,0)) as september,
	sum(if(month(FKDAT)=10,FKIMG,0)) as october,
	sum(if(month(FKDAT)=11,FKIMG,0)) as november,
	sum(if(month(FKDAT)=12,FKIMG,0)) as december,
	sum(if(month(FKDAT)=1,FKIMG,0)) as january,
	sum(if(month(FKDAT)=2,FKIMG,0))as february,
	sum(if(month(FKDAT)=3,FKIMG,0))  as march,
	sum(if(month(FKDAT)=4,FKIMG,0)) as april,
	sum(if(month(FKDAT)=5,FKIMG,0))as may,
	sum(if(month(FKDAT)=6,FKIMG,0)) as june
	from sap_sales_process 
	where   fyear=$vyear and MATNR=$mat";
	
	$sql=mysqli_query( $GLOBALS['con'] ,$str );
	$result=mysqli_fetch_object($sql);
	$data[0] = json_encode($result);
	
	
	
	
	$str="select (LABST+TRAME-imp+sales ) as qty     from
	(
	(SELECT  ifnull(SUM(LABST),0) AS LABST  FROM stock_process_mard_one where MATNR=$mat) as LABST,

	(SELECT  ifnull(SUM(TRAME),0) AS TRAME  FROM stock_process_marc_two where MATNR=$mat) as TRAME,

	(SELECT ifnull(SUM( MENGE ),0) AS imp  FROM stock_process_mseg_three

	WHERE MATNR = $mat and BUDAT >='$vyear-07-01') as imp,

	(SELECT ifnull(SUM( MENGE ),0) AS sales  FROM stock_process_mseg_four

	WHERE MATNR = $mat and BUDAT >='$vyear-07-01')  as sales

	)
	";
	
	$sql=mysqli_query( $GLOBALS['con'] ,$str );
	$result=mysqli_fetch_object($sql);
	$data[1] = json_encode($result);
	
	
	
/*	
	
	
	
	mysqli_query( $GLOBALS['con'] ,"set @c := 0,@w := 0,@p := 0;");
	$str="
select 
	
	sum(if(iMonth=1,pvalue,0)) as july,
	sum(if(iMonth=2,pvalue,0))as august,
	sum(if(iMonth=3,pvalue,0)) as september,
	sum(if(iMonth=4,pvalue,0)) as october,
	sum(if(iMonth=5,pvalue,0)) as november,
	sum(if(iMonth=6,pvalue,0)) as december,
	sum(if(iMonth=7,pvalue,0)) as january,
	sum(if(iMonth=8,pvalue,0))as february,
	sum(if(iMonth=9,pvalue,0))  as march,
	sum(if(iMonth=10,pvalue,0)) as april,
	sum(if(iMonth=11,pvalue,0))as may,
	sum(if(iMonth=12,pvalue,0)) as june
	from 


(select d.WERKS,d.iYear,d.iMonth , m.LABST , 
@c :=  if(@w=d.WERKS,@c,0) +1 as cnt,
@p:=  if(m.LABST is null, if(@w=d.WERKS and @c>0,@p,0), m.LABST  ) as pvalue
,@w:=  d.WERKS
from
(select WERKS,iYear,iMonth from werks,mardh_session where active_status=1 order by WERKS,iYear,iMonth ) as d
left join (select * from  mardh  where MATNR=$mat) m on 
( d.iYear=m.LFGJA and d.iMonth=m.LFMON and m.WERKS=d.WERKS)) as details where iYear=$vyear";
	
	$sql=mysqli_query( $GLOBALS['con'] ,$str );
	$result=mysqli_fetch_object($sql);	
	$data[1] = json_encode($result);
*/	
	$nyear=$vyear+1;
	
	$str="select 
	
	ifnull(sum(if(month(BUDAT)=7,if(BWART=101,MENGE,-1*MENGE),0)),0) as july,
	ifnull(sum(if(month(BUDAT)=8,if(BWART=101,MENGE,-1*MENGE),0)),0)as august,
	ifnull(sum(if(month(BUDAT)=9,if(BWART=101,MENGE,-1*MENGE),0)),0) as september,
	ifnull(sum(if(month(BUDAT)=10,if(BWART=101,MENGE,-1*MENGE),0)),0) as october,
	ifnull(sum(if(month(BUDAT)=11,if(BWART=101,MENGE,-1*MENGE),0)),0) as november,
	ifnull(sum(if(month(BUDAT)=12,if(BWART=101,MENGE,-1*MENGE),0)),0) as december,
	ifnull(sum(if(month(BUDAT)=1,if(BWART=101,MENGE,-1*MENGE),0)),0) as january,
	ifnull(sum(if(month(BUDAT)=2,if(BWART=101,MENGE,-1*MENGE),0)),0)as february,
	ifnull(sum(if(month(BUDAT)=3,if(BWART=101,MENGE,-1*MENGE),0)),0)  as march,
	ifnull(sum(if(month(BUDAT)=4,if(BWART=101,MENGE,-1*MENGE),0)),0) as april,
	ifnull(sum(if(month(BUDAT)=5,if(BWART=101,MENGE,-1*MENGE),0)),0) as may,
	ifnull(sum(if(month(BUDAT)=6,if(BWART=101,MENGE,-1*MENGE),0)),0) as june
	from track_inbound where BUDAT>='$vyear-07-01' and BUDAT<='$nyear-06-30'
	and MATNR=$mat
	";
	
	$sql=mysqli_query( $GLOBALS['con'] ,$str );
	$result=mysqli_fetch_object($sql);	
	$data[2] = json_encode($result);
	
	
	$str="select mat_no,sum(stock_val)/
	sum(sqty) as val
	from stock where mat_no=$mat";
	
	$sql=mysqli_query( $GLOBALS['con'] ,$str );
	$result=mysqli_fetch_object($sql);
	$data[3] = json_encode($result);
	
	
	print json_encode($data);
}


?>
