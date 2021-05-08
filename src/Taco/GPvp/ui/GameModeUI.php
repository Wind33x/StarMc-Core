<?php
namespace Taco\GPvp\ui;
use muqsit\invmenu\InvMenu;
use muqsit\invmenu\transaction\{InvMenuTransaction, InvMenuTransactionResult};
use pocketmine\Player;
use pocketmine\item\Item;
use pocketmine\math\Vector3;
use Taco\GPvp\Loader;
use jojoe77777\FormAPI;
use jojoe77777\FormAPI\SimpleForm;
class GamemodeUI {
    public function GamemodeUI(Player $player) {
        $gap = count(Loader::getInstance()->getServer()->getLevelByName("gapple")->getPlayers());
        $nodebuf = count(Loader::getInstance()->getServer()->getLevelByName("nodebuff")->getPlayers());
        $comb = count(Loader::getInstance()->getServer()->getLevelByName("combo")->getPlayers());
        $fist = count(Loader::getInstance()->getServer()->getLevelByName("fist")->getPlayers());
        $diam = count(Loader::getInstance()->getServer()->getLevelByName("diamond")->getPlayers());
        $ovral = $comb + $nodebuf + $gap + $fist + $diam;
        $api = Loader::getInstance()->getServer()->getPluginManager()->getPlugin("FormAPI");
        $form = $api->createSimpleForm(function (Player $player, int $data = null) {
            $result = $data;
            if($result === null){
                return true;
            }             
            switch($result){
                case 0:
                    $player->sendMessage("§aWarped To NoDebuff");
                    $position1 = Loader::getInstance()->getServer()->getLevelByName("nodebuff")->getSafeSpawn();
                    $player->teleport($position1);
                    //
                    //
                    //
                    //
                    //
                    ///
                    //
                    $x = rand(333,217);
                    $z = rand(160,285);
                    $position = new Vector3($x, 67, $z);
                    $player->teleport($position);
                    Loader::getInstance()->giveKit($player, "nodebuff");
                break;
                case 1:
                    Loader::getInstance()->giveKit($player, "gapple");
                    $player->sendMessage("§aWarped To Gapple");
                    $position1 = Loader::getInstance()->getServer()->getLevelByName("gapple")->getSafeSpawn();
                    $player->teleport($position1);
                    //
                    //
                    //
                    //
                    //
                    ///
                    //
                    $x = rand(333,217);
                    $z = rand(160,285);
                    $position = new Vector3($x, 67, $z);
                    $player->teleport($position);
                break;
                case 2:
                    Loader::getInstance()->giveKit($player, "diamond");
                    $player->sendMessage("§aWarped To Diamond");
                    $position1 = Loader::getInstance()->getServer()->getLevelByName("diamond")->getSafeSpawn();
                    $player->teleport($position1);
                    //
                    //
                    //
                    //
                    //
                    ///
                    //
                    $x = rand(333,217);
                    $z = rand(160,285);
                    $position = new Vector3($x, 67, $z);
                    $player->teleport($position);
                break;
                case 3:
                    $player->getInventory()->clearAll();
		            $player->getArmorInventory()->clearAll();
                    $player->sendMessage("§aWarped To Fist");
                    $position1 = Loader::getInstance()->getServer()->getLevelByName("fist")->getSafeSpawn();
                    $player->teleport($position1);
                    //
                    //
                    //
                    //
                    //
                    ///
                    //
                    $x = rand(333,217);
                    $z = rand(160,285);
                    $position = new Vector3($x, 67, $z);
                    $player->teleport($position);
                break;
                case 4:
                    $player->sendMessage("§aWarped To Combo");
                    $position = Loader::getInstance()->getServer()->getLevelByName("combo")->getSafeSpawn();
                    $player->teleport($position);
                    Loader::getInstance()->giveKit($player, "combo");
                break;
                case 5:

                break;
                
                }
            });
            $form->setTitle("§l§dStar§5MC §dF§5F§dA");
            $form->setContent("§r§5Pvp With §d" . $ovral . " §5Other Players");
            $form->addButton("§5Nodebuff\n§dPlaying: " . $nodebuf);
            $form->addButton("§5Gapple\n§dPlaying: " . $gap);
            $form->addButton("§5Diamond\n§dPlaying: " . $diam);
            $form->addButton("§5Fist\n§dPlaying: " . $fist);
            $form->addButton("§5Combo\n§dPlaying: " . $comb);
            $form->addButton("§5Exit");
            $player->sendForm($form);                  
            return $form;                                           
    }
    /*
        public function openGamemodeUI(Player $player) {
        $gap = count(Loader::getInstance()->getServer()->getLevelByName("gapple")->getPlayers());
        $nodebuf = count(Loader::getInstance()->getServer()->getLevelByName("nodebuff")->getPlayers());
        $comb = count(Loader::getInstance()->getServer()->getLevelByName("combo")->getPlayers());
        $fist = count(Loader::getInstance()->getServer()->getLevelByName("fist")->getPlayers());
        $diam = count(Loader::getInstance()->getServer()->getLevelByName("diamond")->getPlayers());
        $ovral = $comb + $nodebuf + $gap + $fist + $diam;
        $choice1 = Item::get(438, 0, 1);
	    $choice1->setCustomName("§r§cNoDebuff");
        $choice1->setLore(["§f" . $nodebuf . " Currently In Arena"]);
        $choice2 = Item::get(322, 0, 1);
	    $choice2->setCustomName("§r§cGapple");
        $choice2->setLore(["§f" . $gap . " Currently In Arena"]);
        $choice3 = Item::get(276, 0, 1);
	    $choice3->setCustomName("§r§cDiamond");
        $choice3->setLore(["§f" . $diam . " Currently In Arena"]);
        $choice4 = Item::get(364, 0, 1);
	    $choice4->setCustomName("§r§cCombo");
        $choice4->setLore(["§f" . $comb . " Currently In Arena"]);
        $choice5 = Item::get(320, 0, 1);
	    $choice5->setCustomName("§r§cFist");
        $choice5->setLore(["§f" . $fist . " Currently In Arena"]);
        $menu = InvMenu::create(InvMenu::TYPE_HOPPER);
        $inventory = $menu->getInventory();
        $menu->setName("Fight With " . $ovral . " Other Players!");
        $menu->getInventory()->setItem(0, $choice1);
        $menu->getInventory()->setItem(1, $choice2);
        $menu->getInventory()->setItem(2, $choice3);
        $menu->getInventory()->setItem(3, $choice4);
        $menu->getInventory()->setItem(4, $choice5);
        $menu->setListener(function(InvMenuTransaction $transaction) : InvMenuTransactionResult {
            $player = $transaction->getPlayer();
            $itemClicked = $transaction->getItemClicked();
            switch($itemClicked->getCustomName()) {
                case "§r§cNoDebuff":
                    $player->sendMessage("§aWarped To NoDebuff");
                    $position1 = Loader::getInstance()->getServer()->getLevelByName("nodebuff")->getSafeSpawn();
                    $player->teleport($position1);
                    //
                    //
                    //
                    //
                    //
                    ///
                    //
                    $x = rand(333,217);
                    $z = rand(160,285);
                    $position = new Vector3($x, 67, $z);
                    $player->teleport($position);
                    $transaction->getPlayer()->removeWindow($transaction->getAction()->getInventory());
                    Loader::getInstance()->giveKit($player, "nodebuff");
                break;
                case "§r§cGapple":
                    Loader::getInstance()->giveKit($player, "gapple");
                    $player->sendMessage("§aWarped To Gapple");
                    $position1 = Loader::getInstance()->getServer()->getLevelByName("gapple")->getSafeSpawn();
                    $player->teleport($position1);
                    //
                    //
                    //
                    //
                    //
                    ///
                    //
                    $x = rand(333,217);
                    $z = rand(160,285);
                    $position = new Vector3($x, 67, $z);
                    $player->teleport($position);
                    $transaction->getPlayer()->removeWindow($transaction->getAction()->getInventory());
                break;
                case "§r§cDiamond":
                    Loader::getInstance()->giveKit($player, "diamond");
                    $player->sendMessage("§aWarped To Diamond");
                    $position1 = Loader::getInstance()->getServer()->getLevelByName("diamond")->getSafeSpawn();
                    $player->teleport($position1);
                    //
                    //
                    //
                    //
                    //
                    ///
                    //
                    $x = rand(333,217);
                    $z = rand(160,285);
                    $position = new Vector3($x, 67, $z);
                    $player->teleport($position);
                    $transaction->getPlayer()->removeWindow($transaction->getAction()->getInventory());
                break;
                case "§r§cCombo":
                    $player->sendMessage("§aWarped To Combo");
                    $position = Loader::getInstance()->getServer()->getLevelByName("combo")->getSafeSpawn();
                    $player->teleport($position);
                    $transaction->getPlayer()->removeWindow($transaction->getAction()->getInventory());
                    Loader::getInstance()->giveKit($player, "combo");
                break;
                case "§r§cFist":
                    $player->getInventory()->clearAll();
		            $player->getArmorInventory()->clearAll();
                    $player->sendMessage("§aWarped To Fist");
                    $position1 = Loader::getInstance()->getServer()->getLevelByName("fist")->getSafeSpawn();
                    $player->teleport($position1);
                    //
                    //
                    //
                    //
                    //
                    ///
                    //
                    $x = rand(333,217);
                    $z = rand(160,285);
                    $position = new Vector3($x, 67, $z);
                    $player->teleport($position);
                    $transaction->getPlayer()->removeWindow($transaction->getAction()->getInventory());
                break;
                default:
            }
            return $transaction->discard();
        });
        $menu->send($player);
    }
    */
}
