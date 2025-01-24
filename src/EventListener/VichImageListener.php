<?php

namespace App\EventListener;

use Intervention\Image\ImageManager;
use Vich\UploaderBundle\Event\Event;

final class VichImageListener
{

    public function __construct(private readonly ImageManager $imageManager)
    {
    }

    public function onVichUploaderPostUpload(Event $event): void
    {
        $mapping = $event->getMapping();
        $propertyName = $mapping->getFilePropertyName();
        $object = $event->getObject();
        $getter = 'get'.ucfirst($propertyName);
        $file = $object->$getter();

        $mappingName = $mapping->getMappingName();

        switch($mappingName):

            case 'oh_items':
                $image = $this->imageManager->read($file->getPathname());
                $image->cover(80, 80);
                $image->save($file->getPathname());
                break;
            case 'oh_specializations':
                $image = $this->imageManager->read($file->getPathname());
                $image->cover(64, 64);
                $image->save($file->getPathname());
                break;
            case 'oh_memetics':
            case 'oh_servers_tags':
                $image = $this->imageManager->read($file->getPathname());
                $image->cover(48, 48);
                $image->save($file->getPathname());
                break;

        endswitch;
    }
}
