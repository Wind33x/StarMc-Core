<?php
namespace Taco\GPvp\commands;
use Taco\GPvp\ui\GamemodeUI;
use pocketmine\command\PluginCommand;
use pocketmine\command\CommandSender;
use pocketmine\Player;
use Taco\GPvp\Loader;
use pocketmine\Server;
class ReportCommand extends PluginCommand {
    private $pcooldown;
    public $repr;
    public function __construct() {
        parent::__construct("report", Loader::getInstance());
	    $this->setDescription("Report A Bad Player");
    }
    public function execute(CommandSender $player, string $commandLabel, array $args) {
        $ccooldown = 1800;
        if (isset($this->pcooldown[$player->getName()]) and time() - $this->pcooldown[$player->getName()] < $ccooldown) {
            $time = time() - $this->pcooldown[$player->getName()];
            $message = "§6You Are On Cooldown For This Command For {cooldown} More Seconds";
            $message = str_replace("{cooldown}", ($ccooldown - $time), $message);
            $player->sendMessage($message);
            } else {
                if (empty($args[0]) or empty($args[1])) {
                    $player->sendMessage("§6Usage: /report (player) (reason)");
                    return true;
                }
                $playerr = Loader::getInstance()->getServer()->getPlayer($args[0]);
                if (!$playerr == null) {
                    $player->sendMessage("§6That Player Isnt Online");
                    return true;
                }
                $this->pcooldown[$player->getName()] = time();
                $player->sendMessage("§6Report Was Sent To Staff, Help Is On The Way!");
                foreach (Loader::getInstance()->getServer()->getOnlinePlayers() as $staff) {
                    $ranks = ["Owner", "Admin", "Moderator", "Helper"];
                    unset($args[0]); 
                    $reason = implode(" ", $args);
                    if (in_array(Loader::getInstance()->getPlayerRank($staff), $ranks)) {
                        $staff->sendMessage("§l§cREPORT:\n§r§6" . $player->getName() . " Reported: " . $playerr . " For: " . $reason);
                    }
                
            }
        }
    }
}