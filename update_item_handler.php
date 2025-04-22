<?php
include('includes/dbconn.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id     = $_POST['fdid'];
    $name   = $_POST['name'];
    $des    = $_POST['des'];
    $stat   = $_POST['stat'];
    $prize  = $_POST['prize'];
    $role   = $_POST['role'];

    $image_path = "";
    $video_path = "";

    // Handle image upload
    if (!empty($_FILES['image']['tmp_name'])) {
        $img_name = basename($_FILES["image"]["name"]);
        $image_path = "images/" . $img_name;
        move_uploaded_file($_FILES["image"]["tmp_name"], $image_path);
    }

    // Handle video upload
    if (isset($_FILES['video']) && $_FILES['video']['error'] === UPLOAD_ERR_OK) {
        $videoTmpPath = $_FILES['video']['tmp_name'];
        $videoName = basename($_FILES['video']['name']);
        $video_path = 'video/' . $videoName;

        if (!move_uploaded_file($videoTmpPath, $video_path)) {
            http_response_code(500);
            echo "❌ Failed to move uploaded video.";
            exit;
        }
    }

    // Prepare SQL
    $sql = "UPDATE tblcnp SET 
        name = '$name',
        description = '$des',
        status = '$stat',
        role = '$role',
        prize = '$prize'";

    if (!empty($image_path)) {
        $sql .= ", image = '$image_path'";
    }

    if (!empty($video_path)) {
        $sql .= ", video = '$video_path'";
    }

    $sql .= " WHERE id = '$id'";

    $result = mysqli_query($con, $sql);

    if ($result) {
        echo "success";
    } else {
        http_response_code(500);
        echo "error";
    }
}
?>
