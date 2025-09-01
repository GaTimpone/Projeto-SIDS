# Projeto-SIDS

Integrantes da Dupla Gabriel Augusto Coelho Timpone e Aline Santos Ferreira

Tema principal: Configuração de um servidor LAMP no Ubuntu para hospedar uma aplicação web.

1. O que é LAMP?

Linux → o sistema operacional (Ubuntu, no caso).

Apache → o servidor web que entrega as páginas.

MySQL/MariaDB → banco de dados para armazenar informações.

PHP → linguagem de servidor para processar páginas dinâmicas.

2. Passos da Configuração
Atualizar o sistema
sudo apt update && sudo apt upgrade -y

Instalar Apache
sudo apt install apache2 -y


Testar: abrir no navegador http://IP_DO_SERVIDOR → deve aparecer a página "It works!".

Instalar MySQL/MariaDB
sudo apt install mysql-server -y

Instalar MariaDB:

sudo apt install -y mariadb-server

Iniciar serviços e habilitar no boot:

sudo systemctl enable --now apache2 mariadb

Configurar segurança:

sudo mysql_secure_installation

Instalar PHP
sudo apt install php libapache2-mod-php php-mysql -y


Criar arquivo de teste:

echo "<?php phpinfo(); ?>" | sudo tee /var/www/html/info.php

Apagar depois:

sudo rm /var/www/html/phpinfo.php

Acessar no navegador: http://IP_DO_SERVIDOR/info.php


Conecte-se ao MySQL/MariaDB:

sudo mysql -u root -p


Crie o banco e a tabela:

CREATE DATABASE crud_php CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE crud_php;

CREATE TABLE pessoas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    idade INT NOT NULL,
    email VARCHAR(100) NOT NULL
);


Crie usuário (opcional, mas recomendado):

CREATE USER 'cruduser'@'localhost' IDENTIFIED BY 'senha123';
GRANT ALL PRIVILEGES ON crud_php.* TO 'cruduser'@'localhost';
FLUSH PRIVILEGES;
EXIT;

Acesse o diretório do Apache
cd /var/www/html

Crie a pasta do projeto
sudo mkdir meu_crud
cd meu_crud

Crie o arquivo de conexão db.php
sudo nano db.php

Cole:

<?php
$host = "localhost";
$user = "cruduser";
$pass = "senha123";
$db   = "crud_php";

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}
?>


Salvar e sair (CTRL+O, ENTER, CTRL+X).

Crie a página inicial index.php
sudo nano index.php

Cole:

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

Crie create.php (inserir)
sudo nano create.php


Cole:

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

Crie update.php (editar)
sudo nano update.php


Cole:

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

Crie delete.php (excluir)
sudo nano delete.php


Cole:

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

Ajuste permissões (para o Apache ler os arquivos)
sudo chown -R www-data:www-data /var/www/html/meu_crud
sudo chmod -R 755 /var/www/html/meu_crud

Abra:
http://IP_DO_SERVIDOR/meu_crud/
