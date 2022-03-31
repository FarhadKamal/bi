<?php

include_once("db.php");

if (isset($_GET['logout'])) {

	session_destroy();

	if ($_GET['logout'] == "yes")
		header("Location: index.php?msg=logout");
	else if ($_GET['logout'] == "fail")
		header("Location: index.php?msg=failLog");
	else if ($_GET['logout'] == "relog")
		header("Location: login.php?msg=relog");
}




?>
<?php
if (isset($_SESSION['logged'])) {
?>
	<!DOCTYPE html>
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
		
		
		<link rel="stylesheet" href="script/flexselect.css" type="text/css" media="screen" />
		<script src="script/liquidmetal.js" type="text/javascript"></script>
		<script src="script/jquery.flexselect.js" type="text/javascript"></script>


	</head>

	<body>
		<?php
		include_once("sidebar.php");
		?>
		<div class="container">
			<div class="row"><br />
				<div class="col-md-12">
					<div id="msg"></div>
					
					<table class="table table-striped">
				
						<tr>
							<td><label>Offer Name</label></td><td><input type="text" id="offer" size="50" /></td>
							<td rowspan=3 align="center"><input type="button" value="Create" id="create"></td>
						</tr>
						<tr>
							<td><label>Start Date</label></td><td><input type="date" id="sdate" value="<?php echo date('Y-m-d');?>"></td>
						</tr>
						<tr>
							<td><label>End Date</label></td><td><input type="date" id="edate" value="<?php echo date('Y-m-d');?>" ></td>
						</tr>
						
				
					</table>
					<br/><br/>
					<div id="msgbox"></div>
					<table class="table table-striped">
				
						<tr>
							<td><label>Offer&nbsp;List</label></td><td><select id="olist" ></select></td>
							
							<td><font color='FF0000'><input type='button'  value='X' onclick='$.removeOffer()' ></font></td>
						
						</tr>
						<tr>
							<td><label>Material:</label></td>
							<td>
							<select id="matno" style="width: 300px;" class="flexselect" >
								<?php $sql=mysqli_query($GLOBALS['con'],
								"select MATNR,MAKTX from  material_data where MTART='HAWA' and SPART in(20,30,50,60)");
						
								while($row=mysqli_fetch_object($sql)){
									echo '<option value="'.$row->MATNR.'">'.$row->MAKTX.' - '.$row->MATNR.'</option>';
								}?>
							</select>
							</td>
							
							<td><label>Discount&nbsp;Amt.</label></td>
							<td><input type="text" id="discount" value="" size="5" /></td>
							
							<td><label>Type</label></td>
							<td>
								<select id="dtype">
									<option value="Value">Value</option>
									<option value="Percentage">Percentage</option>
								</select>
							</td>
							
							
									
							
							<td><label>L.&nbsp;Bound</label></td>
							<td><input type="text" id="lwb" value="1" size="2" /></td>
							
							<td><label>U.&nbsp;Bound</label></td>
							<td><input type="text" id="upb" value="1" size="2" /></td>
							<td  align="center"><input type="button" value="add" id="add"></td>
						</tr>
						
						
				
					</table>
					
					<div id="itembox"></div>
					<div id="matList">
					
					</div>
						
						

				</div>
			</div>
		</div>



		<!-- Custom Script -->
		<script>
			$(document).ready(function() {
					
					$("select.flexselect").flexselect();
					orderList();
					
					$( '#create' ).click(function(){
						
							var offer = $("#offer").val(); 
							var sdate = $("#sdate").val(); 
							var edate = $("#edate").val(); 
							
							//alert(sdate);
							
							
							if(offer.length==0)
							{
								
								$( "#msg" ).empty();			
								$( "#msg" ).append('<p class="alert alert-warning">Please input Offer Name!</p>');
							}
							else if(offer.length<4)
							{
								$( "#msg" ).empty();			
								$( "#msg" ).append('<p class="alert alert-warning">Offer Name length must be greater than 3!</p>');
							}

							else{
								$.post('offmodel.php?call=1', {
									'offer': offer,
									'sdate': sdate,
									'edate': edate
								},

						
								function(result) {
		
									if (result) {
									
										$( "#msg" ).empty();
										$( "#msg" ).append(result );
										orderList();

									}
								}
								);
							}
				
					});


				

				function orderList(){

					  $.post('offmodel.php?call=2', {
									
								},
					
								function(result) {
		
									if (result) {
									
										$( "#olist" ).empty();									
										$( "#olist" ).append(result );
										list_mat();

									}
								}
								);
						
				 }
				 
				 
				 
				$( '#add' ).click(function(){
						
							var olist = $("#olist").val(); 											
							var lwb = $("#lwb").val(); 
							var upb = $("#upb").val(); 
							var matno = $("#matno").val(); 							
							var discount = $("#discount").val(); 
							var dtype = $("#dtype").val(); 
							
							
							
							if(olist==null)
							{
								
								$( "#msgbox" ).empty();			
								$( "#msgbox" ).append('<p class="alert alert-warning">Please select Offer Name!</p>');
							}else{
								
								$.post('offmodel.php?call=3', {
									'olist': olist,
									'lwb': lwb,
									'upb': upb,
									'matno': matno,
									'discount': discount,
									'dtype': dtype
								},

						
								function(result) {
		
									if (result) {
									
										$( "#msgbox" ).empty();
										$( "#msgbox" ).append(result );
										
										list_mat();

									}
								}
								);
							
							}			
							
							
				
					});



				
				function list_mat(){

					  
					  var olist = $("#olist").val(); 
					  //alert(olist);
					  $.post('offmodel.php?call=4', {
									'olist': olist
								},
					
								function(result) {
		
									if (result) {
									
										$( "#matList" ).empty();									
										$( "#matList" ).append(result );
										//alert(result);

									}
								}
								);
						
				 }
				 
				 
				 $('#olist').change(function(){	
					list_mat();
					
				});	
				 		
				
			
			
			$(function() {
			  $.removeItem = function(id) {
			
			
				
				if (confirm('Are you sure you want to remove it?')) {
					
					
					
					
					 $.post('offmodel.php?call=5', {
									'id': id
								},
					
								function(result) {
		
									if (result) {
									
										$( "#itembox" ).empty();									
										$( "#itembox" ).append(result );
				

									}
								}
								);
			
			
			
			
			
			//$( "#itembox" ).empty();			
			//$( "#itembox" ).append('<p class="alert alert-warning">Item Removed!</p>');
			
			} else {
				$( "#itembox" ).empty();
				$( "#itembox" ).append('<p class="alert alert-success">Item not Removed!</p>');
			}

		list_mat();
	
			
			
	  };
	  
	  
		  
	
	});
	
	
			
			$(function() {
					  $.removeOffer = function() {
					
					 var olist = $("#olist").val(); 
					// alert(olist);
						
					if (confirm('Are you sure you want to remove this offer?')) {
									
									
							
								
								$.post('offmodel.php?call=6', {
									'id': olist
								},
					
								function(result) {
		
									if (result) {
									
										$( "#msgbox" ).empty();									
										$( "#msgbox" ).append(result );
				

									}
								}
								);
									
								
							
							} else {
								$( "#msgbox" ).empty();
								$( "#msgbox" ).append('<p class="alert alert-success">Offer not Removed!</p>');
							}

			
				orderList();
					
					
			  };
			  
			  
				  
			
			});
	
	
	
			
			
				
				


			});
		</script>




	</body>

	</html>
<?php

	// include_once("footer.php"); 

} else {
	include_once("login.php");
} ?>