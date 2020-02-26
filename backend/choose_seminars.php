<?php
    require "config/db.php";
    echo '<form action="index.php" method="post">';
    
    $sql = "SELECT * FROM Seminars";
              $result = $conn->query($sql);
              if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                  echo "<input type='checkbox' name='".$row[id]."'>".$row[]
                }

    echo '<input type="submit" name="formSubmit" value="Potvrdit"></form>';
  }
?>
