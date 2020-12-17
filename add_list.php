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
            <a class="btn-secondry" href="<?php echo SITEURL; ?>manage_list.php">Manage Lists</a>

            <h3>Add List Page</h3>

            <p>
                <?php
                    //Check whether the session is created or not
                    if(isset($_SESSION['add_fail']))
                    {
                        //Display Session Message
                        echo $_SESSION['add_fail'];
                        //Reamove the message after sowing once
                        unset($_SESSION['add_fail']);
                    }
                ?>
            </p>

            <!--Form to add list start here-->

            <form action="" method="post">

                <table class="tbl-half">
                    <tr>
                        <td>List Name: </td>
                        <td><input type="text" name="list_name" placeholder="Type List Name" required="required"></td>
                    </tr>

                    <tr>
                        <td>List Description: </td>
                        <td><textarea name="list_description" placeholder="Type List Description"></textarea></td>
                    </tr>

                    <tr>
                        <td><input class="btn-primary btn-lg" type="submit" name="submit" value="Save"></td>
                    </tr>
                </table>

            </form>    
            
            <!--Form to add list end here-->
        </div>
    </body>
</html>

<?php

    //Check Whether a form is submitted or not
    if(isset($_POST{'submit'}))
    {
        //echo "Form Submitted";

        // get the values from and save it in variable
        $list_name = $_POST{'list_name'};
        $list_description = $_POST{'list_description'};

        //Connect Database
        $conn = mysqli_connect(LOCALHOST,DB_USERNAME, DB_PASSWORD) or die(mysqli_error());

        //check database connected or not
        /*
        if($conn == true)
        {
            echo "Database Connected";
        }*/

        //select database
        $db_select = mysqli_select_db ($conn, DB_NAME);

        //check database connected or not
        /*if($db_select==true)
        {
            echo "database selected";
        }*/

        //sql querry to insert data into database

        $sql = "INSERT INTO tbl_lists SET 
            list_name = '$list_name',
            list_description = '$list_description'
        ";

        //Execute querry and insert into database

        $res = mysqli_query($conn, $sql);

        //check querry executes or not
        if($res==true)
        {
            //echo "Data inserted";

            //Crearing a session variable to display message
            $_SESSION['add'] = "List Added Successfully";

            //redirect to Manage list page

            header('location:'.SITEURL.'manage_list.php');
                        
        }
        else
        {
            echo "Faild to insert data";

            //Crearing a session variable to display message
            $_SESSION['add_fail'] = "Faild To Add List";

            //redirect to same page
            header('location:'.SITEURL.'add_list.php');
        }
    }
   

?>