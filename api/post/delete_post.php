<?php
// Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: DELETE');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-requested-with');

include_once '../../config/Database.php';
include_once '../../models/Post.php';

// Instantiate DB & connect
$database = new Database();
$db = $database->connect();

// Instantiate blog post object
$post = new Post($db);

// Retrieve Raw posted data (from postman)
$data = json_decode(file_get_contents("php://input"));

// Set id to update
$post->id = $data->id;

// Delete Post
if ($post->delete_post()) {
    echo json_encode(array('Message' => 'Post Deleted!'));
} else {
    echo json_encode(array('Message' => 'Post deletion failed!'));
}
