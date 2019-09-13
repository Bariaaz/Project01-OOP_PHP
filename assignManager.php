<?php
include 'Layouts/main.php';
include 'Models/Employee.php';
include 'Models/Store.php';
include 'DBConfiguration.php';

if(isset($_GET['id'])){
    $store=Store::getStore($_GET['id'],$conn);
    $managers= Employee::getStoreManagers($_GET['id'], $conn);
}

if(isset($_POST['save'])){
    $store=Store::getStore($_POST['store_to_update'],$conn);
    $store->setConnection($conn);
    $updates=array('ManagerID' => $_POST['manager']);
    $store->updateStore($updates);

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
    <div align='center'>
        <div class="container"> 
        <h3>Managers Available:</h3><br> 
        <form action="<?php echo $_SERVER['PHP_SELF']?>" method="post">       
        <table class="table table-bordered">
            <thead>
            <tr>
                <th>first name</th>
                <th>last name</th>
                <th>email</th>
                <th>#</th>
            </tr>
            </thead>
            <tbody>
                <?php 
                if($managers){
                    foreach($managers as $manager){
                        echo "<tr>"
                                ."<td>".$manager->firstname."</td>"
                                ."<td>".$manager->lastname."</td>"
                                ."<td>".$manager->email."</td>"
                                ."<td><input type='radio' name='manager' value=$manager->id></td>"
                            ."</tr>"; 
                    }
                } 
                ?>
                
            </tbody>
            </table>
            <input type="hidden" name="store_to_update" value="<?php echo $store->id?>">
            <input type="submit" name="save" value="Save">
            </form>
        </div>
    </div>
</body>
</html>
    
