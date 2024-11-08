<?php
require_once 'load.php';
$deliveryModule->navbar();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Profile</title>
<link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>My profile</h1>
            <div class="actions">
                <button class="btn btn-secondary" onclick="cancelChanges()">Cancel</button>
                <button class="btn btn-primary" onclick="saveChanges()">Save</button>
            </div>
        </div>

        <div class="profile-section">
            <div class="left-section">
                <div class="profile-photo">
                    <img src="./assets/cindy.jpeg" alt="Profile photo">
                    <button class="btn btn-secondary">Change photo</button>
                </div>

                <div class="form-group">
                    <label>First Name</label>
                    <input type="text" class="form-control" value="">
                </div>

                <div class="form-group">
                    <label>Last Name</label>
                    <input type="text" class="form-control" value="">
                </div>

                <div class="form-group">
                    <label>Email</label>
                    <input type="email" class="form-control" placeholder="eg. kevinmorel@gmail.com" value="">
                </div>

                <div class="form-group">
                    <label>Phone</label>
                    <input type="tel" class="form-control" placeholder="eg. +254 759 074 192" value="">
                </div>
            </div>

            <div class="right-section">
                <div class="form-group">
                    <label>Gender</label>
                    <select class="form-control">
                        <option>Male</option>
                        <option>Female</option>
                        <option>Other</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Date of Birth</label>
                    <input type="date" class="form-control">
                </div>

                <div class="form-group">
                    <label>Address</label>
                    <input type="text" class="form-control" value="">
                </div>

                <div class="form-group">
                    <label>Nation</label>
                    <input type="text" class="form-control" value="">
                </div>

                <div class="form-group">
                    <label>Payment Methods</label>
                    <div class="payment-methods">
                        <div class="payment-card">
                            <img  src="./assets/visa.jpeg" alt="">
                        </div>
                        <div class="payment-card">
                            <img  src="./assets/mpesa.jpeg" alt="">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="script.js">
       
    </script>
</body>
</html>
