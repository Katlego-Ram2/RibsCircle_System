<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background: linear-gradient(120deg, #f6d365 0%, #fda085 100%);
        }
        nav {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px;
            background: rgba(255, 255, 255, 0.8);
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        .container {
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
            background: white;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }
        label {
            display: block;
            margin-top: 10px;
            font-weight: bold;
        }
        input {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
        }
        button {
            background-color: #007bff;
            color: white;
            padding: 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 20px;
        }
        button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
<?php include 'header.php'; ?>
<div class="container">
    <h2>Edit Profile</h2>
    <form id="editProfileForm">
        <label for="name">Name:</label>
        <input type="text" id="username" name="name" value="" required>
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" value="" required>
        <label for="phone">Phone:</label>
        <input type="text" id="phone" name="phone" value="" required>
        <input type="hidden" id="userId" name="userId" value="">
        <button type="submit">Update Profile</button>
    </form>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const userId = localStorage.getItem('userId');
        document.getElementById('userId').value = userId;
        
        if (userId) {
            fetch(`get_user_details.php?userId=${userId}`)
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        document.getElementById('username').value = data.user.username;
                        document.getElementById('email').value = data.user.email;
                        document.getElementById('phone').value = data.user.phone;
                    } else {
                        console.error(data.message);
                    }
                })
                .catch(error => {
                    console.error('Error fetching user details:', error);
                });
        } else {
            console.error('User ID not found in local storage.');
        }

        document.getElementById('editProfileForm').addEventListener('submit', function (e) {
            e.preventDefault();
            const formData = new FormData(this);
            fetch('update_profile.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    alert('Profile updated successfully.');
                } else {
                    console.error(data.message);
                }
            })
            .catch(error => {
                console.error('Error updating profile:', error);
            });
        });
    });
</script>
</body>
</html>
