<?php
namespace Taco\GPvp;
use pocketmine\event\Listener;
use pocketmine\{Player, Server, item\Item};
use pocketmine\event\block\{BlockBreakEvent, BlockPlaceEvent};
use Taco\GPvp\{Loader, kit\Kits, ui\GamemodeUI};
use pocketmine\event\server\DataPacketReceiveEvent;
use pocketmine\level\sound\AnvilBreakSound;
use pocketmine\network\mcpe\protocol\AddActorPacket;
use pocketmine\entity\Entity;
use pocketmine\math\Vector3;
use Taco\GPvp\tasks\DeathTask;
use pocketmine\network\mcpe\protocol\InventoryTransactionPacket;
use pocketmine\event\entity\{EntityDamageByEntityEvent, EntityDamageEvent};
use pocketmine\event\player\{PlayerJoinEvent, PlayerQuitEvent, PlayerRespawnEvent, PlayerDeathEvent, PlayerChatEvent, PlayerExhaustEvent, PlayerInteractEvent, PlayerDropItemEvent, PlayerCommandPreprocessEvent};
class EventListener implements Listener {
    private $hubitemcd;
    private $combat;
    public function onJoin(PlayerJoinEvent $event) {
        $player = $event->getPlayer();
        $event->setJoinMessage("§2+ §a" . $player->getName());
        if (Loader::getInstance()->checkRegistered($player)) {
            Loader::getInstance()->registerPlayer($player);
        }else{
            
        }
        $position = Loader::getInstance()->getServer()->getDefaultLevel()->getSpawnLocation();
        $player->teleport($position);   
        Loader::getInstance()->giveKit($player, "spawn");
    }
    public function onDrop(PlayerDropItemEvent $event) {
        $player = $event->getPlayer();
        if (Loader::getInstance()->getWorld($player) == "hub") {
            $event->setCancelled(true);
        }
    }
    public function onQuit(PlayerQuitEvent $event) {
        $player = $event->getPlayer();
        $cooldown = 12;
        if (isset($this->combat[$player->getName()]) and time() - $this->combat[$player->getName()] < $cooldown) {
            $player->kill();
            $event->setQuitMessage("§4- §c" . $player->getName());
        }
    }
    public function onRespawn(PlayerRespawnEvent $event) {
        $player = $event->getPlayer();
        $position = Loader::getInstance()->getServer()->getDefaultLevel()->getSpawnLocation();
        $player->teleport($position);   
        Loader::getInstance()->giveKit($player, "spawn");
        
    }
    public function onDeath(PlayerDeathEvent $event) {
        $event->setDeathMessage(false);
    }
    public function onhitWhat(EntityDamageByEntityEvent $event) {
        if ($event->getEntity() instanceof Player and $event->getDamager() instanceof Player) {
            $player = $event->getEntity();
            $killer = $event->getDamager();
            $cooldown = 12;
            $this->combat[$player->getName()] = time();
            $this->combat[$killer->getName()] = time();
        }
    }
    public function onCmd(PlayerCommandPreprocessEvent $event) {
        $player = $event->getPlayer();
        $cooldown = 12;
        $cmd = strtolower(explode(' ', $event->getMessage())[0]);
        if ($cmd == "/report") {
            return true;
        }
        if (isset($this->combat[$player->getName()]) and time() - $this->combat[$player->getName()] < $cooldown) {
            $player->sendMessage("§6You are in combat!");
            $event->setCancelled(true);
        }
    }
    public function onDie(EntityDamageEvent $event) {
        switch ($event->getCause()) {
            case EntityDamageEvent::CAUSE_FALL:
                $event->setCancelled();
                return true;
            break;
            case EntityDamageEvent::CAUSE_VOID:
                $player = $event->getEntity();
                $event->setCancelled();
                $position = Loader::getInstance()->getServer()->getDefaultLevel()->getSpawnLocation();
                $player->teleport($position);
                return true;
            break;
        }
        if ($event instanceof EntityDamageByEntityEvent) {
            if ($event->getEntity() instanceof Player) {
                if ($event->getDamager() instanceof Player) {
                    $player = $event->getEntity();
                    $killer = $event->getDamager();
                    if ($player->getHealth() - $event->getFinalDamage() <= 0) {
                        Loader::getInstance()->getServer()->broadcastMessage("§6" . $player->getName() . " §eWas Killed By §6" . $killer->getName() . "§l§7[§r§c" . $killer->getHealth() . "§l§7]");
                        $player->setGamemode(3);
                        $player->getInventory()->clearAll();
                        $player->getArmorInventory()->clearAll();
                        $player->setHealth(20);
                        $player->setFood(20);
                        $light = new AddActorPacket();
                        $light->entityRuntimeId = Entity::$entityCount++;
                        $light->type = "minecraft:lightning_bolt";
                        $light->metadata = array();
                        $light->position = $player->asVector3()->add(0,$height = 0);
                        $light->yaw = $player->getYaw();
                        $light->pitch = $player->getPitch();
                        Loader::getInstance()->addKill($killer);
                        Loader::getInstance()->addDeath($player);
                        unset($this->combat[$player->getName()]);
                        $player->getServer()->broadcastPacket($player->getLevel()->getPlayers(), $light);
                        Loader::getInstance()->getScheduler()->scheduleRepeatingTask(new DeathTask($player), 20);
                    }
                }
            }
        }
    }
    public function onChat(PlayerChatEvent $event) {
        $player = $event->getPlayer();//»
        $msg = $event->getMessage();//§
        if (Loader::getInstance()->isMuted($player)) {
            $player->sendMessage("§6You Are Muted!");
            $event->setCancelled(true);
            return true;
        }
        switch (Loader::getInstance()->getPlayerRank($player)) {
            case "Owner":
                $event->setFormat("§b[" . Loader::getInstance()->getKills($player) . "] [OWNER] §d" . $player->getName() . " » §b" . $msg);
            break;
            case "Admin":
                $event->setFormat("§c[" . Loader::getInstance()->getKills($player) . "] [ADMIN] §e" . $player->getName() . " » §c" . $msg);
            break;
            case "Moderator":
                $event->setFormat("§5[" . Loader::getInstance()->getKills($player) . "] [MODERATOR] §b" . $player->getName() . " » §5" . $msg);
            break;
            case "Helper":
                $event->setFormat("§e[" . Loader::getInstance()->getKills($player) . "] [HELPER] §a" . $player->getName() . " » §e" . $msg);
            break;
            case "Trainee":
                $event->setFormat("§7[" . Loader::getInstance()->getKills($player) . "] [TRAINEE] §a" . $player->getName() . " » §7" . $msg);
            break;
            case "Star":

            break;
            case "Nebula":

            break;
            case "Supernova":

            break;
            case "Member":
                $event->setFormat("§3[" . Loader::getInstance()->getKills($player) . "] " . $player->getName() . " » §7" . $msg);
            break;
        }
    }
    public function Hunger(PlayerExhaustEvent $exhaustEvent) {
        $exhaustEvent->setCancelled(true);
    }
    public function antiCheat1(EntityDamageByEntityEvent $event) {
        if ($event->getEntity() instanceof Player) {
            $player = $event->getEntity();
            $damager = $event->getDamager();
            if ($player->distance($damager) >= 8) {
                if ($damager->getPing() >= 299) {
                    return true;
                }   
                $damager->setBanned(true);
                $damager->kick("§cAnticheat: You Were Banned For Reach! Questions? discord.starmc.xyz", false);
                Loader::getInstance()->getServer()->broadcastMessage("§l§dBAN >> §r" . $damager->getName() . " Was Automatically Banned For: Reach Hacks");
            }
        }
    }
    public function combo(EntityDamageEvent $event) {
        if ($event instanceof EntityDamageByEntityEvent) {
            $killer = $event->getDamager();
            if ($killer instanceof Player) {
                if (Loader::getInstance()->getWorld($killer) == "combo") {
                    $event->setAttackCooldown(0);
                }
            }
        }
    }
    
