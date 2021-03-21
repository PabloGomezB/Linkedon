<?php

namespace App\Form;

use App\Entity\Oferta;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OfertaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titol', null, array('attr' => array('class' => 'form-control', 'placeholder' => 'Programador web')))
            ->add('descripcio', null, array('attr' => array('class' => 'form-control', 'placeholder' => 'Se necesita programador web con 10 años de experiencia en Kolvin corp.')))
            // ->add('dataPublicacio', null, array('data' => new \DateTime()))
            ->add('ubicacio', null, array('attr' => array('class' => 'form-control', 'placeholder' => 'Barcelona')))
            // ->add('estat', null, array('attr' => array('class' => 'form-control', 'placeholder' => '1')))
            ->add('empresa', null, [
                'attr' => array('readonly' => 'true', // si pones disabled no pilla la data y lo guarda NULL en la DB
                                'class' => 'form-control',
                                'style' => 'background-color:#C8C8C8;pointer-events:none;cursor:not-allowed;')
            ])
            // ->add('candidats', null, array('attr' => array('class' => 'form-control')))
            ->add('categoria', null, array('attr' => array('class' => 'form-control')))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Oferta::class,
        ]);
    }
}
