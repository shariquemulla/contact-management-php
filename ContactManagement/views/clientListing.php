<?php

// Check Authentication
session_start();
if(!isset($_SESSION['auth']) || $_SESSION['auth'] == "false") {
    header("Location: login.php");
    exit();
}

require_once("./../models/ClientManager.php");

$clientManager = new ClientManager();
if(isset($_POST['birthdayMonth']) && $_POST['birthdayMonth'] != "") {
    $allClients = $clientManager->getClientsByBirthMonth($_POST['birthdayMonth']);    
} else {
    $allClients = $clientManager->getAllClients();
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

        <div class="row m-2">
            <div>
                <div class="row mb-4">
                    <div class="col-12 col-md-8 col-sm-12 my-auto">
                        <h1>Contact Manager</h1>
                        <div><a href="addClient.php">Add New</a> | 
                            <a href="emailForm.php">Email Contacts</a>
                        </div>
                        <div>
                            <a href="importData.php">Import Contacts</a> | 
                            <a href="exportData.php">Export Contacts</a>
                        </div>
                        <div class="my-2">
                            <form action="clientListing.php" method="POST">
                                <div class="row">
                                    <label class="col-12 col-md-4 col-sm-12 form-label" for="birthdayMonth">Filter by birthday month: </label>
                                    <select class="col-12 col-md-4 col-sm-12 form-control mb-2" name="birthdayMonth" id="birthdayMonth">
                                        <option value="">-</option>
                                        <option value="01">January</option>
                                        <option value="02">February</option>
                                        <option value="03">March</option>
                                        <option value="04">April</option>
                                        <option value="05">May</option>
                                        <option value="06">June</option>
                                        <option value="07">July</option>
                                        <option value="08">August</option>
                                        <option value="09">September</option>
                                        <option value="10">October</option>
                                        <option value="11">November</option>
                                        <option value="12">December</option>
                                    </select>
                                    <div class="col-12 col-md-4 col-sm-12"><input class="btn btn-sm btn-primary" type="submit" value="Find"></div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="col-12 col-md-4 col-sm-12 text-end">
                        <div><a href="logout.php">Logout</a></div>
                    </div>
                </div>

                <?php if(!empty($allClients)) { ?>
                    <div class="table-responsive">
                        <table class="table small">
                            <thead>
                                <tr>
                                    <th>First Name</th>
                                    <th>Last Name</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Birthday</th>
                                    <th>Street Address</th>
                                    <th>City</th>
                                    <th>Province</th>
                                    <th>Postal Code</th>
                                </tr>
                            </thead>

                            <?php if(!empty($allClients)) foreach($allClients as $k => $client) { ?>
                                <tbody>
                                    <tr>
                                        <td><?php echo $client->firstName ?></td>
                                        <td><?php echo $client->lastName ?></td>
                                        <td><?php echo $client->emailAddress ?></td>
                                        <td><?php echo $client->phoneNumber ?></td>
                                        <td><?php echo $client->birthday ?></td>
                                        <td><?php echo $client->streetAddress ?></td>
                                        <td><?php echo $client->city ?></td>
                                        <td><?php echo $client->province ?></td>
                                        <td><?php echo $client->postalCode ?></td>
                                        <form action="editClient.php" method="post">
                                            <td><button class="btn btn-sm btn-success" type="submit" name="editId" value="<?php echo $client->id ?>">Edit</button></td>
                                        </form>
                                        <form action="deleteClient.php" method="post">
                                            <td><button class="btn btn-sm btn-danger" type="submit" name="deleteId" value="<?php echo $client->id ?>">Delete</button></td>
                                        </form>
                                    </tr>
                                </tbody>
                            <?php } ?>
                        </table>
                    </div>
                <?php } else { ?>
                    <div class="h3">No records to display</div>
                <?php } ?>
            </div>
        </div>

        
    </body>
</html>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>