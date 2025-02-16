# Laravel Fund Management API

## 📌 Overview

This project is a **Laravel API** for managing investment funds, including:

- CRUD operations for **Funds** and **Fund Managers**.
- **Aliases** for Funds.
- Event-driven logging for **duplicate fund warnings**.
- Structured using **Repositories, Services, and Events**.

---

## 📌 Requirements

To run this project, you need:

- **Docker & Docker Compose** (for containerized environment)
- **Git** (to clone the repository)
- **cURL or Postman** (for API testing)
- **Composer** (to manage PHP dependencies)

## 🚀 Setup & Run the Project

### 1️⃣ **Clone the Repository**

```sh
git clone https://github.com/ruhancomh/funds-project.git
cd funds-project
```

### 2️⃣ **Start the Docker Containers**

```sh
docker-compose up --build -d
```

### 3️⃣ **Install Dependencies**

```sh
docker exec -it laravel_app composer install
```

### 4️⃣ **Run Migrations & Seed Database**

```sh
docker exec -it laravel_app php artisan migrate:fresh --seed
```

### 4️⃣ **Update Storage Permissions (ONLY FOR DEV ENV)**

```sh
docker exec -it laravel_app chmod -R 777 /var/www/html/storage
docker exec -it laravel_app chmod -R 777 /var/www/html/bootstrap/cache
```

### 5️⃣ **Clear Cache (Optional)**

```sh
docker exec -it laravel_app php artisan optimize:clear
```

---

## 📌 API Endpoints

### 🟢 **1. Create a New Fund**

**`POST /api/funds`**  
Creates a new fund with an optional list of aliases.

#### 🔹 **Request Parameters**

| Parameter         | Type   | Required | Description                            |
|-------------------|--------|----------|----------------------------------------|
| `name`            | string | ✅ Yes    | Name of the fund                       |
| `start_year`      | int    | ✅ Yes    | The year the fund was started          |
| `fund_manager_id` | int    | ✅ Yes    | The fund manager's ID                  |
| `aliases`         | array  | ❌ No     | List of alternative names for the fund |

#### ✅ **Full cURL Request**

```sh
curl -X POST "http://localhost:8080/api/funds"      -H "Content-Type: application/json"      -d '{
          "name": "Tech Fund",
          "start_year": 2024,
          "fund_manager_id": 1,
          "aliases": ["Tech Growth", "AI Fund"]
         }'
```

#### 📤 **Corrected Response Example**

```json
{
    "message": "Fund created successfully",
    "data": {
        "id": 10,
        "name": "Tech Fund",
        "start_year": 2024,
        "fund_manager": {
            "id": 1,
            "company": {
                "id": 5,
                "name": "Wealth Management Ltd"
            }
        },
        "aliases": [
            {
                "id": 1,
                "alias": "Tech Growth"
            },
            {
                "id": 2,
                "alias": "AI Fund"
            }
        ]
    }
}
```

---

### 🟡 **2. Update a Fund**

**`PUT /api/funds/{id}`**  
Updates fund details including its manager.

#### 🔹 **Request Parameters**

| Parameter         | Type   | Required | Description              |
|-------------------|--------|----------|--------------------------|
| `name`            | string | ✅ Yes    | Updated name of the fund |
| `start_year`      | int    | ✅ Yes    | Updated start year       |
| `fund_manager_id` | int    | ✅ Yes    | Updated fund manager ID  |

#### ✅ **Full cURL Request**

```sh
curl -X PUT "http://localhost:8080/api/funds/5"      -H "Content-Type: application/json"      -d '{
          "name": "Updated Tech Fund",
          "start_year": 2025,
          "fund_manager_id": 2
         }'
```

#### 📤 **Corrected Response Example**

```json
{
    "message": "Fund updated successfully",
    "data": {
        "id": 5,
        "name": "Updated Tech Fund",
        "start_year": 2025,
        "fund_manager": {
            "id": 2,
            "company": {
                "id": 6,
                "name": "Alpha Capital"
            }
        },
        "aliases": []
    }
}
```

---

### 🔵 **3. Get All Funds (With Filters)**

**`GET /api/funds`**  
Retrieves all funds, optionally filtered by **name, manager, or year**.

#### 🔹 **Query Parameters**

| Parameter      | Type   | Required | Description                         |
|----------------|--------|----------|-------------------------------------|
| `name`         | string | ❌ No     | Filter by fund name                 |
| `fund_manager` | string | ❌ No     | Filter by fund manager company name |
| `year`         | int    | ❌ No     | Filter by start year                |

#### ✅ **Full cURL Request**

```sh
curl -X GET "http://localhost:8080/api/funds?name=Tech&fund_manager=Wealth%20Management%20Ltd&year=2024"      -H "Accept: application/json"
```

#### 📤 **Corrected Response Example**

```json
[
    {
        "id": 10,
        "name": "Tech Fund",
        "start_year": 2024,
        "fund_manager": {
            "id": 1,
            "company": {
                "id": 5,
                "name": "Wealth Management Ltd"
            }
        },
        "aliases": [
            {
                "id": 1,
                "alias": "Tech Growth"
            }
        ]
    }
]
```

---

## 🔥 Logs & Debugging

### 📄 **View Laravel Logs**

```sh
docker exec -it laravel_app tail -f storage/logs/laravel.log
```

### 🛠 **Check Running Docker Containers**

```sh
docker ps
```

### 🛠 **Restart the Application**

```sh
docker-compose restart
```

---

## 🚀 **Next Steps / Improvements**

- Implement **pagination** for large fund lists.
- Add **authentication & authorization** for API security.
- Extend **event-driven logging** with email alerts.
