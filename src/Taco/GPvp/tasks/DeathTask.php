<?php
namespace Taco\GPvp\tasks;
use pocketmine\scheduler\Task;//§
use Taco\GPvp\Loader;//»
use pocketmine\Player;
use pocketmine\Server;
use pocketmine\level\Level;
use pocketmine\utils\Config;
use Taco\GPvp\EventListener;
class DeathTask extends Task {
    private $player;
    private $time = 0;
    public function __construct($player) {
        $this->player = $player;
    }
    public function onRun(int $tick) {
        $player = $this->player;
        $this->time++;
        if ($this->time == 5) {
            $player->setGamemode(0);
            $player->setHealth(20);
            $position = Loader::getInstance()->getServer()->getDefaultLevel()->getSpawnLocation();
            $player->teleport($position);   
            Loader::getInstance()->giveKit($player, "spawn");
            $this->time = 0;
            Loader::getInstance()->getScheduler()->cancelTask($this->getTaskId());
        }
    }
}