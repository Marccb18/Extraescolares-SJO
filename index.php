<?php require('./config/conexion.php') ?>
<?php
    try {
        $statement = $db -> prepare('SELECT * FROM personal');
        $statement->execute();
        $results = $statement -> fetchAll(PDO::FETCH_ASSOC);

        foreach ($results as $row) {
            echo 'ID: ' . $row['DNI'] . '<br>';
        }
    } catch (PDOException $e) {
        echo "Error de consulta: " . $e->getMessage();
    }
?>