<?php

namespace SebastianBerc\Presenters\Traits;

use SebastianBerc\Presenters\Contracts\ShouldPresent;
use SebastianBerc\Presenters\Exceptions\MissingPresentation;
use SebastianBerc\Presenters\Exceptions\MissingPresenter;
use SebastianBerc\Presenters\Presenter;

/**
 * Class Presentable
 *
 * @author  Sebastian Berć <sebastian.berc@gmail.com>
 * @package SebastianBerc\Presenters\Traits
 */
trait Presentable
{
    /**
     * The presenter instance.
     *
     * @var Presenter
     */
    protected $presenterInstance;

    /**
     * Return instance of presenter.
     *
     * @return Presenter
     */
    public function present()
    {
        if ($this->presenterInstance) {
            return $this->presenterInstance;
        }

        if (!property_exists($this, 'presenter') || !class_exists($this->presenter)) {
            $presenter = get_class($this) . 'Presenter';
        } elseif (property_exists($this, 'presenter') || class_exists($this->presenter)) {
            $presenter = $this->presenter;
        } else {
            throw new MissingPresenter;
        }

        return $this->presenterInstance = new $presenter($this);
    }

    /**
     * Check if entity should be allways use presenter.
     *
     * @return bool
     */
    public function shouldPresent()
    {
        if ($this instanceof ShouldPresent) {
            return true;
        }

        return in_array(ShouldPresent::class, (new \ReflectionClass($this))->getInterfaceNames());
    }

    /**
     * Give ability to dynamicaly retrieve property from presenter.
     *
     * @param string $method
     * @param array  $parameters
     *
     * @return mixed
     * @throws MissingPresentation
     */
    public function __call($method, $parameters)
    {
        if ($this->shouldPresent() && method_exists($this->present(), $method)) {
            return $this->presenterInstance->$method($parameters);
        }

        return $this->callOnParent($method, $parameters);
    }

    /**
     * Call method on parent class if parent class exists and method exists.
     *
     * @param string $method
     * @param array  $parameters
     *
     * @return mixed
     * @throws MissingPresentation
     */
    protected function callOnParent($method, $parameters)
    {
        if (!empty(class_parents($this))) {
            try {
                (new \ReflectionClass($this))->getParentClass()->getMethod('__call');
            } catch (\ReflectionException $exception) {
                throw new MissingPresentation();
            }

            return parent::__call($method, $parameters);
        }

        throw new MissingPresentation();
    }
}
