# demo_games

Самописный фреймворк MVC.

1. Обновить и установить все зависимости:
   composer update
2. Загрузить образы и собрать контейнер:
   composer docker-compose-build
3. Импортировать базу данных:
   composer db-migrate

или запустить одну команду:
composer dev-deploy
