<?php
header('Content-Type: application/json');

require_once('spoj.php');
try {
    $json = file_get_contents('php://input');
    $obj = json_decode($json, true);
    $id = $obj['id'];

    $stmt = $spoj->prepare("DELETE FROM komentar WHERE id=:kom_id");
    $stmt->bindParam(':kom_id', $id);
    $stmt->execute();

    echo json_encode(array('status' => 1));

} catch(Exception $e) {
    echo json_encode(array('status' => 0));
}
