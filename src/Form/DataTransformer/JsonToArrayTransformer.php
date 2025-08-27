<?php

namespace App\Form\DataTransformer;

use Symfony\Component\Form\DataTransformerInterface;

class JsonToArrayTransformer implements DataTransformerInterface
{
    public function transform($value): string|false
    {
        return json_encode($value, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    }

    public function reverseTransform($value): mixed
    {
        if (empty($value)) {
            return [];
        }

        $decoded = json_decode($value, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new \UnexpectedValueException('Le contenu JSON est invalide : ' . json_last_error_msg());
        }

        return $decoded;
    }
}
