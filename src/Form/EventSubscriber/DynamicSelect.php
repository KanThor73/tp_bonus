<?php

namespace App\Form\EventSubscriber;

use App\Entity\Categories;
use App\Entity\Products;
use App\Entity\SousCategories;
use Doctrine\DBAL\Exception\DatabaseDoesNotExist;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;

class DynamicSelect implements EventSubscriberInterface
{
    public function __construct(){}

    public function formModifier(FormInterface $form, Categories $categorie)
    {
        $sousCate = $categorie->getParent();

        $form->add('sousCate', EntityType::class, [
            'mapped' => false,
            'class' => SousCategories::class,
            'choices' => $sousCate,
            'choice_label' => 'Sous-categorie',
            'label' => 'Sous-categorie',
            'required' => false
        ]);
    }

    public function onPostSubmitEvent(FormEvent $event)
    {
        $data = $event->getForm()->getData();
        $form = $event->getForm();
        $this->formModifier($form, $data);
    }

    public static function getSubscribedEvents()
    {
        return [
            FormEvents::POST_SUBMIT => 'onPostSubmitEvent'
        ];
    }
}