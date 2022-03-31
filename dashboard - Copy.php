<?php

$fyear=2020;

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


$strStock="SELECT
				SPART AS id,
				division, 
				sum(if(product_type='HAWA',pv,0)) as pv ,
				sum(if(product_type='HAWA',pq,0)) as pq,
				sum(if(product_type='HALB',pv,0)) as sv,
				sum(if(product_type='HALB',pq,0)) as sq
			FROM stock_inventory
			WHERE
			SPART NOT IN (70)
				group by SPART
				ORDER BY SPART";

// Dead Stock Calculation For HAWA
$str_dead_stock_hawa = "SELECT
							SPART AS id,
							division, 
							product_type, 
							SUM(pv) as pv, 
							SUM(pq) as pq, 
							SalesVal as sv, 
							SalesQty as sq
						FROM stock_inventory
						WHERE
						SalesQty = 0.00 AND product_type = 'HAWA' AND SPART NOT IN (70)
							group by SPART, product_type
							ORDER BY SPART, product_type";

// Dead Stock Calculation For HALB
$str_dead_stock_halb = "SELECT
							SPART AS id,
							division, 
							product_type, 
							SUM(pv) as pv, 
							SUM(pq) as pq, 
							SalesVal as sv, 
							SalesQty as sq
						FROM stock_inventory
						WHERE
						SalesQty = 0.00 AND product_type = 'HALB' AND SPART NOT IN (70)
							group by SPART, product_type
							ORDER BY SPART, product_type";


// $strStock;

// array_column manual function
if (! function_exists('array_column')) {
    function array_column(array $input, $columnKey, $indexKey = null) {
        $array = array();
        foreach ($input as $value) {
            if ( !array_key_exists($columnKey, $value)) {
                trigger_error("Key \"$columnKey\" does not exist in array");
                return false;
            }
            if (is_null($indexKey)) {
                $array[] = $value[$columnKey];
            }
            else {
                if ( !array_key_exists($indexKey, $value)) {
                    trigger_error("Key \"$indexKey\" does not exist in array");
                    return false;
                }
                if ( ! is_scalar($value[$indexKey])) {
                    trigger_error("Key \"$indexKey\" does not contain scalar value");
                    return false;
                }
                $array[$value[$indexKey]] = $value[$columnKey];
            }
        }
        return $array;
    }
}



$strcostYearCur="select
sum(
if(RBUKRS=1000,
$monthrange,0)) as pedtotalCurYear,
sum(
if(RBUKRS=2000,
$monthrange,0)) as pratotalCurYear,
sum(
if(RBUKRS=5000,
$monthrange,0)) as pnltotalCurYear
from pep_faglflext 
inner join account_cost_center on account_cost_center.cost_id=pep_faglflext.RCNTR
 where account_head in ('Administrative','Distribution','Marketing & Selling') and RYEAR=$fyear";
 
 
$strCogsYearCur="select fyear,
sum(
if(burks=1000,
$monthrange,0)) as pedCOGS,
sum(
if(burks=2000,
$monthrange,0)) as praCOGS,
sum(
if(burks=5000,
$monthrange,0)) as pnlCOGS
from cost_yearly 
inner join account_cost_area on account_cost_area.area_id=cost_yearly.area_id where fyear= $fyear
and cost_yearly.area_id in(6) 

"; 




//echo $strcostYearCur;

$strcostYearOld="select
sum(
if(RBUKRS=1000,
$monthrange,0)) as pedtotalOldYear,
sum(
if(RBUKRS=2000,
$monthrange,0)) as pratotalOldYear,
sum(
if(RBUKRS=5000,
$monthrange,0)) as pnltotalOldYear
from pep_faglflext 
inner join account_cost_center on account_cost_center.cost_id=pep_faglflext.RCNTR
 where account_head in ('Administrative','Distribution','Marketing & Selling') and RYEAR=$oYear";


 $strCogsYearOld="select fyear,
sum(
if(burks=1000,
$monthrange,0)) as pedCOGS,
sum(
if(burks=2000,
$monthrange,0)) as praCOGS,
sum(
if(burks=5000,
$monthrange,0)) as pnlCOGS
from cost_yearly 
inner join account_cost_area on account_cost_area.area_id=cost_yearly.area_id where fyear= $oYear
and cost_yearly.area_id in(6) 
"; 
 
 
 
 
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




	
	
//Year wise COGS calculation
	

$strCOGSYear="

select  det.fyear,round(pedtotal/ped*100,2) as ped,
round(pratotal/pra*100,2) as pra,
round(pnltotal/pnl*100,2) as pnl,
round(ovtot/ov*100,2) as ovl,

round(pedCOGS/ped*100,2) as pedCOGS,
round(praCOGS/pra*100,2) as praCOGS,
round(pnlCOGS/pnl*100,2) as pnlCOGS,
round(ovCOGS/ov*100,2) as ovlCOGS,

round(pedCOGS/10000000,2) as pedCGV,
round(praCOGS/10000000,2) as praCGV,
round(pnlCOGS/10000000,2) as pnlCGV,
round(ovCOGS/10000000,2) as  ovCGV,

round(ped/10000000,2) as pedSV,
round(pra/10000000,2) as praSV,
round(pnl/10000000,2) as pnlSV,
round(ov/10000000,2) as  ovSV,


round(pedtotal/10000000,2) as pedOV,
round(pratotal/10000000,2) as praOV,
round(pnltotal/10000000,2) as pnlOV,
round(ovtot/10000000,2) as  ovOV

 from 
(select RYEAR as fyear,

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

where RYEAR in(2017,2018,2019) and account_head in ('Administrative','Distribution','Marketing & Selling')
group by RYEAR) as det
inner join 
(select fyear,
sum(
if(company=1000,
july+august+september+october+november+december+january+february+march+april+may+june,0)) as ped,
sum(
if(company=2000,
july+august+september+october+november+december+january+february+march+april+may+june,0)) as pra,
sum(
if(company=5000,
july+august+september+october+november+december+january+february+march+april+may+june,0)) as pnl,
sum(
if(company in (1000,2000,5000),
july+august+september+october+november+december+january+february+march+april+may+june,0)) as ov

from sales_monthy 
 where   fyear in(2017,2018,2019) 
group by fyear) as det2 on det.fyear=det2.fyear

inner join
(select fyear,
sum(
if(burks=1000,
july+august+september+october+november+december+january+february+march+april+may+june,0)) as pedCOGS,
sum(
if(burks=2000,
july+august+september+october+november+december+january+february+march+april+may+june,0)) as praCOGS,
sum(
if(burks=5000,
july+august+september+october+november+december+january+february+march+april+may+june,0)) as pnlCOGS,
sum(
if(burks in (1000,2000,5000),
july+august+september+october+november+december+january+february+march+april+may+june,0)) as ovCOGS
from cost_yearly 
inner join account_cost_area on account_cost_area.area_id=cost_yearly.area_id
 where cost_yearly.area_id in(6) and fyear in(2017,2018,2019) 
 group by fyear) as det3 on det.fyear=det3.fyear

";






//-ITEM Growth


$str="select  sap_sales_process.spart,sum(  if(   FKDAT>='$osdate' and FKDAT<='$oedate'  ,FKIMG,0 )  ) as oldqty,
sum(  if(   FKDAT>='$csdate' and FKDAT<='$cedate'  ,FKIMG,0 )  ) as qty
from sap_sales_process 
inner join material_data on material_data.MATNR=sap_sales_process.MATNR 
where FKDAT>='$osdate' and CTAG in('CR','BD','SR')  and material_data.MTART='HAWA'
group by sap_sales_process.spart

";
//echo $str;

$pedItmTotSales=0;
$hcpItmTotSales=0;
$bgItmTotSales=0;
$itapItmTotSales=0;
$saerItmTotSales=0;
$tefItmTotSales=0;
$pentItmTotSales=0;
$maxItmTotSales=0;
$muntItmTotSales=0;
$rovItmTotSales=0;
$panelliItmTotSales=0;
$purItmTotSales=0;

$pedItmOldTotSales=0;
$hcpItmOldTotSales=0;
$bgItmOldTotSales=0;
$itapItmOldTotSales=0;
$saerItmOldTotSales=0;
$tefItmOldTotSales=0;
$pentItmOldTotSales=0;
$maxItmOldTotSales=0;
$muntItmOldTotSales=0;
$rovItmOldTotSales=0;
$panelliItmOldTotSales=0;
$purItmOldTotSales=0;
$sql=mysqli_query( $GLOBALS['con'] ,$str );
while($rowItm=mysqli_fetch_object($sql))	
{

	if($rowItm->spart==20)
	{
		$pedItmTotSales= $rowItm->qty;
		$pedItmOldTotSales= $rowItm->oldqty;
	}	
	else if($rowItm->spart==30)
	{
		$hcpItmTotSales= $rowItm->qty;
		$hcpItmOldTotSales= $rowItm->oldqty;
	}
	else if($rowItm->spart==50)
	{
		$bgItmTotSales= $rowItm->qty;
		$bgItmOldTotSales= $rowItm->oldqty;
	}
	else if($rowItm->spart==60)
	{
		$itapItmTotSales= $rowItm->qty;
		$itapItmOldTotSales= $rowItm->oldqty;
	}
	else if($rowItm->spart==51)
	{
		$saerItmTotSales= $rowItm->qty;
		$saerItmOldTotSales= $rowItm->oldqty;
	}
	else if($rowItm->spart==90)
	{
		$tefItmTotSales= $rowItm->qty;
		$tefItmOldTotSales= $rowItm->oldqty;
	}
	else if($rowItm->spart==99)
	{
		$pentItmTotSales= $rowItm->qty;
		$pentItmOldTotSales= $rowItm->oldqty;
	}
	else if($rowItm->spart==95)
	{
		$maxItmTotSales= $rowItm->qty;
		$maxItmOldTotSales= $rowItm->oldqty;
	}
	else if($rowItm->spart==80)
	{
		$muntItmTotSales= $rowItm->qty;
		$muntItmOldTotSales= $rowItm->oldqty;
	}
	else if($rowItm->spart==40)
	{
		$rovItmTotSales= $rowItm->qty;
		$rovItmOldTotSales= $rowItm->oldqty;
	}
	else if($rowItm->spart==52)
	{
		$panelliItmTotSales= $rowItm->qty;
		$panelliItmOldTotSales= $rowItm->oldqty;
	}
	else if($rowItm->spart==81)
	{
		//echo $purItmTotSales;
		$purItmTotSales= $rowItm->qty;
		$purItmOldTotSales= $rowItm->oldqty;
	}
	
	//echo " ".$rowItm->spart;

}


//PEDROLLO
$str="select
(select ifnull(sum(NETWR),0) as tot from sap_sales_process where FKDAT>='$csdate' and FKDAT<='$cedate'
and SPART=20 and CTAG in('CR','BD','SR')
) as newtot,
(select ifnull(sum(NETWR),0) as tot from sap_sales_process where FKDAT>='$osdate' and FKDAT<='$oedate'
and SPART=20 and CTAG in('CR','BD','SR')) as oldtot

";



$sql=mysqli_query( $GLOBALS['con'] ,$str );
$rowItm=mysqli_fetch_object($sql);	


$pedGrv	=	$rowItm->newtot-$rowItm->oldtot;
$pedGrp=  round(($pedGrv/$rowItm->oldtot)*100,2);

//echo $str;


//HCP

$str="select
(select ifnull(sum(NETWR),0) as tot from sap_sales_process where FKDAT>='$csdate' and FKDAT<='$cedate'
and SPART=30 and CTAG in('CR','BD','SR')
) as newtot,
(select ifnull(sum(NETWR),0) as tot from sap_sales_process where FKDAT>='$osdate' and FKDAT<='$oedate'
and SPART=30 and CTAG in('CR','BD','SR')) as oldtot
";
$sql=mysqli_query( $GLOBALS['con'] ,$str );
$rowItm=mysqli_fetch_object($sql);


$hcpGrv	=	$rowItm->newtot-$rowItm->oldtot;
$hcpGrp=  round(($hcpGrv/$rowItm->oldtot)*100,2);





//BGFLOW

$str="select
(select ifnull(sum(NETWR),0) as tot from sap_sales_process where FKDAT>='$csdate' and FKDAT<='$cedate'
and SPART=50 and CTAG in('CR','BD','SR')
) as newtot,
(select ifnull(sum(NETWR),0) as tot from sap_sales_process where FKDAT>='$osdate' and FKDAT<='$oedate'
and SPART=50 and CTAG in('CR','BD','SR')) as oldtot
";
$sql=mysqli_query( $GLOBALS['con'] ,$str );
$rowItm=mysqli_fetch_object($sql);	


