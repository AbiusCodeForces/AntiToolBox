<?php

namespace Abius\AntiToolBox;

use pocketmine\event\Listener;
use pocketmine\event\player\PlayerLoginEvent;
use pocketmine\permission\DefaultPermissions;
use pocketmine\plugin\PluginBase;
use pocketmine\Server;
use pocketmine\utils\Config as UtilsConfig;
use pocketmine\utils\TextFormat;

class Loader extends PluginBase implements Listener{

    public $message;
    public static $instance;

    public static function getInstance(): self{
        return self::$instance;
    }

    public function onEnable(): void{
        self::$instance = $this;
        $this->saveResource("message.yml");
        $this->message = new UtilsConfig($this->getDataFolder(). "message.yml", UtilsConfig::YAML);
        Server::getInstance()->getPluginManager()->registerEvents($this, $this);
        Server::getInstance()->getLogger()->notice("AntiToolBox was enabled !");
    }

    public function onLogin(PlayerLoginEvent $event){
        $player = $event->getPlayer();
        $extradata = $player->getPlayerInfo()->getExtraData();
        $os = (int)$extradata["DeviceOS"];
        $model = (string)$extradata["DeviceModel"];
        if($os == 1){
            $devicemodel = explode(" ", $model);
            if(isset($devicemodel[0])){
                $model = strtoupper($devicemodel[0]);
                if($model !== $devicemodel[0]){
                    foreach ($this->getServer()->getOnlinePlayers() as $p) {
                       if($player->hasPermission(DefaultPermissions::ROOT_OPERATOR)){
                          $p->sendMessage(TextFormat::RED . "STAFF > " . TextFormat::WHITE . $player->getName() . " Detected as Toolbox");
                        }
                        $player->kick($this->message->get("kick-message"));
                    }
                }

            }
        }
    }

    
    
}