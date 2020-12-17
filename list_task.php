<?php
    include('config/constants.php');

    //get list id from url

    $list_id_url = $_GET['list_id'];
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

            <div class="all_task">
                    
                    <a class="btn-primary" href="<?php echo SITEURL; ?>add_task.php">Add Task</a>

                    <table class="tbl-full">
                        <tr>
                            <th>S.N.</th>
                            <th>Task Name</th>
                            <th>Priority</th>
                            <th>Deadline</th>
                            <th>Actions</th>
                        </tr>
                        
                        <?php
                            //connect database
                            $conn = mysqli_connect(LOCALHOST, DB_USERNAME, DB_PASSWORD) or die(mysqli_error());

                            //select database
                            $db_select = mysqli_select_db($conn, DB_NAME) or die(mysqli_error());

                            //query to display task by list name
                            $sql = "SELECT * FROM tbl_tasks WHERE list_id=$list_id_url";

                            //execute the query
                            $res = mysqli_query($conn, $sql);

                            if($res==true)
                            {
                                //display the task based on list
                                $count_rows = mysqli_num_rows($res);

                                if($count_rows>0)
                                {
                                    //be have task on the list 
                                    while($row = mysqli_fetch_assoc($res))
                                    {
                                        $task_id = $row['task_id'];
                                        $task_name = $row['task_name'];
                                        $priority = $row['priority'];
                                        $deadline = $row['deadline'];
                                        ?>

                                        <tr>
                                            <td>1.</td>
                                            <td><?php echo $task_name; ?></td>
                                            <td><?php echo $priority; ?></td>
                                            <td><?php echo $deadline; ?></td>
                                            <td>
                                                <a href="<?php echo SITEURL;?>update_task.php?task_id=<?php echo $task_id; ?>">Update</a>
                                                <a href="<?php echo SITEURL;?>delete_task.php?task_id=<?php echo $task_id; ?>">Delete</a>
                                            </td>
                                        </tr>



                                        <?php
                                    }
                                }
                                else
                                {
                                    //no task on this list
                                    ?>

                                    <tr>
                                        <td colspan="5">NO task added on this list.</td>
                                    </tr>

                                    <?php
                                }
                            }
                        ?>
                        
                    </table>
            </div>
        </div>

    </body>
</html>