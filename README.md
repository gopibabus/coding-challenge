# Coding Challenge

### How to Set up and run the Application
```bash
# Copy Config
cp ./.env ./.env.local

DATABASE_URL="mysql://root:root@127.0.0.1:3306/note_taking_app"

# Install php dependencies
composer update

# Spin docker container for creating database
docker-compose up

# Create Database
php bin/console doctrine:database:create

# Migrate data to database
php bin/console doctrine:migrations:migrate

# Serve Application
symfony serve (OR) symfony server start
```

### Screenshots

![notes](img.png)

---

![new note](img_2.png)

---

![tags](img_1.png)
