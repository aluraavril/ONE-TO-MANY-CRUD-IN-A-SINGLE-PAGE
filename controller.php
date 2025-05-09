<?php
session_start();
include 'database.php';

if ($_POST['action'] == 'addArtist') {
    $name = $_POST['name'];
    $uid = $_SESSION['user_id'];
    $conn->query("INSERT INTO artists (name, user_id, updated_by) VALUES ('$name', $uid, $uid)");
} elseif ($_POST['action'] == 'addSong') {
    $title = $_POST['title'];
    $artist_id = $_POST['artist_id'];
    $uid = $_SESSION['user_id'];
    $conn->query("INSERT INTO songs (title, artist_id, user_id, updated_by) VALUES ('$title', $artist_id, $uid, $uid)");
} elseif ($_POST['action'] == 'getData') {
    $artists = $conn->query("SELECT a.*, 
                                u.username AS created_by, 
                                u2.username AS updated_by 
                         FROM artists a 
                         JOIN users u ON a.user_id = u.id 
                         LEFT JOIN users u2 ON a.updated_by = u2.id 
                         ORDER BY a.id DESC");


    $data = [];
    while ($a = $artists->fetch_assoc()) {
        $songs = $conn->query("SELECT s.*, u1.username AS created_by, u2.username AS updated_by 
                       FROM songs s 
                       LEFT JOIN users u1 ON s.user_id = u1.id 
                       LEFT JOIN users u2 ON s.updated_by = u2.id 
                       WHERE s.artist_id = " . $a['id']);


        $a['songs'] = $songs->fetch_all(MYSQLI_ASSOC);
        $data[] = $a;
    }
    echo json_encode($data);
} elseif ($_POST['action'] == 'deleteArtist') {
    $id = $_POST['id'];
    $conn->query("DELETE FROM artists WHERE id=$id");
    $conn->query("DELETE FROM songs WHERE artist_id=$id");
} elseif ($_POST['action'] == 'deleteSong') {
    $id = $_POST['id'];
    $conn->query("DELETE FROM songs WHERE id=$id");
} elseif ($_POST['action'] == 'editArtist') {
    $id = $_POST['id'];
    $newName = $_POST['newName'];
    $uid = $_SESSION['user_id'];
    $now = date('Y-m-d H:i:s');

    $stmt = $conn->prepare("UPDATE artists SET name=?, updated_by=?, updated_at=? WHERE id=?");
    $stmt->bind_param("sisi", $newName, $uid, $now, $id);
    $stmt->execute();
} elseif ($_POST['action'] == 'editSong') {
    $id = $_POST['id'];
    $newTitle = $_POST['newTitle'];
    $uid = $_SESSION['user_id'];
    $now = date('Y-m-d H:i:s');
    $stmt = $conn->prepare("UPDATE songs SET title=?, updated_by=?, updated_at=? WHERE id=?");
    $stmt->bind_param("sisi", $newTitle, $uid, $now, $id);
    $stmt->execute();
}
