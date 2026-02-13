<?php
require 'conn.php';
session_start();
if (isset($_POST['search'])) {
    $acdyear = mysqli_real_escape_string($con, $_POST['acdyear']);
    $semester = mysqli_real_escape_string($con, $_POST['semester']);
    $year_name = mysqli_real_escape_string($con, $_POST['year_name']);
    $section_name = mysqli_real_escape_string($con, $_POST['section_name']);

    // Get year_id
    $stmt = $con->prepare("SELECT year_id FROM year WHERE acdyear = ? AND semester = ? AND year_name = ?");
    $stmt->bind_param("sss", $acdyear, $semester, $year_name);
    $stmt->execute();
    $year_id = $stmt->get_result()->fetch_assoc()['year_id'];

    // Get section_id
    $stmt = $con->prepare("SELECT section_id FROM section WHERE section_name = ?");
    $stmt->bind_param("s", $section_name);
    $stmt->execute();
    $section_id = $stmt->get_result()->fetch_assoc()['section_id'];

    // Check if teaches_id exists for the year and section
    $check_stmt = $con->prepare("SELECT teaches_id FROM teaches WHERE year_id = ? AND section_id = ?");
    $check_stmt->bind_param("ss", $year_id, $section_id);
    $check_stmt->execute();
    $result_teaches = $check_stmt->get_result();

    if ($result_teaches->num_rows > 0) {
        // Already assigned

        // Check if this timetable already exists
        $stmt = $con->prepare("SELECT section_id, year_id FROM timetable WHERE section_id = ? AND year_id = ?");
        $stmt->bind_param("ii", $section_id, $year_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            header("Location: Auto.php?status=have_error");
            exit;
        } else {
            header("Location: Auto_search.php?year_id=$year_id&acdyear=$acdyear&year_name=$year_name&semester=$semester&section_name=$section_name");
            exit;
        }
    } else {
        // not assigned
        header("Location: Auto.php?status=error");
        exit;
    }
}

