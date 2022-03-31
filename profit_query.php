<?php
include_once("db.php"); 

$id=$_GET['id'];

$str=
"
select iyear,imonth,
round((prd_price/sell_price)*100,2) as cogs
 from 
((select sum(sell_price-prd_price) as pnet,sum(sell_price) as sell_price,sum(prd_price) as prd_price,
product_division.division,product_division.id,year(profit_date) as iyear,MONTHNAME(profit_date) as imonth,
month(profit_date) as mn

from profit
inner join product_division on product_division.id=profit.division
where product_division.id = $id and
TIMESTAMPDIFF(MONTH, profit_date, now())<13
group by year(profit_date), month(profit_date) ,profit.division)
) as det group by iyear,mn 
";


$sql=mysqli_query( $GLOBALS['con'] ,$str );


$jsonData = array();
while ($array = mysqli_fetch_row($sql)) {
    $jsonData[] = $array;
}
echo json_encode($jsonData);


?>