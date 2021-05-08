<?php
namespace Taco\GPvp\tasks;
use pocketmine\scheduler\Task;//§
use Taco\GPvp\Loader;//»
use pocketmine\Player;
use pocketmine\Server;
use pocketmine\level\Level;
use pocketmine\utils\Config;
class NameTagTask extends Task {
    public function onRun(int $tick) {
        foreach (Loader::getInstance()->getServer()->getOnlinePlayers() as $player) {
            $player->setNameTag("§r§f" . $player->getName() . "§l§7[§r§c" . $player->getHealth() . "§l§7]");
        }
    }
}