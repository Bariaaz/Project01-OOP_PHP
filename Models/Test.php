<?php
    ini_set('mysql.connect_timeout', 300);
    ini_set('default_socket_timeout', 300);
    include 'DBConnection.php';
    include 'Store.php';
    include 'Employee.php';

    $conn= new DBConnection("127.0.0.1", "root","" , "storesdb");

    function testStoreInsert(){
        $sample_store= Store::create();
        $sample_store->setConnection($GLOBALS['conn']);
        $sample_store->setFields(array('name'=>'whetver', 'address'=>'whatever', 'area'=>'ghgBeirut','phone'=>'786534'));
        $sample_store->addStore();
        var_dump($sample_store);
    }

    function testGetStore(){
        $store=Store::getStore(2, $GLOBALS['conn']);
        var_dump($store);
    }

    function testGetAllStores(){
        $stores=Store::getAllStores($GLOBALS['conn']);
        var_dump($stores);

    }

    function testUpdateStore(){
        $store_to_be_updated=Store::getStore(2,$GLOBALS['conn']);
        $store_to_be_updated->setConnection($GLOBALS['conn']);
        $updates=array('Name' => 'Pull&Bear', 'Address' => 'Hamra');
        $store_to_be_updated->updateStore($updates);
        $store_to_be_updated=Store::getStore(2,$GLOBALS['conn']);
        var_dump($store_to_be_updated);

    }

    function testDeleteStore(){
        $store=Store::getStore(6, $GLOBALS['conn']);
        $store->setConnection($GLOBALS['conn']);
        $store->deleteStore();
    }

    function testAddEmployee(){
        $sample_employee= Employee::create();
        $sample_employee->setConnection($GLOBALS['conn']);
        $sample_employee->setFields(array('firstname'=>'Salima', 'lastname'=>'Ghzayel', 'address'=>'Barja','email'=>'salima_ghzayel@hotmail.com' ,'phone'=>'78653478','gender'=>1, 'storeID'=>1));
        $sample_employee->addEmployee();
    }

    function testDeleteEmployee(){
        $emp=Employee::getEmployee(1, $GLOBALS['conn']);
        $emp->setConnection($GLOBALS['conn']);
        $emp->deleteEmployee();
    }

    function testAttachRole(){
        $emp=Employee::getEmployee(1, $GLOBALS['conn']);
        $emp->setConnection($GLOBALS['conn']);
        $emp->attachRole(1);
    }

    function testGetStoreEmployees(){
        $emp=Employee::getStoreEmployees(1, $GLOBALS['conn']);
        var_dump($emp);
    }

    function testGetEmployeeByEmail(){
        $emp=Employee::getEmployeeByEmail("yara@gmail.com", $GLOBALS['conn']);
        var_dump($emp);
    }

    function testGetManagers(){
        $managers= Employee::getStoreManagers(2, $GLOBALS['conn']);
        var_dump($managers);
    }



    //testStoreInsert();
    //testGetStore();
    //testGetAllStores();
    //testUpdateStore();
    //testDeleteStore();
    //testAddEmployee();
    //testDeleteEmployee();
    //testAttachRole()
    //testGetStoreEmployees();
    //testGetEmployeeByEmail();
    //testGetManagers();
        








?>