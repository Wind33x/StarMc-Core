<?php
namespace Taco\GPvp\kit;
use pocketmine\item\Item;
use pocketmine\Player;
use pocketmine\item\enchantment\Enchantment;
use pocketmine\item\enchantment\EnchantmentInstance;
class Kits {
	public static function spawnItems(Player $player) {
		if ($player instanceof Player) {
			$player->getInventory()->clearAll();
	    	$player->getArmorInventory()->clearAll();
			$sword = Item::get(276, 0, 1);
			$sword->setCustomName("§r§l§cFFA");
			$sword->addEnchantment(new EnchantmentInstance(Enchantment::getEnchantment(17), 10));
			$player->getInventory()->setItem(0, $sword);
		}
	}
	public static function diamondItems(Player $player) {
		if ($player instanceof Player) {
			$player->setGamemode(0);
		$player->setFood(20);
		$player->setHealth(20);
		$player->getInventory()->setSize(9);
		$player->getInventory()->clearAll();
		$player->getArmorInventory()->clearAll();
			$helmet=Item::get(310, 0, 1);
			$helmet->setCustomName("§l§bDiamond");
			$player->getArmorInventory()->setHelmet($helmet);
			$chestplate=Item::get(311, 0, 1);
			$chestplate->setCustomName("§l§bDiamond");
			$player->getArmorInventory()->setChestplate($chestplate);
			$leggings=Item::get(312, 0, 1);
			$leggings->setCustomName("§l§bDiamond");
			$player->getArmorInventory()->setLeggings($leggings);
			$boots=Item::get(313, 0, 1);
			$boots->setCustomName("§l§bDiamond");
			$player->getArmorInventory()->setBoots($boots);
			$sword=Item::get(276, 0, 1);
			$sword->setCustomName("§l§bDiamond");
		$player->getInventory()->setItem(0, $sword);
		$player->getInventory()->setItem(1, Item::get(261, 0, 1));
		$player->getInventory()->setItem(8, Item::get(262, 0, 1));
		}
	}
	public static function gappleItems(Player $player){
		if ($player instanceof Player) {
		$player->setGamemode(0);
		$player->setFood(20);
		$player->setHealth(20);
		$player->getInventory()->setSize(9);
		$player->getInventory()->clearAll();
		$player->getArmorInventory()->clearAll();
			$helmet=Item::get(310, 0, 1);
			$helmet->setCustomName("§l§aGapple");
			$helmet->addEnchantment(new EnchantmentInstance(Enchantment::getEnchantment(17), 15));
			$player->getArmorInventory()->setHelmet($helmet);
			$chestplate=Item::get(311, 0, 1);
			$chestplate->setCustomName("§l§aGapple");
			$chestplate->addEnchantment(new EnchantmentInstance(Enchantment::getEnchantment(17), 15));
			$player->getArmorInventory()->setChestplate($chestplate);
			$leggings=Item::get(312, 0, 1);
			$leggings->setCustomName("§l§aGapple");
			$leggings->addEnchantment(new EnchantmentInstance(Enchantment::getEnchantment(17), 15));
			$player->getArmorInventory()->setLeggings($leggings);
			$boots=Item::get(313, 0, 1);
			$boots->setCustomName("§l§aGapple");
			$boots->addEnchantment(new EnchantmentInstance(Enchantment::getEnchantment(17), 15));
			$player->getArmorInventory()->setBoots($boots);
			$sword=Item::get(276, 0, 1);
			$sword->setCustomName("§l§aGapple");
			$sword->addEnchantment(new EnchantmentInstance(Enchantment::getEnchantment(17), 20));
		$player->getInventory()->setItem(0, $sword);
		$player->getInventory()->setItem(1, Item::get(322, 0, 16));
		$player->getInventory()->setItem(8, Item::get(373, 6, 1));
		}
    }
    public static function noDebuffItems(Player $player) {
		$name = $player->getName();
		$player->setAllowFlight(false);
		$player->setAllowMovementCheats(false);
		$player->setGamemode(0);
		$player->setFood(20);
		$player->setHealth(20);
		$player->getInventory()->setSize(36);
		$player->getInventory()->clearAll();
		$player->getArmorInventory()->clearAll();
			$helmet = Item::get(310, 0, 1);
			$helmet->setCustomName("§r§l§cNoDebuff");
			$helmet->addEnchantment(new EnchantmentInstance(Enchantment::getEnchantment(17), 10));
			$player->getArmorInventory()->setHelmet($helmet);
			$chestplate = Item::get(311, 0, 1);
			$chestplate->setCustomName("§r§l§cNoDebuff");
			$chestplate->addEnchantment(new EnchantmentInstance(Enchantment::getEnchantment(17), 10));
			$player->getArmorInventory()->setChestplate($chestplate);
			$leggings = Item::get(312, 0, 1);
			$leggings->setCustomName("§r§l§cNoDebuff");
			$leggings->addEnchantment(new EnchantmentInstance(Enchantment::getEnchantment(17), 10));
			$player->getArmorInventory()->setLeggings($leggings);
			$boots = Item::get(313, 0, 1);
			$boots->setCustomName("§r§l§cNoDebuff");
			$boots->addEnchantment(new EnchantmentInstance(Enchantment::getEnchantment(17), 10));
			$player->getArmorInventory()->setBoots($boots);
			$sword = Item::get(276, 0, 1);
			$sword->setCustomName("§r§l§cNoDebuff");
			$sword->addEnchantment(new EnchantmentInstance(Enchantment::getEnchantment(17), 10));
		$player->getInventory()->setItem(0, $sword);
		$player->getInventory()->setItem(1, Item::get(368, 0, 16));
		$player->getInventory()->addItem(Item::get(438, 21, 34));
    }
    public static function comboItems(Player $player){
		$player->setGamemode(0);
		$player->setFood(20);
		$player->setHealth(20);
		$player->getInventory()->setSize(9);
		$player->getInventory()->clearAll();
		$player->getArmorInventory()->clearAll();
			$helmet=Item::get(306, 0, 1);
			$helmet->setCustomName("§l§6Combo");
			$helmet->addEnchantment(new EnchantmentInstance(Enchantment::getEnchantment(17), 10));
			$helmet->addEnchantment(new EnchantmentInstance(Enchantment::getEnchantment(0), 5));
			$player->getArmorInventory()->setHelmet($helmet);
			$chestplate=Item::get(307, 0, 1);
			$chestplate->setCustomName("§l§6Combo");
			$chestplate->addEnchantment(new EnchantmentInstance(Enchantment::getEnchantment(17), 10));
			$chestplate->addEnchantment(new EnchantmentInstance(Enchantment::getEnchantment(0), 5));
			$player->getArmorInventory()->setChestplate($chestplate);
			$leggings=Item::get(308, 0, 1);
			$leggings->setCustomName("§l§6Combo");
			$leggings->addEnchantment(new EnchantmentInstance(Enchantment::getEnchantment(17), 10));
			$leggings->addEnchantment(new EnchantmentInstance(Enchantment::getEnchantment(0), 5));
			$player->getArmorInventory()->setLeggings($leggings);
			$boots=Item::get(309, 0, 1);
			$boots->setCustomName("§l§6Combo");
			$boots->addEnchantment(new EnchantmentInstance(Enchantment::getEnchantment(17), 10));
			$boots->addEnchantment(new EnchantmentInstance(Enchantment::getEnchantment(0), 5));
			$player->getArmorInventory()->setBoots($boots);
		$player->getInventory()->setItem(1, $helmet);
		$player->getInventory()->setItem(2, $chestplate);
		$player->getInventory()->setItem(3, $leggings);
		$player->getInventory()->setItem(4, $boots);
		$player->getInventory()->setItem(0, Item::get(320, 0, 64));
    }
}
