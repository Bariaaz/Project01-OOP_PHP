<?php
include 'Layouts/main.php';
include 'Models/Store.php';
include 'DBConfiguration.php';

if(isset($_POST["submit"])){
    //$conn= new DBConnection("127.0.0.1", "root","" , "storesdb");
    $new_store= Store::create();
    $new_store->setConnection($conn);
    $new_store->setFields(array('name'=>$_POST['name'], 'address'=>$_POST['address'], 'area'=>$_POST['area'],'phone'=>$_POST['phone']));
    $new_store->addStore();
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
            <h3>Add A Store</h3>
            <fieldset>
            <input placeholder="Store name" type="text" name="name" required autofocus>
            </fieldset>
            <fieldset>
            <input placeholder="Address" type="text" name="address" required>
            </fieldset>
            <fieldset>
            <input placeholder="Area" type="text" name= "area" required>
            </fieldset>
            <fieldset>
            <input placeholder="phone" type="tel" name= "phone" required>
            </fieldset>
            <fieldset>
            <button name="submit" type="submit" id="contact-submit" data-submit="...Sending">Submit</button>
            </fieldset>
        </form>
        </div>
    <body>

</html>


