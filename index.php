<?php
session_start();
if (!isset($_SESSION['user_id'])) header("Location: login.php");
?>
<!DOCTYPE html>
<html>

<head>
    <title>🎵 Music Library 🎵 </title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 30px;
            background-color: #f9f7fc;
        }

        h3 {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        h4 {
            margin-bottom: 10px;
            color: #6a4bc9;
        }

        form {
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 40px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
            background: white;
            border-radius: 10px;
            overflow: hidden;
        }

        table th,
        table td {
            border: 1px solid #eee;
            padding: 12px;
            text-align: left;
        }

        table th {
            background-color: #f2ecff;
        }

        tr:hover {
            background-color: #fdf8e8;
        }

        [contenteditable="true"] {
            background-color: #fffbea;
            cursor: text;
            padding: 2px;
        }

        input[type="text"] {
            padding: 8px;
            width: 250px;
            border-radius: 8px;
            border: 1px solid #ccc;
        }

        button {
            padding: 6px 12px;
            margin-left: 5px;
            background-color: #6a4bc9;
            color: white;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 0.9em;
        }

        button:hover {
            background-color: #573baf;
        }

        .small {
            font-size: 0.85em;
            color: #666;
        }

        hr {
            margin-top: 40px;
        }

        a {
            color: #6a4bc9;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>

</head>

<body>

    <h3>Welcome to Music Library, <?= $_SESSION['username']; ?> | <a href="logout.php">Logout</a></h3>

    <h4>Add Artist</h4>
    <form id="artistForm">
        <input name="name" placeholder="Artist Name" required>
        <button>Add Artist</button>
    </form>

    <h4>Artists & Songs</h4>
    <div id="artistList"></div>

    <script src="script.js"></script>
</body>

</html>