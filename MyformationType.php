<?php

namespace App\Form;

use App\Entity\Myformation;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class MyformationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('libelle')
            ->add('description',TextareaType::class, [
                'attr' => ['class' => 'tinymce'],
            ])
            ->add('date')
            ->add('type', ChoiceType::class, [
                'choices'  => [
                    'Vidéo' => null,
                    'Livre' => true,
                ],
            ])
            #->add('image')

            ->add('image', FileType::class,[
                'label' => false,
                'multiple' => true,
                'mapped' => false,
                'required' => false
            ])
            // ...
        ;
    }



    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Myformation::class,
        ]);
    }
}
