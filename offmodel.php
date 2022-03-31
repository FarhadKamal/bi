<?php

include_once("db.php");


?>

<?php


if($_GET['call']==1) entry();
else if($_GET['call']==2) list_offer();
else if($_GET['call']==3) entryDetails();
else if($_GET['call']==4) list_mat();
else if($_GET['call']==5) del_mat();
else if($_GET['call']==6) del_offer();

else if($_GET['call']==7) list_offer_details();


function list_offer_details()
	{
		$oid=0;	
		
		
		if(isset($_POST['olist']))
		{
			$oid=$_POST['olist'];
			if($oid=="")
				$oid=0;
		}
		
		
		$hsql=mysqli_query($GLOBALS['con'], "select * from offer_master where id=".$oid);
		
		
		$result=mysqli_fetch_object($hsql);
		if (!$result)return false;
	
		print("Start Date: ".$result->start_date."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		End Date: ".$result->end_date);
		


		$sql=mysqli_query($GLOBALS['con'], "select 
id,offer_id,mat_id,lower_bound,upper_bound,discount,MAKTX,start_date,end_date,round(totSales,0) as totSales
from 

(select offer_details.id,offer_id,lower_bound,upper_bound,discount,start_date,end_date,mat_id
from  offer_details	
inner join offer_master on offer_master.id=offer_details.offer_id where offer_id=$oid group by mat_id
) det
inner join material_data on material_data.MATNR=det.mat_id
left join 
(select MATNR,sum(FKIMG) as totSales from  sap_sales_process where  FKDAT>='".$result->start_date."' and FKDAT<='".$result->end_date."'and CTAG='CR' group by  MATNR )
 det2 on det.mat_id=det2.MATNR
");
		 
		 print "<table class='table table-striped'>";
			
		 
		 $sl=0;
		 $total = 0;
		 while($row=mysqli_fetch_object($sql)){
			$total = $total + $row->totSales;
			$sl++;
			print "<tr>";
			print '<td>'.$sl.'</td>';
			print '<td>'.$row->MAKTX.'</td>';
		
			print '<td>'.$row->totSales.'</td>';
			print "</tr>";
		}
		
		
		
		if($sl>0){
			print("<thead>");
			print "<tr>";
			print '<th>SL</th>';
			print '<th>Material Name</th>';

			print '<th>Total Quantity Sales</th>';
			print "</tr>";
			print("</thead>");
		}
		 print "<tfoot><tr><td colspan='2'>Total</td><td>".$total."</td></tr></tfoot>";
		 
		 print "</table>";
		
		
	}

function entry()
{
	$offer=$_POST['offer'];
	$sdate=$_POST['sdate'];
	$edate=$_POST['edate'];
	$user=$_SESSION['user_code'];
	
	$sql=mysqli_query($GLOBALS['con'],"select count(offer_name) as tot from offer_master where
		offer_name='$offer' and created_date=date(now())");
	
	$result=mysqli_fetch_object($sql);	
	if($result->tot>0) print '<p class="alert alert-danger">Already Created!</p>';
	else if($sdate>$edate)  print '<p class="alert alert-danger">Start Date cannot be greater than End Date!</p>';
	else{
		mysqli_query($GLOBALS['con'],"insert into bi.offer_master 
		(
		offer_name, 
		start_date, 
		end_date, 
		created_by,
		created_date
		)
		values
		( 
		'$offer', 
		'$sdate', 
		'$edate', 
		'$user',
		date(now())
		)");
		
		
		print '<p class="alert alert-success">Offer Created Successfully!</p>';
	}
}



function entryDetails()
{


	$offer_id=$_POST['olist'];
	$mat_id=$_POST['matno'];
	$discount=$_POST['discount'];
	$lower_bound=$_POST['lwb'];
	$upper_bound=$_POST['upb'];
	$dtype=$_POST['dtype'];
	
	

	if(!is_numeric($lower_bound))
	{
			print '<p class="alert alert-warning">Lower Bound must be an numeric</p>';
			return false;
	}	
	if(!is_numeric($upper_bound))
	{
			print '<p class="alert alert-warning">Upper Bound must be an numeric</p>';
			return false;
	}
	if($lower_bound>$upper_bound)
	{
			print '<p class="alert alert-warning">Lower Bound cannot be greater than Upper Bound</p>';
			return false;
	}
	if(!is_numeric($upper_bound))
	{
			print '<p class="alert alert-warning">Upper Bound must be an numeric</p>';
			return false;
	}


	if(!is_numeric($discount))
	{
			print '<p class="alert alert-warning">Discount must be an numeric</p>';
			return false;
	}		
	
	
	$sql=mysqli_query($GLOBALS['con'],"select MAKTX from material_data where MATNR=".$mat_id);
	$result=mysqli_fetch_object($sql);


		mysqli_query($GLOBALS['con'],"delete from offer_details where offer_id= ".$offer_id." and mat_id=".$mat_id." and lower_bound=".$lower_bound." and upper_bound=".$upper_bound);
		mysqli_query($GLOBALS['con'],"insert into bi.offer_details 
		(
		offer_id, 
		mat_id, 
		discount, 
		lower_bound,
		upper_bound,
		dtype

		)
		values
		( 
		'$offer_id', 
		'$mat_id', 
		'$discount', 
		'$lower_bound',
		'$upper_bound',
		'$dtype'

		)");
		
		
		print '<p class="alert alert-success">Discount added for '.$result->MAKTX.'</p>';
}


	function list_offer()
	{
			

		$sql=mysqli_query($GLOBALS['con'],"select id,offer_name from offer_master where end_date>=date(now())
		 order by id desc");
		
		while($row=mysqli_fetch_object($sql)){
			print '<option value="'.$row->id.'">'.$row->offer_name.'</option>';
		}
	}
	
	
	function list_mat()
	{
		$oid=0;	
		
		
		if(isset($_POST['olist']))
		{
			$oid=$_POST['olist'];
			if($oid=="")
				$oid=0;
		}
		
		
		

		$sql=mysqli_query($GLOBALS['con'], "select offer_details.id,offer_id,mat_id,lower_bound,upper_bound,dtype,discount,material_data.MAKTX from offer_details
		inner join material_data on material_data.MATNR= offer_details.mat_id
		 where offer_id=".$oid);
		 
		 print "<table class='table table-striped'>";
			
		 
		 $sl=0;
		 while($row=mysqli_fetch_object($sql)){
			 
			$link="<font color='FF0000'><input type='button'  value='X' onclick='$.removeItem(\"".$row->id."\")' ></font>"; 
			$sl++;
			print "<tr>";
			print '<td>'.$sl.'</td>';
			print '<td>'.$row->MAKTX.'</td>';
			print '<td>'.$row->lower_bound.'</td>';
			print '<td>'.$row->upper_bound.'</td>';
			print '<td>'.$row->discount.'</td>';
			print '<td>'.$row->dtype.'</td>';
			print '<td>'.$link.'</td>';
			print "</tr>";
		}
		
		
		
		if($sl>0){
			print("<thead>");
			print "<tr>";
			print '<th>SL</th>';
			print '<th>Material Name</th>';
			print '<th>Lower Bound</th>';
			print '<th>Upper Bound</th>';
			print '<th>Discount</th>';
			print '<th>Type</th>';
			print '<th>Delete</th>';
			print "</tr>";
			print("</thead>");
		}
		 print "</table>";
		
		
	
	}



	function del_mat()
	{
		$id=$_POST['id'];	

		mysqli_query($GLOBALS['con'],"delete from offer_details where id=".$id);
		
		print('<p class="alert alert-warning">Item Removed!</p>');
		
		
	}
	
	
	function del_offer()
	{
		$id=$_POST['id'];	

		mysqli_query($GLOBALS['con'],"delete from offer_master where id=".$id);
		
		mysqli_query($GLOBALS['con'],"delete from offer_details where offer_id=".$id);
		
		print('<p class="alert alert-warning">Offer Removed!</p>');
		
		
	}
	



?>
