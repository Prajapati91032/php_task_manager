<?php
    include('config/constants.php');

    //check the task id in url
    if(isset($_GET['task_id']))
    {
        //get the list id value
        $task_id =$_GET['task_id'];

        //connect to database
        $conn = mysqli_connect(LOCALHOST,DB_USERNAME, DB_PASSWORD) or die(mysqli_error());

        //select database
        $db_select = mysqli_select_db($conn, DB_NAME) or die(mysqli_error());

        //query to get the value from database
        $sql = "SELECT * FROM tbl_tasks WHERE task_id=$task_id";

        //execut the query
        $res = mysqli_query($conn, $sql);

        //check the query executed or not
        if($res==true)
        {
            //get the value from database
            $row = mysqli_fetch_assoc($res); //value is in array
            
            //printing row array
           // print_r($row);

           //creating individual variable to save the data
           $task_name = $row['task_name'];
           $task_description = $row['task_description'];
           $list_id = $row['list_id'];
           $priority = $row['priority'];
           $deadline = $row['deadline'];
        }
        else
        {
            //go back to manage list page
            header('Location:'.SITEURL);
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Task manager</title>
        <link rel="stylesheet" href="<?php echo SITEURL; ?>css/style.css">
    </head>
    <body>
        <div class="wrapper">
            <h1>Task Manager</h1>

            <p>
                <a class="btn-secondry" href="<?php echo SITEURL; ?>">Home</a>
            </p>

            <h3>Update Task Page</h3>

            <p>
                <?php 
                    //check session
                    if(isset($_SESSION['update_fail']))
                    {
                        echo $_SESSION['update_fail'];
                        unset($_SESSION['update_fail']);
                    }
                ?>
            </p>

            <form action="" method="POST">

                <table class="tbl-half">
                    <tr>
                        <td>Task Name: </td>
                        <td><input type="text" name="task_name" value="<?php echo $task_name; ?>" required = "required"></td>
                    </tr>

                    <tr>
                        <td>Task Description: </td>
                        <td><textarea name="task_description">
                            <?php echo $task_description; ?>
                        </textarea></td>
                    </tr>

                    <tr>
                        <td>Select List: </td>
                        <td>
                            <select name="list_id" >

                                <?php
                                    //connect database
                                    $conn2 = mysqli_connect(LOCALHOST, DB_USERNAME, DB_PASSWORD) or die(mysqli_error());

                                    //select database
                                    $db_select2 = mysqli_select_db($conn2, DB_NAME) or die(mysqli_error());

                                    //sql query to get list
                                    $sql2 = "SELECT * FROM tbl_lists";

                                    //execute the querry
                                    $res2 = mysqli_query($conn2, $sql2);

                                    //check if query execut5ed or not
                                    if($res==true)
                                    {
                                        //Display the list
                                        //count rows
                                        $count_rows2 = mysqli_num_rows($res2);

                                        //check wheather list is added or not
                                        if($count_rows2>0)
                                        {
                                            //lists are added 
                                            while($row2=mysqli_fetch_assoc($res2))
                                            {
                                                //individual list value
                                                $list_id_db = $row2['list_id'];
                                                $list_name = $row2['list_name'];
                                                ?>
                                                <option <?php if($list_id_db==$list_id) {echo "selected='selected'";}?>value="<?php echo $list_id_db; ?>"><?php echo $list_name;?></option>
                                                <?php
                                            }
                                        }
                                        else
                                        {
                                            //No list added
                                            ?>
                                            <option <?php if($list_id=0) {echo "selected='selected'";}?>value="0">None</option>
                                            <?php
                                        }
                                    }
                                ?>
                                
                            </select>
                        </td>
                    </tr>

                    <tr>
                        <td>Priority: </td>
                        <td>
                            <select name="priority">
                                <option <?php if($priority=="High") {echo "selected='selected'";} ?>value="High">High</option>
                                <option <?php if($priority=="Medium") {echo "selected='selected'";} ?>value="Medium">Medium</option>
                                <option <?php if($priority=="Low") {echo "selected='selected'";} ?>value="Low">Low</option>
                            </select>
                        </td>
                    </tr>

                    <tr>
                        <td>Deadline: </td>
                        <td><input type="date" name="deadline" value="<?php echo $deadline; ?>"></td>
                    </tr>

                    <tr>
                        <td><input class="btn-primary btn-lg" type="submit" name="submit" value="update"></td>
                    </tr>

                </table>
            </form>
        </div>

            
    </body>
</html>

<?php
    //check if the button is clicked
    if(isset($_POST['submit']))
    {
        //echo "Clicked";
        
        //get the values from from
        $task_name = $_POST['task_name'];
        $task_description = $_POST['task_description'];
        $list_id = $_POST['list_id'];
        $priority = $_POST['priority'];
        $deadline = $_POST['deadline'];

        //connect the database
        $conn3 = mysqli_connect(LOCALHOST, DB_USERNAME, DB_PASSWORD) or die(mysqli_error());

        //select database
        $db_select3 = mysqli_select_db($conn3, DB_NAME) or die(mysqli_error());

        //sql query
        $sql3 = "UPDATE tbl_tasks SET
            task_name = '$task_name',
            task_description = '$task_description',
            list_id = '$list_id',
            priority = '$priority',
            deadline = '$deadline'
            WHERE task_id= $task_id
        ";

        //execute query
        $res3 = mysqli_query($conn3, $sql3);

        //check whwther the querry executed or not
        if($res3==true)
        {
            //query executed
            $_SESSION['update'] = "Task updated sucessfully.";

            //redirect to home page
            header('Location:'.SITEURL);
        }
        else
        {
            //faild to update
            $_SESSION['update_fail'] = "Failed to update task.";

            //redirect to home page
            header('Location:'.SITEURL.'update_task.php?task_id='.$task_id);
        }

    }
?>