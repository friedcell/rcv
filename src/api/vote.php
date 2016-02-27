<?php
require_once("config.php");

$errors = array();
$data = array();
// Getting posted data and decodeing json
$_POST = json_decode(file_get_contents('php://input'), true);

// checking for blank values.
if (empty($_POST['ballot_id']))
	$errors['ballot_id'] = 'Ballot ID is required.';

if (empty($_POST['vote']))
	$errors['vote'] = 'Vote is required.';

if (!empty($errors)) {
	$data['errors']  = $errors;
	$data['post'] = $_POST;
	echo json_encode($data);
} else {
	$query = "
		INSERT INTO 
			votes (`ballot_id`, `vote`, `ip_address`)
		VALUES 
			(". $_POST['ballot_id'] .",'". $_POST['vote'] ."','". $_SERVER['REMOTE_ADDR'] ."');";
	$sth = $dbh->prepare($query);
	$sth->execute();
}
?>