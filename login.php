<?php


//importing required script
require_once 'dbopr.php';

$response = array();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // if (!verifyRequiredParams(array('username', 'password', 'email', 'name', 'phone'))) {
    if (!verifyRequiredParams(array('email', 'password'))) {

        //getting values
        // $username = $_POST['username'];
        $password = $_POST['password'];
        $email = $_POST['email'];
        // $name = $_POST['name'];
        // $phone = $_POST['phone'];

        //creating db operation object
        $db = new DbOperation();

        //adding user to database
        // $result = $db->createUser($username, $password, $email, $name, $phone);
        $result = $db->loginUser($email, $password);


        //making the response accordingly
        if ($result == LOGIN_SUCCESS) {
            $response['error'] = false;
            $response['message'] = 'Login successfully';
        }
        elseif ($result == USER_INVALID) {
            $response['error'] = true;
            $response['message'] = 'USER Invalid Plese try agian';
        }


        // if ($result == USER_CREATED) {
        //     $response['error'] = false;
        //     $response['message'] = 'User created successfully';
        // } elseif ($result == USER_ALREADY_EXIST) {
        //     $response['error'] = true;
        //     // $response['message'] = 'User already exist';
        //     $response['message'] = 'Email already exist';

        // } elseif ($result == USER_NOT_CREATED) {
        //     $response['error'] = true;
        //     $response['message'] = 'Some error occurred';
        // }
    } else {
        $response['error'] = true;
        $response['message'] = 'Required parameters are missing';
    }
} else {
    $response['error'] = true;
    $response['message'] = 'Invalid request';
}

//function to validate the required parameter in request
function verifyRequiredParams($required_fields)
{

    //Getting the request parameters
    $request_params = $_REQUEST;

    //Looping through all the parameters
    foreach ($required_fields as $field) {
        //if any requred parameter is missing
        $response['chk'] = 'enter func verify';
        if (!isset($request_params[$field]) || strlen(trim($request_params[$field])) <= 0) {

            //returning true;
            return true;
        }
    }
    return false;
}

echo json_encode($response);