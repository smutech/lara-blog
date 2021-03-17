# Larablog
Larablog is a blog post web application using [Laravel](https://github.com/laravel/laravel) 8. Using this, you can create, view, edit, and delete blog. Follow other users and can also view others profile. The important feature is, the user you follow, their latest blog post will be shown on your home page.

## Quick start
```
# Install dependencies
composer install

# Create environment
cp .env.example .env

# Generate application key
php artisan key:generate

# Create database

# Run migrations and seeds
php artisan migrate --seed

# Create symbolic link between storage/app/public and public/storage
php artisan storage:link

# Start server
php artisan serve
```

## Features
- Authentication <a href="https://github.com/laravel/breeze">(Laravel breeze)</a>
- View profile, update profile, upload profile picture.
- View others profile, see their followers and following.
- See all latest blog posts. Also create, view, edit and delete blog post.
- Follow other users.
- The user you follow, their latest blog posts will automatically be shown on your home page.

