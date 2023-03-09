### PHP Sample code

#### Folder structure
```
├── public
├── functions.php
└── config.php
```

### Configuration
Modify your config file:
- Edit `config.php`
- Change `CLIENT_ID` and `CLIENT_SECRET` to your OAuth credentials
- Change `PAYSTATION_ID` and `GATEWAY_ID` to the Paystation supplied IDs
- and `HMAC_KEY` if using 3-party integration
### Run using PHP built-in web server
```
cd sample-curl
php -S localhost:8002 -t public
```
### Sample pages
#### 3-Party
http://localhost:8002/3party/index.php
#### 2-Party
http://localhost:8002/2party/index.php