# Property Search API

Laravel + Vue.js + Element Plus property search application.

## Setup

```bash
composer install
npm install
cp .env.example .env
php artisan key:generate
php artisan migrate --seed
```

## Run

```bash
php artisan serve
npm run dev
```

Open: http://127.0.0.1:8000

## API

`GET /api/properties/search?name=&bedrooms=&bathrooms=&storeys=&garages=&price_min=&price_max=`
