<?php
    include('config/constants.php');

    //get the current values of selected list
    if(isset($_GET['list_id']))
    {
        //get the list id value
        $list_id =$_GET['list_id'];

        //connect to database
        $conn = mysqli_connect(LOCALHOST,DB_USERNAME, DB_PASSWORD) or die(mysqli_error());

        //select database
        $db_select = mysqli_select_db($conn, DB_NAME) or die(mysqli_error());

        //query to get the value from database
        $sql = "SELECT * FROM tbl_lists WHERE list_id=$list_id";

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
           $list_name = $row['list_name'];
           $list_description = $row['list_description'];
        }
        else
        {
            //go back to manage list page
            header('Location:'.SITEURL.'manage_list.php');
        }
    }
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

            <div class="menu">
                <a href="<?php echo SITEURL;?>">Home</a>
                <a href="<?php echo SITEURL;?>manage_list.php">Manage Lists</a>
            </div>

            <h3>Update List Page</h3>

            <p>
                <?php
                    //Check whether the session is set or not
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
                        <td>List Name: </td>
                        <td><input type="text" name="list_name" value="<?php echo $list_name; ?>" required="required"></td>
                    </tr>

                    <tr>
                        <td>List Description: </td>
                        <td>
                            <textarea name="list_description">   
                                <?php echo $list_description; ?>         
                            </textarea>
                        </td>
                    </tr>

                    <tr>
                        <td><input class="btn-primary btn-lg" type="submit" value="update" name="submit"></td>
                    </tr>
                </table>
            </form>
        </div>
    </body>
</html>


<?php 
    //checked the update button is clicked or not
    if(isset($_POST['submit']))
    {
        //echo "button clicked";

        //get the updated values from form
        $list_name = $_POST['list_name'];
        $list_description = $_POST['list_description'];

        //connect database
        $conn2 = mysqli_connect(LOCALHOST, DB_USERNAME, DB_PASSWORD) or die(mysqli_error());

        //select the database
        $db_select2 = mysqli_select_db($conn2, DB_NAME) or die(mysqli_error());

        //query to update list
        $sql2 = "UPDATE tbl_lists SET 
            list_name = '$list_name',
            list_description = '$list_description'
            WHERE list_id = '$list_id'
        ";

        //execute the query
        $res2 = mysqli_query($conn2, $sql2);

        //check the query executed or not
        if($res2==true)
        {
            //update sucessfully
            $_SESSION['update'] = "List Updated Sucessfully";

            //redirect to manage list page
            header('Location:'.SITEURL.'manage_list.php');
        }
        else
        {
            //failed to update
            $_SESSION['update_fail'] = "Failed to update list";

            //redirect to update list page
            header('Location:'.SITEURL.'update_list.php?list_id='.$list_id);
        }

    }
?>