Symfony The Rick and morty api
==============================

Projekt został zrobiony za pomocą:

- Symfony 6.2.6

- PHP 8.2.0 x64

- MariaDB 10.4.27 x64

- Apache 2.4.54 x64

Przed uruchomieniem projektu trzeba założyć bazę danych o nazwie "symfony_the_rick_and_morty_api" i uruchomić migrację. 
Po uruchomieniu projektu jako strony WWW w lewym menu jest link o tytule "Pobierz postacie z API i zapisz do bazy" i wykonuje 
to co nazwa mówi (link http://nazwa_strony/from_api_and_save_db). Podobnie działa link o tytule "Pobierz postacie z bazy jako JSON" 
(link http://nazwa_strony/from_db_json). Jeśli chcemy wyszukać postacie o określonej nazwie np. zaczynające się na aba i wyświetlić 
jako JSON to trzeba wejść w link http://nazwa_strony/from_db_json/aba. Do projektu trzeba dograć biblioteki Symfony i Symfony Webpack-Encore.
