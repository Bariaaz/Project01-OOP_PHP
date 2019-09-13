<?php
include 'Layouts/main.php';
include 'Models/Employee.php';
include 'Models/Store.php';
include 'Models/Role.php';
include 'DBConfiguration.php';


$stores=Store::getAllStores($conn);
if(isset($_GET['id'])){
    $employee=Employee::getEmployee($_GET['id'], $conn);
}

if(isset($_POST["update"])){
    $emp_to_be_updated=Employee::getEmployee($_POST['emp_to_update'],$conn);
    $emp_to_be_updated->setConnection($conn);
    $updates=array('firstname' => trim($_POST['fn']), 'lastname'=> trim($_POST['ln']), 'address' => trim($_POST['ad']), 'email'=>trim($_POST['email']), 'phone'=>trim($_POST['ph']), 'storeID'=>trim($_POST['store']), 'gender'=>trim($_POST['gender']));
    $emp_to_be_updated->updateEmployee($updates);

    header("Location: employees.php");
}
?>
<html>
    <head>
        <link rel="stylesheet" href="styles/add.css">
    </head>
    <div class="container">  
    <form id="contact" action="<?php echo $_SERVER['PHP_SELF']?>" method="post">
        <h3>Edit <?php echo $employee->firstname?> Info</h3>
        <fieldset>
        <input placeholder="firstname" type="text" name="fn" tabindex="1" value= <?php echo $employee->firstname?> required autofocus>
        </fieldset>
        <fieldset>
        <input placeholder="lastname" type="text" name="ln" tabindex="1" value= <?php echo $employee->lastname?> required autofocus>
        </fieldset>
        <fieldset>
        <input placeholder="Address" type="text" name="ad" tabindex="1" value= <?php echo $employee->address?> required autofocus>
        </fieldset>
        <fieldset>
        <input placeholder="Email Address" type="email" name="email" tabindex="2" value= <?php echo $employee->email?> required>
        </fieldset>
        <fieldset>
        <input placeholder="Phone Number" type="tel" name="ph" tabindex="3" value= <?php echo $employee->phone?> required>
        </fieldset>

        <fieldset>
             <label>Select store</label>
             <select name = "store" required>
                <?php foreach($stores as $store)
                            if($store->id==$employee->storeID)
                                echo "<option selected= 'selected' value='$store->id'>$store->name</option>";
                            else
                                echo "<option value='$store->id'>$store->name</option>";    
                ?>
             </select>
          
        </fieldset>

        <fieldset>
             <label>Select Gender</label>
             <select name = "gender" required>
                 <?php 
                 
                    switch($employee->gender){
                        case '1':
                            echo "<option selected= 'selected' value='1'>Female</option>"
                                 ."<option value='0'>Male</option>" 
                                 ."<option value='2'>Other</option>";
                                 break;
                        case '0':
                            echo "<option value='0' selected= 'selected'>Male</option>"
                                ."<option value='1'>Female</option>" 
                                ."<option value='2'>Other</option>";
                                break;
                        case '2':    
                            echo "<option value='2' selected= 'selected'>Other</option>"
                                ."<option value='0'>Male</option>" 
                                ."<option value='1'>Female</option>";
                                break;
                    }
                    ?>
                    
             </select>

        </fieldset>

        <button name="update" type="submit" id="contact-submit" data-submit="...Sending">Submit</button>
        <input type="hidden" name="emp_to_update" value="<?php echo $_GET['id']?>">
    </form>
    </div>
</html>