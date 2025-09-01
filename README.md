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

Cole o conteudo do arquivo db.php

Salvar e sair == (CTRL+O, ENTER, CTRL+X).



Crie a página inicial index.php
sudo nano index.php
Cole o conteudo do arquivo index.php



Crie create.php (inserir)
sudo nano create.php
Salvar e sair == (CTRL+O, ENTER, CTRL+X).



Cole o conteudo do arquivo create.php

Crie update.php (editar)
sudo nano update.php



Cole o conteudo do arquivo update.php
Salvar e sair == (CTRL+O, ENTER, CTRL+X).



Crie delete.php (excluir)
sudo nano delete.php

Coleo conteudo do arquivo delete.php
Salvar e sair == (CTRL+O, ENTER, CTRL+X).



Ajuste permissões (para o Apache ler os arquivos)
sudo chown -R www-data:www-data /var/www/html/meu_crud
sudo chmod -R 755 /var/www/html/meu_crud



Abra:
http://IP_DO_SERVIDOR/meu_crud/
