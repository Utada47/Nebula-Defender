
<?php

// Database configuration
$host = getenv('DB_HOST') ?: 'localhost';
$user = getenv('DB_USER') ?: 'testuser';
$pass = getenv('DB_PASS') ?: 'Test123';
$db   = getenv('DB_NAME') ?: 'db_testing';

// Scenario name
$scenario = getenv('SCENARIO') ?: 'Apache Native';

// Database connection
$conn = @new mysqli($host, $user, $pass, $db);

$dbStatus = $conn->connect_error
    ? "Disconnected"
    : "Connected Successfully";

$dbVersion = "-";

if (!$conn->connect_error) {
    $result = $conn->query("SELECT VERSION()");
    if ($result) {
        $dbVersion = $result->fetch_row()[0];
    }
}

$phpVersion = phpversion();
$serverTime = date("Y-m-d H:i:s");
$serverSoftware = $_SERVER['SERVER_SOFTWARE'] ?? 'Unknown';

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Infrastructure Benchmark</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background: #0f172a;
            color: #f8fafc;
            min-height: 100vh;
            padding: 40px 20px;
        }

        .container {
            max-width: 850px;
            margin: auto;
        }

        .header {
            margin-bottom: 30px;
        }

        .header h1 {
            font-size: 30px;
            margin-bottom: 10px;
        }

        .header p {
            color: #94a3b8;
            line-height: 1.6;
        }

        .scenario {
            display: inline-block;
            background: #1e3a8a;
            color: #bfdbfe;
            padding: 9px 15px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-size: 13px;
        }

        .grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 16px;
        }

        .card {
            background: #1e293b;
            border: 1px solid #334155;
            border-radius: 12px;
            padding: 22px;
        }

        .card h3 {
            color: #94a3b8;
            font-size: 14px;
            margin-bottom: 15px;
        }

        .value {
            font-size: 21px;
            font-weight: bold;
            overflow-wrap: anywhere;
        }

        .success {
            color: #4ade80;
        }

        .danger {
            color: #f87171;
        }

        .footer {
            margin-top: 25px;
            color: #64748b;
            font-size: 13px;
            text-align: center;
        }

        @media(max-width: 600px) {
            .grid {
                grid-template-columns: 1fr;
            }

            .header h1 {
                font-size: 24px;
            }
        }
    </style>
</head>

<body>

<div class="container">

    <div class="header">
        <div class="scenario">
            <?php echo htmlspecialchars($scenario); ?>
        </div>

        <h1>Infrastructure Benchmark</h1>

        <p>
            Web server and database performance monitoring
            for native VM and containerized environments.
        </p>
    </div>

    <div class="grid">

        <div class="card">
            <h3>PHP STATUS</h3>
            <div class="value success">Running</div>
        </div>

        <div class="card">
            <h3>PHP VERSION</h3>
            <div class="value">
                <?php echo htmlspecialchars($phpVersion); ?>
            </div>
        </div>

        <div class="card">
            <h3>DATABASE STATUS</h3>
            <div class="value <?php echo $conn->connect_error ? 'danger' : 'success'; ?>">
                <?php echo htmlspecialchars($dbStatus); ?>
            </div>
        </div>

        <div class="card">
            <h3>MARIADB VERSION</h3>
            <div class="value">
                <?php echo htmlspecialchars($dbVersion); ?>
            </div>
        </div>

        <div class="card">
            <h3>WEB SERVER</h3>
            <div class="value">
                <?php echo htmlspecialchars($serverSoftware); ?>
            </div>
        </div>

        <div class="card">
            <h3>SERVER TIME</h3>
            <div class="value">
                <?php echo htmlspecialchars($serverTime); ?>
            </div>
        </div>

    </div>

    <div class="footer">
        Infrastructure Benchmark Project | PHP + MariaDB
    </div>

</div>

</body>
</html>

<?php
if ($conn->connect_error === null) {
    $conn->close();
}
?>
