# php-postgres-laminas-doctrine-rest-api 

Сервис постановки и контроля выполнения задач предоставляет возможность пользователю сервиса создавать и просматривать свою коллекцию задач. Все данные пользователя сохраняются в БД. Взаимодействие пользователя с сервисом осуществляется через API. Подсистему пользователей с аутентификацией и авторизацией реализовывать не нужно. Пользоваться сервисом будет единственный анонимный пользователь.

## Service using technology
    REST-API

## Main principles:
    SOLID,
    DTO(Data Transfer Object)

## Tech stack:
    php 7.4, PostgreSQL 11, nginx, laminas, doctrine, vlucas/phpdotenv, git, Dockerfile, compose.yml, linux, shell

```sql
                                         Table "public.tasks"
   Column    |            Type             | Collation | Nullable |              Default              
-------------+-----------------------------+-----------+----------+-----------------------------------
 id          | integer                     |           | not null | nextval('tasks_id_seq'::regclass)
 title       | character varying(255)      |           | not null | 
 description | text                        |           | not null | 
 created_at  | timestamp without time zone |           | not null | 
Indexes:
    "tasks_pkey" PRIMARY KEY, btree (id)
    "idx_tasks_created_at" btree (created_at DESC)
```

## Introduction for start

```bash
git clone https://github.com/Ekvo/php-postgres-laminas-doctrine-rest-api.git
```
```bash
cd php-postgres-laminas-doctrine-rest-api \
  && cp .env.example .env \
  && docker compose up -d
```

#### dependency
```bash
# need use php-postgres-laminas-doctrine-rest-api-app - CONTAINER ID 
# without []
docker exec -it [CONTAINER ID] composer install
```

#### migrations
```bash 
docker exec -it [CONTAINER ID] ./vendor/bin/doctrine-migrations migrate
#APP is ready
```

## curl

#### create a task
```http request
curl -X POST http://localhost:8080/api/todo \
  -H "Content-Type: application/json" \
  -d '{
    "title": "Buy groceries for the week",
    "description": "Purchase fruits, vegetables, bread, and milk from the supermarket.",
    "created_at": "1970-01-01 00:00:01"
  }'
# result {"message":"create_status"}
```

#### get List of Task
```http request
curl -X GET http://localhost:8080/api/todo \
  -H "Content-Type: application/json"
# result - [{"id":2,"title":"title1","description":"desc1","created_at":"1970-01-01 00:00:01"}]
# or {"error":"not found"}
```

#### get a Task
```http request
curl http://localhost:8080/api/todo/1
# result - {"id":2,"title":"title1","description":"desc1","created_at":"1970-01-01 00:00:01"} 
# or {"error":"not found"}
```


#### update a Task
```http request
curl -X PUT http://localhost:8080/api/todo/1 \
  -H "Content-Type: application/json" \
  -d '{
    "title": "Update user profile documentation",
    "description": "Revise the API docs for user profile endpoints and add examples.",
    "created_at": "2025-04-05 12:30:00"
  }'
# result - {"message":"update_status"} or {"error":"not found"}
```

#### delete a Task
```http request
curl -X DELETE http://localhost:8080/api/todo/1
# result - {"message":"delete_status"} or {"error":"not found"}
```

#### any path
```http request
# GET DELETE POST PUT ...
curl http://localhost:8080/ 
# {"error":"resource was not found"}
```

p.s. Thanks for your time:)