<?php
session_start();

$data = $config['DATA_PATH'] . 'dbh.inc.php';
include $data;
$userid = $_SESSION['u_id'];

if (isset($_POST['start']))
{
    $id = isset($_POST['id']) ? $_POST['id'] : '';

    //query to store the current time received to the user progress column that have the same taskid and userid
    $start = "UPDATE user_tasks SET user_start = CURRENT_TIME WHERE user_taskid = '$id' && user_id = '$userid'";
    mysqli_query($conn, $start);
}

elseif (isset($_POST['stop']))
{
    $id = isset($_POST['id']) ? $_POST['id'] : '';

    //query to update the userprogress in the user task that have the same taskid and userid
    $stop = mysqli_query($conn, "UPDATE user_tasks SET user_progress = ADDTIME(user_progress, TIMEDIFF(CURRENT_TIME(), user_start)) WHERE user_taskid = '$id' && user_id = '$userid'");
    mysqli_query($conn, $stop);

}

elseif (isset($_POST['delete']))
{
    $id = isset($_POST['id']) ? $_POST['id'] : '';

    //query to delete task
    $delete = mysqli_query($conn, "DELETE FROM user_tasks WHERE user_taskid = '$id' && user_id = '$userid'");
    mysqli_query($conn, $delete);

}

//redirect the user to the dashboard or homepage
header("Location: ?page=home&clicked");
exit();

?>