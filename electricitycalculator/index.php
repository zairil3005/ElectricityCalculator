<!DOCTYPE html>
<html>

<head>
    <title>Electricity Calculator</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css">
    <style>
        .container {
            background-color: #F9F5F6;
        }

        .border {
            border: 2px black;
            border-radius: 5px;
        }

        h1 {
            text-align: center;
        }

        p {
            text-align: start;
        }

        .form-group {
            margin: 0 20%;
        }

        .form-control {
            width: 100%;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Electricity Calculator</h1>
        <form method="post">
            <div class="form-group">
                <label for="voltage">Voltage (V):</label>
                <input type="number" step=0.01 class="form-control" name="voltage" required>
            </div>
            <div class="form-group">
                <label for="current">Current (A):</label>
                <input type="number" step=0.01 class="form-control" name="current" required>
            </div>
            <div class="form-group">
                <label for="rate">Current Rate:</label>
                <input type="number" step=0.01 class="form-control" name="rate" required>
            </div>
            <div style="text-align:center; margin: 20px">
                <button type="submit" class="btn btn-primary">Calculate</button>
            </div>
        </form>

        <?php
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $voltage = $_POST['voltage'];
            $current = $_POST['current'];
            $rate = $_POST['rate'];

            function calculatePower($voltage, $current)
            {
                return $voltage * $current;
            }

            function calculateEnergy($power, $hours)
            {
                return ($power * $hours) / 1000;
            }

            function calculateTotalCharge($energy, $rate)
            {
                $totalCharge = $energy * ($rate / 100);
                return number_format($totalCharge, 2);
            }


            $power = calculatePower($voltage, $current);
            $totalBill = 0.00;

            echo '<div class="container border" style="text-align: center">';
            echo '<h3>Results:</h3>';
            echo "<p>Power: $power W</p>";

            echo '<table class="table">';
            echo '<thead><tr><th>No</th><th>Hour</th><th>Energy (kWh)</th><th>TOTAL (RM)</th></tr></thead>';
            echo '<tbody>';

            for ($hour = 1; $hour <= 24; $hour++) {
                $energy = calculateEnergy($power, $hour);
                $totalCharge = calculateTotalCharge($energy, $rate);
                $totalBill += $totalCharge;

                echo "<tr><td>$hour</td><td>$hour</td><td>$energy</td><td>$totalCharge</td></tr>";
            }
            echo "<p>Total Charge: RM $totalBill </p>";
            echo '</tbody>';
            echo '</table>';
            echo '</div>';
        }
        ?>
    </div>
</body>

</html>