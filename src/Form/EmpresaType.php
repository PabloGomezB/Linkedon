<?php

namespace App\Form;

use App\Entity\Empresa;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Validator\Constraints\File;


class EmpresaType extends AbstractType {
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
            ->add('nom', null, array('attr' => array('class' => 'form-control', 'placeholder' => 'Kolvin Corp')))
            ->add('tipus', null, array('attr' => array('class' => 'form-control', 'placeholder' => 'Tecnologia')))
            // ->add('logo')
            ->add('correu', null, [
                'attr' => array(
                    'readonly' => 'true', // si pones disabled no pilla la data y lo guarda NULL en la DB
                    'class' => 'form-control',
                    'style' => 'background-color:#C8C8C8;pointer-events:none;cursor:not-allowed;'
                )
            ])
            // ->add('usuari')
            ->add('logo', FileType::class, [
                'label' => 'Logo (Image file)',

                // unmapped means that this field is not associated to any entity property
                'mapped' => false,

                // make it optional so you don't have to re-upload the PDF file
                // every time you edit the Product details
                'required' => false,

                // unmapped fields can't define their validation using annotations
                // in the associated entity, so you can use the PHP constraint classes
                'constraints' => [
                    new File([
                        'maxSize' => '1024k',
                        'mimeTypes' => [
                            'image/jpeg',
                            'image/png',
                            'image/webp'
                        ],
                        'mimeTypesMessage' => 'Please upload a valid image type',
                    ])
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults([
            'data_class' => Empresa::class,
        ]);
    }
}
