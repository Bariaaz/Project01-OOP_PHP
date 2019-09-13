<?php
    class Employee {
        public $conn;
        public $id, $firstname, $lastname, $address, $email, $phone, $gender, $storeID;

        public static function create() {
            $instance = new self();

            return $instance;
        }

        public function setConnection($connn){ 
            $this->conn=$connn;
        }

        public function setFields($fieldsArray){
            if(array_key_exists('id', $fieldsArray))
                $this->id= $fieldsArray['id'];
            $this->firstname= $fieldsArray['firstname'];
            $this->lastname= $fieldsArray['lastname'];
            $this->address= $fieldsArray['address'];
            $this->email= $fieldsArray['email'];
            $this->phone= $fieldsArray['phone'];
            $this->gender= $fieldsArray['gender'];
            $this->storeID= $fieldsArray['storeID'];
        }


        public function addEmployee(){
            $sql = "INSERT INTO employees (firstname, lastname, address, email, phone, gender, storeID)
            VALUES (?,?,?,?,?,?,?)";
            if($stmt = $this->conn->prepare($sql)) { 
                $stmt->bind_param('ssssssi', $this->firstname, $this->lastname, $this->address, $this->email, $this->phone, $this->gender, $this->storeID);
                $stmt->execute();
            } else {
                echo "Error: " . $sql . "<br>" . $this->conn->error; 
            }
        }

        public function updateEmployee($array){
            if (count($array) > 0) {
                foreach ($array as $key => $value) {
                    $value = $this->conn->real_escape_string($value); 
                    $value = "'$value'";
                    $updates[] = "$key = $value";
                }
            }
            $implodeArray = implode(',', $updates);
            $sql = ("UPDATE employees SET $implodeArray WHERE id=?");
            $stmt= $this->conn->prepare($sql);
            $stmt->bind_param('i', $this->id);
            $stmt->execute();
        }

        public function deleteEmployee(){
            $sql="DELETE FROM employees WHERE id=?";
            $stmt= $this->conn->prepare($sql);
            $stmt->bind_param("i", $this->id);
            $stmt->execute();
        }

        public static function getEmployee($employee_id, $conn){
            $sql="SELECT * FROM `employees` WHERE `id`=?";
            $stmt= $conn->prepare($sql);
            $stmt->bind_param('i', $employee_id);
            $stmt->bind_result($id, $fn, $ln, $address, $email, $ph, $gen, $store);
            $stmt->execute();

            if($stmt->fetch()){
                $row=array('id'=>$id, 'firstname'=>$fn, 'lastname'=>$ln, 'address'=>$address, 'email'=>$email, 'phone'=>$ph, 'gender'=>$gen, 'storeID'=>$store);
                $emp= Employee::create();
                $emp->setFields($row);

                return $emp;
            }else
                return null;
        } //=> returns Employee Object

        public static function getEmployeeByEmail($email, $conn){
            $sql="SELECT * FROM `employees` WHERE `email`=?";
            $stmt= $conn->prepare($sql);
            $stmt->bind_param('s', $email);
            $stmt->bind_result($id, $fn, $ln, $address, $email, $ph, $gen, $store);
            $stmt->execute();

            if($stmt->fetch()){
                $row=array('id'=>$id, 'firstname'=>$fn, 'lastname'=>$ln, 'address'=>$address, 'email'=>$email, 'phone'=>$ph, 'gender'=>$gen, 'storeID'=>$store);
                $emp= Employee::create();
                $emp->setFields($row);

                return $emp;
            }else
                return null;
        } //=> returns Employee Object



        public static function getAllEmployees($conn){
            $result= array();
            $sql= "SELECT * FROM employees";
            $stmt= $conn->prepare($sql);
            $stmt->bind_result($id, $fn, $ln, $address, $email, $ph, $gen, $store);
            $stmt->execute();
            while($stmt->fetch()){
                $row=array('id'=>$id, 'firstname'=>$fn, 'lastname'=>$ln, 'address'=>$address, 'email'=>$email, 'phone'=>$ph, 'gender'=>$gen, 'storeID'=>$store);
                $em= Employee::create();
                $em->setFields($row);
                array_push($result, $em);
            }
            
            return $result; 
        }

        public static function getStoreEmployees($store_id, $conn){
            $result= array();
            $sql="SELECT * FROM `employees` WHERE `storeID`=?";
            $stmt= $conn->prepare($sql);
            $stmt->bind_param('i', $store_id);
            $stmt->bind_result($id, $firstname, $lastname, $address, $email, $phone, $gender, $storeId);
            $stmt->execute();
            while($stmt->fetch()){
                $row=array('id'=>$id,'firstname'=>$firstname, 'lastname'=>$lastname, 'address'=>$address, 'email'=>$email, 'phone'=>$phone, 'gender'=>$gender, 'storeID'=>$storeId);
                $employee= Employee::create();
                $employee->setFields($row);
                array_push($result, $employee);
            }

            return $result;
        }


        public function attachRole($role_id){
            $sql = "INSERT INTO role_employee (RoleID, EmployeeID)
            VALUES (?,?)";
            if($stmt = $this->conn->prepare($sql)) { 
                $stmt->bind_param('ii', $role_id, $this->id);
                $stmt->execute();
            } else {
                echo "Error: " . $sql . "<br>" . $this->conn->error; 
            }
        }

        public static function getStoreManagers($store_id, $conn){
            $result= array();
            $sql= "SELECT employees.* FROM employees, role_employee, roles WHERE employees.storeID =?
            and employees.id = role_employee.employeeID and role_employee.roleID = roles.id
            and roles.Name = 'Manager'";
            $stmt= $conn->prepare($sql);
            $stmt->bind_param("i", $store_id);
            $stmt->bind_result($id, $firstname, $lastname, $address, $email, $phone, $gender, $storeId);
            $stmt->execute();
            while($stmt->fetch()){
                $row=array('id'=>$id,'firstname'=>$firstname, 'lastname'=>$lastname, 'address'=>$address, 'email'=>$email, 'phone'=>$phone, 'gender'=>$gender, 'storeID'=>$storeId);
                $employee= Employee::create();
                $employee->setFields($row);
                array_push($result, $employee);
            }
            return $result;

        } //=> returns array of Employee objects (Managers only)

        /*public function checkIfEmployeeIsAManagerAndHeadOfStore($employee_id){
            "SELECT EXISTS(SELECT roles.* from role_employee, roles WHERE role_employee.employeeID=?
            and employees.id = role_employee.employeeID and role_employee.roleID = roles.id
            and roles.Name = 'Manager')";
        }*/

        

    }
?>