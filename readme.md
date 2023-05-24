![Peek 23-05-2023 22-47](https://github.com/soaresrodrigo/todo-list/assets/15149046/332d047b-0da4-45f7-aca5-80c1c8bd5b31)
# Bem vindo a documentação do sistema lista de tarefas

## Esse projeto foi dividido em 2 módulos, sendo eles api e frontend. A *API* foi feita em laravel e precisa ser levantada antes do frontend, e o *frontend* foi feito em vue js.

# Levantando a API

## Descrição

Este é um projeto Laravel que implementa uma lista de tarefas (todolist) simples.

## Pré-requisitos

- PHP >= 7.3
- Composer
- Servidor de banco de dados MySql

## Instalação

Siga as instruções abaixo para configurar a api:

1. Clone este repositório em sua máquina local `git clone https://github.com/soaresrodrigo/todo-list`
2. Entre na pasta api usando o comando `cd api`
3. Crie uma cópia do .env.example usando o comando `cp .env.example .env`
4. Dentro do arquivo *.env*, na seção *DB_*, passe as informações referente ao seu banco de dados local.
5. Crie uma database com o mesmo nome passado no arquivo *.env*, pois ele precisa existir para gerar as migrations.
6. Instale as dependências do projeto usando o Composer: `composer install`
7. Gere uma chave única para a aplicação Laravel usando o comando `php artisan key:generate`
8. Execute os migrations para criar as tabelas do banco de dados usando o comando `php artisan migrate`

Siga as instruções abaixo para executar a api:

1. Inicie o servidor embutido do Laravel (aqui você configura a porta desejada, eu escolhi a 9090): `php artisan serve --port=9090`
2. Deixe seu servidor executando para que a aplicação do vue.js recupere os dados da API.

# Levantando a aplicação frontend

## Descrição

Interface de usuário usando Vue.js 2 para exibir e gerenciar as
tarefas.

## Instalação

Siga as instruções abaixo para instalar e acessar a interface:

1. Instale as dependências do front-end usando npm(Ou outro gerenciador de pacotes da sua preferência): `npm install`
2. Crie uma cópia do .env.example usando o comando `cp .env.example .env`
2. Dentro do arquivo *.env*, na variável 'VITE_BASE_URL', coloque o caminho e a porta exibido no terminal do servidor laravel.
2. Compile os assets do Vue: `npm run dev`
5. A URL informada no terminal vai ser o caminho para ser acessado no seu navegador.


# Utilizando a aplicação

- A aplicação é uma lista de tarefas que foi dividida em 2 categorias, a categoria `Para fazer`(onde as tarefas não estão concluídas) e a categoria `Feitas`(onde as tarefas estão concluídas).
- Para cadastrar uma tarefa, tem que apertar o botão "ADICIONAR TAREFA", que ficam localizados acima das categorias e dentro da categoria `Para fazer`, informe o título e a descrição para cadastrar e ela vai para a categoria propriamente dita, pois ela começa como não concluída.
- Para visualizar os detalhes de uma determinada tarefa, deve-se clicar em cima do título da mesma onde se abrirá uma modal informando o título, descrição e última modificação.
- Para concluir a tarefa pode clicar no primeiro ícone à direita da tarefa referida, que será movida para a categoria `Feitas` e caso queira reabrir ou desfazer o concluído, pode clicar no primeiro ícone da tarefa nessa mesma categoria (Com o cursor do mouse em cima de cada ícone, pode ver o título deles).
- Para editar qualquer tarefa, clique no segundo ícone (que representa um lápis) de uma determinada tarefa e modifique o título ou a descrição dela.
- Para excluir qualquer tarefa, clique no terceiro ícone (que representa uma lixeira) e confirme a exclusão.
- Para cadastrar ou atualizar, precisa informar os campos de título e descrição.


### Aproveite seu mais novo gerenciador de tarefas!