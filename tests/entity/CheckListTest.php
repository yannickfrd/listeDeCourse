<?php

namespace App\Tests\entity;

use App\Entity\CheckList;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class CheckListTest extends KernelTestCase {

    public function getEntity(): CheckList {
        return (new CheckList())->setTitle("Nouveau titre ;)");
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
    /** @test */
    public function checklist () {
        $list = $this->getEntity();
        $this->assertHasErrors($list);
    }
    /** @test */
    public function title_blank () {
        $list = $this->getEntity()->setTitle('');
        $this->assertHasErrors($list, 2);
    }
    /** @test */
    public function title_so_short () {
        $list = $this->getEntity()->setTitle('d');
        $this->assertHasErrors($list, 1);
    }
    /** @test */
    public function title_so_long () {
        $list = $this->getEntity()->setTitle('knfsknfdjnjnfoaznfjednfjenafaojnfedmfdlifndoifndsfdsfdf');
        $this->assertHasErrors($list, 1);
    }
}