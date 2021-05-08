<?php
namespace Taco\GPvp; //§
use pocketmine\plugin\PluginBase;
use pocketmine\{Server, Player, utils\Config, math\Vector3, utils\TextFormat};
use Taco\GPvp\kit\Kits;
use Taco\GPvp\tasks\{AnnouncementTask, NameTagTask, ScoreboardTask, LeaderboardTask};
use pocketmine\item\Item;
use Taco\GPvp\util\{AntiSpam, PearlCooldown};
use muqsit\invmenu\{InvMenu, InvMenuHandler};
use Taco\GPvp\commands\{TestCmd, SetRankCmd, KickCommand, BanCommand, ReportCommand, HubCmd, UnmuteCmd, MuteCmd, GiveVoteReward};
use Taco\GPvp\ui\GamemodeUI;
use pocketmine\level\particle\FloatingTextParticle;
class Loader extends PluginBase {
    public $text;
    public $clicks;
    protected static $instance;
    public function onEnable() {
        if(!InvMenuHandler::isRegistered()){
            InvMenuHandler::register($this);
        }
        $this->getLogger()->info("
        
        StarMC
        
        Created By Taco

        Enjoy Lol
        
        ");
        foreach (["hub", "nodebuff", "gapple", "combo", "fist", "diamond"] as $level) {
			$this->getServer()->loadLevel($level);
        }
        self::$instance = $this; 
        $this->getServer()->getPluginManager()->registerEvents(new EventListener(), $this);
        $this->getServer()->getPluginManager()->registerEvents(new AntiSpam(), $this);
        $this->getServer()->getPluginManager()->registerEvents(new PearlCooldown(), $this);
        $commands = [
            "me",
            "suicide",
            "kill",
            "ban-ip",
            "ban",
            "kick"
        ];
        $this->getServer()->broadcastMessage("Welcome To starmc");
        $this->unregisterCommands($commands);
        $cmds = [
            new TestCmd(),
            new SetRankCmd(),
            new KickCommand(),
            new BanCommand(),
            new ReportCommand(),
            new HubCmd(),
            new MuteCmd(),
            new UnmuteCmd(),
            new GiveVoteReward()
        ];
        foreach ($cmds as $cmd) {
            $this->getServer()->getCommandMap()->registerAll("Loader", [$cmd]);
        }
        $log = new Config($this->getDataFolder() . "kills.yml", Config::YAML);
        $log->save();
        $log1 = new Config($this->getDataFolder() . "deaths.yml", Config::YAML);
        $log1->save();
        $log2 = new Config($this->getDataFolder() . "rank.yml", Config::YAML);
        $log2->save();
        $log3 = new Config($this->getDataFolder() . "muted.yml", Config::YAML);
        $log3->save();
        $log4 = new Config($this->getDataFolder() . "streaks.yml", Config::YAML);
        $log4->save();
        $this->getScheduler()->scheduleRepeatingTask(new AnnouncementTask, 20);
        $this->getScheduler()->scheduleRepeatingTask(new NameTagTask, 20);
        $this->getScheduler()->scheduleRepeatingTask(new ScoreboardTask, 60);
        $this->getScheduler()->scheduleRepeatingTask(new leaderboardTask, 600);//600 = 30sec
    }
    private function unregisterCommands(array $commands) : void {
        $commandMap = $this->getServer()->getInstance()->getCommandMap();
        foreach($commandMap->getCommands() as $cmd) {
            if(in_array($cmd->getName(), $commands)) {
                $cmd->setLabel("disabled_" . $cmd->getName());
                $commandMap->unregister($cmd);
            }
        }
    }
    public static function getInstance() : self {
        return self::$instance;
    }
    //Hold Useful Functions Here Due To Easy Access By Loader::getInstance
    public function getPlayerRank(Player $player) {
        $log = new Config($this->getDataFolder() . "rank.yml", Config::YAML);
        return $log->get($player->getName());
    }   
    public function setRank($player, $rank) {
        $log = new Config($this->getDataFolder() . "rank.yml", Config::YAML);
        $log->set($player, $rank);
        $log->save();
    }
    public function getKills(Player $player) {
        $log = new Config($this->getDataFolder() . "kills.yml", Config::YAML);
        return $log->get($player->getName());
    }
    public function getDeaths(Player $player) {
        $log = new Config($this->getDataFolder() . "deaths.yml", Config::YAML);
        return $log->get($player->getName());
    }
    public function addKill(Player $player) {
        $log = new Config($this->getDataFolder() . "kills.yml", Config::YAML);
        $log->set($player->getName(), $log->get($player->getName()) + 1);
        $log->save();
        $log1 = new Config($this->getDataFolder() . "streaks.yml", Config::YAML);
        $log1->set($player->getName(), $log->get($player->getName()) + 1);
        $log1->save();
        $player->sendMessage("§aYour New Streak Is: " . $this->getStreak($player));
    }
    public function getStreak(Player $player) {
        $log = new Config($this->getDataFolder() . "streaks.yml", Config::YAML);
        return $log->get($player->getName());
    }
    public function addDeath(Player $player) {
        $log = new Config($this->getDataFolder() . "deaths.yml", Config::YAML);
        $log->set($player->getName(), $log->get($player->getName()) + 1);
        $log->save();
        $log1 = new Config($this->getDataFolder() . "streaks.yml", Config::YAML);
        $log1->set($player->getName(), 0);
        $log1->save();
    }
    public function registerPlayer(Player $player) {
        $log = new Config($this->getDataFolder() . "kills.yml", Config::YAML);
        $log1 = new Config($this->getDataFolder() . "deaths.yml", Config::YAML);
        $log2 = new Config($this->getDataFolder() . "rank.yml", Config::YAML);
        $log3 = new Config($this->getDataFolder() . "muted.yml", Config::YAML);
        $log->set($player->getName(), 0);
        $log->save();
        $log1->set($player->getName(), 0);
        $log1->save();
        $log2->set($player->getName(), "Member");
        $log2->save();
        $log3->set($player->getName(), false);
        $log3->save();
    }
    public function checkRegistered(Player $player) {
        $log = new Config($this->getDataFolder() . "kills.yml", Config::YAML);
        if (!$log->exists($player->getName())) {
            return true;
        }else{
            return false;
        }
    }
    public function getWorld(Player $player) {
        $level = $player->getLevel()->getName();
        return $level;
    }
    public function setMuted(Player $player) {
        $log3 = new Config($this->getDataFolder() . "muted.yml", Config::YAML);
        $log3->set($player->getName(), true);
        $log3->save();
    }
    public function unsetMuted(Player $player) {
        $log3 = new Config($this->getDataFolder() . "muted.yml", Config::YAML);
        $log3->set($player->getName(), false);
        $log3->save();
    }
    public function isMuted(Player $player) {
        $log3 = new Config($this->getDataFolder() . "muted.yml", Config::YAML);
        if ($log3->get($player->getName())) {
            return true;
        }
        else{
            return false;
        }
    }
    public function giveKit(Player $player, $type) {
        $file = new Kits();
        switch ($type) {
            case "gapple":
                $file->gappleItems($player);
            break;
            case "nodebuff":
                $file->noDebuffItems($player);
            break;
            case "combo":
                $file->comboItems($player);
            break;
            case "spawn":
                $file->spawnItems($player);
            break;
            case "diamond":
                $file->diamondItems($player);
            break;
            default:
        }
    }
    public function openGui(Player $player, $type) {
        switch($type) {
            case "gamemode":
                $file = new GamemodeUI();
                $file->GamemodeUI($player);
            break;
        }
    }
    public function getTopList() {
        $all = (new Config($this->getDataFolder() . "kills.yml", Config::YAML))->getAll();
        arsort($all);
        $ret = [];
        $n = 1;
        $max = ceil(count($all) / 10);
        $page = min($max, max(1, 1));
        foreach ($all as $p => $m) {
            $current = ceil($n / 10);
            if ($current == $page) {
                $ret[$n] = [$p, $m];
            } elseif ($current > $page) {
                break;
            }
            ++$n;
        }
        return $ret;
    }

    public function sendTopList() {
        $top = $this->getTopList();
        $space = "\n";
        $message = TextFormat::BOLD . TextFormat::AQUA . "§l§eTop Kills" . TextFormat::RESET . "\n \n";
        foreach ($top as $n => $list) {
            $message .= TextFormat::RED . $n . " " . TextFormat::GOLD . $list[0] . ": " . $list[1] . $space;
        }
        //$message = substr($message, 0, -1);
        return $message;
    }
public function getTopList1() {
    $all = (new Config($this->getDataFolder() . "deaths.yml", Config::YAML))->getAll();
    arsort($all);
    $ret = [];
    $n = 1;
    $max = ceil(count($all) / 10);
    $page = min($max, max(1, 1));
    foreach ($all as $p => $m) {
        $current = ceil($n / 10);
        if ($current == $page) {
            $ret[$n] = [$p, $m];
        } elseif ($current > $page) {
            break;
        }
        ++$n;
    }
    return $ret;
}

public function sendTopList1() {
    $top = $this->getTopList1();
    $space = "\n";
    $message = TextFormat::BOLD . TextFormat::AQUA . "§l§eTop Deaths" . TextFormat::RESET . "\n \n";
    foreach ($top as $n => $list) {
        $message .= TextFormat::RED . $n . " " . TextFormat::GOLD . $list[0] . ": " . $list[1] . $space;
    }
    //$message = substr($message, 0, -1);
    return $message;
    }
    /*
        THIS CODE WAS MADE BY JACKMD I DO NOT HAVE ANYTHING TO DO WITH IT THX JACK ILY 
    */
    public function getCPS(Player $player){
        if(!isset($this->clicks[$player->getLowerCaseName()])){
            return 0;
        }
        $time = $this->clicks[$player->getLowerCaseName()][0];
        $clicks = $this->clicks[$player->getLowerCaseName()][1];
        if($time !== time()){
            unset($this->clicks[$player->getLowerCaseName()]);
            return 0;
        }
        return $clicks;
    }

    public function addCPS(Player $player) {
        if(!isset($this->clicks[$player->getLowerCaseName()])){
            $this->clicks[$player->getLowerCaseName()] = [time(), 0];
        }
        $time = $this->clicks[$player->getLowerCaseName()][0];
        $clicks = $this->clicks[$player->getLowerCaseName()][1];
        if($time !== time()){
            $time = time();
            $clicks = 0;
        }
        $clicks++;
        $this->clicks[$player->getLowerCaseName()] = [$time, $clicks];
    }
}