# monolog-stackdriver-handler
Monolog Handler Structured Logging (https://cloud.google.com/logging/docs/structured-logging)

## Installation
```
composer require evaklp/monolog-stackdriver-handler
```

## Basic Usage
```php
<?php

use Klpeva\MonologStackdriverHandler\StackdriverHandler;

$tag = [
    sprintf(
        'environment:%s',
        'ci'
    ),
    sprintf(
        'instance:%s',
        'api'
    )
];

$log = new Logger('name');
$log->pushHandler(
    new StackdriverHandler()
);

```

## License

Klpeva/monolog-stackdriver-handler is licensed under the MIT License - see the LICENSE file for details