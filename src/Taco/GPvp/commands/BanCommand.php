<?php
namespace Taco\GPvp\commands;
use Taco\GPvp\ui\GamemodeUI;
use pocketmine\command\PluginCommand;
use pocketmine\command\CommandSender;
use pocketmine\Player;
use Taco\GPvp\Loader;
use pocketmine\Server;
class BanCommand extends PluginCommand {
    public function __construct() {
        parent::__construct("ban", Loader::getInstance());
	    $this->setDescription("Ban Command");
    }
    public function execute(CommandSender $player, string $commandLabel, array $args) {
        $ranks = ["Owner", "Admin"];
        if (!$player instanceof Player or in_array(Loader::getInstance()->getPlayerRank($player), $ranks)) {
            if (empty($args[0]) or empty($args[1])) {
                $player->sendMessage("§6Usage: /ban (player) (reason)");
                return true;
            }
            $playerr = Loader::getInstance()->getServer()->getPlayer($args[0]);
            if ($playerr == null) {
                $player->sendMessage("§6That Player Is Not Online");
                return true;
            }else{
                unset($args[0]); 
                $reason = implode(" ", $args);
                $playerr->setBanned(true);
                $playerr->kick("§cYou Were Kicked For: " . $reason, false);
                Loader::getInstance()->getServer()->broadcastMessage("§l§dBAN >> §r" . $playerr->getName() . " Was Banned For: " . $reason);

            }
        }
    }
}