    public function onHit(EntityDamageByEntityEvent $event) {
        $player = $event->getEntity();
        $killer = $event->getDamager();
        if ($event->getEntity() instanceof Player) {
            if (Loader::getInstance()->getWorld($player) == "hub") {
                if (!$killer->isOp()) {
                    $event->setCancelled(true);
                }
            }
        }
    }
    public function onBreak(BlockBreakEvent $event) {
        $player = $event->getPlayer();
        if (!$player->getGamemode() == 1) {
            $event->setCancelled();
        }
    }
    public function onPlace(BlockPlaceEvent $event) {
        $player = $event->getPlayer();
        if (!$player->getGamemode() == 1) {
            $event->setCancelled();
        }
    }
    public function onInteract(PlayerInteractEvent $event) {
        $player = $event->getPlayer();
        $item = $event->getItem();
        $cooldown = 3;
        if (isset($this->pcooldown[$player->getName()]) and time() - $this->pcooldown[$player->getName()] < $cooldown) {
            $event->setCancelled(true);
            }else{
                $this->pcooldown[$player->getName()] = time();
                switch ($item->getCustomName()) {
                    case "§r§l§cFFA":
                        $player->sendMessage("§6Opening FFA Menu....");
                        Loader::getInstance()->openGui($player, "gamemode");
                    break;
            }
        }
    }
    public function onDataPacketReceive(DataPacketReceiveEvent $event){
        $player = $event->getPlayer();
        $packet = $event->getPacket();
        if($packet instanceof InventoryTransactionPacket){
            $transactionType = $packet->transactionType;
            if($transactionType === InventoryTransactionPacket::TYPE_USE_ITEM_ON_ENTITY){
                Loader::getInstance()->addCPS($player);
                $player->sendPopup("§dCPS: §f" . Loader::getInstance()->getCPS($player));
                if (Loader::getInstance()->getCps($player) > 19) {
                    $player->sendMessage("§6The Anticheat Says You Are Autoing, The Staff HAVE Been Notified.");
                    $ranks = ["Owner", "Admin", "Moderator", "Helper", "Trainee"];
                    foreach (Loader::getInstance()->getServer()->getOnlinePlayers() as $staff) {
                        if (in_array(Loader::getInstance()->getPlayerRank($staff), $ranks)) {
                            if ($player->getPing() >= 299) {
                                return true;
                            }   
                            if (Loader::getInstance()->getCPS($player) > 30) {
                                $player->setBanned(true);
                                $player->kick("§cAnticheat: You Were Banned For Autoclicking! Questions? discord.starmc.xyz", false);
                                Loader::getInstance()->getServer()->broadcastMessage("§l§dBAN >> §r" . $player->getName() . " Was Automatically Banned For: Autoclicking");
                                return true;
                            }
                            $staff->sendMessage("§6§lANTICHEAT->§cCPS ALERT:\n§r§6Name: " . $player->getName() . "\n§6CPS: " . Loader::getInstance()->getCPS($player) . "\n§6Ping: " . $player->getPing());
                        }
                    }
                }
            }
        }
    }
}