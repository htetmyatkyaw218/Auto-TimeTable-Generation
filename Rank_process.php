<?php
require 'conn.php';

if ($_POST['action'] == 'delete') {
    $rank = $_POST['rank'];
    
    // your delete SQL here
    $query = "DELETE FROM rank_db WHERE rank='$rank' ";
    $query_run = mysqli_query($con, $query);

    if($query_run)
    {
        header("Location: rank.php?status=del_success");
        exit(0);
    }
    else
     {
         header("Location: rank.php?status=del_unsuccess");
        exit(0);
    }
}

if(isset($_POST['update']))
{
    $rank = mysqli_real_escape_string($con, $_POST['rank']);
    $rank_code = mysqli_real_escape_string($con, $_POST['rank_code']);
	

    $query = "UPDATE rank_db SET rank='$rank'  WHERE rank_code='$rank_code' ";
    $query_run = mysqli_query($con, $query);

    if($query_run)
    {
        header("Location: rank.php?status=up_success");
        exit(0);
    }
    else
    {
        header("Location: rank.php?status=up_unsuccess");
        exit(0);
    }

}



if(isset($_POST['add']))
{
    $rank = $_POST['rank'];
    $rank_code = $_POST['rank_code'];

    $check_stmt = $con->prepare("SELECT rank FROM rank_db WHERE rank = ?");
    $check_stmt->bind_param("s", $rank);
    $check_stmt->execute();
    $result = $check_stmt->get_result();

    if ($result->num_rows === 0) {
        $insert_stmt = $con->prepare("INSERT INTO rank_db (rank, rank_code) VALUES (?, ?)");
        $insert_stmt->bind_param("ss", $rank, $rank_code);
        if ($insert_stmt->execute()) {
            header("Location: rank.php?status=success");
            exit;
        } //else {
        //     header("Location: Add_Rank.php?status=error");
        //     exit;
        // }
    } else {
        header("Location: Add_Rank.php?status=error");
        exit;
    }
}

?>
