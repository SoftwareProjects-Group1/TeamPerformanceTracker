<div class="navbar-nav">
<a id="navLink" href="personalPerformanc.php"><span>Personal Performanc</span></a>
</div>
<div class="userArea">
    <span><?php
    echo($_SESSION['userFname'].". ".$_SESSION['userSname']);
    ?></span>
    <button onclick="logout()"><i class = "fa fa-sign-out"></i></button>
</div>