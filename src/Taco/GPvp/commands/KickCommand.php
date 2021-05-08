<?php
namespace Taco\GPvp\commands;
use Taco\GPvp\ui\GamemodeUI;
use pocketmine\command\PluginCommand;
use pocketmine\command\CommandSender;
use pocketmine\Player;
use Taco\GPvp\Loader;
use pocketmine\Server;
class KickCommand extends PluginCommand {
    public function __construct() {
        parent::__construct("kick", Loader::getInstance());
	    $this->setDescription("Kick Command");
    }
    public function execute(CommandSender $player, string $commandLabel, array $args) {
        $ranks = ["Owner", "Admin", "Moderator", "Helper"];
        if (!$player instanceof Player or in_array(Loader::getInstance()->getPlayerRank($player), $ranks)) {
            if (empty($args[0]) or empty($args[1])) {
                $player->sendMessage("§6Usage: /kick (player) (reason)");
                return true;
            }
            $playerr = Loader::getInstance()->getServer()->getPlayer($args[0]);
            if ($playerr == null) {
                $player->sendMessage("§6That Player Is Not Online");
                return true;
            }else{
                unset($args[0]); 
                $reason = implode(" ", $args);
                $playerr->kick("§cYou Were Kicked For: " . $reason, false);
                Loader::getInstance()->getServer()->broadcastMessage("§l§dKICK >> §r" . $playerr->getName() . " Was Kicked For: " . $reason);
            
            }
        }
    }
}