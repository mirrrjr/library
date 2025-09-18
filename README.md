# 📚 Library API

Laravel asosida qurilgan Library Management System (Kutubxona boshqaruv tizimi).
Ushbu loyiha orqali foydalanuvchilar kitoblarni qo‘shishi, ijaraga olishi va qaytarishi, mualliflar statistikasi va eng ko‘p o‘qilgan kitoblar haqida hisobot olishlari mumkin.

## ✨ Asosiy funksionallar

### 🔐 Autentifikatsiya va Ruxsatlar

-   Laravel Sanctum orqali API autentifikatsiya

-   Role & Permission (Spatie Laravel Permission)

    -   `admin` – barcha huquqlar

    -   `author` – kitob qo‘shish, tahrirlash, ko‘rish

    -   `user` – faqat ko‘rish va kitobni ijaraga olish

### 📖 Kitoblar (Books)

-   Kitob qo‘shish, tahrirlash, o‘chirish, ko‘rish

-   Kitoblar muallif nomi va sarlavha bo‘yicha qidirilishi mumkin

-   Kitob statuslari: available, rented

### 📑 Ijara (Rentals)

-   Kitobni ijaraga berish (rentBook)

-   Kitobni qaytarish (returnBook)

-   Joriy ijaradagi kitoblarni ko‘rish

-   Muddati o‘tgan kitoblar ro‘yxati

### 📊 Hisobotlar

-   Eng ko‘p ijaraga olingan (o‘qilgan) kitoblar

-   Har bir muallifning kitoblari statistikasi

-   Joriy vaqtda nechta kitob ijarada

### 🛠 Texnologiyalar

-   Backend: Laravel 11, PHP 8+

-   Autentifikatsiya: Laravel Sanctum

-   Ruxsatlar: Spatie Laravel Permission

-   DB: MySQL

## 📌 API Endpointlar

### Auth

-   POST /api/register – Ro‘yxatdan o‘tish

-   POST /api/login – Login

-   POST /api/logout – Logout (auth:sanctum)

### Users

-   GET /api/users – Foydalanuvchilar ro‘yxati

-   GET /api/users/{id} – Foydalanuvchi bo‘yicha ma’lumot

-   PUT /api/users/{id} – Foydalanuvchi malumotlarini o'zgartirish
-   GET /api/users/books/{id} – Foydalanuvchi kitoblari

### Books

-   GET /api/books – Kitoblar ro‘yxati

-   POST /api/books – Kitob qo‘shish

-   PUT /api/books/{id} – Kitobni tahrirlash

-   DELETE /api/books/{id} – Kitobni o‘chirish

### Rentals

-   POST /api/rentals/rent/{bookId} – Kitobni ijaraga olish

-   POST /api/rentals/return/{bookId} – Kitobni qaytarish

-   GET /api/rentals/active – Joriy ijaradagi kitoblar

-   GET /api/rentals/overdue – Muddati o‘tgan kitoblar

### Reports

-   GET /api/reports/top-books – Eng ko‘p o‘qilgan kitoblar

-   GET /api/reports/author-statistics – Mualliflar statistikasi

-   GET /api/reports/current-rentals – Joriy ijaradagi kitoblar soni
