<?php

namespace App\Tests\entity;

use App\Entity\CheckList;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Validator\ConstraintViolation;

class CheckListTest extends KernelTestCase {

    public function getEntity(): CheckList {
        return (new CheckList())
            ->setTitle("Nouveau titre ;)");
    }

    /**
     * @param CheckList $list
     * @param int $number
     */
    public function assertHasErrors(CheckList $list, int $number = 0) {
        self::bootKernel();
        $errors = self::$container->get('validator')->validate($list);
        $messages = [];
        /** @var ConstraintViolation $error */
        foreach ($errors as $error) {
            $messages[] = $error->getPropertyPath() . ' => ' . $error->getMessage();
        }
        $this->assertCount($number, $errors, implode(', ', $messages));
    }

    public function testCheckList () { // correct insert
        $list = $this->getEntity();
        $this->assertHasErrors($list, 0);
    }
    public function testBlankCheckList () { // blank insert
        $list = $this->getEntity()->setTitle('');
        $this->assertHasErrors($list, 2);
    }
    public function testShortCheckList () { // short char insert
        $list = $this->getEntity()->setTitle('ra');
        $this->assertHasErrors($list, 1);
    }
    public function testLongCheckList () { // long char insert
        $list = $this->getEntity()->setTitle(
            'Texte super super long. Tout ca pour provoquer une erreur. ;)');
        $this->assertHasErrors($list, 1);
    }
}