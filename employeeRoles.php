<?php
include 'Models/Role.php';
include 'Models/Employee.php';
include 'Layouts/main.php';
include 'DBConfiguration.php';

$roles=Role::getAllRoles($conn);

if(isset($_GET['id'])){
    $employee= Employee::getEmployee($_GET['id'], $conn);
    $emp_roles=Role::employeeRoles($employee->id, $conn);
}

if(isset($_POST['submit'])){
    $emp=Employee::getEmployee($_POST['emp_role_update'], $conn);
    Role::resetRoles($emp->id, $conn);
    if(isset($_POST['role'])){
        $emp->setConnection($conn);
        foreach($_POST['role'] as $r)
            $emp->attachRole(trim($r));
    }
    //$emp_store=Store::getStore($emp->storeID, $conn);
    //you should check after roles resetting that the edited employee is a manager and head of her/his store


    header("Location: stores.php");
}


?>

<html>
    <body>
        <h1> This employee Roles : </h1>
        <form id="contact" action="<?php echo $_SERVER['PHP_SELF']?>" method="post">
        <fieldset>
                <?php foreach($roles as $role){
                        if(in_array($role, $emp_roles))
                            echo "<input type='checkbox' name='role[]' value='$role->id' checked>".$role->name."<br>";
                        else 
                            echo "<input type='checkbox' name='role[]' value='$role->id'>".$role->name."<br>";
                      }

                ?>
        </fieldset><br>
        <input type="hidden" name="emp_role_update" value="<?php echo $_GET['id']?>">
        <input type="submit" name="submit" value="Reset Roles">
        </form>
    </body>
</html>