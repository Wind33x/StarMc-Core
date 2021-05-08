<?php
namespace Taco\GPvp\tasks;
use pocketmine\scheduler\Task;//§
use Taco\GPvp\Loader;//»
use pocketmine\Player;
use pocketmine\Server;
use pocketmine\level\Level;
use Scoreboards\Scoreboards;
use pocketmine\utils\Config;
class ScoreboardTask extends Task {
    public function onRun(int $tick) {
        $gap = count(Loader::getInstance()->getServer()->getLevelByName("gapple")->getPlayers());
        $nodebuf = count(Loader::getInstance()->getServer()->getLevelByName("nodebuff")->getPlayers());
        $comb = count(Loader::getInstance()->getServer()->getLevelByName("combo")->getPlayers());
        $fist = count(Loader::getInstance()->getServer()->getLevelByName("fist")->getPlayers());
        $diam = count(Loader::getInstance()->getServer()->getLevelByName("diamond")->getPlayers());
        $ovral = $comb + $nodebuf + $gap + $fist + $diam;
        foreach (Loader::getInstance()->getServer()->getOnlinePlayers() as $player) {
            if (Loader::getInstance()->getWorld($player) == "hub") {
                $api = Scoreboards::getInstance();
                $api->new($player, "ObjectiveName", "§l§dPLAY.STARMC.XYZ");
                $api->setLine($player, 1, "§7                       ");
                $api->setLine($player, 2, "§fOnline: " . count(Loader::getInstance()->getServer()->getOnlinePlayers()));
                $api->setLine($player, 3, "§fFFA: " . $ovral);
                $api->setLine($player, 4, "§fK: " . Loader::getInstance()->getKills($player) . " §fD: " . Loader::getInstance()->getDeaths($player));
                $api->setLine($player, 5, "§7" . "                             ");
            }else{
                $api = Scoreboards::getInstance();
                if ($api->getObjectiveName($player)) {
                    $api->remove($player);
                }
            }
        }   
    }
}
