<?php

namespace Yookou\FarmingChest\bloc;

use pocketmine\block\BlockTypeIds;
use pocketmine\block\tile\Chest;
use pocketmine\block\VanillaBlocks;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerInteractEvent;
use pocketmine\item\VanillaItems;
use pocketmine\math\Vector3;
use Yookou\FarmingChest\Main;

class FarmingChest implements Listener {
    public function onUse(PlayerInteractEvent $event) : void {
        if ($event->getBlock()->getTypeId() === BlockTypeIds::TRAPPED_CHEST) {
            $chest = $event->getBlock()->getPosition()->getWorld()->getTile(new Vector3($event->getBlock()->getPosition()->x, $event->getBlock()->getPosition()->y, $event->getBlock()->getPosition()->z));
            if (!($chest instanceof Chest)) {
                return;
            }
            for ($x = ($event->getBlock()->getPosition()->x - Main::getInstance()->getConfig()->getNested("range.x")); $x <= ($event->getBlock()->getPosition()->x + Main::getInstance()->getConfig()->getNested("range.x")); $x++) {
                for ($z = ($event->getBlock()->getPosition()->z - Main::getInstance()->getConfig()->getNested("range.z")); $z <= ($event->getBlock()->getPosition()->z + Main::getInstance()->getConfig()->getNested("range.z")); $z++) {
                    $block = $event->getBlock()->getPosition()->getWorld()->getBlockAt($x, $event->getBlock()->getPosition()->y, $z);
                    if ($block->getTypeId() === VanillaBlocks::POTATOES()->getTypeId() && $block->getAge() == $block::MAX_AGE) {
                        if (Main::getInstance()->getConfig()->getNested("agriculture.enable-potato", true)) {
                            if ($chest->getInventory()->canAddItem(VanillaItems::POTATO()->setCount(4))) {
                                $chest->getInventory()->addItem(VanillaItems::POTATO()->setCount(mt_rand(1, 4)));
                                $block->getPosition()->getWorld()->setBlock($block->getPosition(), VanillaBlocks::POTATOES());
                            } else {
                                $event->getPlayer()->sendMessage(Main::getInstance()->getConfig()->get("chest-full-message"));
                            }
                        }
                    } elseif ($block->getTypeId() === BlockTypeIds::CARROTS && $block->getAge() == $block::MAX_AGE) {
                        if (Main::getInstance()->getConfig()->getNested("agriculture.enable-carrot", true)) {
                            if ($chest->getInventory()->canAddItem(VanillaItems::CARROT()->setCount(4))) {
                                $chest->getInventory()->addItem(VanillaItems::CARROT()->setCount(mt_rand(1, 4)));
                                $block->getPosition()->getWorld()->setBlock($block->getPosition(), VanillaBlocks::CARROTS());
                            } else {
                                $event->getPlayer()->sendMessage(Main::getInstance()->getConfig()->get("chest-full-message"));
                            }
                        }
                    } elseif ($block->getTypeId() === BlockTypeIds::BEETROOTS && $block->getAge() == $block::MAX_AGE) {
                        if (Main::getInstance()->getConfig()->getNested("agriculture.enable-beetroot", true)) {
                            if ($chest->getInventory()->canAddItem(VanillaItems::BEETROOT()->setCount(1)) and $chest->getInventory()->canAddItem(VanillaItems::BEETROOT_SEEDS()->setCount(2))) {
                                $chest->getInventory()->addItem(VanillaItems::BEETROOT()->setCount(1));
                                $chest->getInventory()->addItem(VanillaItems::BEETROOT_SEEDS()->setCount(mt_rand(1, 2)));
                                $block->getPosition()->getWorld()->setBlock($block->getPosition(), VanillaBlocks::BEETROOTS());
                            } else {
                                $event->getPlayer()->sendMessage(Main::getInstance()->getConfig()->get("chest-full-message"));
                            }
                        }
                    } elseif ($block->getTypeId() === BlockTypeIds::WHEAT && $block->getAge() == $block::MAX_AGE) {
                        if (Main::getInstance()->getConfig()->getNested("agriculture.enable-wheat", true)) {
                            if ($chest->getInventory()->canAddItem(VanillaItems::WHEAT()->setCount(1)) and $chest->getInventory()->canAddItem(VanillaItems::WHEAT_SEEDS()->setCount(3))) {
                                $chest->getInventory()->addItem(VanillaItems::WHEAT()->setCount(1));
                                $chest->getInventory()->addItem(VanillaItems::WHEAT_SEEDS()->setCount(mt_rand(1, 3)));
                                $block->getPosition()->getWorld()->setBlock($block->getPosition(), VanillaBlocks::WHEAT());
                            } else {
                                $event->getPlayer()->sendMessage(Main::getInstance()->getConfig()->get("chest-full-message"));
                            }
                        }
                    }
                }
            }
        }
    }
}
