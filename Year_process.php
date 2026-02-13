<?php
require 'conn.php';

if ($_POST['action'] == 'delete') {
    $year_id = $_POST['year_id'];
    
    // your delete SQL here
    $query = "DELETE FROM year WHERE year_id='$year_id' ";
    $query_run = mysqli_query($con, $query);

    if($query_run)
    {
        header("Location: year.php?status=del_success");
        exit(0);
    }
    else
     {
         header("Location: year.php?status=del_unsuccess");
        exit(0);
    }
}

if(isset($_POST['update']))
{   $year_id =mysqli_real_escape_string($con, $_POST['year_id']);
    $year_name = mysqli_real_escape_string($con, $_POST['year_name']);
    $acdyear = mysqli_real_escape_string($con, $_POST['acdyear']);
	$semester = mysqli_real_escape_string($con, $_POST['semester']);

    $query = "UPDATE year SET year_name='$year_name', acdyear='$acdyear', semester='$semester' 
	WHERE year_id='$year_id' ";
    $query_run = mysqli_query($con, $query);

    if($query_run)
    {
        header("Location: year.php?status=up_success");
        exit(0);
    }
    else
    {
        header("Location: year.php?status=up_unsuccess");
        exit(0);
    }

}

if(isset($_POST['add']))
{
    $year_name = $_POST['year_name'];
    $acdyear = $_POST['acdyear'];
    $semester = $_POST['semester'];

    $check_stmt = $con->prepare("SELECT year_name FROM year WHERE year_name = ?");
    $check_stmt->bind_param("s", $year_name);
    $check_stmt->execute();
    $result = $check_stmt->get_result();

    if ($result->num_rows === 0) {
        $insert_stmt = $con->prepare("INSERT INTO year (year_name, acdyear, semester) VALUES (?, ?, ?)");
        $insert_stmt->bind_param("sss", $year_name, $acdyear, $semester);
        if ($insert_stmt->execute()) {
            header("Location: year.php?status=success");
            exit;
        } else {
            header("Location: Add_year.php?status=error");
            exit;
        }
    } else {
        header("Location: Add_year.php?status=error");
        exit;
    }
}

?>