<?php

namespace App\Form;

use App\Entity\Album;
use App\Entity\Band;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichFileType;
use Symfony\Component\Validator\Constraints as Assert;
use function Sodium\add;

class AlbumType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'constraints' => [
                    new Assert\NotBlank([
                        'message' => 'Escriu un títol.'
                    ]),

                    new Assert\Length([
                        'max' => 25,
                        'maxMessage' => "Has passat les 25 lletres."
                    ])
                ]
            ])
            ->add('releasedAt', DateType::class, [
                'widget' => 'single_text',
            ])
            ->add('coverFile', VichFileType::class, [
//              'required' => false,
                'allow_delete' => false,
                'download_uri' => false,
//                'download_label' => static fn (Album $album): string => $album->getTitle(),
//                'image_uri' => true,
                'constraints' => [
                    new Assert\NotBlank([
                        'message' => 'Puja una portada.'
                    ]),
                    new Assert\Image([
                        'maxSize' => '2M',
                        'mimeTypes' => ['image/jpeg', 'image/png', 'image/gif'],
                        'mimeTypesMessage' => 'Puja estos formats: jpeg, png, gif.'
                    ])
                ]
            ])
            /*->add('band', EntityType::class, [
                'class' => Band::class,
                'choice_label' => 'name',
                'placeholder' => 'Tria una banda',
                'autocomplete' => true,
            ])*/
        ->add('band', AlbumAutocompleteField::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Album::class,
        ]);
    }
}