$bgGrv	=	$rowItm->newtot-$rowItm->oldtot;
$bgGrp=  round(($bgGrv/$rowItm->oldtot)*100,2);



//ITAP

$str="select
(select ifnull(sum(NETWR),0) as tot from sap_sales_process where FKDAT>='$csdate' and FKDAT<='$cedate'
and SPART=60 and CTAG in('CR','BD','SR')
) as newtot,
(select ifnull(sum(NETWR),0) as tot from sap_sales_process where FKDAT>='$osdate' and FKDAT<='$oedate'
and SPART=60 and CTAG in('CR','BD','SR')) as oldtot
";
$sql=mysqli_query( $GLOBALS['con'] ,$str );
$rowItm=mysqli_fetch_object($sql);	


$itapGrv	=	$rowItm->newtot-$rowItm->oldtot;
$itapGrp=  round(($itapGrv/$rowItm->oldtot)*100,2);




//SAER

$str="select
(select ifnull(sum(NETWR),0) as tot from sap_sales_process where FKDAT>='$csdate' and FKDAT<='$cedate'
and SPART=51 and CTAG in('CR','BD','SR')
) as newtot,
(select ifnull(sum(NETWR),0) as tot from sap_sales_process where FKDAT>='$osdate' and FKDAT<='$oedate'
and SPART=51 and CTAG in('CR','BD','SR')) as oldtot
";
$sql=mysqli_query( $GLOBALS['con'] ,$str );
$rowItm=mysqli_fetch_object($sql);	



$saerGrv	=	$rowItm->newtot-$rowItm->oldtot;
$saerGrp=  round(($saerGrv/$rowItm->oldtot)*100,2);






//Other

$str="select
(select ifnull(sum(NETWR),0) as tot from sap_sales_process where FKDAT>='$csdate' and FKDAT<='$cedate'
and SPART not in(20,30,50,60,51) and CTAG in('CR','BD','SR')
) as newtot,
(select ifnull(sum(NETWR),0) as tot from sap_sales_process where FKDAT>='$osdate' and FKDAT<='$oedate'
and SPART not in(20,30,50,60,51) and CTAG in('CR','BD','SR')) as oldtot
";
//echo $str;

$sql=mysqli_query( $GLOBALS['con'] ,$str );
$rowItm=mysqli_fetch_object($sql);	

$othItmTotSales= 0;
$othGrv	=	$rowItm->newtot-$rowItm->oldtot;
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









//PED Growth

$str="select ifnull(sum(NETWR),0) as tot from sap_sales_process where FKDAT>='$osdate' and FKDAT<='$oedate' and CTAG in('CR') and BUKRS=1000";
$sql=mysqli_query( $GLOBALS['con'] ,$str );
$rowOldtotPED=mysqli_fetch_object($sql);	

$str="select ifnull(sum(NETWR),0) as tot from sap_sales_process where FKDAT>='$csdate' and FKDAT<='$cedate' and CTAG in('CR') and BUKRS=1000";	
$sql=mysqli_query( $GLOBALS['con'] ,$str );
$rowCurtotPED=mysqli_fetch_object($sql);

$prevSalesPED		=$rowOldtotPED->tot;
$curSalesPED		=$rowCurtotPED->tot;
$diffSalesPED		=$curSalesPED-$prevSalesPED;
$growthPercentPED	=  round(($diffSalesPED/$prevSalesPED)*100,2);


//PRA Growth

$str="select ifnull(sum(NETWR),0) as tot from sap_sales_process where FKDAT>='$osdate' and FKDAT<='$oedate' and CTAG in('CR') and BUKRS=2000";
$sql=mysqli_query( $GLOBALS['con'] ,$str );
$rowOldtotPRA=mysqli_fetch_object($sql);	

$str="select ifnull(sum(NETWR),0) as tot from sap_sales_process where FKDAT>='$csdate' and FKDAT<='$cedate' and CTAG in('CR') and BUKRS=2000";	
$sql=mysqli_query( $GLOBALS['con'] ,$str );
$rowCurtotPRA=mysqli_fetch_object($sql);

$prevSalesPRA		=$rowOldtotPRA->tot;
$curSalesPRA		=$rowCurtotPRA->tot;
$diffSalesPRA		=$curSalesPRA-$prevSalesPRA;
$growthPercentPRA	=round(($diffSalesPRA/$prevSalesPRA)*100,2);



//PNL Growth

$str="select ifnull(sum(NETWR),0) as tot from sap_sales_process where FKDAT>='$osdate' and FKDAT<='$oedate' and CTAG in('BD','SR')";
$sql=mysqli_query( $GLOBALS['con'] ,$str );
$rowOldtotPNL=mysqli_fetch_object($sql);	

$str="select ifnull(sum(NETWR),0) as tot from sap_sales_process where FKDAT>='$csdate' and FKDAT<='$cedate' and CTAG in('BD','SR')";	
$sql=mysqli_query( $GLOBALS['con'] ,$str );
$rowCurtotPNL=mysqli_fetch_object($sql);

$prevSalesPNL		=$rowOldtotPNL->tot;
$curSalesPNL		=$rowCurtotPNL->tot;
$diffSalesPNL		=$curSalesPNL-$prevSalesPNL;
$growthPercentPNL	=  round(($diffSalesPNL/$prevSalesPNL)*100,2);










///total Calculation-----------------------------------------------------------------------------------------

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
	


$str="select 
	sum( st.january+st.february+st.march+st.april+st.may+st.june+st.july+
	st.august+st.september+st.october+st.november+st.december) as TargetTot
	from sales_target st where st.fyear=$oYear";
	
	//echo $str;
$sql=mysqli_query( $GLOBALS['con'] ,$str );
$rowTargetoldtot=mysqli_fetch_object($sql);	

$str="select 
	sum( sp.january+sp.february+sp.march+sp.april+sp.may+sp.june+sp.july+
	sp.august+sp.september+sp.october+sp.november+sp.december) as SalesTot
	from sales_monthy sp where   sp.fyear=$oYear";	
$sql=mysqli_query( $GLOBALS['con'] ,$str );
$rowSalesoldtot=mysqli_fetch_object($sql);		
	
	
	$targetOldTot=$rowTargetoldtot->TargetTot;

	$salesOldTot=$rowSalesoldtot->SalesTot;

	
	$achieveNotOldTot=$targetOldTot-$salesOldTot;
	if($achieveNotOldTot<0)$achieveNotOldTot=0;
		
	$totOldPercentAchieved	= round(($salesOldTot/$targetOldTot)*100,2);	
	
	

	

	
	
	
	
//PNL Achievement

$str="select 
	sum( st.january+st.february+st.march+st.april+st.may+st.june+st.july+
	st.august+st.september+st.october+st.november+st.december) as TargetTot
	from sales_target st where st.fyear=$fyear and group_tag in ('BD')";
$sql=mysqli_query( $GLOBALS['con'] ,$str );
$rowTargettotPNL=mysqli_fetch_object($sql);	

$str="select 
	sum( sp.january+sp.february+sp.march+sp.april+sp.may+sp.june+sp.july+
	sp.august+sp.september+sp.october+sp.november+sp.december) as SalesTot
	from sales_monthy sp where   sp.fyear=$fyear  and group_tag in ('BD')";	
$sql=mysqli_query( $GLOBALS['con'] ,$str );
$rowSalestotPNL=mysqli_fetch_object($sql);		
	
	
	$targetTotPNL=$rowTargettotPNL->TargetTot;

	$salesTotPNL=$rowSalestotPNL->SalesTot;
	
	$achieveDifTotPNL=$targetTotPNL-$salesTotPNL;

	
	$totPercentAchievedPNL = round(($salesTotPNL/$targetTotPNL)*100,2);
		

	
	
	

	
	
//PED Achievement


$str="select 
	sum( st.january+st.february+st.march+st.april+st.may+st.june+st.july+
	st.august+st.september+st.october+st.november+st.december) as TargetTot
	from sales_target st where st.fyear=$fyear and group_tag='CR' and company=1000";
$sql=mysqli_query( $GLOBALS['con'] ,$str );
$rowTargettotPED=mysqli_fetch_object($sql);	

$str="select 
	sum( sp.january+sp.february+sp.march+sp.april+sp.may+sp.june+sp.july+
	sp.august+sp.september+sp.october+sp.november+sp.december) as SalesTot
	from sales_monthy sp where   sp.fyear=$fyear  and group_tag='CR' and company=1000";	
$sql=mysqli_query( $GLOBALS['con'] ,$str );
$rowSalestotPED=mysqli_fetch_object($sql);		
	
	
	$targetTotPED=$rowTargettotPED->TargetTot;

	$salesTotPED=$rowSalestotPED->SalesTot;
	
	$achieveDifTotPED=$targetTotPED-$salesTotPED;
	$totPercentAchievedPED = round(($salesTotPED/$targetTotPED)*100,2);
	
	
	
	
//PRA Achievement


$str="select 
	sum( st.january+st.february+st.march+st.april+st.may+st.june+st.july+
	st.august+st.september+st.october+st.november+st.december) as TargetTot
	from sales_target st where st.fyear=$fyear and ((group_tag='CR' and company=2000) or group_tag='SR')";
$sql=mysqli_query( $GLOBALS['con'] ,$str );
$rowTargettotPRA=mysqli_fetch_object($sql);	

$str="select 
	sum( sp.january+sp.february+sp.march+sp.april+sp.may+sp.june+sp.july+
	sp.august+sp.september+sp.october+sp.november+sp.december) as SalesTot
	from sales_monthy sp where   sp.fyear=$fyear  and ((group_tag='CR' and company=2000) or group_tag='SR')";	
