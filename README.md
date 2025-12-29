# 📚 Projeto Biblioteca - Raízes do Saber

Este projeto é um **sistema de biblioteca** desenvolvido com foco em **empréstimo de livros**, controle de usuários e administração. Ele foi criado como parte dos estudos em **Análise e Desenvolvimento de Sistemas**, utilizando conceitos de **CRUD**, **MVC**, banco de dados relacional e desenvolvimento web.

---

##  Objetivo do Projeto

O objetivo do sistema é permitir:

* Gerenciar livros disponíveis na biblioteca
* Controlar empréstimos e devoluções
* Gerenciar usuários
* Facilitar o trabalho do administrador

Além disso, o projeto serve como prática de:

* Programação backend com PHP
* Organização de código com padrão MVC
* Integração com banco de dados MySQL
* Uso de Bootstrap para interface

---

##  Tecnologias Utilizadas

* **PHP** (Backend)
* **MySQL** (Banco de Dados)
* **HTML5**
* **CSS3**
* **Bootstrap**
* **JavaScript** (funcionalidades básicas)
* **PDO** (acesso ao banco de dados)


---



##  Banco de Dados

O sistema utiliza um banco de dados relacional com tabelas como:

* **usuario**
* **livro**
* **emprestimo**

Exemplo de tabela de empréstimo:

```sql
CREATE TABLE emprestimo (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_usuario INT NOT NULL,
    id_livro INT NOT NULL,
    data_emprestimo DATETIME DEFAULT CURRENT_TIMESTAMP,
    devolvido TINYINT(1) DEFAULT 0,
    ativo TINYINT(1) NOT NULL DEFAULT 0
);
```

---
##  Funcionalidades

### Usuário

* Visualizar livros disponíveis
* Realizar empréstimo
* Visualizar livros emprestados
* Ateraçôes de nome e email

### Administrador

* Cadastrar livros
* Excluir livros
* Atualizar quantidade de livros
* Gerenciar empréstimos
* Ver empréstimos pendentes e confirmados



---

##  Screenshots do Sistema

> As imagens abaixo apresentam as principais telas do sistema e ajudam a compreender o funcionamento geral sem a necessidade de executar o projeto.

###  Tela de Login

Tela de autenticação para usuários e administradores.

![Tela de Login](src/View/img/printsTela/login.png)

### Dashboard do Usuário
Tela inicial após o login de usuário
![Dashboard Usuário](src/View/img/printsTela/user.png)

###  Perfil do usuário

Tela responsável por mostrar os livros emprestados e o status que se encontra.

![Perfil Usuário](src/View/img/printsTela/perfil.png)

### Dashboard do Administrador

Área principal de gerenciamento do sistema, com acesso às funções administrativas.

![Dashboard Administrador](src/View/img/printsTela/adm.png)


###  Gerenciamento de Livros pendentes(adm)

Listagem de livros com emprestimos pendentes

![Gerenciamento de Livros](src/View/img/printsTela/pendentes.png)


---

##  Fluxo do Sistema

1. O usuário ou administrador realiza o login no sistema
2. O sistema valida as credenciais no banco de dados
3. O usuário visualiza os livros disponíveis
4. O usuário solicita o empréstimo de um livro
5. O administrador gerencia e confirma os empréstimos
6. O usuário realiza a devolução do livro pessoalmente
7. O sistema atualiza o status do empréstimo e a quantidade de livros

---

##  Como Executar o Projeto

1. Clone este repositório:

```bash
git clone https://github.com/seu-usuario/seu-repositorio.git
```

2. Coloque o projeto dentro da pasta do servidor local:

```bash
htdocs/ (XAMPP)
```

3. Crie o banco de dados no **phpMyAdmin** e importe o arquivo `.sql`

4. Configure a conexão com o banco em:

```bash
Dao/ConnectionFactory.php
```

5. Inicie o servidor Apache e MySQL

6. Acesse no navegador:

```bash
http://localhost/Projeto-biblioteca
```
7. OBS: O login de administrador é feito na mesma página de login de usuário com o email:adm@gmail.com e senha:admin@
---

##  Autor

**Claudemir Junior**
Estudante de Análise e Desenvolvimento de Sistemas
Em constante aprendizado em desenvolvimento web e backend

---
