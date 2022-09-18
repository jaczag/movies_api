## Projekt movies_api

### Instalacja

Zmiana nazwy pliku z z katalogu głównego repozytorium .env.example do .env (./.env.example)

Uruchomienie komendy <code>docker-compose build</code>

Uruchomienie komendy <code>docker-compose up -d</code>

Uruchomienie komendy <code>docker exec -it movies_api bash</code>

Uruchomienie komendy <code>composer update</code>

Uruchomienie komendy <code>php artisan key:generate</code>

Uruchomienie komendy <code>php artisan migrate</code>

Uruchomidnie komendy <code>php artisan db:seed</code>

### Uruchomienie

Uruchomienie komendy <code>docker-compose up -d</code>


### Testy:

Utworzenie .env.testing

Skonfigurowanie wewnątrz połączenia z testować bazą danych

Uruchomienie komendy <code>docker-compose up -d</code>
<code>php artisan config:cache --env=testing</code>
<code>php artisan test</code>

### Dokumentacja:

- 
