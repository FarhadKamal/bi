<?php

$fyear=2019;

$oYear=$fyear-1;

$nxtYear=$fyear+1;

$nyear=date('Y');

$ndatesegment= date('-m-d');

$today= date('Y-m-d');

/*temp
$nyear=2019;

$ndatesegment= '-06-30';

$today= '2019-06-30';
temp */

//$date1=date_create("$fyear-07-02");
//echo $date1;
//908220
//908081
// 


  
$sqldiff=mysqli_query( $GLOBALS['con'] ,"select datediff(now(),'$fyear-07-01') as tot");
$rowdiff=mysqli_fetch_object($sqldiff);

$dgap= $rowdiff->tot - 50;
//echo $dgap;
$mgap= $rowdiff->tot - 15;

if($dgap>=360)
{
$monthrange="july+august+september+october+november+december+january+february+march+april+may+june";
$wpsel=("July to June");
}
else if($dgap>=300)
{
$monthrange="july+august+september+october+november+december+january+february+march+april+may";
$wpsel=("July to May");
}
else if($dgap>=270)
{
$monthrange="july+august+september+october+november+december+january+february+march+april";
$wpsel=("July to April");
}
else if($dgap>=240)
{
$monthrange="july+august+september+october+november+december+january+february+march";
$wpsel=("July to March");
}
else if($dgap>=210)
{
$monthrange="july+august+september+october+november+december+january+february";
$wpsel=("July to February");
}
else if($dgap>=180)
{
$monthrange="july+august+september+october+november+december+january";
$wpsel=("july to january");
}
else if($dgap>=150)
{
$monthrange="july+august+september+october+november+december";
$wpsel=("July to December");
}
else if($dgap>=120)
{
$monthrange="july+august+september+october+november";
$wpsel=("July to November");
}
else if($dgap>=90)
{
$monthrange="july+august+september+october";
$wpsel=("July to October");
}
else if($dgap>=60)
{
$monthrange="july+august+september";
$wpsel=("July to September");
}
else if($dgap>=30)
{
$monthrange="july+august";
$wpsel=("July to August");
}
else{
$monthrange="july";
$wpsel=("July");
}
//Costing Calculation
//$monthrange="january+february+march+april+may+june+july+august+september+october+november+december";






if($mgap>=360)
{
$nmon = "june";
$omon = "may";
}
else if($mgap>=300)
{
$nmon = "may";
$omon = "april";
}
else if($mgap>=270)
{
$nmon = "april";
$omon = "march";
}
else if($mgap>=240)
{
$nmon = "march";
$omon = "february";
}
else if($mgap>=210)
{
$nmon = "february";
$omon = "january";
}
else if($mgap>=180)
{
$nmon = "january";
$omon = "december";
}
else if($mgap>=150)
{
$nmon = "december";
$omon = "november";
}
else if($mgap>=120)
{
$nmon = "november";
$omon = "october";
}
else if($mgap>=90)
{
$nmon = "october";
$omon = "september";
}
else if($mgap>=60)
{
$nmon = "september";
$omon = "august";
}
else if($mgap>=30)
{
$nmon = "august";
$omon = "july";
}
else{
$nmon = "july";
$omon = "july";

}






$strStock="select product_division.id,division,sum(if(product_type='HAWA',stock_val,0)) as pv ,sum(if(product_type='HAWA',sqty,0)) as pq,
sum(if(product_type='HALB',stock_val,0)) as sv,sum(if(product_type='HALB',sqty,0)) as sq
 from stock 
inner join product_division on product_division.id=stock.product_division
and product_type in ('HAWA','HALB') and  product_division.id not in(0,70)
group by product_division.id";




/*
$strcost=
"select fyear,burks,cost_area,
sum(
if(burks=1000,
$monthrange,0)) as pedtotal,
sum(
if(burks=2000,
$monthrange,0)) as pratotal,
sum(
if(burks=5000,
$monthrange,0)) as pnltotal
from cost_yearly 
inner join account_cost_area on account_cost_area.area_id=cost_yearly.area_id
 where cost_yearly.area_id not in(117,111,112,108) and fyear=$fyear
group by cost_yearly.area_id"; 
*/

$strcostCOGSYearCur="select
sum(
if(burks=1000,
$monthrange,0)) as ped,
sum(
if(burks=2000,
$monthrange,0)) as pra,
sum(
if(burks=5000,
$monthrange,0)) as pnl
from cost_yearly 
inner join account_cost_area on account_cost_area.area_id=cost_yearly.area_id
 where cost_yearly.area_id in(6) and fyear=$fyear";




$strcostYearCur="select
sum(
if(burks=1000,
$monthrange,0)) as pedtotalCurYear,
sum(
if(burks=2000,
$monthrange,0)) as pratotalCurYear,
sum(
if(burks=5000,
$monthrange,0)) as pnltotalCurYear
from cost_yearly 
inner join account_cost_area on account_cost_area.area_id=cost_yearly.area_id
 where cost_yearly.area_id in(103,104,105,106,107) and fyear=$fyear";




$strcostYearOld="select
sum(
if(burks=1000,
$monthrange,0)) as pedtotalOldYear,
sum(
if(burks=2000,
$monthrange,0)) as pratotalOldYear,
sum(
if(burks=5000,
$monthrange,0)) as pnltotalOldYear
from cost_yearly 
inner join account_cost_area on account_cost_area.area_id=cost_yearly.area_id
 where cost_yearly.area_id in(103,104,105,106,107) and fyear=$oYear";


 
 
$strSalesTotYearCur="select
sum(
if(company=1000,
$monthrange,0)) as ped,
sum(
if(company=2000,
$monthrange,0)) as pra,
sum(
if(company=5000,
$monthrange,0)) as pnl
from sales_monthy 

 where  fyear=$fyear"; 
 
 
$strSalesTotYearOld="select
sum(
if(company=1000,
$monthrange,0)) as ped,
sum(
if(company=2000,
$monthrange,0)) as pra,
sum(
if(company=5000,
$monthrange,0)) as pnl
from sales_monthy 

 where  fyear=$oYear"; 
 





/*  TESTING
$nyear=2018;

$ndatesegment= '-01-07';

$today= '2018-01-07';
*/



$olastday=$fyear."-06-30";

$flastday=$nxtYear."-06-30";


$osdate=$oYear."-07-01";

$oedate=$fyear.$ndatesegment;

if($fyear==$nyear)
$oedate=$oYear.$ndatesegment;

if($today>$flastday)
$oedate=$olastday;


$csdate=$fyear."-07-01";

$cedate=$nyear.$ndatesegment;

if($today>$flastday)
$cedate=$flastday;

//echo $osdate." ".$oedate;
//echo "<br/>";
//echo $csdate." ".$cedate;
//Calculating Achievement





