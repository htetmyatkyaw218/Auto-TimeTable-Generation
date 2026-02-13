<?php
session_start();
require_once __DIR__ . '/vendor/autoload.php';
session_start();

$mon1 = $_POST["mon1"];
//$break=$_POST['break'];
$mon2 = $_POST['mon2'];
$mon3 = $_POST['mon3'];

$tue1 = $_POST['tue1'];
//$break2=$_POST['break2'];
$tue2 = $_POST['tue2'];
$tue3 = $_POST['tue3'];

$wed1 = $_POST['wed1'];
//$break3=$_POST['break3'];
$wed2 = $_POST['wed2'];
$wed3 = $_POST['wed3'];

$thu1 = $_POST['thu1'];
//$break4=$_POST['break4'];
$thu2 = $_POST['thu2'];
$thu3 = $_POST['thu3'];

$fri1 = $_POST['fri1'];
//$break5=$_POST['break5'];
$fri2 = $_POST['fri2'];
$fri3 = $_POST['fri3'];

$t1 = $_POST['t1'];
$t2 = $_POST['t2'];
$t3 = $_POST['t3'];
$t4 = $_POST['t4'];



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

	<h2 align='center'>University  Timetable</h2>
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
$mpdf->SetDisplayMode('fullpage');
$mpdf->Output('Timetable.pdf', 'D');
session_destroy();
?>