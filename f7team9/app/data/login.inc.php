<?php
session_start();

$data = $config['DATA_PATH'] . 'dbh.inc.php';

// It connects to mySQL if the submit button is clicked to make the user login to the site

if (isset($_POST['submit'])){
    include $data;
    $uid = mysqli_real_escape_string($conn, $_POST['uid']);
    $pwd = mysqli_real_escape_string($conn, $_POST['pwd']);
    //Error handler
    //check if inputs are empty
    if (empty($uid) || empty($pwd)){
        header("Location: ?page=login&login=empty");
        exit();
    }
    // $sql is to check if the username the user has put matches the username in the login system in mySQL
    // and it shows nouser if the username doesn't matches (header function makes it show login&login=nouser on the URL)
    else{
        $sql = "SELECT * FROM user_profile WHERE user_uid='$uid' || user_email='$uid'";
        $result = mysqli_query($conn, $sql);
        $resultCheck = mysqli_num_rows($result);
        if ($resultCheck < 1){
            header("Location: ?page=login&login=nouser");
            exit();
        }
        // it proceeds to check if the user has put the password right
        else{
            if($row = mysqli_fetch_assoc($result)){
                //De-hashing the password
                $hashedPwdCheck = password_verify($pwd, $row['user_pwd']);
                if ($hashedPwdCheck == false){
                    header("Location: ?page=login&login=wrongpassword");
                    exit();
                }
                elseif ($hashedPwdCheck == true){
                    //make the user login if the password matches
                    $_SESSION['u_id'] = $row['user_id'];
                    $_SESSION['u_first'] = $row['user_first'];
                    $_SESSION['u_last'] = $row['user_last'];
                    $_SESSION['u_email'] = $row['user_email'];
                    $_SESSION['u_uid'] = $row['user_uid'];
                    header("Location: ?page=home&login=success");
                    exit();
                }
            }
        }
    }
}
else{
    header("Location: ?page=login");
    exit();
}