<?php
require 'conn.php';

if ($_POST['action'] == 'delete') {
    $section_id = $_POST['section_id'];
    
    // your delete SQL here
    $query = "DELETE FROM section WHERE section_id='$section_id' ";
    $query_run = mysqli_query($con, $query);

    if($query_run)
    {
        header("Location: section.php?status=del_success");
        exit(0);
    }
    else
     {
        header("Location: section.php?status=del_unsuccess");
        exit(0);
    }
}

if(isset($_POST['update']))
{
    $section_id = mysqli_real_escape_string($con, $_POST['section_id']);
    $section_name = mysqli_real_escape_string($con, $_POST['section_name']);

    $query = "UPDATE section SET section_name='$section_name'  WHERE section_id='$section_id' ";
    $query_run = mysqli_query($con, $query);

    if($query_run)
    {
        header("Location: section.php?status=up_success");
        exit(0);
    }
    else
    {
        header("Location: section.php?status=up_unsuccess");
        exit(0);
    }

}



if(isset($_POST['add']))
{
    $section_name = $_POST['section_name'];

    $check_stmt = $con->prepare("SELECT section_name FROM section WHERE section_name = ?");
    $check_stmt->bind_param("s", $section_name);
    $check_stmt->execute();
    $result = $check_stmt->get_result();

    if ($result->num_rows === 0) {
        $insert_stmt = $con->prepare("INSERT INTO section ( section_name) VALUES ( ?)");
        $insert_stmt->bind_param("s", $section_name);
        if ($insert_stmt->execute()) {
            header("Location: section.php?status=success");
            exit;
        } //else {
        //     header("Location: Add_Rank.php?status=error");
        //     exit;
        // }
    } else {
        header("Location: Add_Section.php?status=error");
        exit;
    }
}

?>