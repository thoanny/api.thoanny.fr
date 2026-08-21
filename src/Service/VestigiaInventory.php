<?php

namespace App\Service;

use App\Entity\Vestigia\Account;
use App\Entity\Vestigia\InventoryItem;
use App\Entity\Vestigia\Item;
use App\Repository\Vestigia\InventoryItemRepository;
use Doctrine\ORM\EntityManagerInterface;

readonly class VestigiaInventory
{
    public function __construct(
        private InventoryItemRepository $inventoryItemRepository,
        private EntityManagerInterface  $entityManager,
    )
    {
    }

    public function addITem(int $quantity, Item $item, Account $account): true
    {
        $inventory = $this->inventoryItemRepository->findOneBy(['item' => $item, 'account' => $account]);
        if($inventory) {
            $inventory->setQuantity( $inventory->getQuantity() + $quantity );
        } else {
            $inventoryItem = (new InventoryItem())
                ->setQuantity($quantity)
                ->setItem($item)
                ->setAccount($account)
            ;
            $this->entityManager->persist($inventoryItem);
        }
        $this->entityManager->flush();
        return true;
    }

    /**
     * @throws \Exception
     */
    public function removeItem(int $quantity, Item $item, Account $account): true
    {
        $inventory = $this->inventoryItemRepository->findOneBy(['item' => $item, 'account' => $account]);
        if(!$inventory) {
            throw new \Exception('Inventory item not found', 404);
        }

        if($inventory->getQuantity() < $quantity) {
            throw new \Exception('Not enough item in inventory', 403);
        }

        $inventory->setQuantity( $inventory->getQuantity() - $quantity );
        $this->entityManager->flush();

        return true;
    }
}
