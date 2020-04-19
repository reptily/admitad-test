# Установка

* Клонируем репозиторий
```bash
git clone git@github.com:reptily/admitad-test.git
```

* Переходим в директорию с проектом
```bash
cd admitad-test
```

* Поднимаем демон Docker:
```bash
docker-compose up -d && docker-compose ps
```

* Устанавливаем все зависимости
```bash
docker exec app composer install
```

* Устанавливаем права доступа на запись логов и кеш файлов
```bash
docker exec app chmod 777 storage/ -R
```

* Копируем настройки по умолчанию
```bash
docker exec app cp .env.example .env
```

* Создаем ключ приложения
```bash
docker exec app ./artisan key:generate
```

* Мигрируем базы
```bash
docker exec app ./artisan migrate
```

После установки веб проект доступен по адрессу http://127.0.0.1:7000/

## Демо
Демонстрационная версия доступна по адресу http://go2ride.asuscomm.com:7000/
