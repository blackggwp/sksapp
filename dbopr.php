<?php

class DbOperation
{
    private $conn;

    //Constructor
    function __construct()
    {
        require_once dirname(__FILE__) . '/constants.php';
        require_once dirname(__FILE__) . '/dbconnect.php';
        // opening db connection
        $db = new DbConnect();
        $this->conn = $db->connect();
    }

    //Function to create a new user
//     public function createUser($username, $pass, $email, $name, $phone)
//     {
//         if (!$this->isUserExist($username, $email, $phone)) {
//             $password = md5($pass);
//             $stmt = $this->conn->prepare("INSERT INTO users (username, password, email, name, phone) VALUES (?, ?, ?, ?, ?)");
//             $stmt->bind_param("sssss", $username, $password, $email, $name, $phone);
//             if ($stmt->execute()) {
//                 return USER_CREATED;
//             } else {
//                 return USER_NOT_CREATED;
//             }
//         } else {
//             return USER_ALREADY_EXIST;
//         }
//     }


//     private function isUserExist($username, $email, $phone)
//     {
//         $stmt = $this->conn->prepare("SELECT id FROM users WHERE username = ? OR email = ? OR phone = ?");
//         $stmt->bind_param("sss", $username, $email, $phone);
//         $stmt->execute();
//         $stmt->store_result();
//         return $stmt->num_rows > 0;
//     }
// }

    
    //Function to create a new user
    public function createUser($username, $pass, $email, $phone)
    {
        if (!$this->isUserExist($email)) {
            $password = md5($pass);
            $stmt = $this->conn->prepare("INSERT INTO users (username, password, email, phone) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("ssss", $username, $password, $email, $phone);
            if ($stmt->execute()) {
                return USER_CREATED;
            } else {
                return USER_NOT_CREATED;
            }
        } else {
            return USER_ALREADY_EXIST;
        }
    }
    public function loginUser($email,$pass){
        if ($this->checkLogin($email,$pass)) {
             return LOGIN_SUCCESS;
         } 
         else
         {
            return USER_INVALID;
         }
    }


    private function isUserExist($email)
    {
        $stmt = $this->conn->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();
        return $stmt->num_rows > 0;
    }
    private function checkLogin($email,$pass)
    {
        $password = md5($pass);
        $stmt = $this->conn->prepare("SELECT id FROM users WHERE email = ? AND password = ?");
        echo $respond["m"] = $email.$password;
        $stmt->bind_param("ss", $email,$password);
        $stmt->execute();
        $stmt->store_result();
        return $stmt->num_rows > 0;
    }
}