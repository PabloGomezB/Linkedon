<?php

namespace App\Form;

use App\Entity\Candidat;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
//imports para subir un archivo
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Validator\Constraints\File;

class CandidatType extends AbstractType {
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
            ->add('nom', null, array('attr' => array('class' => 'form-control', 'placeholder' => 'Kolvin')))
            ->add('cognom1', null, array('attr' => array('class' => 'form-control', 'placeholder' => 'Larriega')))
            ->add('cognom2', null, array('attr' => array('class' => 'form-control', 'placeholder' => 'Palomino')))
            ->add('telefon', null, array('attr' => array('class' => 'form-control', 'placeholder' => '681038573')))
            // ->add('usuari')
            // ->add('ofertes')
            //Crea el imput puedes elegir el tipo de archivo a subir.
            ->add('cv', FileType::class, [
                'label' => 'Curriculum Vitae (solo archivos .pdf)',

                // unmapped means that this field is not associated to any entity property
                'mapped' => false,

                // make it optional so you don't have to re-upload the PDF file
                // every time you edit the Product details
                'required' => false,

                // unmapped fields can't define their validation using annotations
                // in the associated entity, so you can use the PHP constraint classes
                'constraints' => [
                    new File([
                        'maxSize' => '5120k',
                        'mimeTypes' => [
                            'application/pdf',
                            'application/x-pdf',
                        ],
                        'mimeTypesMessage' => 'Porfavor sube un archivo .pdf valido',
                    ])
                ],
            ]);;
    }

    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults([
            'data_class' => Candidat::class,
        ]);
    }
}
