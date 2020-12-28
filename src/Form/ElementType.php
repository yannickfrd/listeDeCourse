<?php

namespace App\Form;

use App\Entity\Color;
use App\Entity\Element;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ElementType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
//            ->add('isChecked')
            ->add('colorHexa', EntityType::class, [
                'class' => Color::class,
                'choice_label' => 'libel',
                'choice_value' => 'colorHexa',
                'attr' => [
                    'required' => true
                ]
            ])
//            ->add('checkList')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Element::class,
        ]);
    }
}
