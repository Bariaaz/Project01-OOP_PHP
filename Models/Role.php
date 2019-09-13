<?php
    
    class Role {

        public $id, $name, $conn;

        public static function create() {
            $instance = new self();

            return $instance;
        }


        public function setFields($fieldsArray){
            if(array_key_exists('id', $fieldsArray))
                $this->id= $fieldsArray['id'];
            $this->name=$fieldsArray['name'];    
        }


        public static function getAllRoles($conn){
            $result= array();
            $sql= "SELECT * FROM roles";
            $stmt= $conn->prepare($sql);
            $stmt->bind_result($id, $name);
            $stmt->execute();
            while($stmt->fetch()){
                $row=array('id'=>$id, 'name'=>$name);
                $r= Role::create();
                $r->setFields($row);
                array_push($result, $r);
            }
            
            return $result; 
        }

        public static function employeeRoles($employee_id, $conn){
            $result= array();
            $sql= "SELECT roles.* FROM employees, role_employee, roles WHERE role_employee.employeeID =?
            and employees.id = role_employee.employeeID and role_employee.roleID = roles.id";
            $stmt= $conn->prepare($sql);
            $stmt->bind_param("i", $employee_id);
            $stmt->bind_result($id, $name);
            $stmt->execute();
            while($stmt->fetch()){
                $row=array('id'=>$id,'name'=>$name);
                $role= Role::create();
                $role->setFields($row);
                array_push($result, $role);
            }

            return $result;
        }

        public static function resetRoles($employee_id, $conn){
            $sql="DELETE FROM role_employee WHERE employeeID=?";
            $stmt= $conn->prepare($sql);
            $stmt->bind_param("i", $employee_id);
            $stmt->execute();
        }



    }

?>