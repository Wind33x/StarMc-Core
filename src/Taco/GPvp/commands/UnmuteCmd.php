<?php
namespace Taco\GPvp\commands;
use Taco\GPvp\ui\GamemodeUI;
use pocketmine\command\PluginCommand;
use pocketmine\command\CommandSender;
use pocketmine\Player;
use Taco\GPvp\Loader;
use pocketmine\Server;
class UnmuteCmd extends PluginCommand {
    public function __construct() {
        parent::__construct("unmute", Loader::getInstance());
	    $this->setDescription("Un-Mute Command");
    }
    public function execute(CommandSender $player, string $commandLabel, array $args) {
        $ranks = ["Owner", "Admin", "Moderator"];
        if (!$player instanceof Player or in_array(Loader::getInstance()->getPlayerRank($player), $ranks)) {
            if (empty($args[0])) {
                $player->sendMessage("§6Usage: /unmute (player)");
                return true;
            }
            $playerr = Loader::getInstance()->getServer()->getPlayer($args[0]);
            if ($playerr == null) {
                $player->sendMessage("§6That Player Is Not Online");
                return true;
            }else{
                Loader::getInstance()->unsetMuted($playerr);
                $player->sendMessage("§6Unmuted " . $playerr->getName());

            }
        }
    }
}
