<?php

include_once("db.php");


?>

<?php


if($_GET['call']==1) svc_list();



	
	function svc_list()
	{
		$sdate=$_POST['sdate'];	

		$iwsql=mysqli_query($GLOBALS['svc'],"select 
		sum(if(date(s.WarrentyDate)>=date(now()),1,0  )) as wyes, 
		sum(if(date(s.WarrentyDate)<date(now()),1,0  )) as wno, 
		count(*) as totw 
		from complainmaster cm  
		inner join saledproduct s on s.CustomerId=cm.CustomerId
		where date(cm.ComplainDate)='$sdate' and cm.Cancel=0");
		
		$iwres=mysqli_fetch_object($iwsql);
		
		$idwsql=mysqli_query($GLOBALS['svc'],"select sum(if(ServiceChargeAcc<>'Client',1,0)) as wyes, 
		 sum(if(ServiceChargeAcc='Client',1,0)) as wno, 
		count(*) as totw ,sum(TIMESTAMPDIFF(MINUTE,ComplainDate,DeliveryDate) between 0 and 30) as d30
		,sum(TIMESTAMPDIFF(MINUTE,ComplainDate,DeliveryDate) between 31 and 120) as d120
		,sum(TIMESTAMPDIFF(MINUTE,ComplainDate,DeliveryDate) between 121 and 720) as d720
		,sum(TIMESTAMPDIFF(MINUTE,ComplainDate,DeliveryDate) between 721 and 1440) as d1440
		,sum(TIMESTAMPDIFF(MINUTE,ComplainDate,DeliveryDate)>1440) as dover
		from servicebillmaster
		inner join complainmaster on complainmaster.JobReference=servicebillmaster.JobReference
		where date(DeliveryDate)='$sdate'");
		
		$idwres=mysqli_fetch_object($idwsql);
		
		
		$owsql=mysqli_query($GLOBALS['call'],"	select 
		sum(if(ost_product_type.name='Warrenty',1,0  )) as wyes, 
		sum(if(ost_product_type.name='Out of warrenty',1,0  )) as wno, 	
		count(*) as totw	
		from ost_ticket 
		inner join ost_product_info on ost_product_info.id=product_info_id
		inner join ost_ticket_indoor on ost_ticket_indoor.ticket_id=ost_ticket.ticket_id
		inner join ost_product_type on ost_product_type.id=ost_product_info.product_type_id
		where date(ost_ticket.created)='$sdate'    and indoor_staus=0");
		
		$owres=mysqli_fetch_object($owsql);
		
		
		
		$ocwsql=mysqli_query($GLOBALS['call'],"select 

	ticketID,round(avg(TIMESTAMPDIFF(MINUTE,ost_ticket.created,ost_ticket.closed))/60,2) as slvh,	
	sum(if(ost_product_type.name='Warrenty',1,0  )) as wyes, 
sum(if(ost_product_type.name='Out of warrenty',1,0  )) as wno ,
count(*) as totw,sum(TIMESTAMPDIFF(MINUTE,ost_ticket.created,ost_ticket.closed) between 0 and 120) as d120
		,sum(TIMESTAMPDIFF(MINUTE,ost_ticket.created,ost_ticket.closed) between 121 and 720) as d720
		,sum(TIMESTAMPDIFF(MINUTE,ost_ticket.created,ost_ticket.closed) between 721 and 1440) as d1440
		,sum(TIMESTAMPDIFF(MINUTE,ost_ticket.created,ost_ticket.closed) between 1441 and 2880) as d2880
		
		
		,sum(TIMESTAMPDIFF(MINUTE,ost_ticket.created,ost_ticket.closed)>2880) as dover
		from ost_ticket 
		inner join ost_product_info on ost_product_info.id=product_info_id
		inner join ost_ticket_indoor on ost_ticket_indoor.ticket_id=ost_ticket.ticket_id
		inner join ost_product_type on ost_product_type.id=ost_product_info.product_type_id
		where date(ost_ticket.closed)='$sdate'    and indoor_staus=0 and ost_ticket.status='closed'");
		
		$ocwres=mysqli_fetch_object($ocwsql);
		
		
		
		
	

		
		
		
		
		
		//print('<p class="alert alert-warning">Offer Removed!</p>');
		
		
		print "<table class='table table-striped'>";
		
			print("<thead>");
			print "<tr>";
				print '<th>Indoor (Service Soft)</th>';
				print '<th>Outdoor (Ticketing System)</th>';
			print "</tr>";
			print("</thead>");
		
			print("<tr>");
				print("<td>");
					print("<table class='table table-striped'>");
					
						print("<thead>");
						print "<tr>";
							print '<th>Total Complain</th>';
							print '<th>'.$iwres->totw.'</th>';
						print "</tr>";
						print("</thead>");
					
					
						print("<tr>");
							print("<td>");
								print "under Warranty:";
							print("</td>");
							print("<td>");
								print $iwres->wyes;
							print("</td>");
						print("</tr>");
						print("<tr>");
							print("<td>");
								print "non Warranty:";
							print("</td>");
							print("<td>");
								print $iwres->wno;
							print("</td>");
						print("</tr>");
					print("</table>");
				print("</td>");
				
				
				print("<td>");
					print("<table class='table table-striped'>");
					
						print("<thead>");
						print "<tr>";
							print '<th>Total Complain</th>';
							print '<th>'.$owres->totw.'</th>';
						print "</tr>";
						print("</thead>");
					
					
						print("<tr>");
							print("<td>");
								print "under Warranty:";
							print("</td>");
							print("<td>");
								print $owres->wyes;
							print("</td>");
						print("</tr>");
						print("<tr>");
							print("<td>");
								print "non Warranty:";
							print("</td>");
							print("<td>");
								print $owres->wno;
							print("</td>");
						print("</tr>");
					print("</table>");
				print("</td>");
			print("</tr>");
			
			
			
			print("<tr>");
				print("<td>");
					print("<table class='table table-striped'>");
					
						print("<thead>");
						print "<tr>";
							print '<th>Total Delivered</th>';
							print '<th>'.$idwres->totw.'</th>';
						print "</tr>";
						print("</thead>");
					
					
						print("<tr>");
							print("<td>");
								print "under Warranty:";
							print("</td>");
							print("<td>");
								print $idwres->wyes;
							print("</td>");
						print("</tr>");
						print("<tr>");
							print("<td>");
								print "non Warranty:";
							print("</td>");
							print("<td>");
								print $idwres->wno;
							print("</td>");
						print("</tr>");
						
						
					print("</table>");
					print("<table class='table table-striped'>");
						
						print("<thead>");
						print "<tr>";
							print '<th colspan=2>Delivery time breakdown</th>';
						print "</tr>";
						print("</thead>");
					
						print("<tr>");
							print("<td>");
								print "less than 30 min:";
							print("</td>");
							print("<td>");
								print $idwres->d30;
							print("</td>");
						print("</tr>");
						
						print("<tr>");
							print("<td>");
								print "within 30 min to 2 hrs:";
							print("</td>");
							print("<td>");
								print $idwres->d120;
							print("</td>");
						print("</tr>");
						
						print("<tr>");
							print("<td>");
								print "within 2 hrs to 12 hrs:";
							print("</td>");
							print("<td>");
								print $idwres->d720;
							print("</td>");
						print("</tr>");
						
						print("<tr>");
							print("<td>");
								print "within 12 hrs to 24 hrs:";
							print("</td>");
							print("<td>");
								print $idwres->d1440;
							print("</td>");
						print("</tr>");
						
						print("<tr>");
							print("<td>");
								print "over 24 hrs:";
							print("</td>");
							print("<td>");
								print $idwres->dover;
							print("</td>");
						print("</tr>");
						
					print("</table>");
				print("</td>");
				
				
				
				
				
				
				print("<td>");
					print("<table class='table table-striped'>");
					
						print("<thead>");
						print "<tr>";
							print '<th>Total Closed</th>';
							print '<th>'.$ocwres->totw.'</th>';
						print "</tr>";
						print("</thead>");
					
					
						print("<tr>");
							print("<td>");
								print "under Warranty:";
							print("</td>");
							print("<td>");
								print $ocwres->wyes;
							print("</td>");
						print("</tr>");
						print("<tr>");
							print("<td>");
								print "non Warranty:";
							print("</td>");
							print("<td>");
								print $ocwres->wno;
							print("</td>");
						print("</tr>");
						
						//print("<tr>");
							//print("<td>");
								//print "average closing hrs.:";
							//print("</td>");
							//print("<td>");
							//	print $ocwres->slvh;
							//print("</td>");
						//print("</tr>");
						
					
					
					print("</table>");
					
					print("<table class='table table-striped'>");
						
						print("<thead>");
						print "<tr>";
							print '<th colspan=2>Closing time breakdown</th>';
						print "</tr>";
						print("</thead>");
					
						print("<tr>");
							print("<td>");
								print "less than 2 hrs:";
							print("</td>");
							print("<td>");
								print $ocwres->d120;
							print("</td>");
						print("</tr>");
						
						print("<tr>");
							print("<td>");
								print "within 2 hrs to 12 hrs:";
							print("</td>");
							print("<td>");
								print $ocwres->d720;
							print("</td>");
						print("</tr>");
						
						print("<tr>");
							print("<td>");
								print "within 12 hrs to 24 hrs:";
							print("</td>");
							print("<td>");
								print $ocwres->d1440;
							print("</td>");
						print("</tr>");
						
						print("<tr>");
							print("<td>");
								print "within 24 hrs to 48 hrs:";
							print("</td>");
							print("<td>");
								print $ocwres->d2880;
							print("</td>");
						print("</tr>");
						
						
						print("<tr>");
							print("<td>");
								print "over 48 hrs:";
							print("</td>");
							print("<td>");
								print $ocwres->dover;
							print("</td>");
						print("</tr>");
					print("</table>");
					
					
				print("</td>");
			print("</tr>");
			
			
		print "</table>";
	
		
		
	}
	



?>
