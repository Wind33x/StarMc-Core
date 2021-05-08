<?php
namespace Taco\GPvp\commands;
use Taco\GPvp\ui\GamemodeUI;
use pocketmine\command\PluginCommand;
use pocketmine\command\CommandSender;
use pocketmine\Player;
use Taco\GPvp\Loader;
use pocketmine\Server;
class MuteCmd extends PluginCommand {
    public function __construct() {
        parent::__construct("mute", Loader::getInstance());
	    $this->setDescription("Mute Command");
    }
    public function execute(CommandSender $player, string $commandLabel, array $args) {
        $ranks = ["Owner", "Admin", "Moderator"];
        if (!$player instanceof Player or in_array(Loader::getInstance()->getPlayerRank($player), $ranks)) {
            if (empty($args[0]) or empty($args[1])) {
                $player->sendMessage("§6Usage: /mute (player) (reason)");
                return true;
            }
            $playerr = Loader::getInstance()->getServer()->getPlayer($args[0]);
            if ($playerr == null) {
                $player->sendMessage("§6That Player Is Not Online");
                return true;
            }else{
                $player->sendMessage("§6Muted " . $playerr);
                unset($args[0]); 
                $reason = implode(" ", $args);
                Loader::getInstance()->setMuted($playerr);
                Loader::getInstance()->getServer()->broadcastMessage("§l§dMUTE >> §r" . $playerr->getName() . " Was Muted For: " . $reason);

            }
        }
    }
}