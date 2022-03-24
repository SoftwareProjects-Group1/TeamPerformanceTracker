

<?php
    require("../view/_inc/head.php");
    require("../view/_inc/header.php");

    

        

    function displayUsers() {
        $m = new MongoDB\Driver\Manager('mongodb+srv://group1:fvAIyyCRp4PBaDPQ@clst01.to6hh.mongodb.net/projectDB?retryWrites=true&w=majority');
        echo "<table class='table table-bordered table-striped'>";
        echo "<thead>   
           <td>Username</td>                    
            <td>First Name</td>
             <td>Last Name</td>
               <td>Email</td>
               <td>Role</td>
                    <td> Action </td>                       
                 </thead>  ";     
        $results=[];
        $q = new MongoDB\Driver\Query([],[]);
        $cursor = $m->executeQuery('projectDB.Users',$q);
        foreach($cursor as $row) {
            echo "<tr>";
            echo "<td>" . $row->Username. "</td>";
            echo "<td>" . $row->First_Name . "</td>";
            echo "<td>" . $row->Last_Name . "</td>"; 
            echo "<td>" . $row->Email_Address. "</td>"; 
            echo "<td>" . $row->Role. "</td>"; 
            echo '<td><a class="btn btn-info" href="updateUser.php?Username='. $row->Username.'">Update</a></td>';


         echo "</tr>";
        
        
        }
        echo "<table>";

        
}

       
        ?>
        

<div class="main">    
    
    <div class="inner_main">
    <?php if (isset($_GET['Deleted'])){
            echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
            <strong>Project Deleted</strong>
            <a href = "manageUsers.php" "type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </a>
          </div>';
    }
    if (isset($_GET['Created'])){
        echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
        <strong>User Created</strong>
        <a href = "manageUsers.php" "type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </a>
      </div>';
}
if (isset($_GET['Updated'])){
    echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
    <strong>User Updated</strong>
    <a href = "manageUsers.php" "type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </a>
  </div>';
}
    
    ?>
    
    
        <div class="container">

        

            <div class="row">
                <div class="col-sm-9 col-md-7 col-lg-12 mx-auto">
                    <div class="card border-0 shadow rounded-3 my-5">
                    <h1 class="text-center"> Users </h1>

                        <div class="card-body p-4 p-5">

                                                               
                                                     
                                                
                                                <?php
                                                    displayUsers();
                                                 
                                                 
                                                 
                                                 ?>
                                                      
                                        </table>    
                                    </div>
                                    <a href="adminCreateUser.php"  type="button" class="btn btn-primary">Create new user</a>	     

                                </div>
                         
                            </main>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
    require("../view/_inc/footer.php");
?>
