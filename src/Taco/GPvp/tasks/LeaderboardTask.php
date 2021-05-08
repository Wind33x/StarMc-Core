<?php
namespace Taco\GPvp\tasks;
use pocketmine\scheduler\Task;//§
use Taco\GPvp\Loader;//»
use pocketmine\Player;
use pocketmine\Server;
use pocketmine\level\Level;
use pocketmine\level\particle\FloatingTextParticle;
use pocketmine\math\Vector3;
use pocketmine\utils\Config;
class LeaderboardTask extends Task {
    public $ptf = false;
    public $particle;
    public $particle1;
    public function onRun(int $tick) {
        if ($this->ptf == false) {
            $this->ptf = true;
            $this->particle = new FloatingTextParticle(new Vector3(214, 61, 232, Loader::getInstance()->getServer()->getLevelbyName("hub")), "", "");
            $this->particle1 = new FloatingTextParticle(new Vector3(240, 61, 232, Loader::getInstance()->getServer()->getLevelbyName("hub")), "", "");
        }else{
            $this->particle->setText(Loader::getInstance()->sendTopList());
            $level = Loader::getInstance()->getServer()->getLevelbyName("hub");
            $level->addParticle($this->particle);
            $this->particle1->setText(Loader::getInstance()->sendTopList1());
            $level = Loader::getInstance()->getServer()->getLevelbyName("hub");
            $level->addParticle($this->particle1);
        }
    }
}