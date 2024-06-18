<?php

namespace App\Form;

use App\Entity\Band;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\UX\Autocomplete\Form\AsEntityAutocompleteField;
use Symfony\UX\Autocomplete\Form\BaseEntityAutocompleteType;

#[AsEntityAutocompleteField(route: 'ux_entity_autocomplete_admin')]
class AlbumAutocompleteField extends AbstractType
{
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'class' => Band::class,
            'placeholder' => 'Tria una banda',
            'choice_label' => 'name',
            'query_builder' => function (EntityRepository $entityRepository) :QueryBuilder {
                return $entityRepository->createQueryBuilder('b')
                    ->orderBy('b.name', 'ASC');
            },

            // choose which fields to use in the search
            // if not passed, *all* fields are used
            //'searchable_fields' => ['name', 'album.band'],

            // 'security' => 'ROLE_SOMETHING',
        ]);
    }

    public function getParent(): string
    {
        return BaseEntityAutocompleteType::class;
    }
}
