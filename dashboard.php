<div class="container">
	<div class="row"><br/>
		<div class="col-md-12">
		
            <div class="panel with-nav-tabs panel-success">
                <div class="panel-heading">
                        <ul class="nav nav-tabs">							
						<li class="active"><a href="#tab1default" data-toggle="tab">Achievement</a></li>
                            <li><a href="#tab2default" data-toggle="tab">Expenses</a></li>
							<li><a href="#tab3default" data-toggle="tab">Inventory</a></li>
						<li><a href="#tab4default" data-toggle="tab">Target Vs Achivement</a></li>
						<li><a href="#tab5default" data-toggle="tab">Special Offer</a></li>
						<li><a href="#tab6default" data-toggle="tab">Service Ticket</a></li>
						<li><a href="#tab7default" data-toggle="tab">Warranty</a></li>
                        </ul>
                </div>
               
				<div class="panel-body">
					<div class="tab-content">

						<!-- First Tab Start 				 -->
						<div class="tab-pane fade in active" id="tab1default">
							<iframe scrolling="no" style="border: 0; width: 100%; height: 600px; " src="home.php"></iframe>
						</div>
						
						<!-- Second Tab Start  -->
						<div class="tab-pane fade in" id="tab2default">			
							<iframe scrolling="yes" style="border: 0; width: 100%; height: 800px; " src="cogs.php"></iframe>
						</div>
						<!-- Second Tab End  -->	
							
						<!-- Third Tab Start  -->
						<div class="tab-pane fade in" id="tab3default">
							<iframe scrolling="yes" style="border: 0; width: 100%; height: 800px; " src="stock.php"></iframe>
						</div>
						<!-- Third Tab End  -->

						<!-- Fourth Tab Start -->
						<div class="tab-pane fade in" id="tab4default">		
							<iframe scrolling="yes" style="border: 0; width: 100%; height: 800px; " src="target_vs_achivement.php"></iframe>				
						</div>
						<!-- Fourth Tab End -->
						
						<!-- fifth Tab Start  -->
						<div class="tab-pane fade in" id="tab5default">						
							<iframe scrolling="yes" style="border: 0; width: 100%; height: 800px; " src="offerList.php"></iframe>												
						</div>
						<!-- fifth Tab End  -->					
						
						<!-- sixth Tab Start  -->
						<div class="tab-pane fade in" id="tab6default">						
							<iframe scrolling="yes" style="border: 0; width: 100%; height: 800px; " src="service.php"></iframe>												
						</div>
						<!-- sixth Tab End  -->
						
						<!-- sixth Tab Start  -->
						<div class="tab-pane fade in" id="tab7default">						
							<iframe scrolling="yes" style="border: 0; width: 100%; height: 800px; " src="warranty.php"></iframe>												
						</div>
						<!-- sixth Tab End  -->
						
					</div>
				</div>
			</div>
        
		</div>
	</div>
</div>



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
	
	}
	window.onload = tab4;
</script>