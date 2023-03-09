### PHP Sample code

This sample code requires [Composer](https://getcomposer.org/).

#### Folder structure
```
├── config
│   ├── .env
│   └── .env.sample
├── public
├── src
└── vendor
```
### Installation
```
composer install
```
### Configuration
Configure your .env file:
- In config folder, copy `.env.sample` and name it `.env`
- Replace `CLIENT_ID` and `CLIENT_SECRET` with your OAuth credentials
- Replace `PAYSTATION_ID` and `GATEWAY_ID` to the Paystation supplied IDs
- and `HMAC_KEY` if using 3-party integration
### Run using PHP built-in web server
```
cd sample-composer
php -S localhost:8001 -t public
```
### Sample pages
#### 3-Party 
http://localhost:8001/3party/index.php
#### 2-Party
http://localhost:8001/2party/index.php