# Magento Order Management Mock

## Overview
This mock simulates the Magento Order Management system. It is designed to be used for 
local development or test systems which can not connect to a real Magento Order Management
instance.

It supports the basic order workflow interaction between MDC and MOM. This includes the
following functionality:



## Valet + Setup
Run the following commands to set up the mock with Valet +:

```bash
composer update
valet link mom
valet secure
valet db create mom
valet db import setup/db.sql mom
```

Open `app/etc/env.php` in your MDC instance and edit the following
credentials:

```php
'serviceBus' => 
  array (
    'url' => 'https://mom.test/',
    'oauth_server_url' => 'https://mom.test/',
    'oauth_client_id' => 'mom',
    'oauth_client_secret' => 'mom',
    'application_id' => 'mdc',
    'secret' => 'mom',
    'secure_endpoint' => true,
  )
```

Run `bin/magento setup:upgrade --keep-generated` in your MDC instance
to register your MDC instance to the MOM mock and to request your first
OAuth token.