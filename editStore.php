<?php
include 'Layouts/main.php';
include 'Models/Store.php';
include 'Models/Employee.php';
include 'DBConfiguration.php';


if(isset($_GET['id'])){
    $store=Store::getStore($_GET['id'], $conn);
    $storeManagers=Employee::getStoreManagers($_GET['id'], $conn);
    //array_push($storeManagers, NULL);
}

if(isset($_POST["update"])){
    $store_to_be_updated=Store::getStore($_POST['store_to_update'],$conn);
    $store_to_be_updated->setConnection($conn);
    $updates=array('Name' => trim($_POST['name']), 'Address' => trim($_POST['address']), 'area'=>trim($_POST['area']), 'phone'=>trim($_POST['phone']), 'managerID'=>trim($_POST['manager']));
    $store_to_be_updated->updateStore($updates);
    
    header("Location: stores.php");
}
?>
<html>
    <head>
        <link rel="stylesheet" href="styles/add.css">
    </head>
    <body>
        <div class="container">  
        <form id="contact" action="<?php echo $_SERVER['PHP_SELF']?>" method="post">
            <h3>Update <?php echo $store->name?> Store</h3>
            <fieldset>
            <input placeholder="Store name" type="text" name="name" value=<?php echo $store->name?> required autofocus>
            </fieldset>
            <fieldset>
            <input placeholder="Address" type="text" name="address" value=<?php echo $store->address?> required>
            </fieldset>
            <fieldset>
            <input placeholder="Area" type="text" name= "area" value=<?php echo $store->area?> required>
            </fieldset>
            <fieldset>
            <input placeholder="phone" type="tel" name= "phone" value=<?php echo $store->phone?> required>
            </fieldset>

            <fieldset>
             <label>Select Head of Store</label>
             <select name = "manager" required>
                <?php
                $flag=1;
                if(count($storeManagers)>0){               
                    foreach($storeManagers as $manager){
                            if($manager->id==$store->ManagerID){
                                $flag=0;
                                echo "<option selected= 'selected' value='$manager->id'>$manager->firstname</option>";
                            }
                            else
                                echo "<option value='$manager->id'>$manager->firstname</option>";  
                    } 
                } 
                if($flag==1){
                    echo "<option selected= 'selected' value=''>Not appointed yet</option>";
                }   
                ?>
             </select>
          
            </fieldset>

            <fieldset>
            <button name="update" type="submit" id="contact-submit" data-submit="...Sending">Update</button>
            </fieldset>

            <fieldset>
            <input type="hidden" name="store_to_update" value="<?php echo $_GET['id']?>">
            </fieldset>
        </form>
        </div>
    <body>

</html>


