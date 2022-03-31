<style>

    .sidenav {
        height: 100%;
        width: 0;
        position: fixed;
        z-index: 1;
        top: 0;
        left: 0;
        background-color: #111;
        overflow-x: hidden;
        transition: 0.5s;
        padding-top: 60px;
    }

    .sidenav a {
        padding: 8px 8px 8px 32px;
        text-decoration: none;
        font-size: 18px;
        color: #818181;
        display: block;
        transition: 0.3s;
    }

    .sidenav a:hover {
        color: #f1f1f1;
    }

    .sidenav .closebtn {
        position: absolute;
        top: 0;
        right: 25px;
        font-size: 36px;
        margin-left: 50px;
    }

    @media screen and (max-height: 450px) {
        .sidenav {
            padding-top: 15px;
        }

        .sidenav a {
            font-size: 18px;
        }
    }
</style>


<div id="mySidenav" class="sidenav">
    <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
    <a href="index.php">Home</a>
    <a href="analyse.php">Sales vs Target Analyse</a>
    <a href="target_vs_achivement.php">Target vs Achivement Values</a>
    <a href="showroom_cogs_all.php">Showroom Dashboard</a>
    <a href="stockanalyse.php">Stock Analysis</a>
	 <a href="offer.php">Special Offer Entry</a>
	 <a href="maxwell_target.php" target="about_blank">Maxwell Target</a>
	  <a href="mrp.php" target="about_blank">Price Checking</a>
    <a href="change_password.php">Change Password</a>
    <a href="index.php?logout=yes">Logout</a>
</div>
<span style="font-size:28px;cursor:pointer;position:fixed" onclick="openNav()">&#9776; Menu</span>

<script>
    function openNav() {
        document.getElementById("mySidenav").style.width = "250px";
    }

    function closeNav() {
        document.getElementById("mySidenav").style.width = "0";
    }
</script>