//Profit Calculation

$ped_sale_price=0.00;
$ped_prd_price=0.00;
$ped_prof_price=0.00;
$ped_prof_percentage=0.00;

$hcp_sale_price=0.00;
$hcp_prd_price=0.00;
$hcp_prof_price=0.00;
$hcp_prof_percentage=0.00;


$bg_sale_price=0.00;
$bg_prd_price=0.00;
$bg_prof_price=0.00;
$bg_prof_percentage=0.00;


$saer_sale_price=0.00;
$saer_prd_price=0.00;
$saer_prof_price=0.00;
$saer_prof_percentage=0.00;


$itap_sale_price=0.00;
$itap_prd_price=0.00;
$itap_prof_price=0.00;
$itap_prof_percentage=0.00;




 
$str="select sum(sell_price-prd_price) as pnet,sum(sell_price) as sell_price,sum(prd_price) as prd_price,product_division.division,product_division.id
 from profit_cur_monthly
inner join product_division on product_division.id=profit_cur_monthly.division
where product_division.id in(20,30,50,60,51)
group by profit_cur_monthly.division";

$sql=mysqli_query( $GLOBALS['con'] ,$str );
while($row=mysqli_fetch_object($sql))
{

	if($row->id==20)
	{
		
		$ped_sale_price=$row->sell_price;
		$ped_prd_price=$row->prd_price;
		$ped_prof_price=$row->pnet;
		$ped_prof_percentage=round(($row->pnet/$row->prd_price)*100,2);
		$ped_prof_cogs=round(($row->prd_price/$row->sell_price)*100,2);
	}
	else if($row->id==30)
	{
		$hcp_sale_price=$row->sell_price;
		$hcp_prd_price=$row->prd_price;
		$hcp_prof_price=$row->pnet;
		$hcp_prof_percentage=round(($row->pnet/$row->prd_price)*100,2);
		$hcp_prof_cogs=round(($row->prd_price/$row->sell_price)*100,2);
	}
	else if($row->id==50)
	{
		$bg_sale_price=$row->sell_price;
		$bg_prd_price=$row->prd_price;
		$bg_prof_price=$row->pnet;
		$bg_prof_percentage=round(($row->pnet/$row->prd_price)*100,2);
		$bg_prof_cogs=round(($row->prd_price/$row->sell_price)*100,2);
	}
	else if($row->id==51)
	{
		$saer_sale_price=$row->sell_price;
		$saer_prd_price=$row->prd_price;
		$saer_prof_price=$row->pnet;
		$saer_prof_percentage=round(($row->pnet/$row->prd_price)*100,2);
		$saer_prof_cogs=round(($row->prd_price/$row->sell_price)*100,2);
	}
	else if($row->id==60)
	{
		$itap_sale_price		=$row->sell_price;
		$itap_prd_price			=$row->prd_price;
		$itap_prof_price		=$row->pnet;
		$itap_prof_percentage	=round(($row->pnet/$row->prd_price)*100,2);
		$itap_prof_cogs			=round(($row->prd_price/$row->sell_price)*100,2);
	}
}
	







	
	
	
//Old month profit calculation
	
$ped_sale_price_old=0.00;
$ped_prd_price_old=0.00;
$ped_prof_price_old=0.00;
$ped_prof_percentage_old=0.00;

$hcp_sale_price_old=0.00;
$hcp_prd_price_old=0.00;
$hcp_prof_price_old=0.00;
$hcp_prof_percentage_old=0.00;


$bg_sale_price_old=0.00;
$bg_prd_price_old=0.00;
$bg_prof_price_old=0.00;
$bg_prof_percentage_old=0.00;


$saer_sale_price_old=0.00;
$saer_prd_price_old=0.00;
$saer_prof_price_old=0.00;
$saer_prof_percentage_old=0.00;


$itap_sale_price_old=0.00;
$itap_prd_price_old=0.00;
$itap_prof_price_old=0.00;
$itap_prof_percentage_old=0.00;




 
$str="select sum(sell_price-prd_price) as pnet,sum(sell_price) as sell_price,sum(prd_price) as prd_price,product_division.division,product_division.id
 from profit_old_monthly
inner join product_division on product_division.id=profit_old_monthly.division
where product_division.id in(20,30,50,60,51)
group by profit_old_monthly.division";

$sql=mysqli_query( $GLOBALS['con'] ,$str );
while($row=mysqli_fetch_object($sql))
{

	if($row->id==20)
	{
		
		$ped_sale_price_old			=$row->sell_price;
		$ped_prd_price_old			=$row->prd_price;
		$ped_prof_price_old			=$row->pnet;
		$ped_prof_percentage_old	=round(($row->pnet/$row->prd_price)*100,2);
		$ped_prof_cogs_old=round(($row->prd_price/$row->sell_price)*100,2);
	}
	else if($row->id==30)
	{
		$hcp_sale_price_old			=$row->sell_price;
		$hcp_prd_price_old			=$row->prd_price;
		$hcp_prof_price_old			=$row->pnet;
		$hcp_prof_percentage_old	=round(($row->pnet/$row->prd_price)*100,2);
		$hcp_prof_cogs_old=round(($row->prd_price/$row->sell_price)*100,2);
	}
	else if($row->id==50)
	{
		$bg_sale_price_old			=$row->sell_price;
		$bg_prd_price_old			=$row->prd_price;
		$bg_prof_price_old			=$row->pnet;
		$bg_prof_percentage_old		=round(($row->pnet/$row->prd_price)*100,2);
		$bg_prof_cogs_old=round(($row->prd_price/$row->sell_price)*100,2);
	}
	else if($row->id==51)
	{
		$saer_sale_price_old		=$row->sell_price;
		$saer_prd_price_old			=$row->prd_price;
		$saer_prof_price_old		=$row->pnet;
		$saer_prof_percentage_old	=round(($row->pnet/$row->prd_price)*100,2);
		$saer_prof_cogs_old=round(($row->prd_price/$row->sell_price)*100,2);
	}
	else if($row->id==60)
	{
		$itap_sale_price_old		=$row->sell_price;
		$itap_prd_price_old			=$row->prd_price;
		$itap_prof_price_old		=$row->pnet;
		$itap_prof_percentage_old	=round(($row->pnet/$row->prd_price)*100,2);
		$itap_prof_cogs_old			=round(($row->prd_price/$row->sell_price)*100,2);
	}
}
		
	








