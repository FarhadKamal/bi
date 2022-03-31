<script src="script/jquery-1.11.2.min.js"></script>

<div id="lid" >	

<img src="pic/loading.gif" />
</div>
<script>
    $(document).ready(function(){

		
	
			$('#pframe iframe').load(function() { $( "#lid" ).remove();})
	});	
</script>

<div id="pframe">
<iframe scrolling="no" style="border: 0; width: 100%; height: 300px;" 

src="ocryear.php" ></iframe>
</div>


	
