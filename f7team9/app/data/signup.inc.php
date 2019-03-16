<?php
$data = $config['DATA_PATH'] . 'dbh.inc.php';

if (isset($_POST['submit'])){
    include $data;

    $first = mysqli_real_escape_string($conn, $_POST['first']);
    $last = mysqli_real_escape_string($conn, $_POST['last']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $uid = mysqli_real_escape_string($conn, $_POST['uid']);
    $pwd = mysqli_real_escape_string($conn, $_POST['pwd']);

    //error handlers
    //check for empty fields
    if (empty($first) || empty($last) || empty($email) || empty($uid) || empty($pwd)){
        header("Location: ?page=signup&signup=empty");
        exit();
    }
    else{
        //check if input characters are valid
        if (!preg_match("/^[a-zA-Z]*$/",$first) || !preg_match("/^[a-zA-Z]*$/",$last)){
            header("Location: ?page=signup&signup=Invalid");
            exit();
        }
        else{
            //check if email is valid
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                header("Location: ?page=signup&signup=email");
                exit();
            }
            else{
                $sql = "SELECT * FROM user_profile WHERE user_uid='$uid'";
                $result = mysqli_query($conn, $sql);
                $resultCheck = mysqli_num_rows($result);

                if ($resultCheck > 0){
                    header("Location: ?page=signup&signup=usertaken");
                    exit();
                }
                else{
                    //Hashing the password
                    $hashedPwd = password_hash($pwd, PASSWORD_DEFAULT);
                    //Insert the user into the database
                    $sql = "INSERT INTO user_profile (user_first, user_last, user_email, user_uid, user_pwd) VALUES('$first','$last','$email','$uid','$hashedPwd');";
                    $result = mysqli_query($conn, $sql);
                    header("Location: ?page=index&signup=success");
                    exit();
                }
            }
        }
    }

}
else{
    header("Location: ?page=signup");
    exit();
}