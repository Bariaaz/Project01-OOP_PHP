<?php
include 'Layouts/main.php';
include 'Models/Store.php';
include 'Models/Employee.php';
include 'DBConfiguration.php';

if(isset($_GET['id'])){
    $store= Store::getStore($_GET['id'], $conn);
    $employees= Employee::getStoreEmployees($_GET['id'], $conn);
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
  <h3><?php echo $store->name?> Employees :</h3><br>        
  <table class="table table-bordered">
    <thead>
      <tr>
        <th>first name</th>
        <th>last name</th>
        <th>email</th>
        <th>address</th>
        <th>Phone</th>
        <th>Role</th>
      </tr>
    </thead>
    <tbody>
        <?php 
        if($employees){
            foreach($employees as $employee){
                echo "<tr>"
                        ."<td>".$employee->firstname."</td>"
                        ."<td>".$employee->lastname."</td>"
                        ."<td>".$employee->email."</td>"
                        ."<td>".$employee->address."</td>"
                        ."<td>".$employee->phone."</td>"
                        ."<td><a href=employeeRoles.php?id=$employee->id>View/Edit Roles</td>"
                    ."</tr>"; 
            }
        } 
        ?>
        
      </tbody>
    </table>
  </div>
  

</body>
</html>
