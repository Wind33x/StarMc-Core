<?php
namespace Taco\GPvp\commands;
use Taco\GPvp\ui\GamemodeUI;
use pocketmine\command\PluginCommand;
use pocketmine\command\CommandSender;
use pocketmine\Player;
use Taco\GPvp\Loader;
use pocketmine\Server;
class GmCmd extends PluginCommand {
    public function __construct() {
        parent::__construct("gm", Loader::getInstance());
	    $this->setDescription("Change Your Gamemode");
    }
    public function execute(CommandSender $player, string $commandLabel, array $args) {
        $ranks = ["Owner", "Admin"];
        if (in_array(Loader::getInstance()->getPlayerRank($player), $ranks)) {
            if (!$args[0] == 1 or !$args[0] == 0 or empty($args[0])) {
                $player->sendMessage('do /gm 1 or /gm 0');
                return true;
            }
            switch($args[0]) {
                case 1:
                    $player->setGamemode(1);
                    player->sendMessage("ur creative now lol");
                case 0:
                    $player->setGamemode(0);
                    $player->sendMessage("ur survival now lol");
            }
        }
    }
}