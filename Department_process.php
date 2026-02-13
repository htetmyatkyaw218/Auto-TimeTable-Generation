<?php
require 'conn.php';

if ($_POST['action'] == 'delete') {
    $dept_code = $_POST['dept_code'];
    
    // your delete SQL here
    $query = "DELETE FROM department WHERE dept_code='$dept_code' ";
    $query_run = mysqli_query($con, $query);

    if($query_run)
    {
        header("Location: department.php?status=del_success");
        exit(0);
    }
    else
     {
          header("Location: department.php?status=del_unsuccess");
        exit(0);
    }
}

if(isset($_POST['update']))
{
    $dept_code = mysqli_real_escape_string($con, $_POST['dept_code']);
    $dept_name = mysqli_real_escape_string($con, $_POST['dept_name']);
	$dept_building = mysqli_real_escape_string($con, $_POST['dept_building']);

    $query = "UPDATE department SET dept_code='$dept_code', dept_name='$dept_name', dept_building='$dept_building' 
	WHERE dept_code='$dept_code' ";
    $query_run = mysqli_query($con, $query);

    if($query_run)
    {
        header("Location: department.php?status=up_success");
        exit(0);
    }
    else
    {
        header("Location: department.php?status=up_unsuccess");
        exit(0);
    }

}

if(isset($_POST['add']))
{
    $dept_code = $_POST['dept_code'];
    $dept_name = $_POST['dept_name'];
    $dept_building = $_POST['dept_building'];

    $check_stmt = $con->prepare("SELECT dept_code FROM department WHERE dept_code = ?");
    $check_stmt->bind_param("s", $dept_code);
    $check_stmt->execute();
    $result = $check_stmt->get_result();

    if ($result->num_rows === 0) {
        $insert_stmt = $con->prepare("INSERT INTO department (dept_code, dept_name, dept_building) VALUES (?, ?, ?)");
        $insert_stmt->bind_param("sss", $dept_code, $dept_name, $dept_building);
        if ($insert_stmt->execute()) {
            header("Location: department.php?status=success");
            exit;
        } else {
            header("Location: Add_department.php?status=error");
            exit;
        }
    } else {
        header("Location: Add_department.php?status=error");
        exit;
    }
}

?>