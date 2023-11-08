## Laravel Vue.js Tripay Challenge

## How To Use

#### Clone the repository

```bash
git clone https://github.com/ridhoibey0/tripay-challenge
```

#### Copy .env.example file to .env and edit credentials also set app url

## API Server Config Setup

```sh

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=tripay-challenge
DB_USERNAME=root
DB_PASSWORD=


TRIPAY_API_KEY=YOUR_TRIPAY_API_KEY
TRIPAY_PRIVATE_KEY=YOUR_TRIPAY_PRIVATE_KEY
TRIPAY_MERCHANT_CODE=YOUR_TRIPAY_MERCHANT_CODE
```

#### Install Via Composer

```bash
composer install
```

#### Generate Application Key

```bash
php artisan key:generate
```

#### Migrate Database

```bash
php artisan migrate
```

#### Install Node Dependencies

```bash
npm install or yarn install

npm run dev or yarn dev
```

#### Production

```bash
npm run build or yarn build
```
