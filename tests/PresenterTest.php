<?php

namespace SebastianBerc\Presenters\Test;

/**
 * Class PresenterTest
 *
 * @author  Sebastian Berć <sebastian.berc@gmail.com>
 * @package SebastianBerc\Presenters\Test
 */
class PresenterTest extends \PHPUnit_Framework_TestCase
{
    public function testPresenterInitialization()
    {
        $presenter = new PersonPresenter(new Person());

        $this->assertInstanceOf(\SebastianBerc\Presenters\Presenter::class, $presenter);
    }

    public function testPresentMethod()
    {
        $person = new Person();

        $this->assertEquals('sebastian', $person->present()->firstName);
    }

    public function testPresentationOfLastName()
    {
        $person = new Person();

        $this->assertEquals('BERC', $person->present()->lastName);
    }

    public function testDynamicCallToPresentationOfLastName()
    {
        $person = new Person();

        $this->assertEquals('BERC', $person->lastName());
    }

    public function testDynamicCallToNonExistingPresentation()
    {
        $this->setExpectedException(\SebastianBerc\Presenters\Exceptions\MissingPresentation::class);

        $person = new Person();
        $person->missingPresentation();
    }
}

class PersonPresenter extends \SebastianBerc\Presenters\Presenter
{
    public function lastName()
    {
        return strtoupper($this->entity->lastName);
    }
}

class Person implements \SebastianBerc\Presenters\Contracts\ShouldPresent
{
    use \SebastianBerc\Presenters\Traits\Presentable;

    public $firstName = 'sebastian';
    public $lastName = 'berc';
    public $email = 'contact@sebastian-berc.pl';

    public function presenter()
    {
        return PersonPresenter::class;
    }
}
