<?php
    include('config/constants.php');

    //check task id in url
    if(isset($_GET['task_id']))
    {
        //delete the task from database

        //get the task id
        $task_id = $_GET['task_id'];

        //connect database
        $conn = mysqli_connect(LOCALHOST, DB_USERNAME, DB_PASSWORD) or die(mysqli_error());

        //select database
        $db_select = mysqli_select_db($conn, DB_NAME) or die(mysqli_error());

        //sql query to delete task
        $sql = "DELETE FROM tbl_tasks WHERE task_id= $task_id";

        //execut the query
        $res = mysqli_query($conn, $sql);

        //check if the query executed or not
        if($res==true)
        {
            //query executed successfully and task deleted
            $_SESSION['delete'] = "Task deleted successfully";

            //redrict to home page
            header('Location:'.SITEURL);
        }
        else
        {
            //faild to delete task
            $_SESSION['delete_fail'] = "Fail to delete task";

            //redrict to home page
            header('Location:'.SITEURL);
        }
    }
    else
    {
        //redirect to home page
        header('Location:'.SITEURL);
    }
?>