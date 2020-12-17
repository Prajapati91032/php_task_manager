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

            <!-- Menu Start here-->
            <div class="menu">
                <a href="<?php echo SITEURL; ?>">Home</a>

                <?php
                    //displaying lists from database in menu 
                    $conn2 = mysqli_connect(LOCALHOST, DB_USERNAME, DB_PASSWORD) or die(mysqli_error());

                    //select database
                    $db_select2 = mysqli_select_db($conn2, DB_NAME) or die(mysqli_error());

                    //sql query to get the list from database
                    $sql2 = "SELECT * FROM tbl_lists";

                    //execute query 
                    $res2 = mysqli_query($conn2, $sql2);

                    //check query is executed or not
                    if($res2 == true)
                    {
                        //Display the list in menu
                        while($row2 = mysqli_fetch_assoc($res2))
                        {
                            //get list name list id
                            $list_id = $row2['list_id'];
                            $list_name = $row2['list_name'];
                            ?>

                            <a href="<?php echo SITEURL; ?>list_task.php?list_id=<?php echo $list_id; ?>"><?php echo $list_name; ?></a>

                            <?php
                        }
                    }
                ?>

                
                <a href="<?php echo SITEURL; ?>manage_list.php">Manage Lists</a>
            </div>
            <!-- Menu End here-->

            <!--Task Start here-->

            <p>
                <?php
                    //check session
                    if(isset($_SESSION['add']))
                    {
                        echo $_SESSION['add'];
                        unset($_SESSION['add']);
                    }

                    if(isset($_SESSION['delete']))
                    {
                        echo $_SESSION['delete'];
                        unset($_SESSION['delete']);
                    }

                    if(isset($_SESSION['update']))
                    {
                        echo $_SESSION['update'];
                        unset($_SESSION['update']);
                    }
                    
                    if(isset($_SESSION['delete_fail']))
                    {
                        echo $_SESSION['delete_fail'];
                        unset($_SESSION['delete_fail']);
                    }

                ?>
            </p>
            <div class="all_tasks">
                <a class="btn-primary" href="<?php SITEURL; ?>add_task.php">Add Tasks</a>
                <table class="tbl-full">

                    <tr>
                        <th>S.N</th>
                        <th>Task Name</th>
                        <th>Priority</th>
                        <th>Deadline</th>
                        <th>Actions</th>
                    </tr>

                    <?php
                        //connect database
                        $conn =mysqli_connect(LOCALHOST, DB_USERNAME, DB_PASSWORD) or die(mysqli_error());

                        //select database
                        $db_select = mysqli_select_db($conn, DB_NAME) or die(mysqli_error());

                        //sql query to get data from database
                        $sql = "SELECT * FROM tbl_tasks";

                        //execute the query
                        $res = mysqli_query($conn, $sql);

                        //check wheather the query executed or not
                        if($res==true)
                        {
                            //display the task from data base
                            //count task from database
                            $count_rows = mysqli_num_rows($res);

                            //create variable for searial no.
                            $sn=1;

                            //Check wheather there is task in database or not
                            if($count_rows>0)
                            {
                                //data is in database
                                while($row=mysqli_fetch_assoc($res))
                                {
                                    $task_id = $row['task_id'];
                                    $task_name = $row['task_name'];
                                    $priority = $row['priority'];
                                    $deadline = $row['deadline'];
                                    ?>

                                    <tr>
                                        <td><?php echo $sn++;?></td>
                                        <td><?php echo $task_name;?></td>
                                        <td><?php echo $priority;?></td>
                                        <td><?php echo $deadline;?></td>
                                        <td>
                                            <a class="btn-update" href="<?php echo SITEURL;?>update_task.php?task_id=<?php echo $task_id; ?>">Update</a>
                                            <a class="btn-delete" href="<?php echo SITEURL;?>delete_task.php?task_id=<?php echo $task_id; ?>">Delete</a>
                                        </td>
                                    </tr>


                                    <?php
                                }
                            }
                            else
                            {
                                //no data in database
                                ?>
                                
                                <tr>
                                    <td colspan="5">No Task Added Yet.</td>
                                </tr>
                                <?php
                            }
                        }
                    ?>

                    

                </table> 
            </div>
            <!--Task End here-->
        </div>
    </body>
</html>