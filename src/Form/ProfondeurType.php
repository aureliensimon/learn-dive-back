<?php

namespace App\Form;

use App\Entity\Profondeur;
use App\Entity\TablePlongee;

use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProfondeurType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('profondeur', NumberType::class, [
                'attr' => [
                    'class' => 'textinput',    
                ],
            ])
            ->add('table_plongee_id', EntityType::Class, [
                'attr' => [
                    'class' => 'textinput',    
                ],
                'class' => TablePlongee::Class,
                'choice_label' => function ($table) {
                    return $table->getNom();
                }
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Profondeur::class,
        ]);
    }
}
