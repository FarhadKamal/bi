<?php

include_once("db.php");


?>

<?php


if($_GET['call']==1) svc_list();



	
	function svc_list()
	{
		$data1=$_POST['data1'];	

		$todsql=mysqli_query($GLOBALS['oms'],"select 
		count(*) as tot from batch_registered where date(created_date)=date(now())");
		
		$todres=mysqli_fetch_object($todsql);
		
		
		$monsql=mysqli_query($GLOBALS['oms'],"select 
		count(*) as tot from batch_registered where month(created_date)=month(now()) and year(created_date)=year(now())");
		
		$monres=mysqli_fetch_object($monsql);
		
		
		$totsql=mysqli_query($GLOBALS['oms'],"select 
		count(*) as tot from batch_registered ");
		
		$totres=mysqli_fetch_object($totsql);
		
		
		
		
		
	

		
		
		
		
		
		//print('<p class="alert alert-warning">Offer Removed!</p>');
		
		
		print "<table class='table table-striped'>";
		
			print("<thead>");
			print "<tr>";
				print '<th>Total</th>';
				print '<th>Today</th>';
				print '<th>Current month</th>';
			print "</tr>";
			print("</thead>");
		
			print("<tr>");
			
			
				print("<td>");
					print("<table class='table table-striped'>");
					
						print("<thead>");
						print "<tr>";
							print '<th>Registered</th>';
							print '<th><a href="warranty_sort.php?stat=1" target="_blank">'.$totres->tot.'</a></th>';
						print "</tr>";
						print("</thead>");
					
				
						
					print("</table>");
				print("</td>");
			
			
			
				print("<td>");
					print("<table class='table table-striped'>");
					
						print("<thead>");
						print "<tr>";
							print '<th>Registered</th>';
							print '<th><a href="warranty_sort.php?stat=2" target="_blank">'.$todres->tot.'</a></th>';
						print "</tr>";
						print("</thead>");
					
				
						
					print("</table>");
				print("</td>");
				
				
				print("<td>");
					print("<table class='table table-striped'>");
					
						print("<thead>");
						print "<tr>";
							print '<th>Registered</th>';
							print '<th><a href="warranty_sort.php?stat=3" target="_blank">'.$monres->tot.'</a></th>';
						print "</tr>";
						print("</thead>");
					
				
						
					print("</table>");
				print("</td>");
				
				
				;
			print("</tr>");
			
			
			
			
			
			
		print "</table>";
	
		
		
	}
	



?>
