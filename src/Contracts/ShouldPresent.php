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
     * Return instance of presenter.
     *
     * @return Presenter
     */
    public function present();
}
