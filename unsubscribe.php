<?php
    $config = include __DIR__ . './config.php';
    $con = mysqli_connect($config['host'], $config['user'], $config['pass'], $config['db']);
session_start();
    $emailId=$_GET['id'];
    $expected = md5( $_GET['id'] . $config['KEY'] );

if( $_GET['validation_hash'] != $expected )
    throw new Exception("Validation failed.");

    else{
        $check = "select * from list where mailId='$emailId'";
        $resultcheck = mysqli_query($con, $check);
        echo 'test';
        $row = mysqli_num_rows($resultcheck);
    
       
            if ($row == 0)
            {
                $_SESSION['message'] = 'No active subscription on this email id';
                header('Location: index.php');
                exit;
            }
            else
            {
                $query = "delete from list where mailId ='$emailId'";
                $result = mysqli_query($con, $query);
                if ($result == 1)
                {
                    $_SESSION['message'] = 'Unsubscribed Sucessfully.';
                    header('Location: index.php');
                    exit;
                }
            }
    }



   
    

