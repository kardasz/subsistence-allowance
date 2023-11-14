# Subsistence allowance calculator

## Setup 

- `docker compose up -d` - run docker containers
- `docker compose exec php composer install` - install composer dependencies
- `docker compose exec php composer tests` - run phpunit tests

## Endpoints

### Create employee

`POST '/api/employee`

### Create business trip

```
POST /api/business-trip
Content-Type: application/json

{
    "employee_id": "$employeeId",
    "country": "PL",
    "start": "2023-11-13 00:00:00",
    "end": "2023-11-17 23:59:59"
}
```

### List business trip

`GET /api/business-trip`

### DDD

#### Contexts

- Employee
- SubsistenceAllowance
- Shared
