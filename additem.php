<?php

session_start();
if (!isset($_SESSION["user"])) { //Starts the session once logged in
  header("Location: login.php");
  exit();
}

$db = new SQLite3("database.db"); // Connect to SQLite database

if ($_SERVER["REQUEST_METHOD"] == "POST") { //Sees if a form has been submitted

$item_name = $_POST["item_name"]; //gets item name on the form
$quantity = $_POST["quantity"]; //gets how much is there on the form
$expiry_date = $_POST["expiry"]; //gets the expiry date on the form
$location = $_POST["location"]; //gets the location on the form

$stmt = $db->prepare("SELECT * FROM ingredients WHERE item_name = :item_name"); //runs later once all data is inputted
$stmt->bindValue(":item_name", $item_name); //this gives the data field the actual values inputted

$result = $stmt->execute();
$existingItem = $result->fetchArray(SQLITE3_ASSOC); //if it exists in the database, it gets it

if ($existingItem) { //if already in inventory, it updates the quantity
  $stmt = $db->prepare("
  UPDATE ingredients
  SET quantity = quantity + :quantity            
  WHERE item_name = :item_name
  ");

  $stmt->bindValue(":item_name", $item_name);
  $stmt->bindValue(":quantity", $quantity);

  $stmt->execute();

} else {
  $stmt = $db->prepare("
  INSERT INTO ingredients (
  item_name, quantity, expiry_date, location)
  VALUES
  (:item_name, :quantity, :expiry_date, :location)
  "); //if it doesn't exist, it will add the item with the other fields into the inventory

  $stmt->bindValue(":item_name", $item_name);
  $stmt->bindValue(":quantity", $quantity);
  $stmt->bindValue(":expiry_date", $expiry_date);
  $stmt->bindValue(":location", $location);

  $stmt->execute();

}

header("Location: inventory.php"); //returns back to the inventory page once submitted and the user is done after submitting
exit(); 

}

?>

<!DOCTYPE html>
<head>
    <title>Add Item</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <h1>Add Item</h1>
    </header>

    <a href="./inventory.php">Inventory</a></br>

    <hr />

    <form id="addItem" method="POST">
        <label for="item_id">Item ID</label>
        <input
          type="text"
          id="item_id"
          name="item_id"
          placeholder="ID"
        /> </br>
        <label for="item_name">Name</label>
        <input
          type="text"
          id="item_name"
          name="item_name"
          placeholder="Name"
        /> </br>
        <label for="quantity">Quantity</label>
        <input
          type="text"
          id="quantity"
          name="quantity"
          placeholder="Quantity"
        /> </br>
        <label for="expity">Expiry</label>
        <input
          type="date"
          id="expiry"
          name="expiry"
        /> </br>
        <label for="location">Location</label>
        <input
          type="text"
          id="location"
          name="location"
          placeholder="Location"
        /> </br>
        <button type="submit" name="addItem">Add Item</button>
    </form>

<hr />

    <footer>
        <p>COMP5008 - Web Development Assignment 2 - Login: {}</p>
      </footer>

</body>
</html>