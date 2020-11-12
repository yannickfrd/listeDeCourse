<?php

namespace App\Form;

use App\Entity\CheckList;
use App\Entity\Color;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CheckListFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, [
                'attr' => [
                    'placeholder' => 'Enter title',
                    'required' => true
                ]
            ])
//            ->add('createdAt')
//            ->add('isFinished')
            ->add('color', EntityType::class, [
                'class' => Color::class,
                'choice_label' => 'libel',
                'choice_value' => 'colorHexa',
                'attr' => [
                    'required' => true
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => CheckList::class,
        ]);
    }
}
