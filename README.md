## Job Management System
Um sistema simples para gerenciamento de vagas abertas.
#### Tecnologias:
- Symfony 5.1
- MariaDB 10.5
- Nginx
- Docker
- PHPUnit
#### Features:
- Cadastro de vagas
- Login
- Listagem de vagas abertas

#### Intruções para instalação
- Clone o repositório
>`git clone git@github.com:moacirjun/backend-careers.git talentify-test`

- Mude para o diretório com o código do projeto
> `cd talentify-test/talentify-app`

- Suba os containers do Docker
> `docker-compose up -d`

- Instale as dependências de pacotes
> `docker exec -it talentify-app_php-fpm_1 composer install`

- Migrations.
> `docker exec -it talentify-app_php-fpm_1 php bin/console doctrine:migrations:migrate`

OBS: Caso você tenha algum problema aqui, provavelmente foi algum erro ao subir o container do MariaDB. Neste caso, é só rodar o camando `docker-compose up -d` novamente e depois voltar para cá.

- Crie um usuário ADMIN padrão
> `docker exec -it talentify-app_php-fpm_1 php bin/console doctrine:fixtures:load`

- Então é só acessar o endereço `localhost:8080` no seu navegador.