<?php
namespace Taco\GPvp\commands;
use Taco\GPvp\ui\GamemodeUI;
use pocketmine\command\PluginCommand;
use pocketmine\command\CommandSender;
use pocketmine\Player;
use Taco\GPvp\Loader;
use pocketmine\Server;
class GiveVoteReward extends PluginCommand {
    public function __construct() {
        parent::__construct("gvr", Loader::getInstance());
	    $this->setDescription("administrator");
    }
    public function execute(CommandSender $player, string $commandLabel, array $args) {
        if (!$player instanceof Player) {
            $playerr = Loader::getInstance()->getServer()->getPlayer($args[0]);
            Loader::getInstance()->getServer()->broadcastMessage("§l§dVOTE >> §f" . $playerr->getName() . " Has Voted At vote.starmc.xyz THANKS SO MUCH AYYAYAYAYAYYA!");
        }
    }
}