<?php
include_once("db.php"); 

if(isset($_POST['submit']))
	{
		$user=$_POST['user'];
		$pass=$_POST['pass'];
		

		$user= str_replace("'","",$user);
		$user= str_replace('"','',$user);
		
		$pass= str_replace("'","",$pass);
		$pass= str_replace('"','',$pass);
		
		$usql="select count(user_id) as tot,username,authlevel,password,displayname from users where username='".$user."' and password=sha1('".$pass."') and enabled=1
		 and authlevel=70701";
		$ures=mysqli_query($con,$usql);
		$urow=mysqli_fetch_object($ures);
		
		if($urow->tot>0)
		{		
			$IP = $_SERVER['REMOTE_ADDR'] ;
			mysqli_query($con,"insert into bi.user_log 
			( 
			user_id, 
			user_ip 
	
			)
			values
			(
			'".$user."', 
			'".$IP."'

			)	");
			
			$_SESSION['logged']="yes";
			$_SESSION['authlevel']=$urow->authlevel;
			$_SESSION['user_code']=$urow->username;	
			$_SESSION['user_name']=$urow->displayname;
			header("Location: index.php");
		}
		else{
			echo "<div align='center'><font color='#FF0000'><b>Incorrect User or Password!</b></font></div>";
		}
	}

?>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="icon" href="pic/icon.png" />
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>BI</title>
	<link href="script/common.css" rel="stylesheet" type="text/css" />
    <!-- Bootstrap -->
    <!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="script/bootstrap.min.css">
	<link rel="stylesheet" href="script/bootstrap-theme.css">

	<!-- Optional theme -->
	<link rel="stylesheet" href="script/bootstrap-theme.css">
	
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
	<script src="script//bootstrap.min.js"></script>
	<style>
		.center-block {
		  display: block;
		  margin-right: auto;
		  margin-left: auto;
		}
	</style>
	<script>
		$(document).ready(function(){	
		$( "#load" ).hide();	
		$( '#subid' ).click(function(){

			
	
			$( "#load" ).show();
			//$( "#load" ).append('<img src="pic/loading.gif" />');
			
		
	
		}); 
		});
	</script>	
  </head>
  <body>
		<div class="container" align="center">
			<div class="row">
				<div>
					<?php
					if(isset($_GET['msg']))
					{	
						if($_GET['msg']=="relog")
						echo "<div align='center'><font color='#FF0000'><b>please login again with new password!</b></font></div>";

					}	
					?>
					<img src="pic/bi.jpg"  width="500"/></br>
					<div id="load"><img src="pic/loading.gif" /><br/>
					<font size="4" color="#294786">Please wait data is loading....</font>
					</div>
					<br/>
					<form method='post'  class="login-style" action='login.php'>	
						<ul class="form-group">
							<li>
								<input type="text" name="user" id="user_id"class="field-style field-full align-none form-control" placeholder="User Name" style="width:200px;" />			
							</li>
							<li>
								<input type="password" name="pass" id="password" class="field-style field-full align-none form-control" placeholder="Password" style="width:200px;" />				
							</li>
							<li>				
								<input  type="submit" name="submit" id="subid" class="submit" value="Log In" />					
							</li>
						</ul>
					</form>	
					<br/>
					<!--
					<table>
						<tr>
							<td><font size="2" color="#294786">Business Intelligence (Beta: 1.01) @ Copyright 2019 AZNEO Ltd</font></td>
						</tr>
					</table>
					-->
				</div>
			</div>
		
	</body>
</html>




