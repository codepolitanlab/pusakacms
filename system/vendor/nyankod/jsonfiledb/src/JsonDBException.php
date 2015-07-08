<?php
/**
 * @author Philip Wright- Christie <pwrightchristie.sfp@gmail.com>
 * Date: 08/05/14
 */

namespace Nyankod;


class JsonDBException extends \Exception
{

    public function __construct($message, $code = 0, \Exception $previous = null)
    {
        $message = 'JSONDB Error: ' . $message;
        parent::__construct($message, $code, $previous);
    }

    // custom string representation of object
    public function __toString()
    {
        return __CLASS__ . ": [{$this->code}]: {$this->message}\n";
    }
}