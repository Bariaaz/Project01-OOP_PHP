<?php
include 'Layouts/main.php';
include 'Models/Store.php';
include 'Models/Employee.php';
include 'DBConfiguration.php';

$stores=Store::getAllStores($conn);

if(isset($_POST['delete']))
{
    foreach($_POST['del'] as $store_id){
      $store=Store::getStore($store_id, $conn);
      $store->setConnection($conn);
      $store->deleteStore();
    }

    header("Location: stores.php");
}


?>

<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
</head>
<body>

<div class="container"> 
  <h3>Stores :</h3><br> 
  <form action="<?php echo $_SERVER['PHP_SELF']?>" method="POST">       
  <table class="table table-bordered">
    <thead>
      <tr>
        <th>name</th>
        <th>Address</th>
        <th>Area</th>
        <th>Phone</th>
        <th>Employees</th>
        <th>Head Of Store</th>
        <th>Delete</th>
      </tr>
    </thead>
    <tbody>
        <?php 
        if($stores){
            foreach($stores as $store){
                echo "<tr>"
                        ."<td><a href=editStore.php?id=$store->id>".$store->name."</td>"                        .
                        "<td>$store->address</td>"
                        ."<td>$store->area</td>"
                        ."<td>$store->phone</td>"
                        ."<td><a href=storeEmployeeList.php?id=".$store->id.">Employees</td>";
                        if($store->ManagerID != NULL){
                          $manager=Employee::getEmployee($store->ManagerID, $conn);
                          echo "<td>".$manager->firstname." ".$manager->lastname."</td>";
                        }else{
                          echo "<td><a href=assignManager.php?id=$store->id>Assign Head</a></td>"; 
                        }
                          echo "<td><input type='checkbox' name='del[]' value=".$store->id."></td>";
                echo "</tr>";           
            }
         
      }
      ?>
        
    </tbody>
    </table>
    <div align='right'>
    <input type="submit" name="delete" value="Delete">
    </div>
    </form>
  </div>
  

</body>
</html>
