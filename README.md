# demo_games

Самописный фреймворк MVC.

1. Обновить и установить все зависимости:
   composer update
3. Загрузить образы и собрать контейнер:
   docker compose -f docker-compose.yml up -d --build
4. Импортировать таблицы из /migrates/demo_games.sql в базу demo_games.
