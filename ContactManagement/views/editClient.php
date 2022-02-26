<?php

// Check Authentication
session_start();
if(!isset($_SESSION['auth']) || $_SESSION['auth'] == "false") {
    header("Location: login.php");
    exit();
}

require_once("./../models/ClientManager.php");
require_once("./../models/Client.php");

$clientManager = new ClientManager();
if(isset($_POST['editId'])) {
    $client = $clientManager->getClientById($_POST['editId']);
} else if(isset($_POST['id'])) {

    var_dump($_POST);

    if(isset($_POST['id']) && isset($_POST['firstName']) && isset($_POST['lastName'])
        && isset($_POST['email']) && isset($_POST['phone']) && isset($_POST['birthday'])
        && isset($_POST['streetAddress']) && isset($_POST['city']) && isset($_POST['province']) && isset($_POST['postalCode'])) {

        $client = $clientManager->getClientById($_POST['id']);
        $client->firstName      = $_POST['firstName'];
        $client->lastName       = $_POST['lastName'];
        $client->emailAddress   = $_POST['email'];
        $client->phoneNumber    = $_POST['phone'];
        $client->birthday       = $_POST['birthday'];
        $client->streetAddress  = $_POST['streetAddress'];
        $client->city           = $_POST['city'];
        $client->province       = $_POST['province'];
        $client->postalCode     = $_POST['postalCode'];

        $clientManager->updateClient($client, $_POST['id']);
        header("Location: clientListing.php");
        exit();
    } else {
        $error = "Some information is missing. Please fill all the fields.";
    }

} else {
    header("Location: clientListing.php");
    exit();
}

?>

<!DOCTYPE html>
<html>
	<head>
		<title>Contact Manager</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
	</head>
	<body>
        <div class="ms-auto me-auto" style="min-width: 300px; max-width: 500px">
            <div class="mx-4">

                <div class="my-4">
                    <h1>Edit Client</h1>
                </div>
                <form action="editClient.php" method="post">
                        <input type="hidden" name="id" value="<?php echo $client->id; ?>">

                        <div class="form-group mt-2">
                            <label class="form-label" for="firstName">First Name</label>
                            <input class="form-control" type="text" name="firstName" maxlength=100 required value="<?php echo $client->firstName; ?>">
                        </div>

                        <div class="form-group mt-2">
                            <label class="form-label" for="lastName">Last Name</label>
                            <input class="form-control" type="text" name="lastName" maxlength=100 required value="<?php echo $client->lastName; ?>">
                        </div>

                        <div class="form-group mt-2">
                            <label class="form-label" for="email">Email</label>
                            <input class="form-control" type="email" name="email" maxlength=255 required value="<?php echo $client->emailAddress; ?>">
                        </div>

                        <div class="form-group mt-2">
                            <label class="form-label" for="phone">Phone</label>
                            <input class="form-control" type="text" name="phone" pattern="[0-9]{10}" maxlength=10 required value="<?php echo $client->phoneNumber; ?>">
                        </div>

                        <div class="form-group mt-2">
                            <label class="form-label" for="birthday">Birthday</label>
                            <input class="form-control" type="date" name="birthday" min="1950-01-01" max="2022-02-28" required value="<?php echo $client->birthday; ?>">
                        </div>

                        <div class="form-group mt-2">
                            <label class="form-label" for="streetAddress">Street Address</label>
                            <input class="form-control" type="text" name="streetAddress" maxlength=512 required value="<?php echo $client->streetAddress; ?>">
                        </div>

                        <div class="form-group mt-2">
                            <label class="form-label" for="city">City</label>
                            <input class="form-control" type="text" name="city" maxlength=100 required value="<?php echo $client->city; ?>">
                        </div>

                        <div class="form-group mt-2">
                            <label class="form-label" for="province">Province</label>
                            <input class="form-control" type="text" name="province" maxlength=100 required value="<?php echo $client->province; ?>">
                        </div>

                        <div class="form-group mt-2">
                            <label class="form-label" for="postalCode">Postal Code</label>
                            <input class="form-control" type="text" name="postalCode" maxlength=10 required value="<?php echo $client->postalCode; ?>">
                        </div>

                        <div class="form-group my-3">
                            <input class="btn btn-success" type="submit" value="Submit">
                        </div>
                 </form>

                <div class="text-danger"><?php if(isset($error)) echo $error; ?></div>
            </div>
        </div>
    </body>
</html>