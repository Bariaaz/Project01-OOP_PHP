<?php
include 'Layouts/main.php';
include 'Models/Store.php';
include 'Models/Employee.php';
include 'DBConfiguration.php';

//$conn= new DBConnection("127.0.0.1", "root","" , "storesdb");
$employees=Employee::getAllEmployees($conn);

if(isset($_POST['delete']))
{
    foreach($_POST['del'] as $employee_id){
      $store=Employee::getEmployee($employee_id, $conn);
      $store->setConnection($conn);
      $store->deleteEmployee();
    }
    
    header("Location: employees.php");
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
  <h3>Employees :</h3><br>   
  <form action="<?php echo $_SERVER['PHP_SELF']?>" method="POST">     
  <table class="table table-bordered">
    <thead>
      <tr>
        <th>first name</th>
        <th>last name</th>
        <th>email</th>
        <th>address</th>
        <th>Phone</th>
        <th>Store</th>
        <th>Delete</th>
      </tr>
    </thead>
    <tbody>
        <?php 
        if($employees){
            foreach($employees as $employee){
                $store=Store::getStore($employee->storeID, $conn);
                echo "<tr>"
                        ."<td><a href=editEmployee.php?id=$employee->id>".$employee->firstname."</td>"
                        ."<td>".$employee->lastname."</td>"
                        ."<td>".$employee->email."</td>"
                        ."<td>".$employee->address."</td>"
                        ."<td>".$employee->phone."</td>"
                        ."<td>".$store->name."</td>"
                        ."<td><input type='checkbox' name='del[]' value=".$employee->id."></td>"
                    ."</tr>"; 
            }
        } 
         ?>
        
      </tbody>
    </table>
    <div align='right'>
    <input type="submit" name="delete" value="Delete">
    </form>
  </div>
  

</body>
</html>
