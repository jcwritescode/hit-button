<!DOCTYPE html>
<html >
<head>
  <meta charset="UTF-8">
  <title>Hit the Button</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">
      <link rel="stylesheet" href="css/style.css">
</head>

<body>

<div class="timeline-small">
  <div class="header">
    <div class="color-overlay">
      <div class="header-name">PHP Button Mini Project</div>
      <div class="header-sub">Click the button in the box below</div>
    </div>
  </div>
        <div class="whoa">
          <form action="#" method="post">
            <button class="button1" type="submit" name="btn" formmethod="post" formaction="#">Hit This Button!</button>

            <?php
              // Setting the default timezone so it shows the right time in demos - would normally adjust this on the server
              date_default_timezone_set('America/New_York');
              // Setting up variables for the date, time, and getting the visitors ip
              $daDate = date("m-d-Y");
              $daTime = date("h:ia");
              $ip = $_SERVER['REMOTE_ADDR'];

              // If the button was pressed (checking POST) displays the date/time from above
              if (isset($_POST['btn'])){
                echo "<p>You hit the button at " . $daTime . " on " . $daDate;

                // Learing how to connect to a database here
                // Setting variables to pass in to db connection
                $server = "localhost";
                $user = "root";
                $pass = "";
                $db = "timestamps";

                // This is everything needed to connect to the database - added "die" to terminate on unsuccessful connect
                // This is a database connection object
                $conn = new mysqli($server, $user, $pass, $db) or die("Unable to connect to database");

                // SQL statement matching visitors ip and getting all records associated with that ip
                $sql = "SELECT datetime, ip FROM info WHERE ip = '$ip' ORDER BY datetime DESC";
                // This is a database connection function
                $result = mysqli_query($conn, $sql);
                // Setting up SQL to log the date/time and ip upon button press
                $sql = "INSERT INTO info (datetime, ip) VALUES (NOW(), '$ip')";


                if ($conn->query($sql) === TRUE) {
                    // echo " </p>You previously hit the button at: ";
                } else {
                    echo "Error: " . $sql . "<br>" . $conn->error;
                }
                // Logic looking at if this is the first button click or not and displaying text based on that
                if (mysqli_num_rows($result) < 1) {
                  echo "</p><em>Click the button again to see your click history</em>";
                } else {
                  echo "</p>You previously hit the button at: ";
                }

                echo "<br/> ";

                // Gets the data from db and spits it out to screen
                if (mysqli_num_rows($result) > 0) {
                      // Output data of each row
                      while($row = mysqli_fetch_assoc($result)) {
                          $histDateTime = $row["datetime"];
                          $date = date('m-d-Y',strtotime($histDateTime));
                          $time = date('h:i:sa',strtotime($histDateTime));
                          echo $time . " on " . $date . "<br/>";
                      }
                  }

                $conn->close();

              }

            ?>
              </p>

          </form>

        </div>
  </div>
</div>


</body>
</html>
