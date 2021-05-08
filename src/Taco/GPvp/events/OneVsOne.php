<?php
namespace Taco\GPvp\events;
use muqsit\invmenu\InvMenu;
use pocketmine\Player;
use pocketmine\item\Item;
use pocketmine\math\Vector3;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerDeathEvent;
use Taco\GPvp\Loader;
class OneVsOne implements Listener {
    public function eventUI(Player $player) {
        $api = Loader::getInstance()->getServer()->getPluginManager()->getPlugin("FormAPI");
        $form = $api->createSimpleForm(function (Player $player, int $data = null) {
            $result = $data;
            if($result === null){
                return true;
            }             
            switch($result){
                case 0:
                    $player->sendMessage("§6You Have Joined The OneVsOne Event");
                    $this->participants[] = $player->getName();
                break;
                }
            });
            $form->setTitle("§l§dStar§5MC §dE§5V§dE§5N§dT§5S");
            if ($this->onevonerunning == false) {
                $form->setContent("§fThere Is No Events Running");
            }else{
                $form->setContent("§fA OneVsOne Event Is Running!");
            }
            if ($this->onevonerunning == true) {
                $form->addButton("§5Join!\n§dPlaying: ");
            }
            $player->sendForm($form);                  
            return $form;                                           
    }
    public function onDeath(PlayerDeathEvent $event) {
        if ($this->running == false) return;
        if (!in_array($event->getPlayer(), $this->fighting)) return;

    }
    public function endGame() {

    }
    public function startGame() {

    }
}
