<?php include 'db.php'; ?>

<?php
$id = $_GET['id'];
$sql = "DELETE FROM pessoas WHERE id=$id";
if($conn->query($sql) === TRUE){
    echo "<p>Registro excluído!</p>";
} else {
    echo "<p>Erro: " . $conn->error . "</p>";
}
?>

<br><a href="index.php">Voltar</a>
