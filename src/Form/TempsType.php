<?php

namespace App\Form;

use App\Entity\Temps;
use App\Entity\Profondeur;

use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TempsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('temps', NumberType::class, [
                'attr' => [
                    'class' => 'textinput',    
                ],
            ])
            ->add('palier3', NumberType::class, [
                'attr' => [
                    'class' => 'textinput',    
                ],
            ])
            ->add('palier6', NumberType::class, [
                'attr' => [
                    'class' => 'textinput',    
                ],
            ])
            ->add('palier9', NumberType::class, [
                'attr' => [
                    'class' => 'textinput',    
                ],
            ])
            ->add('palier12', NumberType::class, [
                'attr' => [
                    'class' => 'textinput',    
                ],
            ])
            ->add('palier15', NumberType::class, [
                'attr' => [
                    'class' => 'textinput',    
                ],
            ])
            ->add('profondeur_id', EntityType::Class, [
                'attr' => [
                    'class' => 'textinput',    
                ],
                'class' => Profondeur::Class,
                'choice_label' => function ($profondeur) {
                    return $profondeur->getProfondeur();
                }
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Temps::class,
        ]);
    }
}