//-ITEM Growth
//PEDROLLO
$str="select
(select ifnull(sum(NETWR),0) as tot from sap_sales_process where FKDAT>='$csdate' and FKDAT<='$cedate'
and SPART=20 and CTAG in('CR','BD','SR')
) as oldtot,
(select ifnull(sum(NETWR),0) as tot from sap_sales_process where FKDAT>='$osdate' and FKDAT<='$oedate'
and SPART=20 and CTAG in('CR','BD','SR')) as newtot";
$sql=mysqli_query( $GLOBALS['con'] ,$str );
$rowItm=mysqli_fetch_object($sql);	

$pedGrv	=	$rowItm->oldtot-$rowItm->newtot;
$pedGrp=  round(($pedGrv/$rowItm->oldtot)*100,2);



//HCP

$str="select
(select ifnull(sum(NETWR),0) as tot from sap_sales_process where FKDAT>='$csdate' and FKDAT<='$cedate'
and SPART=30 and CTAG in('CR','BD','SR')
) as oldtot,
(select ifnull(sum(NETWR),0) as tot from sap_sales_process where FKDAT>='$osdate' and FKDAT<='$oedate'
and SPART=30 and CTAG in('CR','BD','SR')) as newtot";
$sql=mysqli_query( $GLOBALS['con'] ,$str );
$rowItm=mysqli_fetch_object($sql);	

$hcpGrv	=	$rowItm->oldtot-$rowItm->newtot;
$hcpGrp=  round(($hcpGrv/$rowItm->oldtot)*100,2);





//BGFLOW

$str="select
(select ifnull(sum(NETWR),0) as tot from sap_sales_process where FKDAT>='$csdate' and FKDAT<='$cedate'
and SPART=50 and CTAG in('CR','BD','SR')
) as oldtot,
(select ifnull(sum(NETWR),0) as tot from sap_sales_process where FKDAT>='$osdate' and FKDAT<='$oedate'
and SPART=50 and CTAG in('CR','BD','SR')) as newtot";
$sql=mysqli_query( $GLOBALS['con'] ,$str );
$rowItm=mysqli_fetch_object($sql);	

$bgGrv	=	$rowItm->oldtot-$rowItm->newtot;
$bgGrp=  round(($bgGrv/$rowItm->oldtot)*100,2);



//ITAP

$str="select
(select ifnull(sum(NETWR),0) as tot from sap_sales_process where FKDAT>='$csdate' and FKDAT<='$cedate'
and SPART=60 and CTAG in('CR','BD','SR')
) as oldtot,
(select ifnull(sum(NETWR),0) as tot from sap_sales_process where FKDAT>='$osdate' and FKDAT<='$oedate'
and SPART=60 and CTAG in('CR','BD','SR')) as newtot";
$sql=mysqli_query( $GLOBALS['con'] ,$str );
$rowItm=mysqli_fetch_object($sql);	

$itapGrv	=	$rowItm->oldtot-$rowItm->newtot;
$itapGrp=  round(($itapGrv/$rowItm->oldtot)*100,2);




//SAER

$str="select
(select ifnull(sum(NETWR),0) as tot from sap_sales_process where FKDAT>='$csdate' and FKDAT<='$cedate'
and SPART=51 and CTAG in('CR','BD','SR')
) as oldtot,
(select ifnull(sum(NETWR),0) as tot from sap_sales_process where FKDAT>='$osdate' and FKDAT<='$oedate'
and SPART=51 and CTAG in('CR','BD','SR')) as newtot";
$sql=mysqli_query( $GLOBALS['con'] ,$str );
$rowItm=mysqli_fetch_object($sql);	

$saerGrv	=	$rowItm->oldtot-$rowItm->newtot;
$saerGrp=  round(($saerGrv/$rowItm->oldtot)*100,2);





//Other

$str="select
(select ifnull(sum(NETWR),0) as tot from sap_sales_process where FKDAT>='$csdate' and FKDAT<='$cedate'
and SPART not in(20,30,50,60,51) and CTAG in('CR','BD','SR')
) as oldtot,
(select ifnull(sum(NETWR),0) as tot from sap_sales_process where FKDAT>='$osdate' and FKDAT<='$oedate'
and SPART not in(20,30,50,60,51) and CTAG in('CR','BD','SR')) as newtot";
$sql=mysqli_query( $GLOBALS['con'] ,$str );
$rowItm=mysqli_fetch_object($sql);	

$othGrv	=	$rowItm->oldtot-$rowItm->newtot;
$othGrp=  round(($othGrv/$rowItm->oldtot)*100,2);





//-Business Growth

$str="select ifnull(sum(NETWR),0) as tot from sap_sales_process where FKDAT>='$osdate' and FKDAT<='$oedate' and CTAG in('CR','BD','SR')";
$sql=mysqli_query( $GLOBALS['con'] ,$str );
$rowOldtot=mysqli_fetch_object($sql);	

$str="select ifnull(sum(NETWR),0) as tot from sap_sales_process where FKDAT>='$csdate' and FKDAT<='$cedate' and CTAG in('CR','BD','SR')";	
$sql=mysqli_query( $GLOBALS['con'] ,$str );
$rowCurtot=mysqli_fetch_object($sql);

$prevSales	=$rowOldtot->tot;
$curSales	=$rowCurtot->tot;
$diffSales	=$curSales-$prevSales;
$growthPercent=  round(($diffSales/$prevSales)*100,2);


//CR Growth

$str="select ifnull(sum(NETWR),0) as tot from sap_sales_process where FKDAT>='$osdate' and FKDAT<='$oedate' and CTAG in('CR')";
$sql=mysqli_query( $GLOBALS['con'] ,$str );
$rowOldtotCR=mysqli_fetch_object($sql);	

$str="select ifnull(sum(NETWR),0) as tot from sap_sales_process where FKDAT>='$csdate' and FKDAT<='$cedate' and CTAG in('CR')";	
$sql=mysqli_query( $GLOBALS['con'] ,$str );
$rowCurtotCR=mysqli_fetch_object($sql);

$prevSalesCR		=$rowOldtotCR->tot;
$curSalesCR			=$rowCurtotCR->tot;
$diffSalesCR		=$curSalesCR-$prevSalesCR;
$growthPercentCR	=  round(($diffSalesCR/$prevSalesCR)*100,2);



//BD Growth

$str="select ifnull(sum(NETWR),0) as tot from sap_sales_process where FKDAT>='$osdate' and FKDAT<='$oedate' and CTAG in('BD')";
$sql=mysqli_query( $GLOBALS['con'] ,$str );
$rowOldtotBD=mysqli_fetch_object($sql);	

$str="select ifnull(sum(NETWR),0) as tot from sap_sales_process where FKDAT>='$csdate' and FKDAT<='$cedate' and CTAG in('BD')";	
$sql=mysqli_query( $GLOBALS['con'] ,$str );
$rowCurtotBD=mysqli_fetch_object($sql);

