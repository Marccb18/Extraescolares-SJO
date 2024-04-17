<?php
$uri = "mysql://avnadmin:AVNS_SV3vxOevkckSb-vKih-@extraescolar-msolizrueda-948a.b.aivencloud.com:18078/defaultdb?ssl-mode=REQUIRED";

$fields = parse_url($uri);

// build the DSN including SSL settings
$conn = "mysql:";
$conn .= "host=" . $fields["host"];
$conn .= ";port=" . $fields["port"];;
$conn .= ";dbname=defaultdb";
$conn .= ";sslmode=verify-ca;sslrootcert=ca.pem";

try {
    $db = new PDO($conn, $fields['user'], $fields['pass']);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $showDatabase = $db->query("SHOW tables");
    $showDatabase->execute();
    $result = $showDatabase->fetchAll();
    echo "<h1>Tablas en la base de datos</h1>";
} catch (PDOException $e) {
    echo "Erro de conexion: " . $e->getMessage();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tablas de Base de datos y sus datos</title>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        

        }

        th,
        td {
            border: 1px solid black;
            padding: 8px;
            text-align: center;
        }

        th {
            background-color: #f2f2f2;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        h1 {
            text-align: center;
        }

        main {
            display: flex;
            justify-content: space-around;
            margin-top: 20px;
        }

        section {
            width: 45%;
        }

        .data {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-around;
        }
        .container {
            margin: 0 auto;
            width: 100%;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 20px;
        }
        .containerData {
            width: 100%;
            display: flex;
            flex-wrap: wrap;
            justify-content: space-around;
        }
    </style>
</head>

<body>
    <main class="container">
        <section>
            <table>
                <thead>
                    <tr>
                        <th>Nombre de tablas</th>
                    </tr>
                </thead>
                <tbody>
                    <?php

                    foreach ($result as $row) {
                        $dataCount=$db->query("SELECT * FROM $row[0]");
                        $dataCount->execute();
                        $count = $dataCount->rowCount();
                        echo "<tr>";
                        echo "<td> $row[0] $count</td>";
                        echo "</tr>";
                    }
                    ?>
                </tbody>
            </table>
        </section>
        <section class="data">
            <div class="containerData">
            <?php
            foreach ($result as $row) {
                $tableName = $row[0];
                $showData = $db->query("SELECT * FROM $tableName");
                $showData->execute();
                $data = $showData->fetchAll(PDO::FETCH_ASSOC);
                echo "<h1>$tableName</h1>";
                echo "<table>";
                echo "<thead>";
                echo "<tr>";
                foreach ($data[0] as $key => $value) {
                    echo "<th>$key</th>";
                }
                echo "</tr>";
                echo "</thead>";
                echo "<tbody>";
                foreach ($data as $rowData) {
                    echo "<tr>";
                    foreach ($rowData as $value) {
                        echo "<td>$value</td>";
                    }
                    echo "</tr>";
                }
                echo "</tbody>";
                echo "</table>";
            }
            ?>
            </div>

        </section>
    </main>
</body>

</html>