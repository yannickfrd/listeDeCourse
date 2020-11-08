<?php

namespace App\Tests\entity;

use App\Entity\CheckList;
use App\Entity\Element;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Validator\ConstraintViolation;

class ElementTest extends KernelTestCase {

    /**
     * @return Element
     */
    public function getEntityELement(): Element {
        return (new Element())
            ->setName('Nom du nouvelle élément')
            ->setIsChecked(true)
            ;
    }

    /**
     * @param CheckList $list
     * @param int $number
     */
    public function assertHasErrors(Element $elem, int $number = 0) {
        self::bootKernel();
        $errors = self::$container->get('validator')->validate($elem);
        $messages = [];
        /** @var ConstraintViolation $error */
        foreach ($errors as $error) {
            $messages[] = $error->getPropertyPath() . ' => ' . $error->getMessage();
        }
        $this->assertCount($number, $errors, implode(', ', $messages));
    }

    public function testCheckList () { // correct insert
        $elem = $this->getEntityELement();
        $this->assertHasErrors($elem, 0);
    }
    public function testBlankNameElement () { // blank insert
        $elem = $this->getEntityELement()->setName('');
        $this->assertHasErrors($elem, 2);
    }
    public function testShortNameElement () { // short char insert
        $elem = $this->getEntityELement()->setName('ra');
        $this->assertHasErrors($elem, 1);
    }
    public function testLongCheckList () { // long char insert
        $elem = $this->getEntityELement()->setName(
            'Texte super super long. Tout ca pour provoquer une erreur. ;)');
        $this->assertHasErrors($elem, 1);
    }

    public function testBoolIsChecked() {
        $elem = $this->getEntityELement()->setIsChecked('truekf');
        $this->assertHasErrors($elem, 0);
    }
}