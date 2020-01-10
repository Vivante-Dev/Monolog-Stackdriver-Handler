# monolog-stackdriver-handler
Monolog Handler Structured Logging [https://cloud.google.com/logging/docs/structured-logging]

This handler is `GCP_PROJECT` ID agnostic.
 
Extends `Monolog\Handler\StreamHandler` setting the formatter as `JsonFormatter` and adding `severity` field.

Eliminating information so as to reduce chances of an entry being split in two (both turned back to `textPayload` with `severity="INFO"`) given the Stackdriver limits [https://cloud.google.com/logging/quotas]

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