$prevSalesBD		=$rowOldtotBD->tot;
$curSalesBD			=$rowCurtotBD->tot;
$diffSalesBD		=$curSalesBD-$prevSalesBD;
$growthPercentBD	=  round(($diffSalesBD/$prevSalesBD)*100,2);



//SR Growth

$str="select ifnull(sum(NETWR),0) as tot from sap_sales_process where FKDAT>='$osdate' and FKDAT<='$oedate' and CTAG in('SR')";
$sql=mysqli_query( $GLOBALS['con'] ,$str );
$rowOldtotSR=mysqli_fetch_object($sql);	

$str="select ifnull(sum(NETWR),0) as tot from sap_sales_process where FKDAT>='$csdate' and FKDAT<='$cedate' and CTAG in('SR')";	
$sql=mysqli_query( $GLOBALS['con'] ,$str );
$rowCurtotSR=mysqli_fetch_object($sql);

$prevSalesSR		=$rowOldtotSR->tot;
$curSalesSR			=$rowCurtotSR->tot;
$diffSalesSR		=$curSalesSR-$prevSalesSR;
$growthPercentSR	=  round(($diffSalesSR/$prevSalesSR)*100,2);












///-----------------------------------------------------------------------------------------

$str="select 
	sum( st.january+st.february+st.march+st.april+st.may+st.june+st.july+
	st.august+st.september+st.october+st.november+st.december) as TargetTot
	from sales_target st where st.fyear=$fyear";
$sql=mysqli_query( $GLOBALS['con'] ,$str );
$rowTargettot=mysqli_fetch_object($sql);	

$str="select 
	sum( sp.january+sp.february+sp.march+sp.april+sp.may+sp.june+sp.july+
	sp.august+sp.september+sp.october+sp.november+sp.december) as SalesTot
	from sales_monthy sp where   sp.fyear=$fyear";	
$sql=mysqli_query( $GLOBALS['con'] ,$str );
$rowSalestot=mysqli_fetch_object($sql);		
	
	
	$targetTot=$rowTargettot->TargetTot;

	$salesTot=$rowSalestot->SalesTot;
	
	$achieveNotTot=$targetTot-$salesTot;
	if($achieveNotTot<0)$achieveNotTot=0;
		
	$totPercentAchieved	= round(($salesTot/$targetTot)*100,2);
		
	
	
	
	
//CR Achievement

$str="select 
	sum( st.january+st.february+st.march+st.april+st.may+st.june+st.july+
	st.august+st.september+st.october+st.november+st.december) as TargetTot
	from sales_target st where st.fyear=$fyear and group_tag='CR'";
$sql=mysqli_query( $GLOBALS['con'] ,$str );
$rowTargettotCR=mysqli_fetch_object($sql);	

$str="select 
	sum( sp.january+sp.february+sp.march+sp.april+sp.may+sp.june+sp.july+
	sp.august+sp.september+sp.october+sp.november+sp.december) as SalesTot
	from sales_monthy sp where   sp.fyear=$fyear  and group_tag='CR'";	
$sql=mysqli_query( $GLOBALS['con'] ,$str );
$rowSalestotCR=mysqli_fetch_object($sql);		
	
	
	$targetTotCR=$rowTargettotCR->TargetTot;

	$salesTotCR=$rowSalestotCR->SalesTot;
	
	$achieveDifTotCR=$targetTotCR-$salesTotCR;
	
	
	$totPercentAchievedCR = round(($salesTotCR/$targetTotCR)*100,2);
		
	

	
	
	
	
	
	
	
	
	
	
	
//BD Achievement

$str="select 
	sum( st.january+st.february+st.march+st.april+st.may+st.june+st.july+
	st.august+st.september+st.october+st.november+st.december) as TargetTot
	from sales_target st where st.fyear=$fyear and group_tag='BD'";
$sql=mysqli_query( $GLOBALS['con'] ,$str );
$rowTargettotBD=mysqli_fetch_object($sql);	

$str="select 
	sum( sp.january+sp.february+sp.march+sp.april+sp.may+sp.june+sp.july+
	sp.august+sp.september+sp.october+sp.november+sp.december) as SalesTot
	from sales_monthy sp where   sp.fyear=$fyear  and group_tag='BD'";	
$sql=mysqli_query( $GLOBALS['con'] ,$str );
$rowSalestotBD=mysqli_fetch_object($sql);		
	
	
	$targetTotBD=$rowTargettotBD->TargetTot;

	$salesTotBD=$rowSalestotBD->SalesTot;
	
	$achieveDifTotBD=$targetTotBD-$salesTotBD;

	
	$totPercentAchievedBD = round(($salesTotBD/$targetTotBD)*100,2);
		
	

	
	
	
	
	
	
	
	
	
	
	
	
	
	
//SR Achievement

$str="select 
	sum( st.january+st.february+st.march+st.april+st.may+st.june+st.july+
	st.august+st.september+st.october+st.november+st.december) as TargetTot
	from sales_target st where st.fyear=$fyear and group_tag='SR'";
$sql=mysqli_query( $GLOBALS['con'] ,$str );
$rowTargettotSR=mysqli_fetch_object($sql);	

$str="select 
	sum( sp.january+sp.february+sp.march+sp.april+sp.may+sp.june+sp.july+
	sp.august+sp.september+sp.october+sp.november+sp.december) as SalesTot
	from sales_monthy sp where   sp.fyear=$fyear  and group_tag='SR'";	
$sql=mysqli_query( $GLOBALS['con'] ,$str );
$rowSalestotSR=mysqli_fetch_object($sql);		
	
	
	$targetTotSR=$rowTargettotSR->TargetTot;

	$salesTotSR=$rowSalestotSR->SalesTot;
	
	$achieveDifTotSR=$targetTotSR-$salesTotSR;

	
	$totPercentAchievedSR = round(($salesTotSR/$targetTotSR)*100,2);
		

	
	
	
	
	
	
	
	
	
	
	
	
	


?>

