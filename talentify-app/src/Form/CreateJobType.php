<?php

namespace App\Form;

use App\Entity\Job;
use App\Entity\JobInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CreateJobType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('title', TextType::class);
        $builder->add('description', TextareaType::class);
        $builder->add('salary', NumberType::class);
        $builder->add('status', ChoiceType::class, [
            'choices' => [
                'Vinsível' => JobInterface::STATUS_VISIBLE,
                'Escondido' => JobInterface::STATUS_INVISIBLE,
            ],
        ]);
        $builder->add('workplace', BasicAddressType::class);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Job::class,
        ]);
    }
}