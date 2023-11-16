<!DOCTYPE html>
<html lang="en" >

<head>
  <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
  <style>
#customers {
  font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
  border-collapse: collapse;
  width: 100%;
}

#customers td, #customers th {
  border: 1px solid #ddd;
  padding: 8px;
}

#customers tr:nth-child(even){background-color: #f2f2f2;}
#customers tr:nth-child(odd){background-color: #f2f2f2;}
#customers tr:hover {background-color: #ddd;}

#customers th {
  padding-top: 12px;
  padding-bottom: 12px;
  text-align: left;
  background-color: #4CAF50;
  color: white;
}
.block {
  display: block;
  width: 100%;
  border: none;
  background-color: #4CAF50;
  color: white;
  padding: 14px 28px;
  font-size: 16px;
  cursor: pointer;
  text-align: center;
}

.block:hover {
  background-color: #ddd;
  color: black;
}
</style>
  <meta charset="UTF-8">
  <title>Feedback</title>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.3/modernizr.min.js" type="text/javascript"></script>


    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">

  
      <link rel="stylesheet" href="css/style.css">

  
</head>

<body>


   <form action = "logout.php" method="POST"> 
          <div class="w3-show-inline-block">
          <div class="w3-bar">
            <center>
              <input type="submit" value="LogOut" name="logout" class="w3-btn w3-black">
            </center>
        </div>
        </div>  
  </form>


  <?php
session_start();
require 'config.php';

if (isset($_SESSION['login_user'])) {
    $userLoggedIn = $_SESSION['login_user'];
    $result = mysqli_query($con, "SELECT * FROM poll");

    echo "<form action='' method='POST'>";
    echo "<table border='1' id='customers'>
            <tr>
            <th>Name</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Feedback</th>
            <th>Suggestions</th>
            <th>Action</th>
            </tr>";

    while ($row = mysqli_fetch_array($result)) {
        echo "<tr>";
        echo "<td>" . $row['name'] . "</td>";
        echo "<td>" . $row['email'] . "</td>";
        echo "<td>" . $row['phone'] . "</td>";
        echo "<td>" . $row['feedback'] . "</td>";
        echo "<td>" . $row['suggestions'] . "</td>";
        echo "<td>
                  <button type='submit' name='edit' value='" . $row['id'] . "'>Edit</button>
                  <button type='submit' name='delete' value='" . $row['id'] . "'>Delete</button>
              </td>";
        echo "</tr>";
    }

    echo "</table>";
    echo "</form>";

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (isset($_POST['edit'])) {
            // Handle edit action for the selected row (using $_POST['edit'] as the row id)
            $selectedId = $_POST['edit'];

            // Fetch the existing data for the selected row
            $fetchQuery = "SELECT * FROM poll WHERE id = $selectedId";
            $rowToUpdate = mysqli_fetch_array(mysqli_query($con, $fetchQuery));

            // Display a form for editing
            echo "<form action='' method='POST'>
                      <input type='text' name='updatedName' value='" . $rowToUpdate['name'] . "'>
                      <input type='text' name='updatedEmail' value='" . $rowToUpdate['email'] . "'>
                      <input type='text' name='updatedPhone' value='" . $rowToUpdate['phone'] . "'>
                      <input type='text' name='updatedFeedback' value='" . $rowToUpdate['feedback'] . "'>
                      <input type='text' name='updatedSuggestions' value='" . $rowToUpdate['suggestions'] . "'>
                      <input type='hidden' name='rowId' value='" . $selectedId . "'>
                      <input type='submit' name='updateRow' value='Update'>
                  </form>";

        } elseif (isset($_POST['delete'])) {
            // Handle delete action for the selected row (using $_POST['delete'] as the row id)
            $selectedId = $_POST['delete'];

            // Delete the row
            $deleteQuery = "DELETE FROM poll WHERE id = $selectedId";
            mysqli_query($con, $deleteQuery);

            echo "Delete button clicked for row with ID: $selectedId";
        } elseif (isset($_POST['updateRow'])) {
            // Handle update action for the selected row
            $updatedName = mysqli_real_escape_string($con, $_POST['updatedName']);
            $updatedEmail = mysqli_real_escape_string($con, $_POST['updatedEmail']);
            $updatedPhone = mysqli_real_escape_string($con, $_POST['updatedPhone']);
            $updatedFeedback = mysqli_real_escape_string($con, $_POST['updatedFeedback']);
            $updatedSuggestions = mysqli_real_escape_string($con, $_POST['updatedSuggestions']);
            $rowIdToUpdate = $_POST['rowId'];

            // Update the row
            $updateQuery = "UPDATE poll
                            SET name = '$updatedName', email = '$updatedEmail', phone = '$updatedPhone', 
                                feedback = '$updatedFeedback', suggestions = '$updatedSuggestions'
                            WHERE id = $rowIdToUpdate";
            mysqli_query($con, $updateQuery);

            echo "Update button clicked for row with ID: $rowIdToUpdate";
        }
    }
} else {
    //header("Location: index.php");
}
?>


    
  <script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
  
  
</body>

</html>
