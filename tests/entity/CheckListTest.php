<?php

namespace App\Tests\entity;

use App\Entity\CheckList;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

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
        $error = self::$container->get('validator')->validate($list);
        $this->assertCount($number, $error);
    }

    public function testCheckList () {
        $list = $this->getEntity();
        $this->assertHasErrors($list, 0);
    }

    public function testBlankCheckList () {
        $list = $this->getEntity()->setTitle('');
        $this->assertHasErrors($list, 1);
    }
}