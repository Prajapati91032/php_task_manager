<?php 
    include('config/constants.php');
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Task Manager</title>
        <link rel="stylesheet" href="<?php echo SITEURL; ?>css/style.css">
    </head>
    <body>
        <div class="wrapper">
            <h1>Task Manager</h1>

            <a class="btn-secondry" href="<?php echo SITEURL;?>">Home</a>

            <h3>Add Task Page</h3>

            <p>
                <?php
                    if(isset($_SESSION['add_fail']))
                    {
                        echo $_SESSION['add_fail'];
                        unset($_SESSION['add_fail']);
                    }
                ?>
            </p>

            <form action="" method="POST">

                <table class="tbl-half">

                    <tr>
                        <td>Task Name: </td>
                        <td><input type="text" name="task_name" placeholder="Enter Task Name" required="required"></td>
                    </tr>

                    <tr>
                        <td>Task Description: </td>
                        <td><textarea type="text" name="task_description" placeholder="Enter Task Discription"></textarea></td>
                    </tr>

                    <tr>
                        <td>Select List: </td>
                        <td>
                            <select name="list_id">

                                <?php
                                    //connect database
                                    $conn = mysqli_connect(LOCALHOST, DB_USERNAME, DB_PASSWORD) or die(mysqli_error());

                                    //select database
                                    $db_select = mysqli_select_db($conn, DB_NAME) or die(mysqli_error());

                                    //sql query to get the list from table
                                    $sql = "SELECT * FROM tbl_lists";

                                    //execute query
                                    $res = mysqli_query($conn, $sql);

                                    //check weather the sql query is executed or not
                                    if($res==true)
                                    {
                                        //Create a variable to count rows
                                        $count_rows = mysqli_num_rows($res);

                                        //if there is data in database than display in drop-down window 
                                        if($count_rows>0)
                                        {
                                            //display all lists in drop-down from database
                                            while($row=mysqli_fetch_assoc($res))
                                            {
                                                $list_id = $row['list_id'];
                                                $list_name = $row['list_name'];
                                                ?>
                                                <option value="<?php echo $list_id?>"><?php echo $list_name; ?></option>
                                                <?php
                                            }
                                        }
                                        else
                                        {
                                            //display none as option
                                            ?>
                                            <option value="0">None</option>
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
                                <option value="High">High</option>
                                <option value="Medium">Medium</option>
                                <option value="Low">Low</option>
                            </select>
                        </td>
                    </tr>

                    <tr>
                        <td>Deadline: </td>
                        <td><input type="date" name="deadline"></td>
                    </tr>

                    <tr>
                        <td><input class="btn-primary btn-lg" type="submit" name="submit" value="Save"></td>
                    </tr>
                </table>
            </form>
        </div>
    </body>
</html>

<?php
    //Check save button is clicked or not
    if(isset($_POST['submit']))
    {
        //echo 'Button Clicke';
        //get all the values from form
        $task_name = $_POST['task_name'];
        $task_description = $_POST['task_description'];
        $list_id = $_POST['list_id'];
        $priority = $_POST['priority'];
        $deadline = $_POST['deadline'];

        //connect database
        $conn2 = mysqli_connect(LOCALHOST,DB_USERNAME,DB_PASSWORD) or die(mysqli_error());

        //select database
        $db_select2 = mysqli_select_db($conn2,DB_NAME) or die(mysqli_error());

        //create sql query to insert data into database
        $sql2 = "INSERT INTO tbl_tasks SET
            task_name = '$task_name',
            task_description = '$task_description',
            list_id = '$list_id',
            priority = '$priority',
            deadline = '$deadline'
        "; 

        //execute query
        $res2 = mysqli_query($conn2, $sql2);

        //check wheather the query executed or not
        if($res2==true)
        {
            //display executed and task inserted successfully
            $_SESSION['add'] = "Task added successfully.";

            //redirect to home page
            header('Location:'.SITEURL);
        }
        else
        {
            //faild to add task
            $_SESSION['add_fail'] = "Failed to add task";

            //redirect to add task page
            header('Location:'.SITEURL.'add_task.php');
        }
    }
?>