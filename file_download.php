<?php
define('DMCCMS', 1);
require_once('load.php');
Load::loadApplication();

$id = $_GET['id'];

$logDBConn = new MeekroDB(CFG::$loghost, CFG::$loguser, CFG::$logpassword, CFG::$logdb);
$data = $logDBConn->queryFirstRow("SELECT id,from_email,to_email,from_name,to_name,subject,attachments,post_data,mail_body,send_date FROM " . CFG::$tblPrefix . "mailbox WHERE id=%d ", $id);
/*pre($_SESSION);
pre($data,1);*/
if(!empty($data['post_data'])) {
	$postData = json_decode($data['post_data'], true);
	$arraKey = array_keys($postData);

	if(in_array("createFreightCostReportPdf",$arraKey)) {
		$arrayKey = "createFreightCostReportPdf";
	} else {
		$arrayKey = $arraKey[0];
	}

	$_SESSION[$arrayKey] = $postData[$arrayKey];

}

$attachment = json_decode($data['attachments']);
$filePath = $attachment[0];
//pre($filePath,1);

header("Location:" . $filePath);
exit;
?>