<?php include 'db.php'; ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Adicionar Pessoa</title>
</head>
<body>
    <h2>Adicionar Pessoa</h2>
    <form method="POST">
        Nome: <input type="text" name="nome" required><br><br>
        Idade: <input type="number" name="idade" required><br><br>
        Email: <input type="email" name="email" required><br><br>
        <button type="submit">Salvar</button>
    </form>
    <br><a href="index.php">Voltar</a>
</body>
</html>

<?php
if($_SERVER["REQUEST_METHOD"] == "POST"){
    $nome = $_POST['nome'];
    $idade = $_POST['idade'];
    $email = $_POST['email'];

    $sql = "INSERT INTO pessoas (nome, idade, email) VALUES ('$nome', '$idade', '$email')";
    if($conn->query($sql) === TRUE){
        echo "<p>Registro adicionado com sucesso!</p>";
    } else {
        echo "<p>Erro: " . $conn->error . "</p>";
    }
}
?>
