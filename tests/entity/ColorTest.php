<?php

namespace App\Tests\entity;

use App\Entity\CheckList;
use App\Entity\Color;
use App\Entity\Element;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Validator\ConstraintViolation;

class ColorTest extends KernelTestCase {

    /**
     * @return Element
     */
    public function getEntityColor(): Color {
        return (new Color())
            ->setLibel('vert')
            ->setColorHexa('#33ff96')
            ;
    }

    /**
     * @param CheckList $list
     * @param int $number
     */
    public function assertHasErrors(Color $color, int $number = 0) {
        self::bootKernel();
        $errors = self::$container->get('validator')->validate($color);
        $messages = [];
        /** @var ConstraintViolation $error */
        foreach ($errors as $error) {
            $messages[] = $error->getPropertyPath() . ' => ' . $error->getMessage();
        }
        $this->assertCount($number, $errors, implode(', ', $messages));
    }

    public function testCheckList () { // correct insert
        $color = $this->getEntityColor();
        $this->assertHasErrors($color, 0);
    }
    public function testLibelNameElement () { // blank insert
        $color = $this->getEntityColor()->setLibel('');
        $this->assertHasErrors($color, 2);
    }
    public function testColorHexaNameElement () { // blank insert
        $color = $this->getEntityColor()->setColorHexa('');
        $this->assertHasErrors($color, 1);
    }
    public function testFakeColorHexaNameElement () { // blank insert
        $color = $this->getEntityColor()->setColorHexa('f90AFF');
        $this->assertHasErrors($color, 1);
    }
    public function testShortLibelColor () { // short char insert
        $color = $this->getEntityColor()->setLibel('ra');
        $this->assertHasErrors($color, 1);
    }
    public function testLongLibelColor () { // short char insert
        $color = $this->getEntityColor()->setLibel(
            'Texte un peux trop long ;)'
        );
        $this->assertHasErrors($color, 1);
    }
//    public function testShortColorHexaElement () { // short char insert
//        $color = $this->getEntityColor()->setColorHexa('ra');
//        $this->assertHasErrors($color, 1);
//    }
//    public function testLongCheckList () { // long char insert
//        $color = $this->getEntityColor()->setName(
//            'Texte super super long. Tout ca pour provoquer une erreur. ;)');
//        $this->assertHasErrors($color, 1);
//    }
}