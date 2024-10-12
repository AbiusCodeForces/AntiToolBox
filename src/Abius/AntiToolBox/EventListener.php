<?php

declare(strict_types = 1);

namespace Abius\AntiToolBox;

use Abius\AntiToolBox\manager\CheckerManager;
use pocketmine\event\entity\EntityDamageByEntityEvent;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerInteractEvent;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\event\player\PlayerLoginEvent;
use pocketmine\event\player\PlayerMoveEvent;
use pocketmine\player\Player;

class EventListener implements Listener {

    public function onLogin(PlayerLoginEvent $event): void {
        $player = $event->getPlayer();
        CheckerManager::getInstance()->checkDevice($player);
    }

    public function onJoin(PlayerJoinEvent $event): void {
        $player = $event->getPlayer();

        CheckerManager::getInstance()->setLastPos($player);
    }

    public function onAttack(EntityDamageByEntityEvent $event): void {
        $entity = $event->getEntity();
        $damager = $event->getDamager();
        if($damager instanceof Player){
            CheckerManager::getInstance()->checkDistanceAttack($damager, $entity);
        }
    }

    public function onMove(PlayerMoveEvent $event): void {
        $player = $event->getPlayer();

        CheckerManager::getInstance()->setLastPos($player);
    }

    public function onInteract(PlayerInteractEvent $event): void {
        $player = $event->getPlayer();

        CheckerManager::getInstance()->checkClickTeleport($player);
    }
}