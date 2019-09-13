<?php
include 'Layouts/main.php';
include 'Models/Store.php';
include 'Models/Employee.php';
include 'Models/Role.php';
include 'DBConfiguration.php';

$stores=Store::getAllStores($conn);
$roles=Role::getAllRoles($conn);

if(isset($_POST["submit"])){
    $new_employee= Employee::create();
    $new_employee->setConnection($conn);
    $new_employee->setFields(array('firstname'=>trim($_POST['fn']), 'lastname'=>trim($_POST['ln']), 'address'=>trim($_POST['ad']),'email'=>trim($_POST['email']) ,'phone'=>trim($_POST['ph']),'gender'=>trim($_POST['gender']), 'storeID'=>trim($_POST['store'])));
    $new_employee->addEmployee();
    $addedEmployee=Employee::getEmployeeByEmail($_POST['email'], $conn);
    $addedEmployee->setConnection($conn);
    if(isset($_POST['role'])){
        foreach($_POST['role'] as $r)
            $addedEmployee->attachRole(trim($r));
    }

    header("Location: employees.php");
}

?>

<html>
    <head>
        <link rel="stylesheet" href="styles/add.css">
    </head>
    <div class="container">  
    <form id="contact" action="<?php echo $_SERVER['PHP_SELF']?>" method="post">
        <h3>Add An Employee</h3>
        <fieldset>
        <input placeholder="firstname" type="text" name="fn" tabindex="1" required autofocus>
        </fieldset>
        <fieldset>
        <input placeholder="lastname" type="text" name="ln" tabindex="1" required autofocus>
        </fieldset>
        <fieldset>
        <input placeholder="Address" type="text" name="ad" tabindex="1" required autofocus>
        </fieldset>
        <fieldset>
        <input placeholder="Email Address" type="email" name="email" tabindex="2" required>
        </fieldset>
        <fieldset>
        <input placeholder="Phone Number" type="tel" name="ph" tabindex="3" required>
        </fieldset>
        <fieldset>
          <p>
             <label>Select store</label>
             <select name = "store" required>
                <?php foreach($stores as $store)
                        echo "<option value='$store->id'>$store->name</option>";
                ?>
             </select>
          </p>
        </fieldset>
        <fieldset>
        <p>
             <label>Select Gender</label>
             <select name = "gender" required>
                    <option value='1'>Female</option>
                    <option value='0'>Male</option>
                    <option value='2'>Other</option>
             </select>
        </p>
        </fieldset>

        <fieldset>
        <?php foreach($roles as $role)
            echo "<input type='checkbox' name='role[]' value='$role->id'>".$role->name."<br>";
        ?>
        </fieldset>

        <button name="submit" type="submit" id="contact-submit" data-submit="...Sending">Submit</button>
        </fieldset>
    </form>
    </div>
</html>