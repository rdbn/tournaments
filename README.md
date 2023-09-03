## Tournaments

Для развертывания проекта, зависимости и миграции он тоже накатит
> make init

Прописать хост
```
echo tournament.local >> /etc/hosts
``` 
Сам сервак на 88 порту
> tournament.local:88 

Поднять приложение
> make up

Положить приложение
> make down

Общий список команд
```
make build
make migration
make fixtures
make composer
make init_db (migration + fixtures)
make init
make up
make down
```
