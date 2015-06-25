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
     * @throws MissingPresenter
     */
    public function present()
    {
        if ($this->presenterInstance) {
            return $this->presenterInstance;
        }

        if ($this->shouldPresent() && method_exists($this, 'presenter')) {
            $presenter = $this->presenter();
        }

        if (isset($presenter)) {
            return $this->presenterInstance = new $presenter($this);
        }

        throw new MissingPresenter;
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

        if (!empty(class_parents($this)) && function_exists('parent::__call')) {
            return parent::__call($method, $parameters);
        }

        throw new MissingPresentation;
    }
}
