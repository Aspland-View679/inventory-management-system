<?php

session_start();
if (!isset($_SESSION["user"])) { //Starts the session once logged in
  header("Location: login.php");
  exit();
}

$db = new SQLite3("database.db"); // Connect to SQLite database

if (isset($_POST["delete"])) {
  $deleteID = $_POST["deleteID"];

  $stmt = $db->prepare("DELETE FROM ingredients WHERE item_id = :item_id");
  $stmt->bindValue(":item_id", $deleteID);

  $stmt->execute();          //Deletes item from query/form

  header("Location: inventory.php");
  exit();
}

if (isset($_GET["search"]) && $_GET["search"] != "") {
  $search = $_GET["search"]; //Searches the query/form

  $stmt = $db->prepare("SELECT * FROM ingredients WHERE item_name LIKE :search");
  $stmt->bindValue(":search", "%" . $search . "%"); //Shows everything

  $results = $stmt->execute();
} else {
  $results = $db->query("SELECT * FROM ingredients");  //gets the results from the selected ingredients

}

$expiryMessage = "";

$expiryResults = $db->query("
SELECT * FROM ingredients WHERE expiry_date BETWEEN date('now') AND date('now', '+7 days')");

while ($expiryRow = $expiryResults->fetchArray(SQLITE3_ASSOC)) {
$expiryMessage .= $expiryRow["item_name"] . " expires on " . $expiryRow["expiry_date"] . "\\n"; //This works out through the query using arrays what is expired and when it expires.
}

if ($expiryMessage == "") {
  $expiryMessage = "No items are expiring within the next week.";  //This is to ensure the alert isn't blank.
}

?>

<!DOCTYPE html>
<head>
    <title>Inventory</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <h1>Stock Inventory</h1>
      </header>

    <form id="search" method="GET">
        <label for="search">Search</label><br />
        <input
          type="text"
          id="search" 
          name="search"
          placeholder="search"
        />
        <button type="submit" name="search">Search</button>
    </form>

</br>

    <a href="./additem.php">Add Item</a>

</br></br>

    <button type="button" onclick="window.alert('<?php echo $expiryMessage; ?>')">
      Warning - Expiry Close
    </button>   <!-- This is the warning button for expiry -->

<hr />
    
<table border="1">
<thead>
  <tr>
    <th>item_id</th>
    <th>item_name</th>  <!-- right table names -->
    <th>quantity</th>
    <th>expiry_date</th>
    <th>location</th>
    <th>Delete?</th>
  </tr></thead>
<tbody>
  
<?php while ($row = $results->fetchArray(SQLITE3_ASSOC)) { ?> 
<tr>
  <td><?php echo $row["item_id"]; ?></td>
  <td><?php echo $row["item_name"]; ?></td>
  <td><?php echo $row["quantity"]; ?></td>  <!-- populates the table -->
  <td><?php echo $row["expiry_date"]; ?></td>
  <td><?php echo $row["location"]; ?></td>

  <td>
    <form method="POST">
      <input type="hidden" name="deleteID" value="<?php echo $row["item_id"]; ?>">
      <button type="submit" name="delete">Delete</button>
    </form>  <!-- The delete button -->
  </td>

</tr>
<?php } ?>

</tbody>
</table>

<hr />

    <footer>
        <p>COMP5008 - Web Development Assignment 2 - Login: {}</p>
      </footer>
</body>
</html>