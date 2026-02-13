<?php
require 'conn.php';

if ($_POST['action'] == 'delete') {
    $teacher_id = $_POST['teacher_id'];
    
    // your delete SQL here
    $query = "DELETE FROM teacher WHERE teacher_id='$teacher_id' ";
    $query_run = mysqli_query($con, $query);

    if($query_run)
    {
        header("Location: teacher.php?status=del_success");
        exit(0);
    }
    else
     {
         $_SESSION['message'] = "Deleted Unsuccessfully";
         header("Location:teacher.php?status=del_unsuccess");
         exit(0);
    }
}

if(isset($_POST['update']))
{
    $teacher_id = mysqli_real_escape_string($con, $_POST['teacher_id']);
    $tname = mysqli_real_escape_string($con, $_POST['tname']);
    $rank = mysqli_real_escape_string($con,$_POST['rank'] );
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $ph_no = mysqli_real_escape_string($con, $_POST['ph_no']);
    $address = mysqli_real_escape_string($con, $_POST['address']);
    $dept_code = mysqli_real_escape_string($con,$_POST['dept_code']);

     $query = "UPDATE teacher SET tname='$tname', rank='$rank', email='$email' , ph_no='$ph_no' , address='$address' , dept_code='$dept_code'
    WHERE teacher_id='$teacher_id' ";
    $query_run = mysqli_query($con, $query);

    if($query_run)
    {
        header("Location: teacher.php?status=up_success");
        exit(0);
    }
    else
    {
        header("Location: teacher.php?status=up_unsuccess");
        exit(0);
    }

}

if(isset($_POST['add']))
{
    $tname = mysqli_real_escape_string($con, $_POST['tname']);
    $rank = mysqli_real_escape_string($con,$_POST['rank'] );
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $ph_no = mysqli_real_escape_string($con, $_POST['ph_no']);
    $address = mysqli_real_escape_string($con, $_POST['address']);
    $dept_code = mysqli_real_escape_string($con,$_POST['dept_code']);

    $query = "INSERT INTO teacher (tname,rank,email,ph_no,address,dept_code) VALUES ('$tname','$rank','$email','$ph_no','$address','$dept_code')";
    $query_run = mysqli_query($con, $query);
    if($query_run)
        {
            header("Location: teacher.php?status=success");
            exit;
        } else {
            header("Location: Add_Teacher.php?status=error");
            exit;
        }
    
}

?>