if (isset($_POST['print'])) {

    
    require_once __DIR__ . '/vendor/autoload.php'; // Make sure this file exists (via Composer)

    // Get session data
    $acd_year = $_SESSION['acdyear'];
    $semester_name = $_SESSION['semester'];
    $year = $_SESSION['year_name'];
    $sec_name = $_SESSION['section_name'];

    // Get POST data
    $mon1 = $_POST["mon1"];
    $mon2 = $_POST["mon2"];
    $mon3 = $_POST["mon3"];

    $tue1 = $_POST["tue1"];
    $tue2 = $_POST["tue2"];
    $tue3 = $_POST["tue3"];

    $wed1 = $_POST["wed1"];
    $wed2 = $_POST["wed2"];
    $wed3 = $_POST["wed3"];

    $thu1 = $_POST["thu1"];
    $thu2 = $_POST["thu2"];
    $thu3 = $_POST["thu3"];

    $fri1 = $_POST["fri1"];
    $fri2 = $_POST["fri2"];
    $fri3 = $_POST["fri3"];

    $t1 = $_POST["t1"];
    $t2 = $_POST["t2"];
    $t3 = $_POST["t3"];
    $t4 = $_POST["t4"];

    // Initialize HTML string
$data .= "<!DOCTYPE html>
<html>

<head>
    <title>Timetable</title>
    
</head>

<body>
<!--mpdf
<htmlpagefooter name='myfooter'>
<div style='border-top: 1px solid #000000; font-size: 9pt; text-align: center; padding-top: 3mm; '>
Page {PAGENO} of {nb}
</div>
</htmlpagefooter>

<sethtmlpageheader name='myheader' value='on' show-this-page='1' />
<sethtmlpagefooter name='myfooter' value='on' />
mpdf-->

    <h2 align='center'>University of Computer Studies (Pathein) Timetable</h2>
    <h2 align='center'>$acd_year Academic Year</h2>
    <h2 align='center'>$year</h2>
    <h2 align='center'>$semester_name</h2>
    <h2 align='center'>Section - $sec_name</h2>
    <table border='1' cellspacing='0' align='center'>
            <tbody><tr>
            <td align='center' width='150'><br>
            <b>Period</b></br>
        </td>
        <td align='center' width='150'>
            <b>I</b>
        </td>
        <td align='center' width='150'>
            <b>Break</b>
        </td>
        <td align='center' width='150'>
            <b>II</b>
        </td>
        <td align='center' width='150'>
            <b>III</b>
        </td>
    </tr>
    <tr>
                <td align='center' height='10'>
                    <b>Day/Time</b>
                </td>
                <td align='center' height='10'>$t1</td>
                <td align='center' height='10'>$t2</td>
                <td align='center' height='10'>$t3</td>
                <td align='center' height='10'>$t4</td>
            </tr>
            <tr>
                <td align='center' height='10'>
                    <b>Monday</b>
                </td>
                <td align='center' height='10'>$mon1 </td>
                <td rowspan='6' align='center' height='50'>
                    <h2>L<br>U<br>N<br>C<br>H</h2>
                </td>
                <td align='center' height='10'>$mon2</td>
                <td align='center' height='10'>$mon3</td>
            </tr>
            <tr>
                <td align='center' height='10'>
                    <b>Tuesday</b>
                </td>
                <td align='center' height='10'>$tue1</td>
                <td align='center' height='10'>$tue2</td>
                <td align='center' height='10'>$tue3</td>
            </tr>
            <tr>
            <td align='center' height='10'>
                    <b>Wednesday</b>
                </td>
                <td align='center' height='10'>$wed1</td>
                <td align='center' height='10'>$wed2</td>
                <td align='center' height='10'>$wed3</td>
            </tr>
            <tr>
            <td align='center' height='10'>
                    <b>Thursday</b>
                </td>
                <td align='center' height='10'>$thu1</td>
                <td align='center' height='10'>$thu2</td>
                <td align='center' height='10'>$thu3</td>
            </tr>
            <tr>
            <td align='center' height='10'>
                    <b>Friday</b>
                </td>
                <td align='center' height='10'>$fri1</td>
                <td align='center' height='10'>$fri2</td>
                <td align='center' height='10'>$fri3</td>
            </tr>
            </tbody>
            </table>
            </body>
            </html>";

$mpdf = new \Mpdf\Mpdf();
$mpdf->WriteHTML($data);
$mpdf->WriteHTML('<table cellpadding=10 cellspacing=1 align="left">
            <tr><td id=head><strong>Subject Code</td>
            <td id=head><strong>Subject Name</strong></td>
            <td id=head><strong>Teacher Name</strong></td></tr>');

    $tname = $_SESSION['TeacherList'];
    $i = 0;

    foreach ($_SESSION['SubjectList'] as $subject) {
        $scode = htmlspecialchars($subject['scode']);
        $sname = htmlspecialchars($subject['sname']);
        $teacher = isset($tname[$i]) ? htmlspecialchars($tname[$i]) : "****";
        $mpdf->WriteHTML("<tr><td>$scode</td><td>$sname</td><td>$teacher</td></tr>");
        $i++;
    }

    $mpdf->WriteHTML('</table>');
    $mpdf->SetDisplayMode('fullpage');
    $mpdf->Output('Timetable.pdf', 'D'); // download the file
    session_destroy();
}

if (isset($_POST['save'])) {
    $acdyear      = trim($_SESSION['acdyear']);
    $semester     = trim($_SESSION['semester']);
    $year_name    = trim($_SESSION['year_name']);
    $section_name = trim($_SESSION['section_name']);

    // Get year_id
    $stmt = $con->prepare("SELECT year_id FROM year WHERE acdyear = ? AND semester = ? AND year_name = ?");
    $stmt->bind_param("sss", $acdyear, $semester, $year_name);
    $stmt->execute();
    $result = $stmt->get_result();
    $year_id = $result->fetch_assoc()['year_id'];

    // Get section_id
    $stmt = $con->prepare("SELECT section_id FROM section WHERE section_name = ?");
    $stmt->bind_param("s", $section_name);
    $stmt->execute();
    $result = $stmt->get_result();
    $section_id = $result->fetch_assoc()['section_id'];

    // Check if this timetable already exists
    $stmt = $con->prepare("SELECT section_id, year_id FROM timetable WHERE section_id = ? AND year_id = ?");
    $stmt->bind_param("ii", $section_id, $year_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
         header("Location: Auto_generate.php?status=error");
        exit;
    } else {
       
        // Timetable exists, update
        $days = ['mon', 'tue', 'wed', 'thu', 'fri'];

        foreach ($days as $d) {
            $p1 = $_POST["{$d}1"] ?? '';
            $p2 = $_POST["{$d}2"] ?? '';
            $p3 = $_POST["{$d}3"] ?? '';
            $dayFull = ucfirst($d) . "day";

            $sql = "INSERT INTO timetable (day, period1, period2, period3, section_id, year_id)
                    VALUES (?, ?, ?, ?, ?, ?)
                    ON DUPLICATE KEY UPDATE period1=?, period2=?, period3=?";
            
            $stmt = $con->prepare($sql);
            $stmt->bind_param("ssssiisss", $dayFull, $p1, $p2, $p3, $section_id, $year_id, $p1, $p2, $p3);
            $stmt->execute();
        }
        header("Location: Auto_generate.php?status=success");
        exit;
    }
}
session_destroy();
?>