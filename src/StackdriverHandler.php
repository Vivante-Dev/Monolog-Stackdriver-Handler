<?php
declare(strict_types=1);

namespace VivanteHealth\MonologStackdriverHandler;

use Monolog\Formatter\JsonFormatter;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;

/**
 * Monolog Handler Structured Logging
 * @link https://cloud.google.com/logging/docs/structured-logging
 *
 * @author Eva Koliopoulou <ekoliopoulou@vivantehealth.com>
 */
class StackdriverHandler extends StreamHandler
{
    public function __construct($stream = 'php://stdout', $level = Logger::DEBUG, $bubble = true, $filePermission = null, $useLocking = false)
    {
        parent::__construct($stream, $level, $bubble, $filePermission, $useLocking);

        /**
         * In Stackdriver Logging, structured logs refer to log entries
         * that use the jsonPayload field to add structure to their payloads.
         */
        $this->setFormatter(new JsonFormatter());
    }

    protected function processRecord(array $record)
    {
        if ($this->processors) {
            foreach ($this->processors as $processor) {
                $record = call_user_func($processor, $record);
            }
        }

        /**
         * LogSeverity
         * https://cloud.google.com/logging/docs/reference/v2/rest/v2/LogEntry#logseverity
         */
        $record['severity'] = $record['level_name'];

        //Skip empty fields
        foreach ($record['extra'] as $key => $value) {
            if ($value === null) {
                unset($record['extra'][$key]);
            }
        }

        //Specific to VH implementation
        if (isset($record['extra']['tags'])) {
            $record['extra']['tags'] = array_values(
                array_filter(
                    $record['extra']['tags'],
                    function (string $tag): bool {
                        return strpos($tag, 'environment:') !== 0 || strpos($tag, 'instance:') !== 0;
                    }
                )
            );
        }

        //Skip unsused information
        unset($record['level_name']);
        unset($record['level']);
        unset($record['channel']);

        return $record;
    }
}
