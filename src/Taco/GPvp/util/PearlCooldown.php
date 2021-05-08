<?php
namespace Taco\GPvp\util;
use pocketmine\event\player\PlayerInteractEvent;
use pocketmine\item\EnderPearl;
use pocketmine\event\Listener;
use Taco\GPvp\Loader;
class PearlCooldown implements Listener {
    private $pcooldown;
    /*
        Code Basically Taken From Prims Pearlcooldown
    */
    public function onEnderPearl(PlayerInteractEvent $event){
        $item = $event->getItem();
		if($event->getAction() === PlayerInteractEvent::RIGHT_CLICK_AIR) {
            if($item instanceof EnderPearl) {
                $cooldown = 12;
                $player = $event->getPlayer();
                if (isset($this->pcooldown[$player->getName()]) and time() - $this->pcooldown[$player->getName()] < $cooldown) {
                    $event->setCancelled(true);
                    $time = time() - $this->pcooldown[$player->getName()];
                    $message = "§6You Are On Cooldown For {cooldown} More Seconds";
                    $message = str_replace("{cooldown}", ($cooldown - $time), $message);
                    $player->sendMessage($message);
                    } else {
                        $this->pcooldown[$player->getName()] = time();
                    }
		    }
        }
    }
}