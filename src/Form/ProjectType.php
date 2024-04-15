<?php

namespace App\Form;

use App\Entity\Message;
use App\Entity\Post;
use App\Entity\Project;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProjectType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('filiere')
            ->add('isFinish')
            ->add('isActive')
            ->add('post', EntityType::class, [
                'class' => Post::class,
'choice_label' => 'id',
            ])
            ->add('message', EntityType::class, [
                'class' => Message::class,
'choice_label' => 'id',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Project::class,
        ]);
    }
}
