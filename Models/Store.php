<?php

    class Store {
        private $conn;
        public $id, $name, $address, $area, $phone, $ManagerID;

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
            $this->name= $fieldsArray['name'];
            $this->address= $fieldsArray['address'];
            $this->area= $fieldsArray['area'];
            $this->phone= $fieldsArray['phone'];
            if(array_key_exists('managerID', $fieldsArray))
                $this->ManagerID= $fieldsArray['managerID']; 
        }


        public function addStore(){  //called on the object to be added
            $sql = "INSERT INTO stores (name, address, area, phone)
            VALUES (?,?,?,?)";
            if($stmt = $this->conn->prepare($sql)) { 
                $stmt->bind_param('ssss', $this->name, $this->address, $this->area, $this->phone);
                $stmt->execute();
            } else {
                echo "Error: " . $sql . "<br>" . $this->conn->error; 
            }
        }

        public function updateStore($array){ //called on the object to be updated
            if (count($array) > 0) {
                foreach ($array as $key => $value) {
                    $value = $this->conn->real_escape_string($value); 
                    $value = "'$value'";
                    $updates[] = "$key = $value";
                }
            }
            $implodeArray = implode(',', $updates);
            $sql = ("UPDATE stores SET $implodeArray WHERE id=?");
            $stmt= $this->conn->prepare($sql);
            $stmt->bind_param('i', $this->id);
            $stmt->execute();
        }

        public function deleteStore(){ //called on the object to be deleted
            $sql="DELETE FROM stores WHERE id=?";
            $stmt= $this->conn->prepare($sql);
            $stmt->bind_param("i", $this->id);
            $stmt->execute();
        }
        
        public static function getStore($store_id, $conn){ //static so I don't have to create an instance of Store every time I query a store + that's why passing a conn object
            $sql="SELECT * FROM `stores` WHERE `id`=?";
            $stmt= $conn->prepare($sql);
            $stmt->bind_param('i', $store_id);
            $stmt->bind_result($id, $name, $address, $area, $phone, $managerId);
            $stmt->execute();
            if($stmt->fetch()){
                $row=array('id'=>$id, 'name'=>$name, 'address'=>$address, 'area'=>$area, 'phone'=>$phone, 'managerID'=>$managerId);
                $store= Store::create();
                $store->setFields($row);
                return $store;
            }else
                return null;


        } //=> returns Store object

        public static function getAllStores($conn){
            $result= array();
            $sql= "SELECT * FROM stores";
            $stmt= $conn->prepare($sql);
            $stmt->bind_result($id, $name, $address, $area, $phone, $managerId);
            $stmt->execute();
            while($stmt->fetch()){
                $row=array('id'=>$id, 'name'=>$name, 'address'=>$address, 'area'=>$area, 'phone'=>$phone, 'managerID'=>$managerId);
                $store= Store::create();
                $store->setFields($row);
                array_push($result, $store);
            }
            
            return $result; 
            
        } //=> returns array of all Store objects



    }
    





?>