$sql=mysqli_query( $GLOBALS['con'] ,$str );
$rowSalestotPRA=mysqli_fetch_object($sql);		
	
	
	$targetTotPRA=$rowTargettotPRA->TargetTot;

	$salesTotPRA=$rowSalestotPRA->SalesTot;	
	
	$achieveDifTotPRA=$targetTotPRA-$salesTotPRA;
	$totPercentAchievedPRA = round(($salesTotPRA/$targetTotPRA)*100,2);

			
	




	
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
		<div>
            <div class="panel with-nav-tabs panel-success">
                <div class="panel-heading">
                        <ul class="nav nav-tabs">							
						<li class="active"><a href="#tab1default" data-toggle="tab">Achievement</a></li>
                            <li><a href="#tab2default" data-toggle="tab">Expenses</a></li>
							<li><a href="#tab3default" data-toggle="tab">Inventory</a></li>
						<li><a href="#tab4default" data-toggle="tab">Target Vs Achivement</a></li>
                        </ul>
                </div>
               
				<div class="panel-body">
			<div class="tab-content">
			<!-- <table border=2 bordercolor="#9B9EA3" > -->
			<!-- First Tab Start 				 -->
			<div class="tab-pane fade in active" id="tab1default">
			<table border=2 bordercolor="#9B9EA3" >
				<tr>
					<td colspan=3>
						<div  style="background-color:#59DDB5;text-align:left" >
							<table width="100%">
								<tr>
									<td>
										<font size="4" color="#404548"><b>&nbsp;Management&nbsp;Dashboard</b></font>
										<br/>
										<font size="2" color="#FFFFFF">&nbsp;Last pulling sales data: <b><?php echo  $last_pull_date; ?></b></font>
									</td>
								
									<td align="right">
										<table>
											<tr>
												<td align="right">	
													<font size="4" color="#FF0000">*</font><font size="2" color="#404548">&nbsp;Data Source: Previous financial year 2019 & Current financial year 2020 data (Pedrollo, PNL & Pragati)&nbsp;</font>					
												</td>
											</tr>
											<tr>
												<td align="left">
													<font size="4" color="#FF0000">*</font><font size="2" color="#404548">&nbsp;All Monetary value is in Crore&nbsp;</font>	
												</td>
											</tr>
										</table>
									</td>
								</tr>
							</table>		
						</div>
					</td>	
				</tr>	
				<tr>
					
					
					<td valign="top" ><font size="4">
						<table class="table table-striped" >
							<tr bgcolor="B0D3E2">
								<td align="left" bgcolor="B0D3E2" ><font color="#404548"><b>Company&nbsp;wise&nbsp;achievement</b></font></td>						
							</tr>
							<tr>
								<td align="center">
									<table class="table table-striped">
									
										<tr>
											
											<td>
											
												<div  align="center" style="background-color:#59DDB5;width: 40px">
													<font size=3 color="#FFFFFF"><b>Unit</b></font>
												</div>	
								
											</td>
											
											<td>
											
												<div  align="center" style="background-color:#59DDB5;width: 60px">
													<font size=3 color="#FFFFFF"><b>Target</b></font>
												</div>	
												<font size="2" color="#404548">year&nbsp;2020</font>
											</td>
											<td>
											
												<div  align="center" style="background-color:#59DDB5;width: 70px">
													<font size=3 color="#FFFFFF"><b>Achieve</b></font>
												</div>	
											    <font size="2" color="#404548">till&nbsp;now</font>
											</td>
											<td>
											
												<div  align="center" style="background-color:#59DDB5;width: 130px">
													<font size=3 color="#FFFFFF"><b>Last Year Sales</b></font>
												</div>	
											    <font size="2" color="#404548">Same period 2019</font>
											</td>
											
										</tr>
					
										
										<tr>
											<td><font color="#404548">Pedrollo:</font></td>
											<td><font   color="#800000"><?php echo sprintf("%.2f",$targetTotPED/10000000) ?></font></td>							
											<td><font  color="#800000"><?php echo sprintf("%.2f",$salesTotPED/10000000) ?></font></td>
											<td><font  color="#800000"><?php echo sprintf("%.2f",$prevSalesPED/10000000) ?></font></td>
										</tr>
										
										<tr>
											<td><font color="#404548">Pragati:</font></td>
											<td><font   color="#800000"><?php echo sprintf("%.2f",$targetTotPRA/10000000) ?></font></td>							
											<td><font  color="#800000"><?php echo sprintf("%.2f",$salesTotPRA/10000000) ?></font></td>
											<td><font  color="#800000"><?php echo sprintf("%.2f",$prevSalesPRA/10000000) ?></font></td>
										</tr>
										
										<tr>
											<td><font color="#404548">PNL:</font></td>
											<td><font   color="#800000"><?php echo sprintf("%.2f",$targetTotPNL/10000000) ?></font></td>							
											<td><font  color="#800000"><?php echo sprintf("%.2f",$salesTotPNL/10000000) ?></font></td>
											<td><font  color="#800000"><?php echo sprintf("%.2f",$prevSalesPNL/10000000) ?></font></td>
										</tr>
								
									
									</table>
								
												<div  align="center" style="background-color:#59DDB5;width: 160px">
													<font size=3 color="#FFFFFF"><b>Target vs Achieve%</b></font>
												</div>	
												<br/>						
												<div class="chart">
													<canvas id="totSegment"></canvas>	
												</div>
											 	
								</td>
									
							</tr>
						</table></font>					
					</td>
					
					
					
					
					<td valign="top" colspan=2><font size="4">
						<table class="table table-striped" >
							<tr bgcolor="#B0D3E2">
								<td align="left" colspan=2  bgcolor="B0D3E2"><font color="#404548"><b>Overall</b></font></td>							
							</tr>
							<tr>
								<td  align="center">
									
									<table class="table table-striped" >
		
										<tr>
											<td>
											
												<div  align="center" style="background-color:#59DDB5;width: 60px">
													<font size=3 color="#FFFFFF"><b>Target</b></font>
												</div>	
												<font size="2" color="#404548">year&nbsp;2020</font>
											</td>
											<td>
											
												<div  align="center" style="background-color:#59DDB5;width: 70px">
													<font size=3 color="#FFFFFF"><b>Achieve</b></font>
												</div>	
											    <font size="2" color="#404548">till&nbsp;now</font>
											</td>
											<td>
											
												<div  align="center" style="background-color:#59DDB5;width: 130px">
													<font size=3 color="#FFFFFF"><b>Last Year Sales</b></font>
												</div>							
											    <font size="2" color="#404548">Same period 2019</font>
											</td>
										</tr>
										<tr>
										
											<td><font size="4"  color="#800000"> <?php echo sprintf("%.2f",$targetTot/10000000) ?> </font></td>
											<td><font size="4"  color="#800000"> <?php echo sprintf("%.2f",$salesTot/10000000) ?> </font></td>
											<td><font size="4" color="#800000"><?php echo sprintf("%.2f",$prevSales/10000000) ?> </font></td>											
										</tr>
										<!--
										<tr>
											<td><font size="4"  color="#FFB35F">  <?php echo round($targetOldTot/10000000,2) ?> crore</font></td>										
											<td><font size="4"  color="#FFB35F"> <?php echo round($achieveNotTot/10000000,2) ?> crore</font></td>
											<td><font size="4"  color="#FFB35F">  <?php echo round($achieveNotOldTot/10000000,2) ?> crore</font></td>
											<td><font size="4"  color="#FFB35F">  <?php echo round($salesOldTot/10000000,2) ?> crore</font></td>
										</tr>
										-->
							
									</table>
									
								</td>
								<td align="center">
									
								
									<table class="table table-striped" >
							
										
										<!--						
										<tr>
											<td><font size="4" color="#59DDB5">Current Year Sales:</font>
											<br/><font size="2" color="#404548"><?php echo $csdate." to ".$cedate; ?></font>
											</td><td><font size="4" color="#FFB35F"><?php echo round($curSales/10000000,2) ?> crore</font></td>						
										</tr>
										
										
										<tr>
											<td><font size="4" color="#59DDB5">Previous Year Sales:</font>
											<br/><font size="2" color="#404548"><?php echo $osdate." to ".$oedate; ?></font>
											</td><td><font size="4" color="#FFB35F"><?php echo round($prevSales/10000000,2) ?> crore</font></td>						
										</tr>
										-->
										<tr>
											<td>
											<div  align="center" style="background-color:#59DDB5;width: 160px">
												<font size=3 color="#FFFFFF"><b>Growth Value</b></font>
											</div>	
											<font size="2" color="#404548">Comparing with 2019</font>
											</td><td><font size="4" color="#800000"><?php echo sprintf("%.2f",$diffSales/10000000); ?> </font>
											<?php if($diffSales>0){ ?> <img src="pic/up.png" height="20"  /><?php }else if($diffSales<0){ ?><img src="pic/down.gif" height="20"  /><?php } ?>
											</td>						
										</tr>
										
										<tr>
											<td>
											<div  align="center" style="background-color:#59DDB5;width: 160px">
												<font size=3 color="#FFFFFF"><b>Growth Percentage</b></font>
											</div>
											</td><td><font size="4" color="#800000"><?php echo $growthPercent; ?>%</font>
											<?php if($growthPercent>0){ ?> <img src="pic/up.png" height="20"  /><?php }else if($growthPercent<0){ ?><img src="pic/down.gif" height="20"  /><?php } ?>
											</td>						
										</tr>
										
									</table>
									
								</td>		
								
							</tr>
							</table>
							<table width="100%">
						
							
							<tr>
								
							
								<td colspan=2 align="center">
									<div  align="center" style="background-color:#59DDB5;width: 160px">
										<font size=3 color="#FFFFFF"><b>Segment Wise</b></font>
									</div>
									<div class="chart" >
										<canvas id="segAchievement"></canvas>	
									</div>
									<div align="center"><font size="2" color="#404548">Sales & Target Values measured in Crore</font></div>
									<!--
									<table class="table table-striped">
								
			
										<tr>
											<td><font color="#59DDB5">Unit</font></td>
											<td><font color="#59DDB5">Target</font></td>
											<td><font color="#59DDB5">Achieve</font></td>
											<td><font color="#59DDB5">Sales</font></td>
											<td><font color="#59DDB5">Growth</font></td>
											<td><font color="#59DDB5">Compare with previous </font></td>
										</tr>
										<tr>
											<td><font color="#404548">CR:</font></td>
											<td><font  color="#FFB35F"><?php echo round($targetTotCR/10000000,2) ?> crore</font></td>
											<td><font color="#FFB35F"> <?php echo $totPercentAchievedCR ?>%</font></td>
											<td><font  color="#FFB35F"><?php echo round($salesTotCR/10000000,2) ?> crore</font></td>
											
											<td><font size="4" color="#FFB35F"><?php echo $growthPercentCR; ?>%</font></td>
											<td><font  size="4" color="#FFB35F"><?php echo round($diffSalesCR/10000000,2) ?> crore</font>
											<?php if($diffSalesCR>0){ ?> <img src="pic/up.png" height="20"  /><?php }else if($diffSalesCR<0){ ?><img src="pic/down.png" height="20"  /><?php } ?>		
											</td>
											
										</tr>
										<tr>
											<td><font color="#404548">BD:</font></td>
											<td><font   color="#FFB35F"><?php echo round($targetTotBD/10000000,2) ?> crore</font></td> 
											<td><font color="#FFB35F"> <?php echo $totPercentAchievedBD ?>%</font></td>
											<td><font  color="#FFB35F"><?php echo round($salesTotBD/10000000,2) ?> crore</font></td>
											<td><font size="4" color="#FFB35F"><?php echo $growthPercentBD; ?>%</font></td>
											<td><font  size="4" color="#FFB35F"><?php echo round($diffSalesBD/10000000,2) ?> crore</font>
											<?php if($diffSalesBD>0){ ?> <img src="pic/up.png" height="20"  /><?php }else if($diffSalesBD<0){ ?><img src="pic/down.png" height="20"  /><?php } ?>
											</td>
										</tr>
										<tr>
											<td><font color="#404548">SR:</font></td>
											<td><font   color="#FFB35F"><?php echo round($targetTotSR/10000000,2) ?> crore</font></td>
											<td><font color="#FFB35F"> <?php echo $totPercentAchievedSR ?>%</font></td>
											<td><font  color="#FFB35F"><?php echo round($salesTotSR/10000000,2) ?> crore</font></td>
											<td><font size="4" color="#FFB35F"><?php echo $growthPercentSR; ?>%</font></td>
											<td><font  size="4" color="#FFB35F"><?php echo round($diffSalesSR/10000000,2) ?> crore</font>
											<?php if($diffSalesSR>0){ ?> <img src="pic/up.png" height="20"  /><?php }else if($diffSalesSR<0){ ?><img src="pic/down.png" height="20"  /><?php } ?>
											</td>	
										</tr>
									</table>
									-->
								</td>	
							</tr>	
							
							
						</table>
						</font>		

					
					
				</tr>
				<!-- First Tab End  -->
			</table>	
			</div>
			<!-- Second Tab Start  -->
			<div class="tab-pane fade in" id="tab2default">
			<table border=2 bordercolor="#9B9EA3" >
				<tr>
					<td colspan=3 bgcolor="#FFB35F" height="50">
						<font size="4">
							<table width="100%">
								<tr>
									<td width="50%" >
										<font  color="#404548"><b>&nbsp;COGS & Operating expenses</b></font>						
									</td>
									<td>
										<font color="#404548">&#124;</font>
								
									</td>
									<td>
										<b><font color="#404548">Company Wise</font></b>					
									</td>
								</tr>
							</table>
						</font>
					</td>
				</tr>
				
				
				<tr>
					<td valign="top" colspan=3 align="center">
						<font size="4">
							<table >
						
								<tr>
									
									<td >
										
										<table class="table table-striped" >
									
											<tr >
								
												<td colspan=2  >
												
														<table class="table table-striped" >	
														
															
															<tr>						
																<td></td>
																<td colspan=4 align="center"><b><font size="4" color="#0A236F">Pedrollo</font><b/></td>
																<td style="border-left: 1px solid #9B9EA3;" colspan=4 align="center"><b><font size="4" color="#125b46">Pragati</font><b/></td>
																<td style="border-left: 1px solid #9B9EA3;" colspan=4 align="center"><b><font size="4" color="#7c4100">PNL</font><b/></td>
															
															</tr>
															
															<tr bgcolor="#FFB35F">						
																<td ><b><font size="4" color="#404548">&nbsp;Year&nbsp;</font></b></td>
																<td><font size="4" color="#404548">&nbsp;Turnover&nbsp;</font></td>
																<td><font size="4" color="#404548">&nbsp;COGS&nbsp;</font></td>
																
																<td><font size="4" color="#404548">&nbsp;Op&nbsp;Cost&nbsp;</font></td>
																<td><font size="4" color="#404548">&nbsp;GP&nbsp;</font></td>
																
																
																<td style="border-left: 1px solid #9B9EA3;"><font size="4" color="#404548">&nbsp;Turnover&nbsp;</font></td>
																<td><font size="4" color="#404548">&nbsp;COGS&nbsp;</font></td>
																
																<td><font size="4" color="#404548">&nbsp;Op&nbsp;Cost&nbsp;</font></td>
																<td><font size="4" color="#404548">&nbsp;GP&nbsp;</font></td>
																
																
																<td style="border-left: 1px solid #9B9EA3;"><font size="4" color="#404548">&nbsp;Turnover&nbsp;</font></td>
																<td><font size="4" color="#404548">&nbsp;COGS&nbsp;</font></td>
																
																<td><font size="4" color="#404548">&nbsp;Op&nbsp;Cost&nbsp;</font></td>
																<td><font size="4" color="#404548">&nbsp;GP&nbsp;</font></td>
																
																
													
																
																
															</tr>

																<?php 

																
																$x=0;
																$sqlCGS=mysqli_query( $GLOBALS['con'] ,$strCOGSYear );
																while($row=mysqli_fetch_object($sqlCGS)){
																
																$ACGS[$x][0]=$row->fyear;
																$ACGS[$x][1]=$row->pedCOGS;
																$ACGS[$x][2]=$row->ped;
																$ACGS[$x][3]=$row->praCOGS;
																$ACGS[$x][4]=$row->pra;
																$ACGS[$x][5]=$row->pnlCOGS;
																$ACGS[$x][6]=$row->pnl;
																$x++;
																
															
															?>		

															<tr>	
														
																<td bgcolor="#FFB35F"><b><font size="4" color="#404548">&nbsp;<?php echo $row->fyear; ?>&nbsp;</font></b></td>
																
																<td><font size="4" color="#0A236F">&nbsp;<?php echo $row->pedSV; ?>&nbsp;</font></td>
																<td><font size="4" color="#0A236F">&nbsp;<?php echo $row->pedCGV; ?>&nbsp;</font></td>
															
																<td><font size="4" color="#0A236F">&nbsp;<?php echo $row->pedOV; ?>&nbsp;</font></td>
																
																<td><font size="4" color="#0A236F">&nbsp;<?php echo $row->pedSV-($row->pedCGV+$row->pedOV); ?>&nbsp;</font></td>
														
																
																<td style="border-left: 1px solid #9B9EA3;"><font size="4" color="#125b46">&nbsp;<?php echo $row->praSV; ?>&nbsp;</font></td>
																<td><font size="4" color="#125b46">&nbsp;<?php echo $row->praCGV; ?>&nbsp;</font></td>
															
																<td><font size="4" color="#125b46">&nbsp;<?php echo $row->praOV; ?>&nbsp;</font></td>
																
																<td><font size="4" color="#125b46">&nbsp;<?php echo $row->praSV-($row->praCGV+$row->praOV); ?>&nbsp;</font></td>
																
																
																<td style="border-left: 1px solid #9B9EA3;"><font size="4" color="#800000">&nbsp;<?php echo $row->pnlSV; ?>&nbsp;</font></td>
																<td><font size="4" color="#800000">&nbsp;<?php echo $row->pnlCGV; ?>&nbsp;</font></td>
														
																<td><font size="4" color="#800000">&nbsp;<?php echo $row->pnlOV; ?>&nbsp;</font></td>
																<td><font size="4" color="#800000">&nbsp;<?php echo $row->pnlSV-($row->pnlCGV+$row->pnlOV); ?>&nbsp;</font></td>
																
															
																
																
															</tr>
															<?php } ?>
															<tr>
																<td></td>
																
																<td colspan=3>
																	
																		<div class="chart">
																			<canvas id="pedCGS"></canvas>	
																		</div>
																</td>	
														
															
																
																<td colspan=3>
																	
																		<div class="chart">
																			<canvas id="praCGS"></canvas>	
																		</div>
																</td>	
															
																
																<td colspan=3>
																	
																		<div class="chart">
																			<canvas id="pnlCGS"></canvas>	
																		</div>
																</td>	
															</tr>	

														</table>								
													
												</td>
												
												
											</tr>
										</table>
									
											
			
						<div align="center"><font size="2" color="#404548">COGS & Operating Cost Percentage is calculated based on Turnover.</font></div>
				
										
										<table class="table table-striped">
											
											<tr>
								
												<td>
												
														<table class="table table-striped" align="center"  >	
														
															
															<tr>						
															
									
																<td colspan=5  align="center"><b><font size="2" color="#9b0c68">Overall</font></b></td>
															</tr>
															
															<tr bgcolor="#FFB35F">						
																
																
																
																<td><font size="2" color="#404548">&nbsp;Year&nbsp;</font></td>
																<td><font size="2" color="#404548">&nbsp;Turnover&nbsp;</font></td>
																<td><font size="2" color="#404548">&nbsp;COGS&nbsp;</font></td>
															
																<td><font size="2" color="#404548">&nbsp;Op&nbsp;Cost&nbsp;</font></td>
													
																<td><font size="2" color="#404548">&nbsp;O.&nbsp;Profit&nbsp;</font></td>
																
															</tr>

																<?php 

																
																$x=0;
																$sql=mysqli_query( $GLOBALS['con'] ,$strCOGSYear );
																while($row=mysqli_fetch_object($sql)){																
											
																$ACGS[$x][7]=$row->ovlCOGS;
																$ACGS[$x][8]=$row->ovl;
																$x++;
														
																
															
															?>		

															<tr>	
														
																<td bgcolor="#FFB35F"><font size="2" color="#404548">&nbsp;<?php echo $row->fyear; ?>&nbsp;</font></td>
																
					
																
																<td><font size="2" color="#9b0c68">&nbsp;<?php echo $row->ovSV; ?>&nbsp;</font></td>
																<td><font size="2" color="#9b0c68">&nbsp;<?php echo $row->ovCGV; ?>&nbsp;</font></td>
																
																<td><font size="2" color="#9b0c68">&nbsp;<?php echo $row->ovOV; ?>&nbsp;</font></td>
																
																
																
																<td><font size="2" color="#9b0c68">&nbsp;<?php echo $row->ovSV-($row->ovCGV+$row->ovOV); ?>&nbsp;</font></td>
																
															</tr>
															<?php } ?>

														</table>								
													
												</td>
							
												<td>	
													<br/>	
													<br/>	
													<div class="chart">
														<canvas id="ovCGS"></canvas>	
													</div>
												</td>	
												
												<td>
													<table class="table table-striped" >
														<tr >
															<td colspan=7 align="center">
															
																<b><font size="2" color="#0F6DB7">(<?php echo $wpsel; ?>)</font></b>
																
																
															</td>
														</tr>
												
													
															<?php 
															$sqlcostYearCur=mysqli_query( $GLOBALS['con'] ,$strcostYearCur );			
															$rowcostYearCur=mysqli_fetch_object($sqlcostYearCur);
															
															
															
															$sqlCogsYearCur=mysqli_query( $GLOBALS['con'] ,$strCogsYearCur );			
															$rowCogsYearCur=mysqli_fetch_object($sqlCogsYearCur);
															
															$sqlCogsYearOld=mysqli_query( $GLOBALS['con'] ,$strCogsYearOld );			
															$rowCogsYearOld=mysqli_fetch_object($sqlCogsYearOld);
													
															
															
															$sqlcostYearOld=mysqli_query( $GLOBALS['con'] ,$strcostYearOld );
															$rowcostYearOld=mysqli_fetch_object($sqlcostYearOld);
															
															
															$sqlSalesTotYearCur=mysqli_query( $GLOBALS['con'] ,$strSalesTotYearCur );
															$rowSalesTotYearCur=mysqli_fetch_object($sqlSalesTotYearCur);
													
													
															
															$sqlSalesTotYearOld=mysqli_query( $GLOBALS['con'] ,$strSalesTotYearOld );
															$rowSalesTotYearOld=mysqli_fetch_object($sqlSalesTotYearOld);
													
															?>
														<tr bgcolor="#FFB35F">						
															<td><font size="2" color="#404548">&nbsp;Company&nbsp;</font></td>
															<td><font size="2" color="#404548">&nbsp;Last&nbsp;Year&nbsp;COGS&nbsp;</font></td>
															<td colspan=2><font size="2" color="#404548">&nbsp;Cur&nbsp;COGS&nbsp;</font></td>
															<td><font size="2" color="#404548">&nbsp;Last&nbsp;Year&nbsp;OpCost&nbsp;</font></td>
															<td colspan=2><font size="2" color="#404548">&nbsp;Cur&nbsp;OpCost&nbsp;</font></td>
														</tr>
														<?php
															$pedoop=round(($rowcostYearOld->pedtotalOldYear/$rowSalesTotYearOld->ped)*100,2);
															$pednop=round(($rowcostYearCur->pedtotalCurYear/$rowSalesTotYearCur->ped)*100,2);										
											
															$pedocgs=round(($rowCogsYearOld->pedCOGS/$rowSalesTotYearOld->ped)*100,2);
															$pedncgs=round(($rowCogsYearCur->pedCOGS/$rowSalesTotYearCur->ped)*100,2);
															
															
															
															$pnloop=round(($rowcostYearOld->pnltotalOldYear/$rowSalesTotYearOld->pnl)*100,2);
															$pnlnop=round(($rowcostYearCur->pnltotalCurYear/$rowSalesTotYearCur->pnl)*100,2);
															
															$pnlocgs=round(($rowCogsYearOld->pnlCOGS/$rowSalesTotYearOld->pnl)*100,2);
															$pnlncgs=round(($rowCogsYearCur->pnlCOGS/$rowSalesTotYearCur->pnl)*100,2);
															
															
															$praoop=round(($rowcostYearOld->pratotalOldYear/$rowSalesTotYearOld->pra)*100,2);
															$pranop=round(($rowcostYearCur->pratotalCurYear/$rowSalesTotYearCur->pra)*100,2);
															
															$praocgs=round(($rowCogsYearOld->praCOGS/$rowSalesTotYearOld->pra)*100,2);
															$prancgs=round(($rowCogsYearCur->praCOGS/$rowSalesTotYearCur->pra)*100,2);
														?>		
														<tr>					
															<td><font size="2" color="#404548">&nbsp;Pedrollo:&nbsp;</font></td>	
															
															
															<td><font size="2" color="#0F6DB7">&nbsp;<?php echo $pedocgs; ?>%</font></td>
															<td><font size="2" color="#0F6DB7">&nbsp;<?php echo $pedncgs ; ?>%</font></td>
															<td>
															<?php if($pedocgs>$pedncgs){ ?> <img src="pic/upd.png" height="20"  /><?php }else{ ?><img src="pic/downd.gif" height="20"  /><?php } ?>
															</td>
															
															
															<td><font size="2" color="#0F6DB7">&nbsp;<?php echo $pedoop; ?>%</font></td>
															<td><font size="2" color="#0F6DB7">&nbsp;<?php echo $pednop ; ?>%</font></td>
															<td>
															<?php if($pedoop>$pednop){ ?> <img src="pic/upd.png" height="20"  /><?php }else{ ?><img src="pic/downd.gif" height="20"  /><?php } ?>
															</td>
															
														</tr>
														<tr>
															<td><font size="2" color="#404548">&nbsp;PNL:</font></td>
															<td><font size="2" color="#0F6DB7">&nbsp;<?php echo $pnlocgs; ?>%</font></td>
															<td><font size="2" color="#0F6DB7">&nbsp;<?php echo $pnlncgs ; ?>%</font></td>
															<td>
															<?php if($pnlocgs>$pnlncgs){ ?> <img src="pic/upd.png" height="20"  /><?php }else{ ?><img src="pic/downd.gif" height="20"  /><?php } ?>
															</td>
															
															<td><font size="2" color="#0F6DB7">&nbsp;<?php echo $pnloop;?>%</font></td>
															<td><font size="2" color="#0F6DB7">&nbsp;<?php echo $pnlnop; ?>%</font></td>
															<td>
															<?php if($pnloop>$pnlnop){ ?> <img src="pic/upd.png" height="20"  /><?php }else{ ?><img src="pic/downd.gif" height="20"  /><?php } ?>
															</td>
															
														</tr>
														<tr>	
															<td><font size="2" color="#404548">&nbsp;Pragati:&nbsp;</font></td>
															
															<td><font size="2" color="#0F6DB7">&nbsp;<?php echo $praocgs; ?>%</font></td>
															<td><font size="2" color="#0F6DB7">&nbsp;<?php echo $prancgs ; ?>%</font></td>
															<td>
															<?php if($praocgs>$prancgs){ ?> <img src="pic/upd.png" height="20"  /><?php }else{ ?><img src="pic/downd.gif" height="20"  /><?php } ?>
															</td>
															
															
															<td><font size="2" color="#0F6DB7">&nbsp;<?php echo $praoop; ?>%</font></td>
															<td><font size="2" color="#0F6DB7">&nbsp;<?php echo $pranop; ?>%</font></td>
															<td>
															<?php if($praoop>$pranop){ ?> <img src="pic/upd.png" height="20"  /><?php }else{ ?><img src="pic/downd.gif" height="20"  /><?php } ?>
															</td>
															
														</tr>
													

													</table>
													
														
												</td>	
												
												
											</tr>
										</table>
										
										
									
									<td>	
								</tr>	
							</table>	
						
						
						</font>
					
							
					</td>	
				</tr>
			</table>
			</div>
			<!-- Second Tab End  -->	
				
			<!-- Third Tab Start  -->
			<div class="tab-pane fade in" id="tab3default">
			<table border=2 bordercolor="#9B9EA3" >
				<tr>
					
					<td colspan=3 bgcolor="#add1e2" height="50">
					
						<font size=4 color="#404548">&nbsp;<b>Inventory</b></font>
						
						
					</td>		
				</tr>		
				<tr>
				
				
					<td align="center" colspan=3>
						<table>
							<tr>
								<td>								
									<table class="table table-striped" >
										<tr>
											<td align="center">
												<div  align="center" style="background-color:#108C08;width: 200px">
													<font size=3 color="#FFFFFF"><b>Growth Value Item Wise</b></font>
												</div>
											</td>								
										</tr>
										<tr>
											<td>
											
												<input type="radio" name='giwv' value='1' /><font size="2" color="#404548">&nbsp;Pedrollo</font>
												<input type="radio" name='giwv' value='2'  /><font size="2" color="#404548">&nbsp;Pragati</font>
												<input type="radio" name='giwv' value='3'  /><font size="2" color="#404548">&nbsp;PNL</font>	
												<input type="radio" name='giwv' value='4' checked /><font size="2" color="#404548">&nbsp;All</font>	
											
											</td>
										</tr>	
										<tr>
											<td>
												<div id="giw">
													<table class="table table-striped" >	
														<tr>
															<td><font size="4" color="#404548">Pedrollo:</font></td>
															<td><font  color="#108C08"><?php echo round($pedGrv/10000000,2) ?> </font></td>
															<td align="right"><font size="4" color="#108C08"><?php echo $pedGrp; ?>%</font><?php if($pedGrp>0){ ?> <img src="pic/up.png" height="20"  /><?php }else if($pedGrp<0){ ?><img src="pic/down.gif" height="20"  /><?php } ?></td>						
														</tr>
														<tr>
															<td><font size="4" color="#404548">HCP:</font></td>
															<td><font  color="#108C08"><?php echo round($hcpGrv/10000000,2) ?> </font></td>									
															<td align="right"><font size="4" color="#108C08"><?php echo $hcpGrp; ?>%</font><?php if($hcpGrp>0){ ?> <img src="pic/up.png" height="20"  /><?php }else if($hcpGrp<0){ ?><img src="pic/down.gif" height="20"  /><?php } ?></td>						
														</tr>
														<tr>
															<td><font size="4" color="#404548">BGFlow:</font></td>
															<td><font  color="#108C08"><?php echo round($bgGrv/10000000,2) ?> </font></td>
															<td align="right"><font size="4" color="#108C08"><?php echo $bgGrp; ?>%</font><?php if($bgGrp>0){ ?> <img src="pic/up.png" height="20"  /><?php }else if($bgGrp<0){ ?><img src="pic/down.gif" height="20"  /><?php } ?></td>						
														</tr>
														
														
														<tr>
															<td><font size="4" color="#404548">SAER:</font></td>
															<td><font  color="#108C08"><?php echo round($saerGrv/10000000,2) ?> </font></td>
															
															<td align="right"><font size="4" color="#108C08"><?php echo $saerGrp; ?>%</font><?php if($saerGrp>0){ ?> <img src="pic/up.png" height="20"  /><?php }else if($saerGrp<0){ ?><img src="pic/down.gif" height="20"  /><?php } ?></td>						
														</tr>
														
														<tr>
															<td><font size="4" color="#404548">ITAP:</font></td>
															<td><font  color="#108C08"><?php echo round($itapGrv/10000000,2) ?> </font></td>
															<td align="right"><font size="4" color="#108C08"><?php echo $itapGrp; ?>%</font><?php if($itapGrp>0){ ?> <img src="pic/up.png" height="20"  /><?php }else if($itapGrp<0){ ?><img src="pic/down.gif" height="20"  /><?php } ?></td>						
														</tr>
														<tr>
															<td><font size="4" color="#404548">Other:</font></td>
															<td><font  color="#108C08"><?php echo round($othGrv/10000000,2) ?> </font></td>
															<td align="right"><font size="4" color="#108C08"><?php echo $othGrp; ?>%</font><?php if($othGrp>0){ ?> <img src="pic/up.png" height="20"  /><?php }else if($othGrp<0){ ?><img src="pic/down.gif" height="20"  /><?php } ?></td>						
														</tr>
													</table>
													</div>
												</td>
											</tr>
										
										</table>
									
									
									
								</td>	
								<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
								<td align="center">	
									<table border=0 width="600" class="table table-striped" >
										<tr>
											<td align="center" colspan="5">
												<div  align="center" style="background-color:#FE7D00;width: 210px">
													<font size=3 color="#FFFFFF"><b>Current Stock Brand Wise</b></font>
													
												</div>
												<input type="radio" name='sqtm' value='1' checked /><font size="2" color="#404548">&nbsp;Quantity</font>
												<input type="radio" name='sqtm' value='2'  /><font size="2" color="#404548">&nbsp;Value</font>
												&#124;
												<input type="radio" name='product' value='1' checked /><font size="2" color="#404548">&nbsp;Water&nbsp;Pump</font>
												<input type="radio" name='product' value='2'  /><font size="2" color="#404548">&nbsp;Other</font>
												<input type="radio" name='product' value='3'  /><font size="2" color="#404548">&nbsp;All</font>
												 
											</td>	
						
																										
										</tr>
										<tr bgcolor="#add1e2">
											<td><font size="4" color="#404548">&nbsp;Brand&nbsp;</font></td>
											<td class="sqty" align="center"><font size="4" color="#404548">&nbsp;Product Qty&nbsp;</font>
											<br/>
												<font size="2" color="#404548">												
													in stock
												</font>
											</td>
											</td>
											<td class="sqty"><font size="4" color="#404548">&nbsp;Dead Stock&nbsp;</font></td>
											<td class="sqtv"><font size="4" color="#404548">&nbsp;Product Value&nbsp;</font></td>
											<td class="sqtv"><font size="4" color="#404548">&nbsp;Dead Stock&nbsp;</font></td>
											<td class="sqty" align="center"><font size="4" color="#404548">&nbsp;Spare Qty&nbsp;</font>
											<br/>
												<font size="2" color="#404548">												
													in stock
												</font>
											</td>
											<td class="sqty"><font size="4" color="#404548">&nbsp;Dead Stock&nbsp;</font></td>
											<td class="sqtv"><font size="4" color="#404548">&nbsp;Spare Value&nbsp;</font></td>
											<td class="sqtv"><font size="4" color="#404548">&nbsp;Dead Stock&nbsp;</font></td>
											
											<td align="center"  ><font size="4" color="#404548">&nbsp;Sales Qty&nbsp;</font>
											<br/>
												<font size="2" color="#404548">
												2019 same period
												</font>
											</td>
											
											
											
											<td align="center"  ><font size="4" color="#404548">&nbsp;Sales Qty&nbsp;</font>
											<br/>
												<font size="2" color="#404548">												
												2020 till now
												</font>
											</td>	
											
										</tr>

										<tr class="<?php echo $classname; ?>">
											<td align="left"><font size="4" color="#404548">&nbsp;&nbsp;</font></td>
											<td class="sqtv" align="center" colspan = "6">
											<?php
												$total_rowStock_pq = 0; $total_rowStock_pv = 0; $total_DeadStock_hawa_pq = 0; $total_DeadStock_hawa_pv = 0; 
												$total_rowStock_sq = 0; $total_rowStock_sv = 0; $total_DeadStock_halb_sq = 0; $total_DeadStock_halb_sv = 0;

												$sql_dead_stock_hawa=mysqli_query($GLOBALS['con'] ,$str_dead_stock_hawa);
												$all_DeadStock_hawa = array();
												while ($row = mysqli_fetch_assoc($sql_dead_stock_hawa)) {
													$all_DeadStock_hawa[] = $row;
												}

												$sql_dead_stock_halb=mysqli_query($GLOBALS['con'] ,$str_dead_stock_halb);
												$all_DeadStock_halb = array();
												while ($row = mysqli_fetch_assoc($sql_dead_stock_halb)) {
													$all_DeadStock_halb[] = $row;
												}

												// $test_search = array_search("Munters", array_column($all_DeadStock_hawa, "division"));
												// $test_search2 = array_search("Munters", array_column($all_DeadStock_halb, "division"));
												
												
												// echo "<br />";
												// print_r ($all_DeadStock_halb);
												// echo "</pre>";
												
											?>
											</td>
										</tr>
									
										<?php  
											$classname="water";
											$sqlStock=mysqli_query($GLOBALS['con'] ,$strStock);
											while($rowStock=mysqli_fetch_object($sqlStock)){
												
												if($rowStock->division=="Pedrollo" OR $rowStock->division=="HCP" OR $rowStock->division=="Rovatti" OR $rowStock->division=="BGFlow" OR $rowStock->division=="SAER" OR $rowStock->division=="Panelli"){
													$classname="water";
												}
												elseif( $rowStock->division=="ITAP" OR $rowStock->division=="Munters" OR $rowStock->division=="Pureit" OR $rowStock->division=="Teflon" OR $rowStock->division=="Maxwell" OR $rowStock->division=="Pentagono"){
													$classname="other";	
												}
												else{
													$classname = "All";
												}

												

												if($rowStock->division=="Pedrollo" OR $rowStock->division=="HCP" OR $rowStock->division=="Rovatti" OR $rowStock->division=="BGFlow" OR $rowStock->division=="SAER" OR $rowStock->division=="Panelli" OR $rowStock->division=="ITAP" OR $rowStock->division=="Munters" OR $rowStock->division=="Pureit" OR $rowStock->division=="Teflon" OR $rowStock->division=="Maxwell" OR $rowStock->division=="Pentagono")
												{
													$classname2 = "All";
												}
										?>
										<tr class="<?php echo $classname; ?>">
											<td align="left"><font size="4" color="#404548">&nbsp;<?php echo $rowStock->division; ?>&nbsp;</font></td>
											<td class="sqty" align="right"><font size="4" color="#0F6DB7"><?php echo round($rowStock->pq,0) ; ?></font>&nbsp;</td>
											<td class="sqty" align="right">
											<font size="4" color="#0F6DB7">
												<?php 
													$key_pq = array_search($rowStock->division, array_column($all_DeadStock_hawa, "division")); 
												?>
													<a href="dead_stock_data_report.php?division='<?php echo $rowStock->division; ?>'&product_type='HAWA'" target="_blank"><?php echo (isset($key_pq) AND $key_pq !== false)?$all_DeadStock_hawa[$key_pq]["pq"]:0; ?></a>
											</font>
											</td>
											<td class="sqtv" align="right"><font size="4" color="#0F6DB7"><?php echo round($rowStock->pv/10000000,2); ?></font>&nbsp;</td>
											<td class="sqtv" align="right">
											<font size="4" color="#0F6DB7">
												<?php 
													$key_pv = array_search($rowStock->division, array_column($all_DeadStock_hawa, "division")); 
												?>
												<a href="dead_stock_data_report.php?division='<?php echo $rowStock->division; ?>'&product_type='HAWA'" target="_blank"><?php echo (isset($key_pv) AND $key_pv !== false)?round($all_DeadStock_hawa[$key_pv]["pv"]/10000000,2):0; ?></a>
											</font>
											</td>
											<td class="sqty" align="right"><font size="4" color="#0F6DB7"><?php echo round($rowStock->sq,2); ?></font>&nbsp;</td>
											<td class="sqty" align="right">
											<font size="4" color="#0F6DB7">
												<?php 
													$key_sq = array_search($rowStock->division, array_column($all_DeadStock_halb, "division"));
												?>
												<a href="dead_stock_data_report.php?division='<?php echo $rowStock->division; ?>'&product_type='HALB'" target="_blank"><?php echo sprintf("%.0f", (isset($key_sq) AND $key_sq !== false)?$all_DeadStock_halb[$key_sq]["pq"]:0); ?></a>
											</font>
											</td>
											<td class="sqtv" align="right"><font size="4" color="#0F6DB7"><?php echo round($rowStock->sv/10000000,2); ?></font>&nbsp;</td>
											<td class="sqtv" align="right">
											<font size="4" color="#0F6DB7">
												<?php 
													$key_sv = array_search($rowStock->division, array_column($all_DeadStock_halb, "division"));
												?>
												<a href="dead_stock_data_report.php?division='<?php echo $rowStock->division; ?>'&product_type='HALB'" target="_blank"><?php echo (isset($key_sv) AND $key_sv !== false)?round($all_DeadStock_halb[$key_sv]["pv"]/10000000,2):0; ?></a>
											</font>
											</td>
											
											<td align="right"><font size="4" color="#0F6DB7">
											<a href="comparesSalesQty.php?spart=<?php echo $rowStock->id; ?>&osdate=<?php echo $osdate; ?>&oedate=<?php echo $oedate; ?>&csdate=<?php echo $csdate; ?>'&cedate='<?php echo $cedate; ?>" target="_blank" rel="noopener noreferrer">
											<?php
											 if( $rowStock->division=="Pedrollo"){ 
												echo round($pedItmOldTotSales,0) ;
											 } 
											 else if( $rowStock->division=="HCP"){ 
												echo round($hcpItmOldTotSales,0) ;
											 } 
											 else if( $rowStock->division=="Panelli"){ 
												echo round($panelliItmOldTotSales,0) ;
											 } 
											 else if( $rowStock->division=="BGFlow"){ 
												echo round($bgItmOldTotSales,0) ;
											 } 
											 else if( $rowStock->division=="SAER"){ 
												echo round($saerItmOldTotSales,0) ;
											 } 
											 else if( $rowStock->division=="ITAP"){ 
												echo round($itapItmOldTotSales,0) ;
											 } 
											 else if( $rowStock->division=="Munters"){ 
												echo round($muntItmOldTotSales,0) ;
											 } 
											 else if( $rowStock->division=="Teflon"){ 
												echo round($tefItmOldTotSales,0) ;
											 } 
											 else if( $rowStock->division=="Pentagono"){ 
												echo round($pentItmOldTotSales,0) ;
											 }
											  else if( $rowStock->division=="Maxwell"){ 
												echo round($maxItmOldTotSales,0) ;
											 }
											 
											 else if( $rowStock->division=="Pureit"){ 
												echo round($purItmOldTotSales,0) ;
											 }
											 //echo round($maxItmOldTotSales,0) ;
											 //echo "Hello";
											 ?>	
											 </a>
											</font></td>
											
											
											<td align="right"><font size="4" color="#0F6DB7">
											<?php
											 if( $rowStock->division=="Pedrollo"){ 
												echo round($pedItmTotSales,0) ;
												
												if($pedItmTotSales>$pedItmOldTotSales){ ?> <img src="pic/up.png" height="20"  /><?php }else if($pedItmOldTotSales>$pedItmTotSales){ ?><img src="pic/down.gif" height="20"  /><?php } 
												
											 } 
											 else if( $rowStock->division=="HCP"){ 
												echo round($hcpItmTotSales,0) ;
												
												if($hcpItmTotSales>$hcpItmOldTotSales){ ?> <img src="pic/up.png" height="20"  /><?php }else if($hcpItmOldTotSales>$hcpItmTotSales){ ?><img src="pic/down.gif" height="20"  /><?php } 
											 } 
											 else if( $rowStock->division=="Panelli"){ 
												echo round($panelliItmTotSales,0) ;
												if($panelliItmTotSales>$panelliItmOldTotSales){ ?> <img src="pic/up.png" height="20"  /><?php }else if($panelliItmOldTotSales>$panelliItmTotSales){ ?><img src="pic/down.gif" height="20"  /><?php } 
											 } 
											 else if( $rowStock->division=="BGFlow"){ 
												echo round($bgItmTotSales,0) ;
												if($bgItmTotSales>$bgItmOldTotSales){ ?> <img src="pic/up.png" height="20"  /><?php }else if($bgItmOldTotSales>$bgItmTotSales){ ?><img src="pic/down.gif" height="20"  /><?php } 
											 } 
											 else if( $rowStock->division=="SAER"){ 
												echo round($saerItmTotSales,0) ;
												if($saerItmTotSales>$saerItmOldTotSales){ ?> <img src="pic/up.png" height="20"  /><?php }else if($saerItmOldTotSales>$saerItmTotSales){ ?><img src="pic/down.gif" height="20"  /><?php } 
										
											 } 
											 else if( $rowStock->division=="ITAP"){ 
												echo round($itapItmTotSales,0) ;
												if($itapItmTotSales>$itapItmOldTotSales){ ?> <img src="pic/up.png" height="20"  /><?php }else if($itapItmOldTotSales>$itapItmTotSales){ ?><img src="pic/down.gif" height="20"  /><?php } 
											 } 
											 else if( $rowStock->division=="Munters"){ 
												echo round($muntItmTotSales,0) ;
												if($muntItmTotSales>$muntItmOldTotSales){ ?> <img src="pic/up.png" height="20"  /><?php }else if($muntItmOldTotSales>$muntItmTotSales){ ?><img src="pic/down.gif" height="20"  /><?php } 
											 } 
											 else if( $rowStock->division=="Teflon"){ 
												echo round($tefItmTotSales,0) ;
												if($tefItmTotSales>$tefItmOldTotSales){ ?> <img src="pic/up.png" height="20"  /><?php }else if($tefItmOldTotSales>$tefItmTotSales){ ?><img src="pic/down.gif" height="20"  /><?php } 
											 } 
											 else if( $rowStock->division=="Pentagono"){ 
												echo round($pentItmTotSales,0) ;
												if($pentItmTotSales>$pentItmOldTotSales){ ?> <img src="pic/up.png" height="20"  /><?php }else if($pentItmOldTotSales>$pentItmTotSales){ ?><img src="pic/down.gif" height="20"  /><?php } 
											 }
											  else if( $rowStock->division=="Maxwell"){ 
												echo round($maxItmTotSales,0) ;
												if($maxItmTotSales>$maxItmOldTotSales){ ?> <img src="pic/up.png" height="20"  /><?php }else if($maxItmOldTotSales>$maxItmTotSales){ ?><img src="pic/down.gif" height="20"  /><?php } 
											 }
											 
											  else if( $rowStock->division=="Pureit"){ 
												
												echo round($purItmTotSales,0) ;
												if($purItmTotSales>$purItmOldTotSales){ ?> <img src="pic/up.png" height="20"  /><?php }else if($purItmOldTotSales>$purItmTotSales){ ?><img src="pic/down.gif" height="20"  /><?php } 
											 }
											 
											 ?>	
											</font></td>
											
											
											
											
											
											
										</tr>

										<?php 
											if(isset($classname2)){ 
										?>	 
											<tr class="<?php echo $classname2; ?>">
												<td align="left"><font size="4" color="#404548">&nbsp;<?php echo $rowStock->division; ?>&nbsp;</font></td>
												<td class="sqty" align="right"><font size="4" color="#0F6DB7"><?php echo round($rowStock->pq,0) ; $total_rowStock_pq += round($rowStock->pq,0); ?></font>&nbsp;</td>
												<td class="sqty" align="right">
												<font size="4" color="#0F6DB7">
													<?php 
														$key_pq = array_search($rowStock->division, array_column($all_DeadStock_hawa, "division")); 
													?>
														<a href="dead_stock_data_report.php?division='<?php echo $rowStock->division; ?>'&product_type='HAWA'" target="_blank"><?php echo (isset($key_pq) AND $key_pq !== false)?$all_DeadStock_hawa[$key_pq]["pq"]:0; $total_DeadStock_hawa_pq += (isset($key_pq) AND $key_pq !== false)?$all_DeadStock_hawa[$key_pq]["pq"]:0;  ?></a>
												</font>
												</td>
												<td class="sqtv" align="right"><font size="4" color="#0F6DB7"><?php echo round($rowStock->pv/10000000,2); $total_rowStock_pv += round($rowStock->pv/10000000,2);?></font>&nbsp;</td>
												<td class="sqtv" align="right">
												<font size="4" color="#0F6DB7">
													<?php 
														$key_pv = array_search($rowStock->division, array_column($all_DeadStock_hawa, "division")); 
													?>
													<a href="dead_stock_data_report.php?division='<?php echo $rowStock->division; ?>'&product_type='HAWA'" target="_blank"><?php echo (isset($key_pv) AND $key_pv !== false)?round($all_DeadStock_hawa[$key_pv]["pv"]/10000000,2):0; $total_DeadStock_hawa_pv += (isset($key_pv) AND $key_pv !== false)?round($all_DeadStock_hawa[$key_pv]["pv"]/10000000,2):0; ?></a>
												</font>
												</td>
												<td class="sqty" align="right"><font size="4" color="#0F6DB7"><?php echo round($rowStock->sq,2);  $total_rowStock_sq += round($rowStock->sq,2);  ?></font>&nbsp;</td>
												<td class="sqty" align="right">
												<font size="4" color="#0F6DB7">
													<?php 
														$key_sq = array_search($rowStock->division, array_column($all_DeadStock_halb, "division"));
													?>
													<a href="dead_stock_data_report.php?division='<?php echo $rowStock->division; ?>'&product_type='HALB'" target="_blank"><?php echo sprintf("%.0f", (isset($key_sq) AND $key_sq !== false)?$all_DeadStock_halb[$key_sq]["pq"]:0); $total_DeadStock_halb_sq += (isset($key_sq) AND $key_sq !== false)?$all_DeadStock_halb[$key_sq]["pq"]:0; ?></a>
												</font>
												</td>
												<td class="sqtv" align="right"><font size="4" color="#0F6DB7"><?php echo round($rowStock->sv/10000000,2); $total_rowStock_sv += round($rowStock->sv/10000000,2); ?></font>&nbsp;</td>
												<td class="sqtv" align="right">
												<font size="4" color="#0F6DB7">
													<?php 
														$key_sv = array_search($rowStock->division, array_column($all_DeadStock_halb, "division"));
													?>
													<a href="dead_stock_data_report.php?division='<?php echo $rowStock->division; ?>'&product_type='HALB'" target="_blank"><?php echo (isset($key_sv) AND $key_sv !== false)?round($all_DeadStock_halb[$key_sv]["pv"]/10000000,2):0; $total_DeadStock_halb_sv += (isset($key_sv) AND $key_sv !== false)?round($all_DeadStock_halb[$key_sv]["pv"]/10000000,2):0 ?></a>
												</font>
												</td>
												
												<td align="right"><font size="4" color="#0F6DB7">
												<a href="comparesSalesQty.php?spart=<?php echo $rowStock->id; ?>&osdate=<?php echo $osdate; ?>&oedate=<?php echo $oedate; ?>&csdate=<?php echo $csdate; ?>'&cedate='<?php echo $cedate; ?>" target="_blank" rel="noopener noreferrer">
												<?php
													if( $rowStock->division=="Pedrollo"){ 
													echo round($pedItmOldTotSales,0) ;
													} 
													else if( $rowStock->division=="HCP"){ 
													echo round($hcpItmOldTotSales,0) ;
													} 
													else if( $rowStock->division=="Panelli"){ 
													echo round($panelliItmOldTotSales,0) ;
													} 
													else if( $rowStock->division=="BGFlow"){ 
													echo round($bgItmOldTotSales,0) ;
													} 
													else if( $rowStock->division=="SAER"){ 
													echo round($saerItmOldTotSales,0) ;
													} 
													else if( $rowStock->division=="ITAP"){ 
													echo round($itapItmOldTotSales,0) ;
													} 
													else if( $rowStock->division=="Munters"){ 
													echo round($muntItmOldTotSales,0) ;
													} 
													else if( $rowStock->division=="Teflon"){ 
													echo round($tefItmOldTotSales,0) ;
													} 
													else if( $rowStock->division=="Pentagono"){ 
													echo round($pentItmOldTotSales,0) ;
													}
													else if( $rowStock->division=="Maxwell"){ 
													echo round($maxItmOldTotSales,0) ;
													}
													
													else if( $rowStock->division=="Pureit"){ 
													echo round($purItmOldTotSales,0) ;
													}
													//echo round($maxItmOldTotSales,0) ;
													//echo "Hello";
													?>	
												</a>
												</font></td>
												
												
												<td align="right"><font size="4" color="#0F6DB7">
												<?php
													if( $rowStock->division=="Pedrollo"){ 
													echo round($pedItmTotSales,0) ;
													
													if($pedItmTotSales>$pedItmOldTotSales){ ?> <img src="pic/up.png" height="20"  /><?php }else if($pedItmOldTotSales>$pedItmTotSales){ ?><img src="pic/down.gif" height="20"  /><?php } 
													
													} 
													else if( $rowStock->division=="HCP"){ 
													echo round($hcpItmTotSales,0) ;
													
													if($hcpItmTotSales>$hcpItmOldTotSales){ ?> <img src="pic/up.png" height="20"  /><?php }else if($hcpItmOldTotSales>$hcpItmTotSales){ ?><img src="pic/down.gif" height="20"  /><?php } 
													} 
													else if( $rowStock->division=="Panelli"){ 
													echo round($panelliItmTotSales,0) ;
													if($panelliItmTotSales>$panelliItmOldTotSales){ ?> <img src="pic/up.png" height="20"  /><?php }else if($panelliItmOldTotSales>$panelliItmTotSales){ ?><img src="pic/down.gif" height="20"  /><?php } 
													} 
													else if( $rowStock->division=="BGFlow"){ 
													echo round($bgItmTotSales,0) ;
													if($bgItmTotSales>$bgItmOldTotSales){ ?> <img src="pic/up.png" height="20"  /><?php }else if($bgItmOldTotSales>$bgItmTotSales){ ?><img src="pic/down.gif" height="20"  /><?php } 
													} 
													else if( $rowStock->division=="SAER"){ 
													echo round($saerItmTotSales,0) ;
													if($saerItmTotSales>$saerItmOldTotSales){ ?> <img src="pic/up.png" height="20"  /><?php }else if($saerItmOldTotSales>$saerItmTotSales){ ?><img src="pic/down.gif" height="20"  /><?php } 
											
													} 
													else if( $rowStock->division=="ITAP"){ 
													echo round($itapItmTotSales,0) ;
													if($itapItmTotSales>$itapItmOldTotSales){ ?> <img src="pic/up.png" height="20"  /><?php }else if($itapItmOldTotSales>$itapItmTotSales){ ?><img src="pic/down.gif" height="20"  /><?php } 
													} 
													else if( $rowStock->division=="Munters"){ 
													echo round($muntItmTotSales,0) ;
													if($muntItmTotSales>$muntItmOldTotSales){ ?> <img src="pic/up.png" height="20"  /><?php }else if($muntItmOldTotSales>$muntItmTotSales){ ?><img src="pic/down.gif" height="20"  /><?php } 
													} 
													else if( $rowStock->division=="Teflon"){ 
													echo round($tefItmTotSales,0) ;
													if($tefItmTotSales>$tefItmOldTotSales){ ?> <img src="pic/up.png" height="20"  /><?php }else if($tefItmOldTotSales>$tefItmTotSales){ ?><img src="pic/down.gif" height="20"  /><?php } 
													} 
													else if( $rowStock->division=="Pentagono"){ 
													echo round($pentItmTotSales,0) ;
													if($pentItmTotSales>$pentItmOldTotSales){ ?> <img src="pic/up.png" height="20"  /><?php }else if($pentItmOldTotSales>$pentItmTotSales){ ?><img src="pic/down.gif" height="20"  /><?php } 
													}
													else if( $rowStock->division=="Maxwell"){ 
													echo round($maxItmTotSales,0) ;
													if($maxItmTotSales>$maxItmOldTotSales){ ?> <img src="pic/up.png" height="20"  /><?php }else if($maxItmOldTotSales>$maxItmTotSales){ ?><img src="pic/down.gif" height="20"  /><?php } 
													}
													
													else if( $rowStock->division=="Pureit"){ 
													
													echo round($purItmTotSales,0) ;
													if($purItmTotSales>$purItmOldTotSales){ ?> <img src="pic/up.png" height="20"  /><?php }else if($purItmOldTotSales>$purItmTotSales){ ?><img src="pic/down.gif" height="20"  /><?php } 
													}
													
													?>	
												</font></td>
											</tr>
										<?php  } ?>
										<?php } ?>
										<tr class="<?php echo $classname2; ?>">
										
											<td align="left"><font size="4" color="#404548">&nbsp;Total&nbsp;</font></td>
											<td class="sqty" align="right"><font size="4" color="#0F6DB7"><?php echo $total_rowStock_pq ; ?></font>&nbsp;</td>
											<td class="sqty" align="right"><font size="4" color="#0F6DB7"><?php echo $total_DeadStock_hawa_pq; ?></font></td>
											<td class="sqtv" align="right"><font size="4" color="#0F6DB7"><?php echo $total_rowStock_pv; ?></font>&nbsp;</td>
											<td class="sqtv" align="right"><font size="4" color="#0F6DB7"><?php echo $total_DeadStock_hawa_pv; ?></font></td>
											<td class="sqty" align="right"><font size="4" color="#0F6DB7"><?php echo $total_rowStock_sq; ?></font>&nbsp;</td>
											<td class="sqty" align="right"><font size="4" color="#0F6DB7"><?php echo $total_DeadStock_halb_sq; ?></font>&nbsp;</td>
											<td class="sqtv" align="right"><font size="4" color="#0F6DB7"><?php echo $total_rowStock_sv; ?></font>&nbsp;</td>
											<td class="sqtv" align="right"><font size="4" color="#0F6DB7"><?php echo $total_DeadStock_halb_sv; ?></font>&nbsp;</td>
											<td class="sqtv" align="right"><font size="4" color="#0F6DB7">&nbsp;</font>&nbsp;</td>
											<td class="sqtv" align="right"><font size="4" color="#0F6DB7">&nbsp;</font>&nbsp;</td>
											<td class="sqty" align="right"><font size="4" color="#0F6DB7">&nbsp;</font>&nbsp;</td>
											<td class="sqty" align="right"><font size="4" color="#0F6DB7">&nbsp;</font>&nbsp;</td>
										</tr>
									</table>
								</td>
							</tr>			
						</table>
					</td>
						
	
				</tr>
			</table>
			</div>
			<!-- Third Tab End  -->

			<!-- Fourth Tab Start -->
			<div class="tab-pane fade in" id="tab4default">
				<div style="margin-left: -3%; font-size:12px">
				<iframe style="width: 90%; height:80vh " src="target_vs_achivement.php"></iframe>
				<?php
				// require_once('target_vs_achivement.php');
				?>
				</div>
			</div>
			<!-- Fourth Tab End -->
		
			<!-- </table> -->
				
		</div>
	</div>
			</div>
        </div>
		</div>
	</div>
