<?php
namespace Taco\GPvp\tasks;
use pocketmine\scheduler\Task;//§
use Taco\GPvp\Loader;//»
use pocketmine\Player;
use pocketmine\Server;
use pocketmine\level\Level;
use pocketmine\utils\Config;
class AnnouncementTask extends Task {
    /*
        @var int $time
    */
    private $time = 1;
    public function onRun(int $tick) {
        $this->time++;
        switch ($this->time) {
            case 60:
                Loader::getInstance()->getServer()->broadcastMessage("\n§7-------------------------------\n§f » §bBuy A Rank At (coming soon)\n§7-------------------------------\n");
            break;
            case 120:
                Loader::getInstance()->getServer()->broadcastMessage("\n§7-------------------------------\n§f » §bBe Sure To Vote At Vote.StarMC.XYZ\n§7-------------------------------\n");
            break;
            case 180:
                Loader::getInstance()->getServer()->broadcastMessage("\n§7-------------------------------\n§f » §bReport Players Using /report\n§7-------------------------------\n");
            break;
            case 240:
                Loader::getInstance()->getServer()->broadcastMessage("\n§7-------------------------------\n§f » §bThe IP Is Play.StarMC.XYZ\n§7-------------------------------\n");
            break;
            case 300:
                Loader::getInstance()->getServer()->broadcastMessage("\n§7-------------------------------\n§f » §bJoin The Discord! Discord.StarMC.XYZ\n§7-------------------------------\n");
                $this->time = 0;
            break;
            default:
        }

    }
}