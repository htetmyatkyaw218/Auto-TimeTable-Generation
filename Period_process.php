<?php
require 'conn.php';

if ($_POST['action'] == 'delete') {
    $pid = $_POST['pid'];
    
    // your delete SQL here
    $query = "DELETE FROM period WHERE pid='$pid' ";
    $query_run = mysqli_query($con, $query);

    if($query_run)
    {
        header("Location: period.php?status=del_success");
        exit(0);
    }
    else
     {
          header("Location: period.php?status=del_unsuccess");
        exit(0);
    }
}

if(isset($_POST['update']))
{
    $pid = mysqli_real_escape_string($con, $_POST['pid']);
    $acdyear = mysqli_real_escape_string($con, $_POST['acdyear']);
    $semester = mysqli_real_escape_string($con, $_POST['semester']);
    $pday = mysqli_real_escape_string($con, $_POST['pday']);
    $subweek = mysqli_real_escape_string($con, $_POST['subweek']);

    if($subweek != null){

    $query = "UPDATE period SET acdyear='$acdyear', semester='$semester', periodperday='$pday', subperweek='$subweek' 
	WHERE pid='$pid' ";
    $query_run = mysqli_query($con, $query);

    if($query_run)
    {
        header("Location: period.php?status=up_success");
        exit(0);
    }
    else
    {
        header("Location: Period_Update.php?status=error");
        exit(0);
    }
    
    }else{

    header("Location: Period_Update.php?status=error&pid=$pid");
        exit(0);   
}
}

if(isset($_POST['add']))
{
    $acdyear = mysqli_real_escape_string($con, $_POST['acdyear']);
    $semester = mysqli_real_escape_string($con, $_POST['semester']);
    $pday = mysqli_real_escape_string($con, $_POST['pday']);
    $subweek = mysqli_real_escape_string($con, $_POST['subweek']);

    $check_stmt = $con->prepare("SELECT acdyear,semester FROM period WHERE acdyear = ? and semester = ?");
    $check_stmt->bind_param("ss", $acdyear,$semester);
    $check_stmt->execute();
    $result = $check_stmt->get_result();

    if ($result->num_rows === 0) {
        $insert_stmt = $con->prepare("INSERT INTO period (subperweek, periodperday, acdyear,semester) VALUES (?, ?, ?, ?)");
        $insert_stmt->bind_param("ssss", $subweek, $pday, $acdyear ,$semester);
        if ($insert_stmt->execute()) {
            header("Location: period.php?status=success");
            exit;
        } else {
            header("Location: Add_Period.php?status=error");
            exit;
        }
    } else {
        header("Location: Add_Period.php?status=error");
        exit;
    }
}

?>