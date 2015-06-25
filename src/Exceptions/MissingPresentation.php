<?php

namespace SebastianBerc\Presenters\Exceptions;

/**
 * Class MissingPresentation
 *
 * @author  Sebastian Berć <sebastian.berc@gmail.com>
 * @package SebastianBerc\Presenters\Exceptions
 */
class MissingPresentation extends \Exception
{
    /**
     * Create a new MissingPresenter instance.
     */
    public function __construct()
    {
        $debug = debug_backtrace(DEBUG_BACKTRACE_PROVIDE_OBJECT, 4)[3];
        $error = sprintf(
            'Call to undefined method %s::%s in %s on line %s',
            $debug['class'],
            $debug['function'],
            isset($debug['file']) ? $debug['file'] : 'unknown file',
            isset($debug['line']) ? $debug['line'] : 'unknown line'
        );

        parent::__construct($error);
    }
}