<div class="container">
	<div class="row"><br/>
		<div class="col-md-12">
			<table border=1 >
				<tr>
					<td valign="top"><font size="4">
						<table class="table table-striped" >
							<tr>
								<td colspan=3 align="center"><font color="#294786"><b>Total Achievement</b></font></td>						
							</tr>
							
							
							
							<tr>
								<td><font color="#294786">Total Target:</font></td><td><font size="4"  color="#CD8540"> <?php echo round($targetTot/10000000,2) ?> crore</font></td>
					
							</tr>
						
							<tr>
								<td><font color="#294786">Total Sales:</font></td><td><font size="4"  color="#CD8540">  <?php echo round($salesTot/10000000,2) ?> crore</font></td>						
							</tr>
							<tr>
								<td><font color="#294786">Pending Target:</font></td><td><font size="4"  color="#CD8540">  <?php echo round($achieveNotTot/10000000,2) ?> crore</font></td>						
							</tr>
							
							<tr>
								<td><font  color="#294786">Total Achieve:</font></td><td><font size="4" color="#0AD067"><?php echo $totPercentAchieved; ?>%</font></td>						
							</tr>
						</table>
						</font>		
					</td>
					<td valign="top" colspan=2><font size="4">
						<table class="table table-striped" >
							<tr>
								<td colspan=3 align="center"><font color="#294786"><b>Achievement Segment wise</b></font></td>						
							</tr>
							<tr>
								<td>
									<table class="table table-striped">
										<tr>
											<td><font color="#294786">Unit</font></td>
											<td><font color="#294786">Target</font></td>
											<td><font color="#294786">Achieve</font></td>
										</tr>
										<tr>
											<td><font color="#294786">CR:</font></td>
											<td><font  color="#CD8540"><?php echo round($targetTotCR/10000000,2) ?> crore</font></td>
											<!--<td><font color="#CD8540"> <?php echo $totPercentAchievedCR ?>%</font></td>  -->
											<td><font  color="#CD8540"><?php echo round($salesTotCR/10000000,2) ?> crore</font></td>
										</tr>
										<tr>
											<td><font color="#294786">BD:</font></td>
											<td><font   color="#CD8540"><?php echo round($targetTotBD/10000000,2) ?> crore</font></td> 
											<!--<td><font color="#CD8540"> <?php echo $totPercentAchievedBD ?>%</font></td>-->
											<td><font  color="#CD8540"><?php echo round($salesTotBD/10000000,2) ?> crore</font></td>
										</tr>
										<tr>
											<td><font color="#294786">SR:</font></td>
											<td><font   color="#CD8540"><?php echo round($targetTotSR/10000000,2) ?> crore</font></td>
											<!--<td><font color="#CD8540"> <?php echo $totPercentAchievedSR ?>%</font></td> -->
											<td><font  color="#CD8540"><?php echo round($salesTotSR/10000000,2) ?> crore</font></td>
										</tr>
									</table>
								</td>
								<td>
									<div class="chart">
										<canvas id="totSegment"></canvas>
									</div>
								</td>	
							</tr>
						</table></font>					
					</td>
				</tr>
				<tr>
					<td valign="top">
						<table class="table table-striped" >
							<tr>
								<td colspan=3 align="center"><font size="4" color="#294786"><b>Business Growth</b></font></td>	
							</tr>
							
													
							<tr>
								<td><font size="4" color="#294786">Current Year Sales:</font>
								<br/><font size="2" color="#294786"><?php echo $csdate." to ".$cedate; ?></font>
								</td><td><font size="4" color="#CD8540"><?php echo round($curSales/10000000,2) ?> crore</font></td>						
							</tr>
							
							
							<tr>
								<td><font size="4" color="#294786">Previous Year Sales:</font>
								<br/><font size="2" color="#294786"><?php echo $osdate." to ".$oedate; ?></font>
								</td><td><font size="4" color="#CD8540"><?php echo round($prevSales/10000000,2) ?> crore</font></td>						
							</tr>
							<tr>
								<td><font size="4" color="#294786">Growth Value:</font>
								</td><td><font size="4" color="#CD8540"><?php echo round($diffSales/10000000,2); ?> crore</font>
								<?php if($diffSales>0){ ?> <img src="pic/up.png" height="20"  /><?php }else if($diffSales<0){ ?><img src="pic/down.png" height="20"  /><?php } ?>
								</td>						
							</tr>
				
							<tr>
								<td><font size="4" color="#294786">Growth Percentage:</font>
								</td><td><font size="4" color="#CD8540"><?php echo $growthPercent; ?>%</font>
								<?php if($growthPercent>0){ ?> <img src="pic/up.png" height="20"  /><?php }else if($growthPercent<0){ ?><img src="pic/down.png" height="20"  /><?php } ?>
								</td>						
							</tr>
							
						</table>
							
					</td>
					<td valign="top">
						<table class="table table-striped" >
							<tr>
								<td colspan=3 align="center"><font size="4" color="#294786"><b>Growth Segment Wise</b></font></td>									
							</tr>
			
							
							<tr>
								<td><font size="4" color="#294786">CR:</font>
								</td><td><font size="4" color="#CD8540"><?php echo $growthPercentCR; ?>%</font>
								<br/><font  size="2" color="#294786"><?php echo round($diffSalesCR/10000000,2) ?> crore</font>
								<?php if($diffSalesCR>0){ ?> <img src="pic/up.png" height="20"  /><?php }else if($diffSalesCR<0){ ?><img src="pic/down.png" height="20"  /><?php } ?>		
								</td>	
								<td rowspan=3>
								
									<div class="chart">
										<canvas id="grSegment"></canvas>	
									</div>
								
								</td>	
							</tr>
							
							<tr>
								<td><font size="4" color="#294786">BD:</font>
								</td><td><font size="4" color="#CD8540"><?php echo $growthPercentBD; ?>%</font>
								<br/><font  size="2" color="#294786"><?php echo round($diffSalesBD/10000000,2) ?> crore</font>
								<?php if($diffSalesBD>0){ ?> <img src="pic/up.png" height="20"  /><?php }else if($diffSalesBD<0){ ?><img src="pic/down.png" height="20"  /><?php } ?>
								</td>						
							</tr>
							
							<tr>
								<td><font size="4" color="#294786">SR:</font>
								</td><td><font size="4" color="#CD8540"><?php echo $growthPercentSR; ?>%</font>
								<br/><font  size="2" color="#294786"><?php echo round($diffSalesSR/10000000,2) ?> crore</font>
								<?php if($diffSalesSR>0){ ?> <img src="pic/up.png" height="20"  /><?php }else if($diffSalesSR<0){ ?><img src="pic/down.png" height="20"  /><?php } ?>
								</td>						
							</tr>
					
						</table>
							
					</td>
					<td  valign="top">
						<table class="table table-striped" >
							<tr>
								<td colspan=4 align="center"><font size="4" color="#294786"><b>Growth Item Wise</b></font></td>								
							</tr>
							<tr>
								<td><font size="4" color="#294786">Pedrollo:</font></td>
								<td><font  color="#294786"><?php echo round($pedGrv/10000000,2) ?> crore</font></td>
								<td align="right"><font size="4" color="#CD8540"><?php echo $pedGrp; ?>%</font><?php if($pedGrp>0){ ?> <img src="pic/up.png" height="20"  /><?php }else if($pedGrp<0){ ?><img src="pic/down.png" height="20"  /><?php } ?></td>						
							</tr>
							<tr>
								<td><font size="4" color="#294786">HCP:</font></td>
								<td><font  color="#294786"><?php echo round($hcpGrv/10000000,2) ?> crore</font></td>									
								<td align="right"><font size="4" color="#CD8540"><?php echo $hcpGrp; ?>%</font><?php if($hcpGrp>0){ ?> <img src="pic/up.png" height="20"  /><?php }else if($hcpGrp<0){ ?><img src="pic/down.png" height="20"  /><?php } ?></td>						
							</tr>
							<tr>
								<td><font size="4" color="#294786">BGFlow:</font></td>
								<td><font  color="#294786"><?php echo round($bgGrv/10000000,2) ?> crore</font></td>
								<td align="right"><font size="4" color="#CD8540"><?php echo $bgGrp; ?>%</font><?php if($bgGrp>0){ ?> <img src="pic/up.png" height="20"  /><?php }else if($bgGrp<0){ ?><img src="pic/down.png" height="20"  /><?php } ?></td>						
							</tr>
							
							
							<tr>
								<td><font size="4" color="#294786">SAER:</font></td>
								<td><font  color="#294786"><?php echo round($saerGrv/10000000,2) ?> crore</font></td>
								
								<td align="right"><font size="4" color="#CD8540"><?php echo $saerGrp; ?>%</font><?php if($saerGrp>0){ ?> <img src="pic/up.png" height="20"  /><?php }else if($saerGrp<0){ ?><img src="pic/down.png" height="20"  /><?php } ?></td>						
							</tr>
							
							<tr>
								<td><font size="4" color="#294786">ITAP:</font></td>
								<td><font  color="#294786"><?php echo round($itapGrv/10000000,2) ?> crore</font></td>
								<td align="right"><font size="4" color="#CD8540"><?php echo $itapGrp; ?>%</font><?php if($itapGrp>0){ ?> <img src="pic/up.png" height="20"  /><?php }else if($itapGrp<0){ ?><img src="pic/down.png" height="20"  /><?php } ?></td>						
							</tr>
							<tr>
								<td><font size="4" color="#294786">Other:</font></td>
								<td><font  color="#294786"><?php echo round($othGrv/10000000,2) ?> crore</font></td>
								<td align="right"><font size="4" color="#CD8540"><?php echo $othGrp; ?>%</font><?php if($othGrp>0){ ?> <img src="pic/up.png" height="20"  /><?php }else if($othGrp<0){ ?><img src="pic/down.png" height="20"  /><?php } ?></td>						
							</tr>
						</table>	
					</td>
	
				</tr>
			
				<tr>
					
					
					<td valign="top">
						<table class="table table-striped" >
							<tr>
								<td colspan=4 align="center">
									<font size="4" color="#294786"><b>Operating Cost Ratio:</b><br/></font>
									<font size="2" color="#294786"><?php echo $wpsel; ?></font>
								</td>
							</tr>
						
								<?php 
								$sqlcostYearCur=mysqli_query( $GLOBALS['con'] ,$strcostYearCur );			
								$rowcostYearCur=mysqli_fetch_object($sqlcostYearCur);
								
								
								$sqlcostCOGSYearCur=mysqli_query( $GLOBALS['con'] ,$strcostCOGSYearCur );			
								$rowcostCOGSYearCur=mysqli_fetch_object($sqlcostCOGSYearCur);
								
								
								$sqlcostYearOld=mysqli_query( $GLOBALS['con'] ,$strcostYearOld );
								$rowcostYearOld=mysqli_fetch_object($sqlcostYearOld);
								
								
								$sqlSalesTotYearCur=mysqli_query( $GLOBALS['con'] ,$strSalesTotYearCur );
								$rowSalesTotYearCur=mysqli_fetch_object($sqlSalesTotYearCur);
						
								//echo $rowcostYearCur->pnltotalCurYear;
								//echo "<br>";
								//echo $rowSalesTotYearCur->pnl;
								
								
								$sqlSalesTotYearOld=mysqli_query( $GLOBALS['con'] ,$strSalesTotYearOld );
								$rowSalesTotYearOld=mysqli_fetch_object($sqlSalesTotYearOld);
								/*
								echo $rowcostYearOld->pedtotalOldYear."//".$rowSalesTotYearOld->ped."<br/>";
								
									echo $rowcostYearOld->pnltotalOldYear."//".$rowSalesTotYearOld->pnl."<br/>";
									
										echo $rowcostYearOld->pratotalOldYear."//".$rowSalesTotYearOld->pra."<br/>";
										
										
										
										echo $rowcostYearCur->pedtotalCurYear."//".$rowSalesTotYearCur->ped."<br/>";
								
									echo $rowcostYearCur->pnltotalCurYear."//".$rowSalesTotYearCur->pnl."<br/>";
									
										echo $rowcostYearCur->pratotalCurYear."//".$rowSalesTotYearCur->pra."<br/>";  */
								?>
							<tr>						
								<td><font size="4" color="#294786">Company</font></td>
								<td><font size="4" color="#294786">Prev Year</font></td>
								<td><font size="4" color="#294786">Cur Year</font></td>
							</tr>
							<?php
								$pedocgs=round(($rowcostYearOld->pedtotalOldYear/$rowSalesTotYearOld->ped)*100,2);
								$pedncgs=round(($rowcostYearCur->pedtotalCurYear/$rowSalesTotYearCur->ped)*100,2);
								
								$pnlocgs=round(($rowcostYearOld->pnltotalOldYear/$rowSalesTotYearOld->pnl)*100,2);
								$pnlncgs=round(($rowcostYearCur->pnltotalCurYear/$rowSalesTotYearCur->pnl)*100,2);
								
								
								$praocgs=round(($rowcostYearOld->pratotalOldYear/$rowSalesTotYearOld->pra)*100,2);
								$prancgs=round(($rowcostYearCur->pratotalCurYear/$rowSalesTotYearCur->pra)*100,2);
							?>		
							<tr>					
								<td><font size="4" color="#294786">Pedrollo:</font></td>	
								
								<td><font size="4" color="#CD8540"><?php echo $pedocgs; ?>%</font></td>
								<td><font size="4" color="#CD8540"><?php echo $pedncgs ; ?>%</font>
								<?php if($pedocgs>$pedncgs){ ?> <img src="pic/upd.png" height="20"  /><?php }else{ ?><img src="pic/downd.png" height="20"  /><?php } ?>
								</td>
							</tr>
							<tr>
								<td><font size="4" color="#294786">PNL:</font></td>
								<td><font size="4" color="#CD8540"><?php echo $pnlocgs;?>%</font></td>
								<td><font size="4" color="#CD8540"><?php echo $pnlncgs; ?>%</font>
								<?php if($pnlocgs>$pnlncgs){ ?> <img src="pic/upd.png" height="20"  /><?php }else{ ?><img src="pic/downd.png" height="20"  /><?php } ?>
								</td>
							</tr>
							<tr>	
								<td><font size="4" color="#294786">Pragati:</font></td>
								<td><font size="4" color="#CD8540"><?php echo $praocgs; ?>%</font></td>
								<td><font size="4" color="#CD8540"><?php echo $prancgs; ?>%</font>
								<?php if($praocgs>$prancgs){ ?> <img src="pic/upd.png" height="20"  /><?php }else{ ?><img src="pic/downd.png" height="20"  /><?php } ?>
								</td>
							</tr>
							

						</table>
						<table class="table table-striped" >
							<tr>
								<td colspan=4 align="center">
									<font size="4" color="#294786"><b>Turnover & Cost</b><br/></font>
								</td>
							</tr>
							<tr>
								<td><font size="4" color="#294786">Company</font></td>
								<td><font size="4" color="#294786">Turnover</font></td>
								<td><font size="4" color="#294786">OP Cost</font></td>		
								<td><font size="4" color="#294786">COGS</font></td>		
							</tr>
							<tr>								
								<td><font size="4" color="#294786">Pedrollo:</font></td>	
								<td><font size="4" color="#CD8540"><?php echo round(($rowSalesTotYearCur->ped/10000000),2); ?> cr</font></td>
								<td><font size="4" color="#CD8540"><?php echo round(($rowcostYearCur->pedtotalCurYear/10000000),2); ?> cr</font></td>
								<td><font size="4" color="#CD8540"><?php echo round(($rowcostCOGSYearCur->ped/10000000),2); ?> cr</font></td>
							</tr>
							<tr>								
								<td><font size="4" color="#294786">PNL:</font></td>
								<td><font size="4" color="#CD8540"><?php echo round(($rowSalesTotYearCur->pnl/10000000),2); ?> cr</font></td>
								<td><font size="4" color="#CD8540"><?php echo round(($rowcostYearCur->pnltotalCurYear/10000000),2); ?> cr</font></td>
								<td><font size="4" color="#CD8540"><?php echo round(($rowcostCOGSYearCur->pnl/10000000),2); ?> cr</font></td>
							</tr>
							<tr>								
								<td><font size="4" color="#294786">Pragati:</font></td>
								<td><font size="4" color="#CD8540"><?php echo round(($rowSalesTotYearCur->pra/10000000),2); ?> cr</font></td>
								<td><font size="4" color="#CD8540"><?php echo round(($rowcostYearCur->pratotalCurYear/10000000),2); ?> cr</font></td>
								<td><font size="4" color="#CD8540"><?php echo round(($rowcostCOGSYearCur->pra/10000000),2); ?> cr</font></td>
							</tr>
						</table>	
					</td>
					<td  valign="top" colspan=2 >
						<table class="table table-striped" >
							<tr>
								<td align="center" colspan="2"><font size="4" color="#294786"><b>COGS Ratio</b></font>
								
								<br/><font size="2" color="#294786">Month Basis</font>
								</td>								
							</tr>
							<tr>
								
								<td>
									<table class="table table-striped" >
										<tr>
											<td colspan=2>
											<font size="2" color="#294786"><?php echo date('Y-m-d', strtotime('-395 day', strtotime(date('Y-m-d')))); echo " to "; echo date('Y-m-d', strtotime('-365 day', strtotime(date('Y-m-d')))); ?></font>
											</td>
										</tr>
										
										<tr>
											<td><font size="4" color="#294786">Pedrollo:</font></td>
											<td align="right"><font size="4" color="#CD8540"><?php echo $ped_prof_cogs_old; ?>% </font></td>						
										</tr>
										<tr>
											<td><font size="4" color="#294786">HCP:</font></td>
											<td align="right"><font size="4" color="#CD8540"><?php echo $hcp_prof_cogs_old; ?>%</font></td>						
										</tr>
										<tr>
											<td><font size="4" color="#294786">BGFlow:</font></td>
											<td align="right"><font size="4" color="#CD8540"><?php echo $bg_prof_cogs_old; ?>%</font></td>						
										</tr>
										<tr>
											<td><font size="4" color="#294786">ITAP:</font></td>
											<td align="right"><font size="4" color="#CD8540"><?php echo $itap_prof_cogs_old; ?>%</font></td>						
										</tr>
										<tr>
											<td><font size="4" color="#294786">SAER:</font></td>
											<td align="right"><font size="4" color="#CD8540"><?php echo $saer_prof_cogs_old; ?>%</font></td>						
										</tr>
																	
									</table>
								</td>
								<td>
									<table class="table table-striped" >
										
										<tr>
											<td colspan=2 color="#294786">
											<font size="2" color="#294786"><?php echo date('Y-m-d', strtotime('-30 day', strtotime(date('Y-m-d')))); echo " to "; echo date('Y-m-d'); ?></font>
											</td>
										</tr>
										<tr> 
											<td><font size="4" color="#294786">Pedrollo:</font></td>
											<td align="right"><font size="4" color="#CD8540"><?php echo $ped_prof_cogs; ?>%</font><?php if($ped_prof_cogs<$ped_prof_cogs_old){ ?> <img src="pic/upd.png" height="20"  /><?php }else if($ped_prof_cogs>$ped_prof_cogs_old){ ?><img src="pic/downd.png" height="20"  /><?php } ?></td>						
											<td><a href="profit_prompt.php?id=20" target="about_blank">&#8666; Click Details</a> </td>
										</tr>
										<tr>
											<td><font size="4" color="#294786">HCP:</font></td>
											<td align="right"><font size="4" color="#CD8540"><?php echo $hcp_prof_cogs; ?>%</font><?php if($hcp_prof_cogs<$hcp_prof_cogs_old){ ?> <img src="pic/upd.png" height="20"  /><?php }else if($hcp_prof_cogs>$hcp_prof_cogs_old){ ?><img src="pic/downd.png" height="20"  /><?php } ?></td>						
											<td><a href="profit_prompt.php?id=30" target="about_blank">&#8666; Click Details</a> </td>
										</tr>
										<tr>
											<td><font size="4" color="#294786">BGFlow:</font></td>
											<td align="right"><font size="4" color="#CD8540"><?php echo $bg_prof_cogs; ?>%</font><?php if($bg_prof_cogs<$bg_prof_cogs_old){ ?> <img src="pic/upd.png" height="20"  /><?php }else if($bg_prof_cogs>$bg_prof_cogs_old){ ?><img src="pic/downd.png" height="20"  /><?php } ?></td>						
											<td><a href="profit_prompt.php?id=50" target="about_blank">&#8666; Click Details</a> </td>
										</tr>
										<tr>
											<td><font size="4" color="#294786">ITAP:</font></td>
											<td align="right"><font size="4" color="#CD8540"><?php echo $itap_prof_cogs; ?>%</font><?php if($itap_prof_cogs<$itap_prof_cogs_old){ ?> <img src="pic/upd.png" height="20"  /><?php }else if($itap_prof_cogs>$itap_prof_cogs_old){ ?><img src="pic/downd.png" height="20"  /><?php } ?></td>						
											<td><a href="profit_prompt.php?id=60" target="about_blank">&#8666; Click Details</a> </td>
										</tr>
										<tr>
											<td><font size="4" color="#294786">SAER:</font></td>
											<td align="right"><font size="4" color="#CD8540"><?php echo $saer_prof_cogs; ?>%</font><?php if($saer_prof_cogs<$saer_prof_cogs_old){ ?> <img src="pic/upd.png" height="20"  /><?php }else if($saer_prof_cogs>$saer_prof_cogs_old){ ?><img src="pic/downd.png" height="20"  /><?php } ?></td>						
											<td><a href="profit_prompt.php?id=51" target="about_blank">&#8666; Click Details</a> </td>
										</tr>
																	
									</table>								
									
								</td>
								
								
							</tr>
							<tr>
								<td colspan=2  valign="top">
									<table border=1>
										<tr>
											<td align="center" colspan="5"><font size="4" color="#294786"><b>Current Stock Brand Wise</b></font></td>																		
										</tr>
										<tr>
											<td><font size="4" color="#294786">&nbsp;Brand&nbsp;</font></td>
											<td><font size="4" color="#294786">&nbsp;Product Qty&nbsp;</font></td>
											<td><font size="4" color="#294786">&nbsp;Product Value&nbsp;</font></td>
											<td><font size="4" color="#294786">&nbsp;Spare Qty&nbsp;</font></td>
											<td><font size="4" color="#294786">&nbsp;Spare Value&nbsp;</font></td>
										</tr>
										<?php    
											$sqlStock=mysqli_query($GLOBALS['con'] ,$strStock);
											while($rowStock=mysqli_fetch_object($sqlStock)){
										?>
										<tr>
											<td align="left"><font size="4" color="#294786">&nbsp;<?php echo $rowStock->division; ?>&nbsp;</font></td>
											<td align="right"><font size="4" color="#CD8540"><?php echo bd_money_format($rowStock->pq); ?></font></td>
											<td align="right"><font size="4" color="#CD8540"><?php echo bd_money_format($rowStock->pv); ?></font></td>
											<td align="right"><font size="4" color="#CD8540"><?php echo bd_money_format($rowStock->sq); ?></font></td>
											<td align="right"><font size="4" color="#CD8540"><?php echo bd_money_format($rowStock->sv); ?></font></td>
										</tr>
										<?php } ?>
									</table>
								</td>
							</tr>
						</table>	
					</td>
					
				</tr> 
			</table>
		</div>
	</div>
