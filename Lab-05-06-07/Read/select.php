<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>User Lists</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <header>
    <h1>User Lists</h1>
    <nav>
      <ul>
        <li><a href="../index.php">Home</a></li>
        <li><a href="../Create/create.php">Create</a></li>
        <li><a href="../Update/update-form.php">Edit</a></li>
        <li><a href="../Delete/delete-form.php">Delete</a></li>
      </ul>
    </nav>
  </header>
  <main>
    <?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "student_manager_db";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
    // Check connection
    if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT id, name, mssv, age, birthday, phone, email, address, gender, description FROM students";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
      echo "<table>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>MSSV</th>
                    <th>Age</th>
                    <th>Birthday</th>
                    <th>Phone</th>
                    <th>Email</th>
                    <th>Address</th>
                    <th>Gender</th>
                    <th>Description</th>
                </tr>";
      // output data of each row
      while($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>".$row["id"]."</td>
                <td>".$row["name"]."</td>
                <td>".$row["mssv"]."</td>
                <td>".$row["age"]."</td>
                <td>".$row["birthday"]."</td>
                <td>".$row["phone"]."</td>
                <td>".$row["email"]."</td>
                <td>".$row["address"]."</td>
                <td>".$row["gender"]."</td>
                <td>".$row["description"]."</td>
            </tr>";
      }
      echo "</table>";
    } else {
      echo "0 results";
    }
    $conn->close();
    ?>
  </main>
</body>
</html>

