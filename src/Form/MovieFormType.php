<?php


namespace App\Form;


use App\Entity\Movie;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\RangeType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MovieFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('title', TextType::class);
        $builder->add('director', TextType::class);
        $builder->add('releaseDate', DateType::class, ['widget'=>'single_text']);
        $builder->add('genres', TextType::class);
        $builder->add('poster', TextType::class);
        $builder->add('range', RangeType::class, ['attr'=> ['min' => 1, 'max' => 10, 'step' => 0.5]]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(['data_class' => Movie::class]);
    }
}