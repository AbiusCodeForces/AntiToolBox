<?php

namespace Abius\AntiToolBox;

use pocketmine\plugin\PluginBase;
use pocketmine\Server;
use pocketmine\utils\Config as UtilsConfig;

class Loader extends PluginBase {

    public UtilsConfig $message;
    public static self $instance;

    public static function getInstance(): self{
        return self::$instance;
    }

    public function onEnable(): void{
        self::$instance = $this;
        $this->saveResource("message.yml");
        $this->message = new UtilsConfig($this->getDataFolder(). "message.yml", UtilsConfig::YAML);
        Server::getInstance()->getPluginManager()->registerEvents(new EventListener(), $this);
        Server::getInstance()->getLogger()->notice("AntiToolBox was enabled !");
    }
}