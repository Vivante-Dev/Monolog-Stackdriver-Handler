# monolog-stackdriver-handler
Monolog Handler Structured Logging (https://cloud.google.com/logging/docs/structured-logging)

## Installation
```
composer require vivante-health/monolog-stackdriver-handler
```

## Basic Usage
```php
<?php

use VivanteHealth\MonologStackdriverHandler\StackdriverHandler;

$log = new Logger('name');
$log->pushHandler(
    new StackdriverHandler()
);

```

## License

vivante-health/monolog-stackdriver-handler is licensed under the MIT License - see the LICENSE file for details