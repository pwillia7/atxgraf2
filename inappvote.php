<?php
$m = new MongoClient();
$db = $m->graffiti;
$collection = $db->posts;
$postID = $_POST["postid"];
$mongoID = new MongoID("$postID");

$collection->update(array("_id" => $mongoID),array('$inc' => array("inappVotes" => 1)));

?>
