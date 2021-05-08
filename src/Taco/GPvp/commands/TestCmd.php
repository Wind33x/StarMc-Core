<?php
namespace Taco\GPvp\commands;
use Taco\GPvp\ui\GamemodeUI;
use pocketmine\command\PluginCommand;
use pocketmine\command\CommandSender;
use pocketmine\Player;
use Taco\GPvp\Loader;
use pocketmine\Server;
class TestCmd extends PluginCommand {
    public function __construct() {
        parent::__construct("test", Loader::getInstance());
	    $this->setDescription("Development Test Command");
    }
    public function execute(CommandSender $player, string $commandLabel, array $args) {
        if (!$player->isOp()) {

        }else{
        $file = new GamemodeUI();
        $file->openGamemodeUI($player);
        }
    }
}