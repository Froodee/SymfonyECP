<?php

namespace App\Form;

use App\Entity\RendezVous;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RendezVousType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class, [
                'label' => 'Nom complet',
                'attr'  => ['placeholder' => 'Jean Dupont'],
            ])
            ->add('email', EmailType::class, [
                'label' => 'Adresse email',
                'attr'  => ['placeholder' => 'jean@exemple.fr'],
            ])
            ->add('telephone', TelType::class, [
                'label' => 'Téléphone',
                'attr'  => ['placeholder' => '06 00 00 00 00'],
            ])
            ->add('service', ChoiceType::class, [
                'label'   => 'Service souhaité',
                'choices' => [
                    'Désherbage radical'   => 'Désherbage radical',
                    'Nettoyage du sol'     => 'Nettoyage du sol',
                    'Cuisine impeccable'   => 'Cuisine impeccable',
                    'Salle de bain nette'  => 'Salle de bain nette',
                    'Conseil produit'      => 'Conseil produit',
                    'Autre'                => 'Autre',
                ],
                'placeholder' => '-- Choisissez un service --',
            ])
            ->add('dateRdv', DateTimeType::class, [
                'label'  => 'Date et heure souhaitées',
                'widget' => 'single_text',
                'attr'   => ['min' => (new \DateTime('+1 day'))->format('Y-m-d\TH:i')],
            ])
            ->add('message', TextareaType::class, [
                'label'    => 'Message (optionnel)',
                'required' => false,
                'attr'     => ['rows' => 4, 'placeholder' => 'Précisions supplémentaires...'],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => RendezVous::class,
        ]);
    }
}
