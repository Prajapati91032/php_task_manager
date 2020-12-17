<?php

    //include constants.php
    include('config/constants.php');


    //echo "delete list page"

    //to check whether the list_id is assigned or not
    if(isset($_GET['list_id']))
    {
        //Delete the list from database

        //get the list_id value from url or get method
        $list_id = $_GET['list_id'];

        //connect the database
        $conn = mysqli_connect(LOCALHOST, DB_USERNAME, DB_PASSWORD) or die(mysqli_error());

        //select the database
        $db_select = mysqli_select_db($conn,DB_NAME) or die(mysqli_error());

        //query to delete list from database
        $sql = "DELETE FROM tbl_lists WHERE list_id=$list_id";

        //execute the query
        $res = mysqli_query($conn, $sql);

        //check the query executed or not
        if($res==true)
        {
            //query executed sucessfully which means list is deleted sucessfull
            $_SESSION['delete'] = "List Deleted Sucessfully";

            //redirect to manage list page
            header('Location:'.SITEURL.'manage_list.php');
            
        }
        else
        {
            //Failed to delete list
            $_SESSION['delete_fail'] = "Failed to delete list.";

            //redirect to manage list page
            header('Location:'.SITEURL.'manage_list.php');
        }

    }
    else
    {
        //redirect to manage list page
        header('Location:'.SITEURL.'manage_list.php');
    }
    
    
    
?>