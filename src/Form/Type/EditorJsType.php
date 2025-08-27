<?php

namespace App\Form\Type;

use App\Form\DataTransformer\JsonToArrayTransformer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EditorJsType extends AbstractType
{
    private JsonToArrayTransformer $transformer;

    public function __construct(JsonToArrayTransformer $transformer)
    {
        $this->transformer = $transformer;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->addModelTransformer($this->transformer);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(['attr' => ['hidden' => true]]);
    }

    public function getParent(): string
    {
        return TextareaType::class;
    }

}
