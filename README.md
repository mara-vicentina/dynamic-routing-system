Obs: Este projeto utiliza o composer, se ele não estiver instalado é preciso fazer a sua instalação antes de rodar o próximo passo É só acessar o link abaixo e fazer a instalação https://getcomposer.org/

Passo 1: Para configurações iniciais do projeto utilize o comando composer install

Passo 2: Para conectar ao seu banco de dados é só copiar o arquivo .env.exemple e renomear para .env e fazer a conexão na linha 22 até 27 colocando sua connection, seu host, o nome do database, seu username e sua password. Assim como no exemplo abaixo:

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=dynamic_routing_system
DB_USERNAME=root
DB_PASSWORD=

Passo 3: Utilize o comando abaixo para criação das tabelas e colunas no banco de dados configurado:
php artisan migrate

Passo 4: Utilize o comando abaixo para configurar as credenciais de acesso via token:
php artisan passport:client --personal

Passo 5: Insira no teminal o comando abaixo, responsável por iniciar o front-end do sistema:
npm run dev

Passo 6: Em outro terminal insira o comando abaixo, responsável por iniciar uma aplicação Laravel:
php artisan serve
Para acesso a página de login utilize a rota fornecida ao rodar o comando acima: http://127.0.0.1:8000

Passo 7: Para acesso ao sistema utilize as seguintes credenciais:
e-mail: admin@admin.com
senha: admin

