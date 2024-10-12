<?php

declare(strict_types=1);

namespace Abius\AntiToolBox\manager;

use Abius\AntiToolBox\Loader;
use pocketmine\entity\Entity;
use pocketmine\math\Vector3;
use pocketmine\permission\DefaultPermissions;
use pocketmine\player\Player;
use pocketmine\utils\SingletonTrait;
use pocketmine\utils\TextFormat;

class CheckerManager {

    use SingletonTrait;
    public array $lastPos = [];

    public function checkDevice(Player $player): void {
        $extradata = $player->getPlayerInfo()->getExtraData();
        $os = (int)$extradata["DeviceOS"];
        $model = (string)$extradata["DeviceModel"];
        if($os == 1){
            $devicemodel = explode(" ", $model);
            if(isset($devicemodel[0])){
                $model = strtoupper($devicemodel[0]);
                if($model !== $devicemodel[0]){
                    foreach (Loader::getInstance()->getServer()->getOnlinePlayers() as $p) {
                        if($player->hasPermission(DefaultPermissions::ROOT_OPERATOR)){
                            $p->sendMessage(TextFormat::RED . "STAFF > " . TextFormat::WHITE . $player->getName() . " Detected as Toolbox");
                        }
                        $player->kick(Loader::getInstance()->message->get("kick-message"));
                    }
                }
            }
        }
    }

    public function checkDistanceAttack(Player $entity1, Entity $entity2): void {
        if($entity1->getPosition()->distance($entity2->getPosition()) > 10) $entity1->kick(Loader::getInstance()->message->get("kick-message"));
    }

    public function checkClickTeleport(Player $player): void {
        if($player->getPosition()->distance($this->getLastPos($player)) > 5) $player->kick(Loader::getInstance()->message->get("kick-message"));
    }

    public function setLastPos(Player $player): void {
        $this->lastPos[$player->getName()] = $player->getPosition();
    }

    public function getLastPos(Player $player): Vector3 {
        return $this->lastPos[$player->getName()];
    }
}