<?php

namespace App\Admin\Field;

use App\Form\Type\EditorJsType;
use EasyCorp\Bundle\EasyAdminBundle\Contracts\Field\FieldInterface;
use EasyCorp\Bundle\EasyAdminBundle\Field\FieldTrait;

class EditorJsField implements FieldInterface
{
    use FieldTrait;

    public static function new(string $propertyName, ?string $label = null): self
    {
        return (new self())
            ->setProperty($propertyName)
            ->setLabel($label)
            ->setFormType(EditorJsType::class)
            ->addFormTheme('form/editorjs_type.html.twig')
            ->addWebpackEncoreEntries('editorjs')
            ->onlyOnForms()
        ;
    }
}
