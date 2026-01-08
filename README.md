<!-- GETTING STARTED -->
## Getting Started

Proyek ini dirancang untuk memenuhi tugas besar mata kuliah Pengembangan Aplikasi Website. Proyek ini merupakan Sistem Manajemen Kantin T-Mart Gedung TULT, yang dibuat menggunakan Laravel + Breeze. Proyek ini memiliki fitur CRUD utama, yaitu

1. Fitur Manajemen User (Admin, Seller, Customer)
2. Fitur Manajemen Menu
3. Fitur Pemesanan Menu
4. Fitur Pengiriman Menu
5. Fitur Manajemen Jasa Kirim
6. Fitur Tracking Pengiriman

### Installation

Berikut merupakan tahap instalasi yang harus dilakukan untuk menjalankan proyek ini. Terdapat 2 metode: menggunakan Docker (recommended) atau Laragon.

#### **Metode 1: Menggunakan Docker (Recommended)**

Docker menyediakan lingkungan yang konsisten di semua mesin, tanpa perlu instalasi database terpisah.

**Prasyarat:** Pastikan [Docker Desktop](https://www.docker.com/products/docker-desktop) sudah terinstall.

1. Clone the repository
   ```sh
   git clone https://github.com/zamzamyst/PAW-KELOMPOK7-SI4710.git
   cd PAW-KELOMPOK7-SI4710
   ```

2. Install dependencies
   ```sh
   composer install
   npm install
   npm run build
   ```

3. Setup environment file
   ```sh
   cp .env.example .env
   php artisan key:generate
   ```

4. Start Docker containers (includes Laravel app, MySQL, and PhpMyAdmin)
   ```sh
   docker-compose up -d --build
   ```
   
   **Note:** The `--build` flag builds the Docker image from the Dockerfile. If you only want to start containers (skip if image already built):
   ```sh
   docker-compose up -d
   ```

5. Run database migrations
   ```sh
   docker-compose exec app php artisan migrate:fresh
   ```

6. Seed database dengan test data
   ```sh
   docker-compose exec app php artisan db:seed --class=RolePermissionSeeder
   docker-compose exec app php artisan db:seed --class=UserSeeder
   docker-compose exec app php artisan db:seed --class=MenuSeeder
   docker-compose exec app php artisan db:seed --class=DeliveryServiceSeeder
   ```

7. Access the application
   - **Laravel App:** http://localhost:8000
   - **GraphQL Playground:** http://localhost:8000/graphql-playground.html
   - **PhpMyAdmin:** http://localhost:8081 (Username: `tmart_user` / Password: `tmart_password`)

**To stop the project:**
```sh
docker-compose down
```

#### **Metode 2: Menggunakan Laragon (Local Development)**

Jika lebih suka menggunakan Laragon, gunakan langkah-langkah berikut:

1. Clone the repository
   ```sh
   git clone https://github.com/zamzamyst/PAW-KELOMPOK7-SI4710.git
   ```
2. Move to directory
   ```sh
   cd PAW-KELOMPOK7-SI4710/
   ```
3. Install Composer packages
   ```sh
   composer install
   ```
4. Install NPM packages
   ```sh
   npm install
   ```
5. Run NPM packages
   ```sh
   npm run build
   ```
6. Copy the `.env.example` file to `.env`
   ```sh
   cp .env.example .env
   ```
7. Setup your database configuration in `.env` sesuai konfigurasi Laragon
8. Run database migrations
   ```sh
   php artisan migrate:fresh
   ```
9. Generate application encryption key (jika belum)
   ```sh
   php artisan key:generate
   ```
10. Seed roles and permission
    ```sh
    php artisan db:seed --class=RolePermissionSeeder
    ```
11. Seed all user
    ```sh
    php artisan db:seed --class=UserSeeder
    ```
12. Seed template menu
    ```sh
    php artisan db:seed --class=MenuSeeder
    ```
13. Seed delivery service
    ```sh
    php artisan db:seed --class=DeliveryServiceSeeder
    ```
14. Start laravel project
    ```sh
    php artisan serve
    ```

### Cara Penggunaan

Untuk menggunakan fitur CRUD pada proyek ini, anda harus login dengan 2 jenis akun yang tersedia pada `database/seeders/UserSeeder.php`.

1. Login menggunakan email `admin@gmail.com`
2. Isi password `12345678`

---

## 🔧 Docker Troubleshooting

### Docker Build Error (Exit Code 100)
Jika mendapat error saat `docker-compose up -d`:
```
failed to solve: process "/bin/sh -c apt-get update..." did not complete successfully: exit code: 100
```

**Solusi:**
```bash
# 1. Clean everything
docker-compose down -v
docker system prune -a

# 2. Rebuild dengan fresh cache
docker-compose up -d --build
```

**Jika masih error:**
```bash
# Build tanpa cache
docker-compose build --no-cache
docker-compose up -d
```

**Penyebab umum:**
- Network timeout (coba ulangi beberapa saat kemudian)
- Disk space penuh (jalankan `docker system prune -a`)
- Docker daemon issue (restart Docker Desktop)

---

## 📚 Documentation

- [GraphQL Detail Schema](GRAPHQL_SCHEMA_DOCUMENTATION.md) - Detail skema GraphQL
- [GraphQL Testing Guide](GRAPHQL_TESTING_GUIDE.md) - Cara menggunakan GraphQL Playground

<p align="right">(<a href="#readme-top">back to top</a>)</p>
