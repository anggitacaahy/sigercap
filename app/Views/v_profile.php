<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Profile</title>
    <link rel="stylesheet" href="<?= base_url('css/main.css'); ?>" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css" />
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f0f2f5;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .profile-container {
            width: 100%;
            max-width: 600px;
            background: #fff;
            padding: 30px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            border-radius: 10px;
            text-align: center;
        }
        .profile-header {
            display: flex;
            align-items: center;
            flex-direction: column;
            margin-bottom: 20px;
        }
        .profile-header img {
            border-radius: 50%;
            width: 120px;
            height: 120px;
            object-fit: cover;
            border: 5px solid #fff;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            margin-bottom: 20px;
        }
        .profile-header h1 {
            margin: 10px 0;
            font-size: 28px;
            color: #333;
        }
        .profile-header p {
            margin: 5px 0 0;
            color: #666;
        }
        .profile-body {
            margin-top: 20px;
            display: flex;
            flex-wrap: wrap;
            justify-content: space-around;
        }
        .profile-card {
            background-color: #e0e0e0;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            padding: 20px;
            margin: 10px;
            width: calc(50% - 20px); /* Ubah sesuai kebutuhan */
            max-width: 600px; /* Atur maksimum lebar card */
            text-align: center;
            transition: transform 0.3s ease;
        }
        .profile-card:hover {
            transform: translateY(-5px);
        }
        .profile-card h3 {
            font-size: 20px;
            margin-bottom: 10px;
            color: #333;
        }
        .profile-card p {
            color: #666;
        }
        .logout-button {
            display: inline-block;
            padding: 7px 15px;
            background-color: #757575; /* Warna abu-abu untuk tombol logout */
            color: #fff;
            text-decoration: none;
            border-radius: 4px;
            transition: background-color 0.3s;
            margin-top: 20px;
            font-size: 16px;
            border: none;
            cursor: pointer;
        }
        .logout-button:hover {
            background-color: #424242; /* Warna hover tombol logout */
        }
    </style>
</head>
<body>
    <?= $this->include('template/navbar'); ?>
    <div class="profile-container">
        <div class="profile-header">
            <img src="img/user.png" alt="Profile Picture">
            <h1><?= $user['username']; ?></h1>
        </div>
        <div class="profile-body">
            <div class="profile-card">
                <h3>Username</h3>
                <p style="font-size: 12px;"><?= $user['username']; ?></p>
            </div>
            <div class="profile-card">
                <h3>Email</h3>
                <p style="font-size: 12px;"><?= $user['email']; ?></p>
            </div>
        </div>
        <a href="<?= base_url('user-report'); ?>" class="logout-button">Daftar Pelaporan Bencana</a>
    </div>
</body>
</html>
