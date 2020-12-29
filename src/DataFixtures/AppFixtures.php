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
    protected $repoColor;
    protected $repoElement;
    protected $repoList;
    protected Faker\Generator $faker;

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
            "red" => "#fad2d2",
            "blue" => "#d2eefa",
            "green" => "#c0fcc2",
            "yellow" => "#f9fdc6",
            "purple" => "#f1daf1",
            ];
        // New colors
        foreach ($colors as $key => $value){
            $color = new Color();
            $color->setLibel($key)->setColorHexa($value);
            $manager->persist($color);
        }

        // New check lists
        for ($i=0; $i<3; $i++){
            $list = new CheckList();
            $list->setTitle("Liste n°". $i);

            // New elements
            if ($i === 0) {
                for ($j=0; $j<5; $j++){
                    $elem = new Element();
                    $elem
                        ->setIsChecked($this->faker->boolean)
                        ->setName($this->faker->text(rand(5,30)))
                    ;
                    $manager->persist($elem);
                    $list->addElement($elem);
                }
            }else{
                for ($j=0; $j<rand(5,25); $j++){
                    if ($j > 5){
//                    $colorALl = $this->repoColor->findAll();
//                    $colorFake = $this->faker->randomElement($colorALl);
                        $elem = new Element();
                        $elem
//                        ->setColorHexa($colorFake->getColorHexa())
                            ->setIsChecked($this->faker->boolean)
                            ->setName($this->faker->text(rand(5,30)))
                        ;
                        $manager->persist($elem);
                        $list->addElement($elem);
                    }
                }
            }


            $manager->persist($list);
            $manager->flush();
        }
    }
}
