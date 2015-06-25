<?php

namespace SebastianBerc\Presenters\Contracts;

use SebastianBerc\Presenters\Presenter;

/**
 * Class ShouldPresent
 *
 * @author  Sebastian Berć <sebastian.berc@gmail.com>
 * @package SebastianBerc\Presenters\Contracts
 */
interface ShouldPresent
{
    /**
     * Return presenter full classname.
     *
     * @return string
     */
    public function presenter();

    /**
     * Return instance of presenter.
     *
     * @return Presenter
     */
    public function present();
}
