<?php

$uri = "mysql://avnadmin:AVNS_SV3vxOevkckSb-vKih-@extraescolar-msolizrueda-948a.b.aivencloud.com:18078/defaultdb?ssl-mode=REQUIRED";

$fields = parse_url($uri);

// build the DSN including SSL settings
$conn = "mysql:";
$conn .= "host=" . $fields["host"];
$conn .= ";port=" . $fields["port"];;
$conn .= ";dbname=defaultdb";
$conn .= ";sslmode=verify-ca;sslrootcert=ca.pem";

try  {
    $db = new PDO($conn, $fields['user'], $fields['pass']);
    $db ->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Conexion exitosa";
} catch (PDOException $e) {
    echo "Erro de conexion: " . $e->getMessage();
}
?>