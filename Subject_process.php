<?php
require 'conn.php';

if ($_POST['action'] == 'delete') {
    $sub_id = $_POST['sub_id'];
    
    // your delete SQL here
    $query = "DELETE FROM subject WHERE sub_id='$sub_id' ";
    $query_run = mysqli_query($con, $query);

    if($query_run)
    {
        header("Location: subject.php?status=del_success");
        exit(0);
    }
    else
     {
         $_SESSION['message'] = "Deleted Unsuccessfully";
         header("Location: subject.php?status=del_unsuccess");
         exit(0);
    }
}

if (isset($_POST['update'])) {
    $acdyear = mysqli_real_escape_string($con, $_POST['acdyear']);
    $year_name = mysqli_real_escape_string($con, $_POST['year_name']);
    $semester = mysqli_real_escape_string($con, $_POST['semester']);

    if (!empty($acdyear) && !empty($semester) && !empty($year_name)) {
        $sql = "SELECT year_id FROM year WHERE acdyear = '$acdyear' AND semester = '$semester' AND year_name = '$year_name'";
        $result = $con->query($sql);

        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $year_id = $row['year_id'];
            }
        } 
    }
    $sub_id = mysqli_real_escape_string($con, $_POST['sub_id']);
    $scode = mysqli_real_escape_string($con, $_POST['scode']);
    $sname = mysqli_real_escape_string($con, $_POST['sname']);
    $pre_requisite = mysqli_real_escape_string($con, $_POST['pre_requisite']);
    $credit_unit = mysqli_real_escape_string($con, $_POST['credit_unit']);
    $type = mysqli_real_escape_string($con, $_POST['type']);
    $dept_code = mysqli_real_escape_string($con, $_POST['dept_code']);
    $degree_type = mysqli_real_escape_string($con, $_POST['degree']);

    $query = "UPDATE subject 
          SET scode='$scode',sname='$sname',year_id='$year_id', pre_requisite='$pre_requisite', 
                    credit_unit='$credit_unit', type='$type', dept_code='$dept_code', degree_type='$degree_type' 
                    WHERE sub_id='$sub_id'";

    $query_run = mysqli_query($con, $query);

    if($query_run)
    {
        header("Location: subject.php?status=up_success");
        exit(0);
    }
    else
    {
        header("Location: subject.php?status=up_unsuccess");
        exit(0);
    }

}

if (isset($_POST['add'])) {
    $acdyear = mysqli_real_escape_string($con, $_POST['acdyear']);
    $year_name = mysqli_real_escape_string($con, $_POST['year_name']);
    $semester = mysqli_real_escape_string($con, $_POST['semester']);

    if (!empty($acdyear) && !empty($semester) && !empty($year_name)) {
        $sql = "SELECT year_id FROM year WHERE acdyear = '$acdyear' AND semester = '$semester' AND year_name = '$year_name'";
        $result = $con->query($sql);

        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $year_id = $row['year_id'];
            }
        } 
    }

    $scode = mysqli_real_escape_string($con, $_POST['scode']);
    $sname = mysqli_real_escape_string($con, $_POST['sname']);
    $pre_requisite = mysqli_real_escape_string($con, $_POST['pre_requisite']);
    $credit_unit = mysqli_real_escape_string($con, $_POST['credit_unit']);
    $type = mysqli_real_escape_string($con, $_POST['type']);
    $dept_code = mysqli_real_escape_string($con, $_POST['dept_code']);
    $degree_type = mysqli_real_escape_string($con, $_POST['degree']);

    $sql = "INSERT INTO subject (scode, sname, year_id, pre_requisite, credit_unit, type, dept_code, degree_type)
            VALUES ('$scode', '$sname', '$year_id', '$pre_requisite', '$credit_unit', '$type', '$dept_code', '$degree_type')";

    $query_run = mysqli_query($con, $sql);

    if ($query_run) {
        header("Location: subject.php?status=success");
        exit;
    } else {
        header("Location: Add_Subject.php?status=error");
        exit;
    }
}

?>