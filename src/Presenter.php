<?php

namespace SebastianBerc\Presenters;

/**
 * Class Presenter
 *
 * @author  Sebastian Berć <sebastian.berc@gmail.com>
 * @package SebastianBerc\Presenters
 */
abstract class Presenter
{
    /**
     * The entity instance to present.
     *
     * @var mixed
     */
    protected $entity;

    /**
     * Create new instance of presenter.
     *
     * @param mixed $entity
     */
    public function __construct($entity)
    {
        $this->entity = $entity;
    }

    /**
     * Give ability to dynamicaly retrieve property from presenter.
     *
     * @param string $parameter
     *
     * @return mixed
     */
    public function __get($parameter)
    {
        // If parameter is a method name, then call this method.
        if (method_exists($this, $parameter)) {
            return $this->$parameter();
        }

        // If parameter is a method name in entity, then call this method on entity.
        if (property_exists($this->entity, $parameter)) {
            return $this->entity->$parameter;
        }

        // If parameter is a method name in entity, then call this method on entity.
        if (isset($this->entity[$parameter])) {
            return $this->entity[$parameter];
        }
    }
}
