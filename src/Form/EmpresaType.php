<?php

namespace App\Form;

use App\Entity\Empresa;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EmpresaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom', null, array('attr' => array('class' => 'form-control', 'placeholder' => 'Kolvin Corp')))
            ->add('tipus', null, array('attr' => array('class' => 'form-control', 'placeholder' => 'Tecnologia')))
            // ->add('logo')
            ->add('correu', null, [
                'attr' => array('readonly' => 'true', // si pones disabled no pilla la data y lo guarda NULL en la DB
                                'class' => 'form-control',
                                'style' => 'background-color:#C8C8C8;pointer-events:none;cursor:not-allowed;')
            ])
            // ->add('usuari')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Empresa::class,
        ]);
    }
}