<div>

<script>
    $(document).ready(function(){	
	
		Chart.defaults.global.defaultFontColor = '#404548';	
		Chart.defaults.global.defaultFontFamily = "'Roboto Condensed', sans-serif";	
	
		 var segAchievement = $("#segAchievement");

		 segAchievement.attr('height',100);
			var CR=<?php echo $totPercentAchievedCR; ?>;
			var BD=<?php echo $totPercentAchievedBD; ?>;
			var SR=<?php echo $totPercentAchievedSR; ?>;
			CR="CR "+CR+"%";
			BD="BD "+BD+"%";
			SR="SR "+SR+"%";
			var segdata = {
				labels: [
					CR,
					BD,
					SR
				],
				datasets: [
					
				
					
					{
						label: "Sales",
						data: [<?php echo round($salesTotCR/10000000,2) ?> , <?php echo round($salesTotBD/10000000,2) ?> ,<?php echo round($salesTotSR/10000000,2) ?> ],
						backgroundColor: 'rgba(37,135,190, 1)'
						
					},
					{
						label: "Target",
						data: [<?php echo round($targetTotCR/10000000,2) ?> , <?php echo round($targetTotBD/10000000,2) ?> ,<?php echo round($targetTotSR/10000000,2) ?> ],
					
						
						
						backgroundColor: 'rgba(173,209,226, 1)'
						
						
						
					}
					
					
					]
			};
			
			
		
		 new Chart(segAchievement, {
			type: 'horizontalBar',
			data: segdata,
			options: {
				scales: {
					 xAxes: [{
			
						ticks: {
							callback: function(label, index, labels) {
									return '';
								},
							beginAtZero: true,
							max: 110,
							
				
						}
					}],
					yAxes: [{
						stacked: true,
						barPercentage: 0.4
					}]
				},
				
				tooltips: {
								   enabled: false
							  }	
				,
				
				
			animation: {
            duration: 0,
            onComplete: function () {
                var chartInstance = this.chart,
                ctx = chartInstance.ctx;
				
                ctx.font = Chart.helpers.fontString(Chart.defaults.global.defaultFontSize, Chart.defaults.global.defaultFontStyle, Chart.defaults.global.defaultFontFamily);
                ctx.textAlign = 'left';
                ctx.textBaseline = 'bottom';

                this.data.datasets.forEach(function (dataset, i) {
                    var meta = chartInstance.controller.getDatasetMeta(i);
                    meta.data.forEach(function (bar, index) {
				//+'cr';
						
                        var data = dataset.data[index];                            
                        ctx.fillText(data, bar._model.x, bar._model.y );
                    });
                });
            }
        },	
				
				
			legend: { 
				//display: false
				
			}	

			}
		});
		
		var doughnutCenterText={
				  beforeDraw: function(chart) {
					var width = chart.chart.width,
						height = chart.chart.height,
						ctx = chart.chart.ctx;

					ctx.restore();
					var fontSize = (height /171).toFixed(2);
					ctx.font = fontSize + "em sans-serif";
					ctx.textBaseline = "middle";
					ctx.fillStyle = '#404548';

					var text = <?php echo $totPercentAchieved; ?>+"%",
						textX = Math.round((width - ctx.measureText(text).width) / 2),
						textY = height / 2;

					ctx.fillText(text, textX, textY);
					ctx.save();
				  }
				};		
		
		
		var config = {
					type: 'doughnut',
					data: {
						datasets: [{
							data: [
								<?php echo round(($salesTotPED/$targetTot)*100,2); ?>,
								<?php echo round(($salesTotPRA/$targetTot)*100,2); ?>,
								<?php echo round(($salesTotPNL/$targetTot)*100,2);  ?>,
								<?php echo round(($achieveNotTot/$targetTot)*100,2); ?>
								
					],
							backgroundColor: [
								'#0A236F',
								'#077B43',
								'#800000',
								'#EEEEEE'
							]
						}],
						labels: [
							'Pedrollo ',
							'Pragati',
							'PNL',	
							'Pending'
						] 
					},
					 plugins: [doughnutCenterText]
					,
					options: {
							 
							 cutoutPercentage: 80,
							 rotation: 3,
							 legend: {
								position: 'bottom', 
								labels: {
										filter: function(item, config) {

											return !item.text.includes('Pending');
										}
								
									}
            
								},
								
								tooltips: {
								  callbacks: {
									label: function(tooltipItem, data) {
									 
									
									 var dataset = data.datasets[tooltipItem.datasetIndex];
									
									  var currentValue = dataset.data[tooltipItem.index];
								       
								       
									  return currentValue + "%";
									},
									
									title: function(tooltipItem, data) {
										return data.labels[tooltipItem[0].index];
									  }
								  }
							  }	
						
				
						
						
					}
					
			
				};
				
				
				
				
				var ctxAchievement = $("#totAchievement");
				
								
				new Chart(ctxAchievement, config);
				
				
				



							
	var chartdata = {
                    labels: ['Pedrollo','Pragati','PNL'],
                    datasets : [              								
						
						
						{                          
							type: 'bar',
							backgroundColor: ['#0A236F','#077B43','#800000'],
							borderColor: 'rgba(200, 200, 200, 0.75)',
							hoverBorderColor: 'rgba(200, 200, 200, 1)',
                            data: [
                            <?php echo $totPercentAchievedPED; ?>,<?php echo $totPercentAchievedPRA; ?>,<?php echo $totPercentAchievedPNL; ?>
                            ]
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
				
			},
			
			tooltips: {
								  callbacks: {
									label: function(tooltipItem, data) {
									 
									
									 var dataset = data.datasets[tooltipItem.datasetIndex];
									
									  var currentValue = dataset.data[tooltipItem.index];
								       
								       
									  return currentValue + "%";
									},
									
									title: function(tooltipItem, data) {
										return data.labels[tooltipItem[0].index];
									  }
								  }
							  }
		}
	});
		
				
				
	
	//PedrolloCGS
	
		var cgsdata = {
                    labels: [
						
						[['COGS',' OpCost'],<?php echo $ACGS[0][0]; ?>],[['COGS',' OpCost'],<?php echo $ACGS[1][0]; ?>],[['COGS',' OpCost'],<?php echo $ACGS[2][0]; ?>]
						
                    ],
                    datasets : [              								
						
						
						{                       
							label: 'COGS',
							type: 'bar',
							backgroundColor: ['#0A236F','#0A236F','#0A236F'],

                            data: [<?php echo $ACGS[0][1]; ?> ,<?php echo $ACGS[1][1]; ?> ,<?php echo $ACGS[2][1]; ?>  ]
                        },
                        
                        
                        {                       
							label: 'OpCost',
							type: 'bar',
							backgroundColor: ['#0A236F','#0A236F','#0A236F'],

                            data: [<?php echo $ACGS[0][2]; ?> ,<?php echo $ACGS[1][2]; ?>,<?php echo $ACGS[2][2]; ?>   ]
                        }
						
		
								
						
                    ]
               
				};
				
	
							
	
		
				

	var ctxpedCGS = $("#pedCGS");
	
	
	
	new Chart(ctxpedCGS, {
		type: 'bar',
		data: cgsdata,
		options: {
			scales: {
				yAxes: [{
						   ticks: {
								callback: function(label, index, labels) {
									return '';
								},
							
									min: 0,
									max: 100,
									stepSize: 10
							}
	
						}]
			},
			 legend: { display: false
				
			},
			
			 tooltips: {
			   enabled: false
			  
		   },
		   
		   
		   
		   
		 animation: {
            duration: 0,
            onComplete: function () {
                var chartInstance = this.chart,
                ctx = chartInstance.ctx;
				
                ctx.font = Chart.helpers.fontString(Chart.defaults.global.defaultFontSize, Chart.defaults.global.defaultFontStyle, Chart.defaults.global.defaultFontFamily);
                ctx.textAlign = 'center';
                ctx.textBaseline = 'bottom';

                this.data.datasets.forEach(function (dataset, i) {
                    var meta = chartInstance.controller.getDatasetMeta(i);
                    meta.data.forEach(function (bar, index) {
                        var data = dataset.data[index]+'%';                            
                        ctx.fillText(data, bar._model.x, bar._model.y - 5);
                    });
                });
            }
        }
			
			
			
		}
	});
		
	
				
				
				
				
				
				
	//Pragati CGS
	
		var cgsPradata = {
                    labels: [
						
						[['COGS',' OpCost'],<?php echo $ACGS[0][0]; ?>],[['COGS',' OpCost'],<?php echo $ACGS[1][0]; ?>],[['COGS',' OpCost'],<?php echo $ACGS[2][0]; ?>]
						
                    ],
                    datasets : [              								
						
						
						{                       
							label: 'COGS',
							type: 'bar',
							backgroundColor: ['#077B43','#077B43','#077B43'],

                            data: [<?php echo $ACGS[0][3]; ?> ,<?php echo $ACGS[1][3]; ?> ,<?php echo $ACGS[2][3]; ?>  ]
                        },
                        
                        
                        {                       
							label: 'OpCost',
							type: 'bar',
							backgroundColor: ['#077B43','#077B43','#077B43'],

                            data: [<?php echo $ACGS[0][4]; ?> ,<?php echo $ACGS[1][4]; ?>,<?php echo $ACGS[2][4]; ?>   ]
                        }
						
		
								
						
                    ]
               
				};
				
	
							
	
		
				

	var ctxpraCGS = $("#praCGS");
	
	
	
	new Chart(ctxpraCGS, {
		type: 'bar',
		data: cgsPradata,
		options: {
			scales: {
				yAxes: [{
						   ticks: {
								callback: function(label, index, labels) {
									return '';
								},
							
									min: 0,
									max: 100,
									stepSize: 10
							}
	
						}]
			},
			 legend: { display: false
				
			},
			
			 tooltips: {
			   enabled: false
			  
		   },
		   
		   
		   
		   
		 animation: {
            duration: 0,
            onComplete: function () {
                var chartInstance = this.chart,
                ctx = chartInstance.ctx;
				
                ctx.font = Chart.helpers.fontString(Chart.defaults.global.defaultFontSize, Chart.defaults.global.defaultFontStyle, Chart.defaults.global.defaultFontFamily);
                ctx.textAlign = 'center';
                ctx.textBaseline = 'bottom';

                this.data.datasets.forEach(function (dataset, i) {
                    var meta = chartInstance.controller.getDatasetMeta(i);
                    meta.data.forEach(function (bar, index) {
                        var data = dataset.data[index]+'%';                            
                        ctx.fillText(data, bar._model.x, bar._model.y - 5);
                    });
                });
            }
        }
			
			
			
		}
	});			
				
				
				
				
				
				
	
	
	
	
	
	//PNL CGS
	
		var cgsPnldata = {
                    labels: [
						
						[['COGS',' OpCost'],<?php echo $ACGS[0][0]; ?>],[['COGS',' OpCost'],<?php echo $ACGS[1][0]; ?>],[['COGS',' OpCost'],<?php echo $ACGS[2][0]; ?>]
						
                    ],
                    datasets : [              								
						
						
						{                       
							label: 'COGS',
							type: 'bar',
							backgroundColor: ['#800000','#800000','#800000'],

                            data: [<?php echo $ACGS[0][5]; ?> ,<?php echo $ACGS[1][5]; ?> ,<?php echo $ACGS[2][5]; ?>  ]
                        },
                        
                        
                        {                       
							label: 'OpCost',
							type: 'bar',
							backgroundColor: ['#800000','#800000','#800000'],

                            data: [<?php echo $ACGS[0][6]; ?> ,<?php echo $ACGS[1][6]; ?>,<?php echo $ACGS[2][6]; ?>   ]
                        }
						
		
								
						
                    ]
               
				};
				
	
							
	
		
				

	var ctxpnlCGS = $("#pnlCGS");
	
	
	
	new Chart(ctxpnlCGS, {
		type: 'bar',
		data: cgsPnldata,
		options: {
			scales: {
				yAxes: [{
						   ticks: {
								callback: function(label, index, labels) {
									return '';
								},
							
									min: 0,
									max: 100,
									stepSize: 10
							}
	
						}]
			},
			 legend: { display: false
				
			},
			
			 tooltips: {
			   enabled: false
			  
		   },
		   
		   
		   
		   
		 animation: {
            duration: 0,
            onComplete: function () {
                var chartInstance = this.chart,
                ctx = chartInstance.ctx;
				
                ctx.font = Chart.helpers.fontString(Chart.defaults.global.defaultFontSize, Chart.defaults.global.defaultFontStyle, Chart.defaults.global.defaultFontFamily);
                ctx.textAlign = 'center';
                ctx.textBaseline = 'bottom';

                this.data.datasets.forEach(function (dataset, i) {
                    var meta = chartInstance.controller.getDatasetMeta(i);
                    meta.data.forEach(function (bar, index) {
                        var data = dataset.data[index]+'%';                            
                        ctx.fillText(data, bar._model.x, bar._model.y - 5);
                    });
                });
            }
        }
			
			
			
		}
	});			
						
				
				
				
				
		
		
		
	//Overall CGS
	
		var cgsOvdata = {
                    labels: [
						
						[['COGS',' OpCost'],<?php echo $ACGS[0][0]; ?>],[['COGS',' OpCost'],<?php echo $ACGS[1][0]; ?>],[['COGS',' OpCost'],<?php echo $ACGS[2][0]; ?>]
						
                    ],
                    datasets : [              								
						
						
						{                       
							label: 'COGS',
							type: 'bar',
							backgroundColor: ['#9b0c68','#9b0c68','#9b0c68'],

                            data: [<?php echo $ACGS[0][7]; ?> ,<?php echo $ACGS[1][7]; ?> ,<?php echo $ACGS[2][7]; ?>  ]
                        },
                        
                        
                        {                       
							label: 'OpCost',
							type: 'bar',
							backgroundColor: ['#9b0c68','#9b0c68','#9b0c68'],

                            data: [<?php echo $ACGS[0][8]; ?> ,<?php echo $ACGS[1][8]; ?>,<?php echo $ACGS[2][8]; ?>   ]
                        }
						
		
								
						
                    ]
               
				};
				
	
							
	
		
				

	var ctxovCGS = $("#ovCGS");
	
	
	
	new Chart(ctxovCGS, {
		type: 'bar',
		data: cgsOvdata,
		options: {
			scales: {
				yAxes: [{
						   ticks: {
								callback: function(label, index, labels) {
									return '';
								},
							
									min: 0,
									max: 100,
									stepSize: 10
							}
	
						}]
			},
			 legend: { display: false
				
			},
			
			 tooltips: {
			   enabled: false
			  
		   },
		   
		   
		   
		   
		 animation: {
            duration: 0,
            onComplete: function () {
                var chartInstance = this.chart,
                ctx = chartInstance.ctx;
				
                ctx.font = Chart.helpers.fontString(Chart.defaults.global.defaultFontSize, Chart.defaults.global.defaultFontStyle, Chart.defaults.global.defaultFontFamily);
                ctx.textAlign = 'center';
                ctx.textBaseline = 'bottom';

                this.data.datasets.forEach(function (dataset, i) {
                    var meta = chartInstance.controller.getDatasetMeta(i);
                    meta.data.forEach(function (bar, index) {
                        var data = dataset.data[index]+'%';                            
                        ctx.fillText(data, bar._model.x, bar._model.y - 5);
                    });
                });
            }
        }
			
			
			
		}
	});			
						
			
		
		
		
		
		
		
		
		
		
				



	var chartdata2 = {
                    labels: ['Pedrollo','Pragati','PNL'],
                    datasets : [              								
						
						
						{                       
							type: 'bar',
							backgroundColor: ['#1C2BF1','#8F9326','#2BB800'],
							borderColor: 'rgba(200, 200, 200, 0.75)',
							hoverBorderColor: 'rgba(200, 200, 200, 1)',
                            data: [<?php echo $diffSalesPED; ?>,<?php echo $diffSalesPRA; ?>,<?php echo $diffSalesPNL; ?>]
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
				
				
				
				
				
				
				

		$( 'input[name="giwv"]:radio' ).change(function(){
			
			//$( "#btchart" ).empty();
			//$( "#btchart" ).append("<h1>Loading.......<\/h1>");
			var baseUrl = document.location.origin;
			var rootUrl = baseUrl+'\/bi\/';
			//alert(rootUrl);
			var giwv = $("input[name='giwv']:checked").val(); 
			//alert(giwv);
			$( "#giw" ).empty();
			$( "#giw" ).append('<img src="pic/loading.gif" id="giwl" />');
			
			var iframe= '<iframe scrolling="no" style="border: 0; width: 100%; height: 280px;" src="'+rootUrl+'giw.php?giwv='+giwv+'&csdate=<?php echo $csdate; ?>&cedate=<?php echo $cedate; ?>&osdate=<?php echo $osdate; ?>&oedate=<?php echo $oedate; ?>" ></iframe>';
			//alert(iframe);
			//$( "#giw" ).empty();
			
			
			$( "#giw" ).append(iframe);
			$('#giw iframe').load(function() { $( "#giwl" ).remove();});
	
		}); 
		
		
		
		$( 'input[name="sqtm"]:radio' ).change(function(){
			
		
			var sqtm = $("input[name='sqtm']:checked").val(); 

			if(sqtm==1)
			{
				   $('.sqty').show();
				   $('.sqtv').hide();
			
		    }else{
				
				$('.sqtv').show();
				$('.sqty').hide();
			}		
			
	
		}); 
		$('.sqtv').hide();
		
		
		
		
		$( 'input[name="product"]:radio' ).change(function(){
			
		
			var product = $("input[name='product']:checked").val(); 

			if(product==1)
			{
				   $('.water').show();
				   $('.other').hide();
				   $('.All').hide();
			
		    }
			else if(product==2)
			{
				$('.water').hide();
				$('.other').show();
				$('.All').hide();
			}
			else
			{
				
				$('.water').hide();
				$('.other').hide();
				$('.All').show();
			}			
	
		}); 
		$('.other').hide();
		$('.All').hide();
		
		
		$( '#aywcid' ).click(function(){
		window.open('loader.php','popup','width=600,height=300,scrollbars=no,resizable=no');
	
		//window.open('ocryear.php','popup','width=600,height=300,scrollbars=no,resizable=no');
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
<script>
	function tab4(){
		var curr_year = new Date().getFullYear();
		document.getElementById('year').value = curr_year;
		var curr_month = new Date().getMonth();
		if(curr_month >= 0 && curr_month <= 2){
			document.getElementsByName('quater[]')[2].checked = true;
		}else if(curr_month >= 3 && curr_month <= 5){
			document.getElementsByName('quater[]')[3].checked = true;
		}else if(curr_month >= 6 && curr_month <= 8){
			document.getElementsByName('quater[]')[0].checked = true;
		}else if(curr_month >= 9 && curr_month <= 11){
			document.getElementsByName('quater[]')[1].checked = true;
		}
		
		// document.getElementById('sub').click();
		// window.onbeforeunload = null;
	}
	window.onload = tab4;
</script>