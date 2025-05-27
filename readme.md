# WSL
 
o comando abaixo instala o Ubuntu como distribuição wsl.
```bash
wsl --install -d Ubuntu
```
 
No powershell, na primeira vez que executar o comando `wsl`,
vai ser pedido para escolher um nome de usuário, digitar a senha e digitar a senha novamente.
 
> Obs: ao digitar a senha **nunca**, será mostrado os caracteres.
 
# Pós instalção
Na pós intalação deve-ser atualizar o sistema operacional com os comandos
 
```bash
sudo apt update
sudo apt upgrade
```
 
# Instalar o mariadb como banco de dados.
 
Antes de instalar qualquer programa, sempre validar se a lista de programas está atualizada
 
```bash
sudo apt update
```
 
Instalar o mariadb:
```bash
sudo apt istall mariadb-server
```
# Pós instalação do mariadb
Roda o comando após a instalação:
```bash
sudo mysql_secure_installation
```
#enter
#n
#y
senha: 123456
#y
#n
#y
#y
 
# Como gerenciar o serviço do banco de dados
```bash
sudo systemctl start maridb # incia
sudo systemctl stop mariadb # para
sudo systemctl restart mariadb # reinicia
sudo systemctl status mariadb # verifica o status
```
 
# criação do banco de dados
 
### cria um banco
```sql
create database my_tarefas;
```
 
### criar as colunas
 
```sql
--- Tablea usuário
create table usuario(
    id int not null primary key auto_increment,
    nome varchar(100) not null,
    login varchar(50) not null unique,
    senha varchar(255) not null,
    email varchar(255) not null unique,
    foto_path varchar(255) null
)
 
create table tarefa(
    id int not null primary key auto_increment,
    titulo varchar(100) not null unique,
    descricao varchar(255) not null,
    status varchar(100) not null unique,
    user_id varchar(255) not null
    CONSTRAINT fk_usuario_tarefa FOREIGN KEY (user_id) REFERENCES usuario (id) ON DELETE CASCADE ON UPDATE
)

create table tarefa(
    id int not null primary key auto_increment,
    titulo varchar(255) not null,
    descricao text not null unique,
    status tinyint(1) not null,
    user_id int not null,
    CONSTRAINT fk_usuario_tarefa FOREIGN KEY (user_id) REFERENCES usuario (id) 
    ON DELETE CASCADE ON UPDATE CASCADE
)
```