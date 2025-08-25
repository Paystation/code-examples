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
- Change `CLIENT_ID` and `CLIENT_SECRET` to your OAuth credentials. These are issued to you by support staff when your account is created and activated. To rotate the `CLIENT_SECRET`, you'll need to raise a support request
- Change `PAYSTATION_ID` and `GATEWAY_ID` to the Paystation supplied IDs
    - Your Paystation ID will be issued to you by support staff, and is visible in the top-left of the [admin dashboard](https://admin.paystation.co.nz/dashboard.php)
    - Your Gateway ID is "DEVELOPMENT" for test-mode.  In live mode, it can be found in the [Gateway Admin](https://admin.paystation.co.nz/gateway_admin.php
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