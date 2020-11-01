<?php

namespace App\DataFixtures;

use App\Entity\CheckList;
use App\Entity\Color;
use App\Entity\Element;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectManager;
use Faker;

class AppFixtures extends Fixture {
    /**
     * @var \Doctrine\ORM\EntityRepository|\Doctrine\Persistence\ObjectRepository
     */
    protected $repoColor;
    /**
     * @var \Doctrine\ORM\EntityRepository|\Doctrine\Persistence\ObjectRepository
     */
    protected $repoElement;
    /**
     * @var \Doctrine\ORM\EntityRepository|\Doctrine\Persistence\ObjectRepository
     */
    protected $repoList;
    /**
     * @var Faker\Generator
     */
    protected $faker;

    /**
     * AppFixtures constructor.
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em) {
        $this->repoColor = $em->getRepository(Color::class);
        $this->repoElement = $em->getRepository(Element::class);
        $this->repoList = $em->getRepository(CheckList::class);
        $this->faker = Faker\Factory::create('fr_FR');
    }

    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager) {
        $colors = [
            "red" => "#ffb3b3",
            "blue" => "#99ccff",
            "green" => "#b3ffe0",
            "yellow" => "#ffffb3",
            "purple" => "#eeccff",
            ];
        // New colors
        foreach ($colors as $key => $value){
            $color = new Color();
            $color->setLibel($key)
                ->setHex($value);
            $manager->persist($color);
        }

        // New check lists
        for ($i=0; $i<3; $i++){
            $list = new CheckList();
            $list->setTitle("Liste n°". $i)
                ->setColor($this->faker->randomElement($this->repoColor->findAll()));
            $manager->persist($list);
            $manager->flush();
        }

        // New elements
        foreach ($this->repoList->findAll() as $list){
            for ($i=0; $i<rand(0,25); $i++){
                $elem = new Element();
                $elem->setColor($this->faker->randomElement($this->repoColor->findAll()))
                    ->setIsChecked($this->faker->boolean)
                    ->setName($this->faker->text(rand(5,30)))
                ;
                $manager->persist($elem);
                $list->addElement($elem);
                $manager->persist($list);
            }
        }
        $manager->flush();
    }
}
