<?php include 'db.php'; ?>

<?php
$id = $_GET['id'];
$sql = "SELECT * FROM pessoas WHERE id=$id";
$result = $conn->query($sql);
$pessoa = $result->fetch_assoc();

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $nome = $_POST['nome'];
    $idade = $_POST['idade'];
    $email = $_POST['email'];

    $sql = "UPDATE pessoas SET nome='$nome', idade='$idade', email='$email' WHERE id=$id";
    if($conn->query($sql) === TRUE){
        echo "<p>Registro atualizado!</p>";
    } else {
        echo "<p>Erro: " . $conn->error . "</p>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Editar Pessoa</title>
</head>
<body>
    <h2>Editar Pessoa</h2>
    <form method="POST">
        Nome: <input type="text" name="nome" value="<?php echo $pessoa['nome']; ?>" required><br><br>
        Idade: <input type="number" name="idade" value="<?php echo $pessoa['idade']; ?>" required><br><br>
        Email: <input type="email" name="email" value="<?php echo $pessoa['email']; ?>" required><br><br>
        <button type="submit">Atualizar</button>
    </form>
    <br><a href="index.php">Voltar</a>
</body>
</html>
