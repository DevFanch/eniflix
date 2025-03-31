<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\Course;
use App\Entity\Trainer;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Doctrine\ORM\EntityRepository;

class CourseType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('content')
            ->add('duration')
            ->add('isPublished')
            ->add('category', EntityType::class, [
                'class' => Category::class,
                'choice_label' => 'name',
                'placeholder' => '--Choisissez une catégorie--',
                'query_builder' => function (EntityRepository $repository) {
                        return $repository->createQueryBuilder('c')
                            ->orderBy('c.name', 'ASC');
                    }
            ])
            ->add('trainers', EntityType::class, [
                'class' => Trainer::class,
                'choice_label' => 'fullname',
                'multiple' => true
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Course::class,
        ]);
    }
}
