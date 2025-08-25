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
- Replace `CLIENT_ID` and `CLIENT_SECRET` with your OAuth credentials.  These are issued to you by support staff when your account is created and activated. To rotate the `CLIENT_SECRET`, you'll need to raise a support request
- Replace `PAYSTATION_ID` and `GATEWAY_ID` to the Paystation supplied IDs.  
    - Your Paystation ID will be issued to you by support staff, and is visible in the top-left of the [admin dashboard](https://admin.paystation.co.nz/dashboard.php)
    - Your Gateway ID is "DEVELOPMENT" for test-mode.  In live mode, it can be found in the [Gateway Admin](https://admin.paystation.co.nz/gateway_admin.php)
- and `HMAC_KEY` if using 3-party integration.  This can be found in [Gateway Admin](https://admin.paystation.co.nz/gateway_admin.php)

The keys should not automatically expire at a set time, but they can be revoked for any reason.  Please reach out to support if you suspect an issue with your keys.

For testing, [please use the test cards issued here.]( https://paystation.co.nz/developers/test-cards/)

### Testing the 3rd party post-response

This is basically a webhook, and can only be tested on a publicly exposed webserver.  For developers in a protected environment, you'll need to consider services such as ngrok.io or webhook.site. You can set this value in the [Gateway Admin](https://admin.paystation.co.nz/gateway_admin.php) and activating "Send Post Response", see the Post response URL fields.  This value can be overridden in code, by setting `response_url` in the initial POST request to the API URL.

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