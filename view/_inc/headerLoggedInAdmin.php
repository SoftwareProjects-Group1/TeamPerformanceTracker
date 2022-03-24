<div class="navbar-nav">
<a id="navLink" href="teamManagement.php"><span>Teams</span></a>  
<a id="navLink" href="EmployeesPage.php">Employees</a>    
<a id="navLink" href="performancePage.php">Performance</a>   
<a id="navLink" href="ViewProject.php">Projects</a>
<a id="navLink" href="manageUsers.php">Users</a>

</div>
<div class="userArea">
    <span><?php
    echo($_SESSION['userFname'].". ".$_SESSION['userSname']);
    ?></span>
    <button onclick="logout()"><i class = "fa fa-sign-out"></i></button>
</div>