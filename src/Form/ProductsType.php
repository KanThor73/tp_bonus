<?php

namespace App\Form;

use App\Entity\Categories;
use App\Entity\Products;
use App\Entity\SousCategories;
use App\Form\EventSubscriber\DynamicSelect;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProductsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('reference')
            ->add('label')
            ->add('description')
            ->add('price')
            ->add('stock')
            ->add('published')
            ->add('categorie', EntityType::class, [
                'class' => Categories::class,
                'choice_label' => 'libelle',
                'label' => 'Categorie'
            ]);
//            ->add('libelle', EntityType::class, [
//                'class' => SousCategories::class,
//                'choice_label' => 'libelle',
//                'label' => 'Sous-Categories'
//            ]);
//        $builder->get('libelle')->addEventSubscriber(new DynamicSelect());
//        ->
//        add('parent');
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Products::class,
        ]);
    }
}
