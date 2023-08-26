Instruções:
// Configurando front

(Abra um terminal na raiz da aplicação e instale as dependências do vue e compile os component do front da aplicação)

`npm i && npm start`


// Configurando API

obs. Abra outra janela do terminal na raiz da aplicação.

(crie um banco para a aplicação, depois cole o conteúdo do .env.example para o novo arquivo .env e configure as variáveis de ambiente do mysql ou banco de preferência com as credenciais do seu ambiente)

`cp .env.example .env`

(instale a dependências da aplicação com o composer)

`composer install`

(rode as migrations para criação das tabelas necessárias no banco)

`php artisan migrate`

(Crie um link simbólico do diretório storage para que as imagens dos games e console fique no diretório public)

`php artisan storage:link`

(Gere a chave de criptografia da api)

`php artisan key:generate`

(Agora, inicie seu servidor para testar todas as funcionalidades da aplicação)

`php artisan serve`