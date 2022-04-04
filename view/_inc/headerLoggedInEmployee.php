<div class="navbar-nav">
<a id="navLink" href="personalPerformance.php"><span>Personal Performance</span></a>
</div>
<div class="userArea">
    <span><?php
    echo($_SESSION['userFname'].". ".$_SESSION['userSname']);
    ?></span>
    <button onclick="logout()"><i class = "fa fa-sign-out"></i></button>
</div>