<div>

<script>
    $(document).ready(function(){	
	
		Chart.defaults.global.defaultFontColor = '#294786';	
		Chart.defaults.global.defaultFontFamily = "'Roboto Condensed', sans-serif";	
		
		var  tottargetcore= Math.round(<?php echo $targetTot; ?>/10000000);
		
		var config = {
					type: 'pie',
					data: {
						datasets: [{
							data: [
								<?php echo $salesTot; ?>,
								<?php echo $achieveNotTot; ?>
						
					],
							backgroundColor: [
								'#4BF41E',
								'#FF0024'
							
							]
						}],
						labels: [
							'Achieved ',
							'Not Achieved '
						
						] 
					},
					options: {
						responsive: true

						
				
						
						
					}
					
			
				};
				
				
				
				
				var ctxAchievement = $("#totAchievement");
								
				new Chart(ctxAchievement, config);
				
	

				
	var chartdata = {
                    labels: ['CR','BD','SR'],
                    datasets : [              								
						
						
						{                          
							type: 'bar',
							backgroundColor: ['#1C2BF1','#8F9326','#2BB800'],
							borderColor: 'rgba(200, 200, 200, 0.75)',
							hoverBorderColor: 'rgba(200, 200, 200, 1)',
                            data: [<?php echo $totPercentAchievedCR; ?>,<?php echo $totPercentAchievedBD; ?>,<?php echo $totPercentAchievedSR; ?>]
                        }
						
		
								
						
                    ]
               
				};
				
				

	var ctxtotSegment = $("#totSegment");
	
	new Chart(ctxtotSegment, {
		type: 'bar',
		data: chartdata,
		options: {
			scales: {
				yAxes: [{
						   ticks: {
								callback: function(label, index, labels) {
									return label+'%';
								},
							
									min: 0,
									max: 100,
									stepSize: 10
							}
	
						}]
			},
			 legend: { display: false
				
			}
		}
	});
		
				
				
				
				
	



	var chartdata2 = {
                    labels: ['CR','BD','SR'],
                    datasets : [              								
						
						
						{                       
							type: 'bar',
							backgroundColor: ['#1C2BF1','#8F9326','#2BB800'],
							borderColor: 'rgba(200, 200, 200, 0.75)',
							hoverBorderColor: 'rgba(200, 200, 200, 1)',
                            data: [<?php echo $diffSalesCR; ?>,<?php echo $diffSalesBD; ?>,<?php echo $diffSalesSR; ?>]
                        }
						
		
								
						
                    ]
               
				};
				
				

	var ctxgrSegment = $("#grSegment");
	
	new Chart(ctxgrSegment, {
		type: 'bar',
		data: chartdata2,
		options: {
					scales: {
						yAxes: [{
						   ticks: {
								callback: function(label, index, labels) {
									return label/10000000+' crore';
								}
							}
	
						}]
					},
					 legend: {
						display: false
					}
				}

	});	
				
				
				
				
				
				
				
				
				
				
				
				
				
				
	
	});
</script>	


<?php



function bd_money_format($num){
        $nums = explode(".",$num);
        if(count($nums)>2){
            return "0";
        }else{
        if(count($nums)==1){
            $nums[1]="00";
        }
        $num = $nums[0];
        $explrestunits = "" ;
        if(strlen($num)>3){
            $lastthree = substr($num, strlen($num)-3, strlen($num));
            $restunits = substr($num, 0, strlen($num)-3); 
            $restunits = (strlen($restunits)%2 == 1)?"0".$restunits:$restunits; 
            $expunit = str_split($restunits, 2);
            for($i=0; $i<sizeof($expunit); $i++){

                if($i==0)
                {
                    $explrestunits .= (int)$expunit[$i].","; 
                }else{
                    $explrestunits .= $expunit[$i].",";
                }
            }
            $thecash = $explrestunits.$lastthree;
        } else {
            $thecash = $num;
        }
        return $thecash.".".$nums[1]; 
        }
    }
?>