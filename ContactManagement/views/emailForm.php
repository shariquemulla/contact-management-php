<?php

// Check Authentication
session_start();
if(!isset($_SESSION['auth']) || $_SESSION['auth'] == "false") {
    header("Location: login.php");
    exit();
}

?>

<!DOCTYPE html>

<html>
    <head>
        <title>Email Form</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    </head>
    <body>
        <div class="ms-auto me-auto" style="min-width: 300px; max-width: 500px">
            <div class="mx-4">
                <div class="my-4">
                    <h1>Email Form</h1>
                </div>
                <form method="post" action="sendEmail.php">
                    <div class="form-group mt-2">
                        <label class="form-label">Your Name</label>
                        <input class="form-control" type="text" name="sender_name" size=100 required>
                    </div>
                    <div class="form-group mt-2">
                        <label class="form-label">Your E-Mail Address</label>
                        <input class="form-control" type="text" name="sender_email" size=100 required>
                    </div>
                    <div class="form-group mt-2">
                        <label class="form-label">Message</label>
                        <textarea class="form-control" name="message" cols=30 rows=5 wrap="soft" maxlength="512" required placeholder="Enter text here."></textarea>
                    </div>
                    <div class="form-group my-3">
                        <input class="btn btn-success" type="submit" name="submit" value="Send">
                    </div>
                </form>
            </div>
        </div>
    </body>
</html> 