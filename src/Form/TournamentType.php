<?php

declare(strict_types=1);

namespace App\Form;

use App\Entity\Tournament;
use App\Repository\TeamRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TournamentType extends AbstractType
{
    public function __construct(private TeamRepository $repository)
    {
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'label' => false,
            ])
            ->add('matchTeams', ChoiceType::class, [
                'expanded' => true,
                'multiple' => true,
                'label' => false,
                'choices' => $this->getData(),
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Tournament::class
        ]);
    }

    private function getData(): array
    {
        $teams = $this->repository->findAll();
        $checkBoxData = [];
        foreach ($teams as $team) {
            $checkBoxData[$team->getName()] = $team->getId();
        }
        return $checkBoxData;
    }
}