<?php
namespace Taco\GPvp\commands;
use Taco\GPvp\ui\GamemodeUI;
use pocketmine\command\PluginCommand;
use pocketmine\command\CommandSender;
use pocketmine\Player;
use Taco\GPvp\Loader;
use pocketmine\Server;
class SetRankCmd extends PluginCommand {
    public function __construct() {
        parent::__construct("setrank", Loader::getInstance());
	    $this->setDescription("Set A Players Rank");
    }
    public function execute(CommandSender $player, string $commandLabel, array $args) {
        if (!$player instanceof Player or Loader::getInstance()->getPlayerRank($player) == "Owner" or $player->isOp()) {
            $ranks = ["Owner", "Admin", "Moderator", "Helper", "Trainee", "Star", "Supernova", "Nebula", "Builder", "Member"];
            if (empty($args[0]) or empty($args[1])) {
                $player->sendMessage("§6Usage: /setrank (player) (rank)");
                return true;
            }
            if (in_array($args[1], $ranks)) {
                Loader::getInstance()->setRank($args[0], $args[1]);
                $player->sendMessage("§6Succesfully Set " . $args[0] . "'s Rank To " . $args[1]);
            }else{
                $player->sendMessage("§6" . $args[1] . " Is Not a Rank!");
            }
        }else{
            $player->sendMessage("§6Missing Permissions");
        }
        
    }
}