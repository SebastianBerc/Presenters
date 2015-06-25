<?php

namespace SebastianBerc\Presenters\Exceptions;

/**
 * Class MissingPresenter
 *
 * @author  Sebastian Berć <sebastian.berc@gmail.com>
 * @package SebastianBerc\Presenters\Exceptions
 */
class MissingPresenter extends \Exception
{
    /**
     * Create a new MissingPresenter instance.
     */
    public function __construct()
    {
        parent::__construct('The $presenter property in entity should contain path to your presenter.');
    }
}
