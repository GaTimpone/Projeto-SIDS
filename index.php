<?php include 'db.php'; ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>CRUD PHP + MariaDB</title>
</head>
<body>
    <h2>Lista de Pessoas</h2>
    <a href="create.php">Adicionar Nova Pessoa</a>
    <table border="1" cellpadding="10">
        <tr>
            <th>ID</th><th>Nome</th><th>Idade</th><th>Email</th><th>Ações</th>
        </tr>
        <?php
        $sql = "SELECT * FROM pessoas";
        $result = $conn->query($sql);

        while($row = $result->fetch_assoc()){
            echo "<tr>
                <td>".$row['id']."</td>
                <td>".$row['nome']."</td>
                <td>".$row['idade']."</td>
                <td>".$row['email']."</td>
                <td>
                    <a href='update.php?id=".$row['id']."'>Editar</a> |
                    <a href='delete.php?id=".$row['id']."' onclick='return confirm(\"Deseja excluir?\")'>Excluir</a>
                </td>
            </tr>";
        }
        ?>
    </table>
</body>
</html>
