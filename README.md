# Instagram Clone API (Etapa 2)

Este projeto é uma API RESTful desenvolvida em Laravel com autenticação JWT, contendo também um Frontend (Cliente) integrado para testes da Segunda Entrega.

## 📋 Pré-requisitos

Para rodar este projeto em qualquer máquina, você precisará ter instalado:
- [PHP](https://www.php.net/) (versão 8.2 ou superior)
- [Composer](https://getcomposer.org/) (Gerenciador de pacotes do PHP)
- [XAMPP](https://www.apachefriends.org/pt_br/index.html) (Para gerenciar o banco de dados MySQL local)

## 🚀 Como Instalar e Rodar

Siga as instruções abaixo para clonar e rodar o projeto na sua máquina local:

### 1. Preparando o Banco de Dados (XAMPP)
1. Abra o **XAMPP Control Panel**.
2. Inicie os módulos **Apache** e **MySQL** clicando nos botões `Start`.
3. Acesse o **phpMyAdmin** pelo navegador: [http://localhost/phpmyadmin](http://localhost/phpmyadmin)
4. Crie um novo banco de dados vazio (Base de Dados) com o nome exato: `instagram_clone`.

### 2. Baixando e Instalando Dependências
1. Abra o seu terminal (Prompt de Comando, PowerShell ou Terminal do VS Code) na pasta onde o projeto está salvo.
2. Instale as dependências do Laravel rodando o Composer:
   ```bash
   composer install
   ```

### 3. Configurando o Ambiente
1. Renomeie (ou faça uma cópia) do arquivo `.env.example` para `.env` na raiz do projeto.
   ```bash
   cp .env.example .env
   ```
2. Abra o arquivo `.env` e verifique/ajuste as configurações de banco de dados para garantir que estão conectando ao seu MySQL local (XAMPP):
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=instagram_clone
   DB_USERNAME=root
   DB_PASSWORD=
   ```
3. Gere a chave de segurança da aplicação Laravel:
   ```bash
   php artisan key:generate
   ```
4. Gere a chave de segurança do Token JWT:
   ```bash
   php artisan jwt:secret
   ```

### 4. Criando as Tabelas
Com o banco configurado, você precisa criar as tabelas executando as *migrations* e popular o banco com o usuário administrador padrão:
```bash
php artisan migrate:fresh
php artisan db:seed
```

### 5. Ligando o Servidor (Acesso na Rede Local)
Por padrão, o Laravel roda apenas para a sua própria máquina (`localhost`). Como você vai testar com seus colegas, você precisa abrir o servidor para a sua rede local. Inicie o servidor com o comando abaixo (usando a porta 24900 conforme a especificação):
```bash
php artisan serve --host=0.0.0.0 --port=24900
```
> Feito isso, descubra o IP do seu computador (no Windows, abra o prompt e digite `ipconfig` e procure pelo "Endereço IPv4"). 
> Supondo que seu IP seja `192.168.1.15`, seus colegas deverão acessar: `http://192.168.1.15:24900/cadastro`

---

## 📱 Como Testar o Projeto

Nós construímos interfaces web (Frontend) integradas para você não precisar de Insomnia ou Postman!

Para apresentar ou testar os requisitos da **Etapa 2**, basta acessar os links abaixo direto pelo seu navegador:

- **Cadastro de Usuários:** [http://localhost:24900/cadastro](http://localhost:24900/cadastro)
- **Login de Usuários:** [http://localhost:24900/login](http://localhost:24900/login)
- **Dashboard de Perfil (CRUD Completo e Logout):** Ocorre automaticamente após o login ou em [http://localhost:24900/perfil](http://localhost:24900/perfil)
- **Painel Administrativo:** [http://localhost:24900/admin](http://localhost:24900/admin) (Somente para administradores)
  - **Admin Padrão:** Login: `admin` | Senha: `admin1234`
- **Monitor do Servidor:** Para ver logs, lista de cadastrados em tempo real e monitorar sua API acessando a tela em [http://localhost:24900/monitor](http://localhost:24900/monitor)
