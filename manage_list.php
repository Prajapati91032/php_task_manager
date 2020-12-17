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

            <a class="btn-secondry" href="<?php echo SITEURL; ?>">Home</a>

            <h3>Manage Lists Page</h3>

            <p>
                <?php
                    //Check the session is set
                    if(isset($_SESSION['add']))
                    {
                        //display the message
                        echo $_SESSION['add'];
                        //remove the message
                        unset($_SESSION['add']);
                    }

                    //Check the session for delete
                    if(isset($_SESSION['delete']))
                    {
                        echo $_SESSION['delete'];
                        unset($_SESSION['delete']);
                    }

                    //check session message for update
                    if(isset($_SESSION['update']))
                    {
                        echo $_SESSION['update'];
                        unset($_SESSION['update']);
                    }

                    

                    //check for delete fail
                    if(isset($_SESSION['delete_fail']))
                    {
                        echo $_SESSION['delete_fail'];
                        unset($_SESSION['delete_fail']);
                    }
                ?>
            </p>
            <!-- Table to display lists start here-->
            <div class="all_lists">
                <a class="btn-primary" href="<?php echo SITEURL; ?>add_list.php">Add Lists</a>
                <table class="tbl-half">
                    <tr>
                        <th>S.N</th>
                        <th>List Name</th>
                        <th>Actions</th>
                    </tr>

                    <?php
                        //connect the database
                        $conn = mysqli_connect(LOCALHOST, DB_USERNAME, DB_PASSWORD) or die(mysqli_error());

                        //Select Database
                        $db_select = mysqli_select_db($conn, DB_NAME) or die(mysqli_error());

                        //sql query to display all data from dsatabase
                        $sql = "SELECT * FROM tbl_lists";

                        //execute the query
                        $res = mysqli_query($conn, $sql);

                        //check whether the query is executed or not
                        if($res==true)
                        {
                            // work on displaying data
                            // echo "Executed";

                            //count the rows of data in database
                            $count_rows = mysqli_num_rows($res);

                            //Create a searial number variable
                            $sn =1;

                            //Check whether there is data or not
                            if($count_rows>0)
                            {
                                //There data in database display in table

                                while($row = mysqli_fetch_assoc($res))
                                {
                                    //geting the data from database

                                    $list_id = $row['list_id'];
                                    $list_name = $row['list_name'];
                                    ?>

                                    <tr>
                                        <td><?php echo $sn++; ?></td>
                                        <td><?php echo $list_name; ?></td>
                                        <td>
                                            <a class="btn-update" href="<?php echo SITEURL; ?>update_list.php?list_id=<?php echo $list_id; ?>">Update</a>
                                            <a class="btn-delete" href="<?php echo SITEURL; ?>delete_list.php?list_id=<?php echo $list_id; ?>">Delete</a>
                                        </td>
                                    </tr>


                                    <?php
                                }

                            }
                            else
                            {
                                //there is no data in database
                                ?>

                                <tr>
                                    <td colspan="3">No List Added Yet.</td>
                                </tr>


                                <?php
                            }
                        }
                    ?>



                    
                </table>
            </div>
            <!-- Table to display lists end here-->
        </div>

    </body>
</html>