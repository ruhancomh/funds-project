# Laravel Fund Management API

## 📌 Overview
This project is a **Laravel API** for managing investment funds, including:
- CRUD operations for **Funds** and **Fund Managers**.
- **Aliases** for Funds.
- Event-driven logging for **duplicate fund warnings**.
- Structured using **Repositories, Services, and Events**.

---

## 🚀 Setup & Run the Project

### 1️⃣ **Clone the Repository**
```sh
git clone https://github.com/ruhancomh/funds-project.git
cd laravel-fund-management
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
docker exec -it laravel_app php artisan migrate --seed
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

#### ✅ **Request Example**
```json
{
    "name": "Tech Fund",
    "start_year": 2024,
    "fund_manager_id": 1,
    "aliases": ["Tech Growth", "AI Fund"]
}
```

#### 📤 **Response Example**
```json
{
    "message": "Fund created successfully",
    "data": {
        "id": 10,
        "name": "Tech Fund",
        "start_year": 2024,
        "fund_manager": { "id": 1, "name": "Wealth Management Ltd" },
        "aliases": [
            { "id": 1, "alias": "Tech Growth" },
            { "id": 2, "alias": "AI Fund" }
        ]
    }
}
```

---

### 🟡 **2. Update a Fund**
**`PUT /api/funds/{id}`**  
Updates fund details including its manager.

#### ✅ **Request Example**
```json
{
    "name": "Updated Tech Fund",
    "start_year": 2025,
    "fund_manager_id": 2
}
```

#### 📤 **Response Example**
```json
{
    "message": "Fund updated successfully",
    "data": {
        "id": 10,
        "name": "Updated Tech Fund",
        "start_year": 2025,
        "fund_manager": { "id": 2, "name": "Alpha Capital" },
        "aliases": []
    }
}
```

---

### 🔵 **3. Get All Funds (With Filters)**
**`GET /api/funds`**  
Retrieves all funds, optionally filtered by **name, manager, or year**.

#### ✅ **Request Example**
```
GET /api/funds?name=Tech&fund_manager=Wealth Management Ltd&year=2024
```

#### 📤 **Response Example**
```json
[
    {
        "id": 10,
        "name": "Tech Fund",
        "start_year": 2024,
        "fund_manager": { "id": 1, "name": "Wealth Management Ltd" },
        "aliases": [
            { "id": 1, "alias": "Tech Growth" }
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
