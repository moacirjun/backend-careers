## Job Management System
Um sistema simples para gerenciamento de vagas abertas.
### Tecnologias:
- Symfony 5.1
- MariaDB 10.5
- Nginx
- Docker
- PHPUnit
### Features:
- Cadastro de vagas (Fomuário HTTP e API)
- Login
- Listagem de vagas abertas

### Intruções para instalação
#### Clonar o repositório

``` bash
$ git clone git@github.com:moacirjun/backend-careers.git talentify-test
$ cd talentify-test/talentify-app
```

#### Subir os containers do Docker
``` bash
$ docker-compose up -d
```

#### Instalar as dependências de pacotes
``` bash
$ docker exec -it talentify-app_php-fpm_1 composer install
```

#### Migrations.
``` bash
$ docker exec -it talentify-app_php-fpm_1 php bin/console doctrine:migrations:migrate
```

> OBS: Caso você tenha algum problema aqui, provavelmente foi algum erro ao subir o container do MariaDB. Neste caso, é só rodar o camando `docker-compose up -d` novamente e depois voltar para cá.

#### Criar um usuário ADMIN padrão
Irá criar o usuário ADMIN necessário para cadastrar novas vagas. email: `admin@admin.com` senha: `admin`.
``` bash
$ docker exec -it talentify-app_php-fpm_1 php bin/console doctrine:fixtures:load
```

#### Gerar as chaves ssh para a autenticação JWT da API:
> Atenção: Use a passphrase `12345` para gerar as chaves.
``` bash
$ mkdir -p config/jwt
$ docker exec -it talentify-app_php-fpm_1 openssl genpkey -out config/jwt/private.pem -aes256 -algorithm rsa -pkeyopt rsa_keygen_bits:4096
$ docker exec -it talentify-app_php-fpm_1 openssl pkey -in config/jwt/private.pem -out config/jwt/public.pem -pubout
$ docker exec -it talentify-app_php-fpm_1 chown -R www-data:www-data config/jwt
```

### Uso
#### HTTP
- `GET localhost:8080` lista todos os jobs abertos. 
- `GET localhost:8080/admin/jobs` Formulário para criar jobs.

#### API
##### Registrar se como usuário da API
``` bash
curl --location --request POST 'localhost:8080/api/register' --form '_email=tests@test.com' --form '_password=test'
```
##### Gerar um  JWT
``` bash
curl --location --request POST 'localhost:8080/api/login_check' --header 'Content-Type: application/json' \
--data-raw '{
    "username": "tests@test.com",
    "password": "test"
}'
```

Resposta esperada:
```json
{
   "token" : "eyJhbGciOiJSUzI1NiIsInR5cCI6IkpXUyJ9.eyJleHAiOjE0MzQ3Mjc1MzYsInVzZXJuYW1lIjoia29ybGVvbiIsImlhdCI6IjE0MzQ2NDExMzYifQ.nh0L_wuJy6ZKIQWh6OrW5hdLkviTs1_bau2GqYdDCB0Yqy_RplkFghsuqMpsFls8zKEErdX5TYCOR7muX0aQvQxGQ4mpBkvMDhJ4-pE4ct2obeMTr_s4X8nC00rBYPofrOONUOR4utbzvbd4d2xT_tj4TdR_0tsr91Y7VskCRFnoXAnNT-qQb7ci7HIBTbutb9zVStOFejrb4aLbr7Fl4byeIEYgp2Gd7gY"
}
```

Com este token você pode consumir as vagas abertas.

``` bash
curl --location --request GET 'localhost:8080/api/jobs' --header 'Authorization: Bearer {JWT_TOKEN}'
```

##### JWT com privilégios de ADMIN.
``` bash
curl --location --request POST 'localhost:8080/api/login_check' \
--header 'Content-Type: application/json' \
--data-raw '{
    "username": "admin@admin.com",
    "password": "admin"
}'
```
Com este token você pode cadastrar novas vagas.
``` bash
curl --location --request POST 'localhost:8080/api/admin/jobs' --header 'Authorization: Bearer {JWT_TOKEN}' --header 'Content-Type: application/json' \
--data-raw '{
    "title": "title example",
    "description": "description example",
    "status": "visible",
    "workplace": {
        "postcode": 12312312,
        "number": 123123
    },
    "salary": 3500
}'
```
