<?php

namespace App\Form;

use App\Entity\CheckList;
use App\Entity\Color;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CheckListFormType extends AbstractType
{
    private $em;
    public function __construct(EntityManagerInterface $em) {
        $this->em = $em;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('colorHexa')
//            ->add('colorHexa', EntityType::class, [
//                'class' => Color::class,
//                'choice_label' => 'libel',
//                'data' => $this->em->getRepository(Color::class)->findOneBy(['libel' => 'red']),
//                'required' => false
//            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => CheckList::class,
        ]);
    }
}
