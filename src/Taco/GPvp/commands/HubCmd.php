<?php
namespace Taco\GPvp\commands;
use Taco\GPvp\ui\GamemodeUI;
use pocketmine\command\PluginCommand;
use pocketmine\command\CommandSender;
use pocketmine\Player;
use Taco\GPvp\Loader;
use pocketmine\Server;
class HubCmd extends PluginCommand {
    public function __construct() {
        parent::__construct("hub", Loader::getInstance());
	    $this->setDescription("Warp Back To Hub");
    }
    public function execute(CommandSender $player, string $commandLabel, array $args) {
        $position = Loader::getInstance()->getServer()->getDefaultLevel()->getSpawnLocation();
        $player->teleport($position);
        $player->sendMessage("§aYou Were Warped To Hub");
        Loader::getInstance()->giveKit($player, "spawn");
    }
}