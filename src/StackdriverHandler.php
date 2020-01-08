<?php
declare(strict_types=1);

namespace Klpeva\MonologStackdriverHandler;

use Monolog\Formatter\JsonFormatter;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;

/**
 * @since {{VERSION}}
 * @author Eva Koliopoulou <ekoliopoulou@vivantehealth.com>
 */
class StackdriverHandler extends StreamHandler
{
    public function __construct($stream = 'php://stdout', $level = Logger::DEBUG, $bubble = true, $filePermission = null, $useLocking = false)
    {
        parent::__construct($stream, $level, $bubble, $filePermission, $useLocking);

        $this->setFormatter(new JsonFormatter());
    }

    protected function processRecord(array $record)
    {
        if ($this->processors) {
            foreach ($this->processors as $processor) {
                $record = call_user_func($processor, $record);
            }
        }

        $record['severity'] = $record['level_name'];

        foreach ($record['extra'] as $key => $value) {
            if ($value === null) {
                unset($record['extra'][$key]);
            }
        }

        $record['extra']['tags'] = array_values(
            array_filter(
                $record['extra']['tags'],
                function (string $tag): bool {
                    return strpos($tag, 'environment:') !== 0;
                }
            )
        );

        unset($record['level_name']);
        unset($record['level']);
        unset($record['channel']);

        return $record;
    }
}
