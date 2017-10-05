<?php
# plugin hecho por KaitoDoDo
namespace KaitoDoDo\KIT;

use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;
use pocketmine\command\CommandSender;
use pocketmine\command\Command;
use pocketmine\utils\TextFormat as TE;
use pocketmine\utils\Config;
use pocketmine\Player;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\event\player\PlayerQuitEvent;
use pocketmine\event\player\PlayerChatEvent;
use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\event\entity\EntityDamageByEntityEvent;
use pocketmine\entity\Effect;
use pocketmine\item\Item;
use pocketmine\event\player\PlayerRespawnEvent;

class KIT extends PluginBase implements Listener {
    
    public $KB = [];
    public $gokus = [];
    public $prefix = TE::GRAY."[".TE::AQUA."Kits".TE::GRAY."]";
    private $attachments = [];
    
	public function onEnable()
	{
		$this->getLogger()->info(TE::AQUA . "KITS §aKaitoDoDo");
                $this->getServer()->getPluginManager()->registerEvents($this ,$this);
		@mkdir($this->getDataFolder());
                $config = new Config($this->getDataFolder() . "/kits.yml", Config::YAML);
                $rank = new Config($this->getDataFolder() . "/rank.yml", Config::YAML);
                $rank->save();
		$config->save();
        }
        
        public function parkourguy($player)
        {
            $rank = new Config($this->getDataFolder() . "/rank.yml", Config::YAML);
            $rank->set($player->getName(), "§f§kiiii§r §eDeveloper §f§kiiii§r");
            $rank->save();
            $player->sendMessage($this->prefix.TE::AQUA."Has ganado un rango especial");
        }

        public function onCommand(CommandSender $player, Command $cmd, $label, array $args) {
        switch($cmd->getName()){
 
        	case "ranks":
        	{
        		$player->sendMessage("§1RANGOS DISPONIBLES EN CIRCOLAND");
        		$player->sendMessage("§fVIP+,YOUTUBER,YOUTUBER+,DEVELOPER,SUB,MOD,IMPORTAL,MWP:SW /n ADMIN,CREADOR,ELITE,POLICIA COMIC SOON");
        		$player->sendMessage("§fUso: /rank <rank> <player>");

        		 }
        		 return true;


			case "rank":
				if($player->isOp())
				{
					if(!empty($args[0]))
					{
							if(!empty($args[1]))
							{
                                                        $rank = new Config($this->getDataFolder() . "/rank.yml", Config::YAML);
                                                        if($args[0]=="sub")
                                                        {
                                                                $r = "§f§kiiii§r §eSUB §f§kiiii§r ";
                                                        }
                                                        else if($args[0]=="vip+")
                                                        {
                                                                $r = "§f§kiiii§r §6VIP§a+ §f§kiiii§r ";
                                                        }
                                                        else if($args[0]=="youtuber")
                                                        {
                                                                $r = "§f§kiiii§r §fYou§cTuber §f§kiiii§r ";
                                                        }
                                                        else if($args[0]=="youtuber+")
                                                        {
                                                                $r = "§f§kiiii§r §fYou§cTuber§6+ §f§kiiii§r ";
                                                        }
                                                        else if($args[0]=="mod")
                                                        {
                                                                $r = "§f§kiiii§r §1Mod §f§kiiii§r ";
                                                        }
                                                        else if($args[0]=="admin")
                                                        {
                                                                $r = "§f§kiiii§r §4Admin §f§kiiii§r ";
                                                        }
                                                        else if($args[0]=="dev")
                                                        {
                                                                $r = "§f§kiiii§r §eDeveloper §f§kiiii§r ";
                                                        }
                                                        else if($args[0]=="creador")
                                                        {
                                                                $r = "§f§kiiii§r §6Creador §f§kiiii§r ";
                                                        }
                                                        else if($args[0]=="inmortal")
                                                        {
                                                                $r = "§f§kiiii§r §4Inmortal §f§kiiii§r ";
                                                        }
                                                        else if($args[0]=="swmwp")
                                                        {
                                                                $r = "§f§kiiii§r §4MwP:§bSw §f§kiiii§r ";
                                                        }
                                                        else if($args[0]=="elite")
                                                        {
                                                                $r = "§f§kiiii§r §7ELITE §f§kiiii§r ";
                                                        }
                                                        else if($args[0]=="builder")
                                                        {
                                                                $r = "§f§kiiii§r §7BUILDER §f§kiiii§r ";
                                                        }
                                                        else
                                                        {
                                                            goto fin;
                                                        }
                                                        $jug = $this->getServer()->getPlayer($args[1]);
                                                        if($jug!=null)
                                                        {
							$player->sendMessage($jug->getName()." obtuvo el rango de: ".$r);
                                                        $rank->set($jug->getName(), $r);
                                                        $rank->save();
                                                        $this->cleanman($jug);
                                                        }
                                                        else
                                                        {
                                                           $player->sendMessage(TE::RED."Dando rango sin estar online a ".$args[1]);
                                                           $rank->set($args[1], $r);
                                                           $rank->save();
                                                        }
                                                        fin:
							}
						}
						else
						{
							$player->sendMessage("§fUso: /rank <rank> <player>");
						}
					}
			return true;
                            
                        case "setkit":
                            if($player->isOp())
                            {
                                if(!empty($args[0]))
                                {
                                    if(!empty($args[1]))
                                    {
                                        $config = new Config($this->getDataFolder() . "/kits.yml", Config::YAML);
                                        $jug = $this->getServer()->getPlayer($args[1]);
                                        if($jug!=null)
                                        {
                                            $config->set($jug->getName(),$args[0]);
                                            $config->save();
                                            $player->sendMessage($jug->getName().TE::GREEN." recibio el kit ". $args[0]);
                                        }
                                    }
                                }
                            }
                            return true;
                            
                        case "sorteo":
                            if(!empty($args[0])&&!empty($args[1])&&($player->isOp()))
                            {
                                if(is_numeric($args[0])&&is_numeric($args[1]))
                                {
                                    $winner = mt_rand($args[0], $args[1]);
                                    $this->getServer()->broadcastMessage(TE::YELLOW."El ganador es el numero ".TE::AQUA.$winner);
                                }
                            }
                            return true;
                            
                        case "kit":
                            if(!empty($args[0]))
                            {
                            $rank = new Config($this->getDataFolder() . "/rank.yml", Config::YAML);
                            $config = new Config($this->getDataFolder() . "/kits.yml", Config::YAML);
                            $r = $rank->get($player->getName());
                            if(strpos($player->getNameTag(), "§f§kiiii§r §6VIP§a §f§kiiii§r ") !== false)
                            {
                                $config->set($player->getName(),$args[0]);
                                $config->save();
                            }
                            elseif($r=="§f§kiiii§r §eSUB §f§kiiii§r ")
                            {
                                if($args[0]=="Midas")
                                {
                                    $config->set($player->getName(),"Midas");
                                    $config->save();
                                }
                                elseif($args[0]=="Promise")
                                {
                                    $config->set($player->getName(),"Promise");
                                    $config->save();
                                }
                                elseif($args[0]=="Warrior")
                                {
                                    $config->set($player->getName(),"Warrior");
                                    $config->save();
                                }
                                elseif($args[0]=="FoodMan")
                                {
                                    $config->set($player->getName(),"FoodMan");
                                    $config->save();
                                }
                                elseif($args[0]=="Archer")
                                {
                                    $config->set($player->getName(),"Archer");
                                    $config->save();
                                }
                                else
                                {
                                    $player->sendMessage(TE::RED."Necesitas tener mas rango para usar este Kit");
                                    goto end;
                                }
                            }
                            elseif($r=="§f§kiiii§r §eDeveloper §f§kiiii§r ")
                            {
                                if($args[0]=="Midas")
                                {
                                    $config->set($player->getName(),"Midas");
                                    $config->save();
                                }
                                elseif($args[0]=="Promise")
                                {
                                    $config->set($player->getName(),"Promise");
                                    $config->save();
                                }
                                elseif($args[0]=="Warrior")
                                {
                                    $config->set($player->getName(),"Warrior");
                                    $config->save();
                                }
                                elseif($args[0]=="FoodMan")
                                {
                                    $config->set($player->getName(),"FoodMan");
                                    $config->save();
                                }
                                elseif($args[0]=="Archer")
                                {
                                    $config->set($player->getName(),"Archer");
                                    $config->save();
                                }
                                elseif($args[0]=="Parkour")
                                {
                                    $config->set($player->getName(),"Parkour");
                                    $config->save();
                                }
                                else
                                {
                                    $player->sendMessage(TE::RED."Necesitas tener mas rango para usar este Kit");
                                    goto end;
                                }
                            }
                            elseif(($r=="§f§kiiii§r §fYou§cTuber §f§kiiii§r ") || ($r=="§f§kiiii§r §1Mod §f§kiiii§r "))
                            {
                                if($args[0]=="Midas")
                                {
                                    $config->set($player->getName(),"Midas");
                                    $config->save();
                                }
                                elseif($args[0]=="Promise")
                                {
                                    $config->set($player->getName(),"Promise");
                                    $config->save();
                                }
                                elseif($args[0]=="Warrior")
                                {
                                    $config->set($player->getName(),"Warrior");
                                    $config->save();
                                }
                                elseif($args[0]=="FoodMan")
                                {
                                    $config->set($player->getName(),"FoodMan");
                                    $config->save();
                                }
                                elseif($args[0]=="Archer")
                                {
                                    $config->set($player->getName(),"Archer");
                                    $config->save();
                                }
                                elseif($args[0]=="Runner")
                                {
                                    $config->set($player->getName(),"Runner");
                                    $config->save();
                                }
                                elseif($args[0]=="Fighter")
                                {
                                    $config->set($player->getName(),"Fighter");
                                    $config->save();
                                }
                                elseif($args[0]=="Jumper")
                                {
                                    $config->set($player->getName(),"Jumper");
                                    $config->save();
                                }
                                else
                                {
                                    $player->sendMessage(TE::RED."Necesitas tener mas rango para usar este Kit");
                                    goto end;
                                }
                            }
                            elseif($r=="§f§kiiii§r §6VIP§a+ §f§kiiii§r ")
                            {
                                $config->set($player->getName(),$args[0]);
                                $config->save();
                            }
                            elseif($r=="§f§kiiii§r §fYou§cTuber §f§kiiii§r ")
                            {
                                $config->set($player->getName(),$args[0]);
                                $config->save();
                            }
                            elseif($r=="§f§kiiii§r §4Admin §f§kiiii§r ")
                            {
                                $config->set($player->getName(),$args[0]);
                                $config->save();
                            }
                            elseif($r=="§f§kiiii§r §6Creador §f§kiiii§r ")
                            {
                                $config->set($player->getName(),$args[0]);
                                $config->save();
                            }
                            elseif($r=="§f§kiiii§r §4Inmortal §f§kiiii§r ")
                            {
                                $config->set($player->getName(),$args[0]);
                                $config->save();
                            }
                            elseif($r=="§f§kiiii§r §4MwP:§bSw §f§kiiii§r ")
                            {
                                $config->set($player->getName(),$args[0]);
                                $config->save();
                            }
                            elseif($r=="§f§kiiii§r §7BUILDER §f§kiiii§r ")
                            {
                                $config->set($player->getName(),$args[0]);
                                $config->save();
                            }
                            else
                            {
                                $player->sendMessage(TE::RED."Necesitas tener rango para usar este Kit".TE::RESET);
                                $player->sendMessage(TE::AQUA."Contacta con el Administrador".TE::RESET);
                                goto end;
                            }
                            $player->sendMessage($this->prefix."§aObtuviste el kit: §e".$args[0]);
                            end:
                            }
                            return true;
        }
        }
        
        public function getkit($p)
        {
            $config = new Config($this->getDataFolder() . "/kits.yml", Config::YAML);
            $r = rand(1,30);
            switch($r){
                case 1:
                    $p->sendMessage(TE::GREEN."Has obtenido el Kit ".TE::YELLOW."Runner".TE::GREEN." para esta sesión!");
                    $config->set($p->getName(),"Runner");
                    $config->save();
                    break;
                case 2:
                    $p->sendMessage(TE::GREEN."Has obtenido el Kit ".TE::YELLOW."Fighter".TE::GREEN." para esta sesión!");
                    $config->set($p->getName(),"Fighter");
                    $config->save();
                    break;
                case 3:
                    $p->sendMessage(TE::GREEN."Has obtenido el Kit ".TE::YELLOW."Jumper".TE::GREEN." para esta sesión!");
                    $config->set($p->getName(),"Jumper");
                    $config->save();
                    break;
                case 4:
                    $p->sendMessage(TE::GREEN."Has obtenido el Kit ".TE::YELLOW."Midas".TE::GREEN." para esta sesión!");
                    $config->set($p->getName(),"Midas");
                    $config->save();
                    break;
                case 5:
                    $p->sendMessage(TE::GREEN."Has obtenido el Kit ".TE::YELLOW."Promise".TE::GREEN." para esta sesión!");
                    $config->set($p->getName(),"Promise");
                    $config->save();
                    break;
                case 6:
                    $p->sendMessage(TE::GREEN."Has obtenido el Kit ".TE::YELLOW."FakeVIP+".TE::GREEN." para esta sesión!");
                    $config->set($p->getName(),"FakeVIP+");
                    $config->save();
                    break;
                case 7:
                    $p->sendMessage(TE::GREEN."Has obtenido el Kit ".TE::YELLOW."Warrior".TE::GREEN." para esta sesión!");
                    $config->set($p->getName(),"Warrior");
                    $config->save();
                    break;
                case 8:
                    $p->sendMessage(TE::GREEN."Has obtenido el Kit ".TE::YELLOW."Begginer".TE::GREEN." para esta sesión!");
                    $config->set($p->getName(),"Begginer");
                    $config->save();
                    break;
                case 9:
                    $p->sendMessage(TE::GREEN."Has obtenido el Kit ".TE::YELLOW."Archer".TE::GREEN." para esta sesión!");
                    $config->set($p->getName(),"Archer");
                    $config->save();
                    break;
                case 10:
                    $p->sendMessage(TE::GREEN."Has obtenido el Kit ".TE::YELLOW."KnockBacker".TE::GREEN." para esta sesión!");
                    $config->set($p->getName(),"KnockBacker");
                    $config->save();
                    break;
                case 11:
                    $p->sendMessage(TE::GREEN."Has obtenido el Kit ".TE::YELLOW."Alchemist".TE::GREEN." para esta sesión!");
                    $config->set($p->getName(),"Alchemist");
                    $config->save();
                    break;
                case 12:
                    $p->sendMessage(TE::GREEN."Has obtenido el Kit ".TE::YELLOW."FoodMan".TE::GREEN." para esta sesión!");
                    $config->set($p->getName(),"FoodMan");
                    $config->save();
                    break;
                case 13:
                    $p->sendMessage(TE::GREEN."Has obtenido el Kit ".TE::YELLOW."SasukeUchiha".TE::GREEN." para esta sesión!");
                    $config->set($p->getName(),"SasukeUchiha");
                    $config->save();
                    break;
                case 14:
                    $p->sendMessage(TE::GREEN."Has obtenido el Kit ".TE::YELLOW."NarutoKyubi".TE::GREEN." para esta sesión!");
                    $config->set($p->getName(),"NarutoKyubi");
                    $config->save();
                    break;
                case 15:
                    $p->sendMessage(TE::GREEN."Has obtenido el Kit ".TE::YELLOW."IronMan".TE::GREEN." para esta sesión!");
                    $config->set($p->getName(),"IronMan");
                    $config->save();
                    break;
                case 16:
                    $p->sendMessage(TE::GREEN."Has obtenido el Kit ".TE::YELLOW."Midas".TE::GREEN." para esta sesión!");
                    $config->set($p->getName(),"Midas");
                    $config->save();
                    break;
                case 17:
                    $p->sendMessage(TE::GREEN."Has obtenido el Kit ".TE::YELLOW."Promise".TE::GREEN." para esta sesión!");
                    $config->set($p->getName(),"Promise");
                    $config->save();
                    break;
                case 18:
                    $p->sendMessage(TE::GREEN."Has obtenido el Kit ".TE::YELLOW."Warrior".TE::GREEN." para esta sesión!");
                    $config->set($p->getName(),"Warrior");
                    $config->save();
                    break;
                case 19:
                    $p->sendMessage(TE::GREEN."Has obtenido el Kit ".TE::YELLOW."Begginer".TE::GREEN." para esta sesión!");
                    $config->set($p->getName(),"Begginer");
                    $config->save();
                    break;
                case 20:
                    $p->sendMessage(TE::GREEN."Has obtenido el Kit ".TE::YELLOW."Archer".TE::GREEN." para esta sesión!");
                    $config->set($p->getName(),"Archer");
                    $config->save();
                    break;
                case 21:
                    $p->sendMessage(TE::GREEN."Has obtenido el Kit ".TE::YELLOW."Alchemist".TE::GREEN." para esta sesión!");
                    $config->set($p->getName(),"Alchemist");
                    $config->save();
                    break;
                case 22:
                    $p->sendMessage(TE::GREEN."Has obtenido el Kit ".TE::YELLOW."FoodMan".TE::GREEN." para esta sesión!");
                    $config->set($p->getName(),"FoodMan");
                    $config->save();
                    break;
                case 23:
                    $p->sendMessage(TE::GREEN."Has obtenido el Kit ".TE::YELLOW."IronMan".TE::GREEN." para esta sesión!");
                    $config->set($p->getName(),"IronMan");
                    $config->save();
                    break;
                case 24:
                    $p->sendMessage(TE::GREEN."Has obtenido el Kit ".TE::YELLOW."Midas".TE::GREEN." para esta sesión!");
                    $config->set($p->getName(),"Midas");
                    $config->save();
                    break;
                case 25:
                    $p->sendMessage(TE::GREEN."Has obtenido el Kit ".TE::YELLOW."Promise".TE::GREEN." para esta sesión!");
                    $config->set($p->getName(),"Promise");
                    $config->save();
                    break;
                case 26:
                    $p->sendMessage(TE::GREEN."Has obtenido el Kit ".TE::YELLOW."Warrior".TE::GREEN." para esta sesión!");
                    $config->set($p->getName(),"Warrior");
                    $config->save();
                    break;
                case 27:
                    $p->sendMessage(TE::GREEN."Has obtenido el Kit ".TE::YELLOW."Begginer".TE::GREEN." para esta sesión!");
                    $config->set($p->getName(),"Begginer");
                    $config->save();
                    break;
                case 28:
                    $p->sendMessage(TE::GREEN."Has obtenido el Kit ".TE::YELLOW."Archer".TE::GREEN." para esta sesión!");
                    $config->set($p->getName(),"Archer");
                    $config->save();
                    break;
                case 29:
                    $p->sendMessage(TE::GREEN."Has obtenido el Kit ".TE::YELLOW."Alchemist".TE::GREEN." para esta sesión!");
                    $config->set($p->getName(),"Alchemist");
                    $config->save();
                    break;
                case 30:
                    $p->sendMessage(TE::GREEN."Has obtenido el Kit ".TE::YELLOW."FoodMan".TE::GREEN." para esta sesión!");
                    $config->set($p->getName(),"FoodMan");
                    $config->save();
                    break;
            }
        }
        
        public function setrank($p)
        {
            $rank = new Config($this->getDataFolder() . "/rank.yml", Config::YAML);
            $r = $rank->get($p->getName());
            if($r == "§f§kiiii§r §eSUB §f§kiiii§r ")
            {
                $p->setNameTag($p->getNameTag()."§f§kiiii§r §eSUB §f§kiiii§r ");
            }
            elseif($r == "§f§kiiii§r §6VIP§a+ §f§kiiii§r ")
            {
                $p->setNameTag($p->getNameTag()."§f§kiiii§r §6VIP§a+ §f§kiiii§r ");
            }
            elseif($r == "§f§kiiii§r §fYou§cTuber §f§kiiii§r")
            {
                $p->setNameTag($p->getNameTag()."§f§kiiii§r §fYou§cTuber §f§kiiii§r");
            }
            elseif($r == "§f§kiiii§r §fYou§cTuber§6+ §f§kiiii§r")
            {
                $p->setNameTag($p->getNameTag()."§f§kiiii§r §fYou§cTuber§6+ §f§kiiii§r");
            }
            elseif($r == "§f§kiiii§r §4Admin §f§kiiii§r ")
            {
                $p->setNameTag($p->getNameTag()."§f§kiiii§r §4Admin §f§kiiii§r ");
            }
            elseif($r == "§f§kiiii§r §1Mod §f§kiiii§r ")
            {
                $p->setNameTag($p->getNameTag()."§f§kiiii§r §1Mod §f§kiiii§r ");
            }
            elseif($r == "§f§kiiii§r §eDeveloper §f§kiiii§r")
            
            {
                $p->setNameTag($p->getNameTag()."§f§kiiii§r §eDeveloper §f§kiiii§r ");
            }
            elseif($r == "§f§kiiii§r §4Inmortal §f§kiiii§r")
            
            {
                $p->setNameTag($p->getNameTag()."§f§kiiii§r §4Imortal §f§kiiii§r ");
            }
            elseif($r == "§f§kiiii§r §4MwP:§bSw §f§kiiii§r ")
            
            {
                $p->setNameTag($p->getNameTag()."§f§kiiii§r §4MwP:§bSw §f§kiiii§r ");
            }
            elseif($r == "§f§kiiii§r §7BUILDER §f§kiiii§r ")
            
            {
                $p->setNameTag($p->getNameTag()."§f§kiiii§r §7BUILDER §f§kiiii§r ");
            }
            unset($r, $rank);
        }

        public function setkit($p)
        {
            $config = new Config($this->getDataFolder() . "/kits.yml", Config::YAML);
            $kit = $config->get($p->getName());
            if(isset($this->KB[$p->getName()])){
                unset ($this->KB[$p->getName()]);
            }
            if($kit=="Runner")
            {
                $speed = Effect::getEffect(1);
                    $speed->setAmplifier(2);
                    $speed->setVisible(true);
                    $speed->setDuration(1000000);
                    $p->addEffect($speed);
            }
            elseif($kit=="Fighter"){
                $fuerza = Effect::getEffect(5);
                    $fuerza->setAmplifier(1.2);
                    $fuerza->setVisible(true);
                    $fuerza->setDuration(1000000);
                    $p->addEffect($fuerza);
            }
            elseif($kit=="Jumper")
            {
                $salto = Effect::getEffect(8);
                    $salto->setAmplifier(3);
                    $salto->setVisible(true);
                    $salto->setDuration(1000000);
                    $p->addEffect($salto);
            }
            elseif($kit=="Midas")
            {
                    $p->getInventory()->setHelmet(Item::get(Item::GOLD_HELMET));
                    $p->getInventory()->setChestplate(Item::get(Item::GOLD_CHESTPLATE));
                    $p->getInventory()->setLeggings(Item::get(Item::GOLD_LEGGINGS));
                    $p->getInventory()->setBoots(Item::get(Item::GOLD_BOOTS));
                    $p->getInventory()->setItem(0, Item::get(Item::GOLD_AXE, 0, 1));
                    $p->getInventory()->sendArmorContents($p);
                    $p->getInventory()->setHotbarSlotIndex(0, 0);
            }
            elseif($kit=="Promise")
            {
                    $p->getInventory()->setHelmet(Item::get(Item::IRON_HELMET));
                    $p->getInventory()->setBoots(Item::get(Item::IRON_BOOTS));
                    $p->getInventory()->setItem(0, Item::get(Item::IRON_PICKAXE, 0, 1));
                    $p->getInventory()->sendArmorContents($p);
                    $p->getInventory()->setHotbarSlotIndex(0, 0);
            }
            elseif($kit=="FakeVIP+")
            {
                    $p->getInventory()->setHelmet(Item::get(Item::CHAIN_HELMET));
                    $p->getInventory()->setChestplate(Item::get(Item::CHAIN_CHESTPLATE));
                    $p->getInventory()->setLeggings(Item::get(Item::CHAIN_LEGGINGS));
                    $p->getInventory()->setBoots(Item::get(Item::CHAIN_BOOTS));
                    $p->getInventory()->setItem(0, Item::get(Item::DIAMOND_AXE, 0, 1));
                    $p->getInventory()->sendArmorContents($p);
                    $p->getInventory()->setHotbarSlotIndex(0, 0);
            }
            elseif($kit=="Warrior")
            {
                    $p->getInventory()->setChestplate(Item::get(Item::CHAIN_CHESTPLATE));
                    $p->getInventory()->setLeggings(Item::get(Item::CHAIN_LEGGINGS));
                    $p->getInventory()->setItem(0, Item::get(Item::IRON_AXE, 0, 1));
                    $p->getInventory()->sendArmorContents($p);
                    $p->getInventory()->setHotbarSlotIndex(0, 0);
            }
            elseif($kit=="Begginer")
            {
                    $p->getInventory()->setHelmet(Item::get(Item::GOLD_HELMET));
                    $p->getInventory()->setChestplate(Item::get(Item::GOLD_CHESTPLATE));
                    $p->getInventory()->setLeggings(Item::get(Item::LEATHER_PANTS));
                    $p->getInventory()->setBoots(Item::get(Item::LEATHER_BOOTS));
                    $p->getInventory()->setItem(0, Item::get(Item::IRON_AXE, 0, 1));
                    $p->getInventory()->sendArmorContents($p);
                    $p->getInventory()->setHotbarSlotIndex(0, 0);
            }
            elseif($kit=="Archer")
            {
                    $p->getInventory()->setItem(0, Item::get(Item::BOW, 0, 1));
                    $p->getInventory()->addItem(Item::get(262,0,20));
                    $p->getInventory()->setHotbarSlotIndex(0, 0);
            }
            elseif($kit=="Parkour")
            {
                    $salto = Effect::getEffect(8);
                    $salto->setAmplifier(4);
                    $salto->setVisible(true);
                    $salto->setDuration(1000000);
                    $p->addEffect($salto);
                    $p->getInventory()->setItem(0, Item::get(Item::DIAMOND_PICKAXE, 0, 1));
                    $p->getInventory()->setHotbarSlotIndex(0, 0);
            }
            elseif($kit=="RobinHood")
            {
                    $p->getInventory()->setItem(0, Item::get(Item::BOW, 0, 1));
                    $p->getInventory()->addItem(Item::get(262,0,30));
                    $p->getInventory()->addItem(Item::get(283,0,1));
                    $p->getInventory()->setHotbarSlotIndex(0, 0);
                    $p->getInventory()->setHelmet(Item::get(Item::DIAMOND_HELMET));
                    $p->getInventory()->setChestplate(Item::get(Item::GOLD_CHESTPLATE));
                    $p->getInventory()->setLeggings(Item::get(Item::CHAIN_LEGGINGS));
                    $p->getInventory()->setBoots(Item::get(Item::IRON_BOOTS));
                    $p->getInventory()->sendArmorContents($p);
            }
            elseif($kit=="KnockBacker")
            {
                $this->KB[$p->getName()] = $p;
            }
            elseif($kit=="Alchemist")
            {
                    $p->getInventory()->addItem(Item::get(373,9,1));
                    $p->getInventory()->addItem(Item::get(373,12,1));
                    $p->getInventory()->addItem(Item::get(373,14,1));
                    $p->getInventory()->addItem(Item::get(373,16,1));
                    $p->getInventory()->addItem(Item::get(373,21,1));
            }
            elseif($kit=="FoodMan")
            {
                    $p->getInventory()->addItem(Item::get(354,0,1));
                    $p->getInventory()->addItem(Item::get(364,0,3));
                    $p->getInventory()->addItem(Item::get(320,0,3));
                    $p->getInventory()->addItem(Item::get(297,0,3));
            }
            elseif($kit=="SasukeUchiha")
            {
                    $p->getInventory()->setItem(0, Item::get(Item::IRON_SWORD, 0, 1));
                    $p->getInventory()->setChestplate(Item::get(Item::IRON_CHESTPLATE));
                    $p->getInventory()->setHotbarSlotIndex(0, 0);
                    $p->getInventory()->sendArmorContents($p);
            }
            elseif($kit=="NarutoKyubi")
            {
                $speed = Effect::getEffect(1);
                    $jump = Effect::getEffect(8);
                    $speed->setVisible(true);
                    $jump->setVisible(true);
                    $jump->setAmplifier(2);
                    $speed->setAmplifier(2);
                    $speed->setDuration(1000000);
                    $jump->setDuration(1000000);
                    $p->addEffect($speed);
                    $p->addEffect($jump);
            }
            elseif($kit=="IronMan")
            {
                    $p->getInventory()->setHelmet(Item::get(Item::IRON_HELMET));
                    $p->getInventory()->setChestplate(Item::get(Item::IRON_CHESTPLATE));
                    $p->getInventory()->setLeggings(Item::get(Item::IRON_LEGGINGS));
                    $p->getInventory()->setBoots(Item::get(Item::IRON_BOOTS));
                    $p->getInventory()->sendArmorContents($p);
            }
            elseif($kit=="Legend")
            {
                    $p->getInventory()->setHelmet(Item::get(Item::IRON_HELMET));
                    $p->getInventory()->setChestplate(Item::get(Item::IRON_CHESTPLATE));
                    $p->getInventory()->setLeggings(Item::get(Item::IRON_LEGGINGS));
                    $p->getInventory()->setBoots(Item::get(Item::IRON_BOOTS));
                    $p->getInventory()->setItem(0, Item::get(Item::DIAMOND_AXE, 0, 1));
                    $p->getInventory()->sendArmorContents($p);
                    $p->getInventory()->setHotbarSlotIndex(0, 0);
                    $this->KB[$p->getName()] = $p;
            }
            elseif($kit=="Vip")
            {
                    $p->getInventory()->setHelmet(Item::get(Item::CHAIN_HELMET));
                    $p->getInventory()->setChestplate(Item::get(Item::CHAIN_CHESTPLATE));
                    $p->getInventory()->setLeggings(Item::get(Item::CHAIN_LEGGINGS));
                    $p->getInventory()->setBoots(Item::get(Item::CHAIN_BOOTS));
                    $p->getInventory()->setItem(0, Item::get(Item::DIAMOND_SWORD, 0, 1));
                    $p->getInventory()->sendArmorContents($p);
                    $p->getInventory()->setHotbarSlotIndex(0, 0);
                    $this->KB[$p->getName()] = $p;
            }
            elseif($kit=="Diamond")
            {
                    $p->getInventory()->setHelmet(Item::get(Item::DIAMOND_HELMET));
                    $p->getInventory()->setChestplate(Item::get(Item::DIAMOND_CHESTPLATE));
                    $p->getInventory()->setLeggings(Item::get(Item::DIAMOND_LEGGINGS));
                    $p->getInventory()->setBoots(Item::get(Item::DIAMOND_BOOTS));
                    $p->getInventory()->sendArmorContents($p);
                    $this->KB[$p->getName()] = $p;
            }
            elseif($kit=="Goku")
            {
                $this->gokus[$p->getName()] = $p;
                $p->setAllowFlight(true);
            }
            unset($config, $kit);
        }

        public function  onJoin(PlayerJoinEvent $event)
        {
            $player = $event->getPlayer();
            $player->getInventory()->clearAll();
            $player->removeAllEffects();
            $rank = new Config($this->getDataFolder() . "/rank.yml", Config::YAML);
            $r = $rank->get($player->getName());
            if($r == "§f§kiiii§r §eSUB §f§kiiii§r ")
            {
                $event->setJoinMessage("");
                $player->setNameTag($r."§a".$player->getName());
                $player->setDisplayName($r."§a".$player->getName());
                $player->sendMessage(TE::DARK_PURPLE."Puedes elegir los siguientes kits: ".TE::YELLOW."Warrior, Midas, FoodMan, Promise, Archer");
            }
            elseif($r == "§f§kiiii§r §6VIP§a+ §f§kiiii§r ")
            {
                $player->setNameTag($r."§b".$player->getName());
                $player->setDisplayName($r."§b".$player->getName());
                $event->setJoinMessage($player->getNameTag().TE::GREEN." ha entrado al juego");
                $player->sendMessage(TE::DARK_PURPLE."Puedes elegir el Kit que mas te guste");
                $attachment = $this->getAttachment($player);
                $attachment->setPermission("pocketmine.command.say", true);
                $attachment->setPermission("select.hero", true);
                $attachment->setPermission("ctf.team.select", true);
                $attachment->setPermission("select.beast", true);
                $attachment->setPermission("vip.lw.access", true);
            }
            elseif($r == "§f§kiiii§r §eDeveloper §f§kiiii§r ")
            {
                $event->setJoinMessage("");
                $player->setNameTag($r."§e".$player->getName());
                $player->setDisplayName($r."§e".$player->getName());
                $player->sendMessage(TE::DARK_PURPLE."Puedes elegir los siguientes kits: ".TE::YELLOW."Warrior, Midas, FoodMan, Promise, Archer, Parkour");
            }
            elseif($r == "§f§kiiii§r §fYou§cTuber §f§kiiii§r ")
            {
                $event->setJoinMessage("");
                $player->setNameTag($r."§a".$player->getName());
                $player->setDisplayName($r."§a".$player->getName());
                $player->sendMessage(TE::DARK_PURPLE."Puedes elegir los siguientes kits: ".TE::YELLOW."Warrior, Midas, FoodMan, Promise, Archer, Runner, Fighter, Jumper");
            }
            elseif($r == "§f§kiiii§r §fYou§cTuber§6+ §f§kiiii§r ")
            {
                $player->setNameTag($r."§b".$player->getName());
                $player->setDisplayName($r."§b".$player->getName());
                $event->setJoinMessage($player->getNameTag().TE::GREEN." ha entrado al juego");
                $player->sendMessage(TE::DARK_PURPLE."Puedes elegir el Kit que mas te guste");
                $attachment = $this->getAttachment($player);
                $attachment->setPermission("pocketmine.command.say", true);
                $attachment->setPermission("select.hero", true);
                $attachment->setPermission("ctf.team.select", true);
                $attachment->setPermission("select.beast", true);
            }
            elseif($r == "§f§kiiii§r §4Admin §f§kiiii§r ")
            {
                $event->setJoinMessage(TE::RED."§f§kiiii§r §4Admin §f§kiiii§r ".TE::AQUA.$player->getName().TE::RED." ha entrado al juego");
                $player->setNameTag($r."§b".$player->getName());
                $player->setDisplayName($r."§b".$player->getName());
                $player->sendMessage(TE::DARK_PURPLE."Puedes elegir el Kit que mas te guste");
                $attachment = $this->getAttachment($player);
                $attachment->setPermission("pocketmine.command.say", true);
                $attachment->setPermission("pocketmine.command.gamemode", true);
                $attachment->setPermission("pocketmine.command.ban.ip", true);
                $attachment->setPermission("pocketmine.command.unban.ip", true);
                $attachment->setPermission("pocketmine.command.ban.player", true);
                $attachment->setPermission("pocketmine.command.kick", true);
                $attachment->setPermission("pocketmine.command.teleport", true);
                $attachment->setPermission("break.lobby", true);
                $attachment->setPermission("mw.cmd.tp", true);
                $attachment->setPermission("iprotector.access", true);
                $attachment->setPermission("select.hero", true);
                $attachment->setPermission("ctf.team.select", true);
                $attachment->setPermission("select.beast", true);
                $attachment->setPermission("vip.lw.access", true);
            }
            elseif($r == "§f§kiiii§r §1Mod §f§kiiii§r")
            {
                $event->setJoinMessage(TE::RED."§f§kiiii§r §1Mod §f§kiiii§r ".TE::AQUA.$player->getName().TE::RED." ha entrado al juego");
                $player->setNameTag($r."§3".$player->getName());
                $player->setDisplayName($r."§3".$player->getName());
                $player->sendMessage(TE::DARK_PURPLE."Puedes elegir algunos kits");
                $attachment = $this->getAttachment($player);
                $attachment->setPermission("pocketmine.command.say", true);
                $attachment->setPermission("pocketmine.command.gamemode", true);
                $attachment->setPermission("pocketmine.command.kick", true);
                $attachment->setPermission("pocketmine.command.ban.ip", true);
                $attachment->setPermission("pocketmine.command.ban.player", true);
                $attachment->setPermission("pocketmine.command.teleport", true);
                $attachment->setPermission("break.lobby", true);
                $attachment->setPermission("iprotector.access", true);
                $attachment->setPermission("mw.cmd.tp", true);
                $attachment->setPermission("select.hero", true);
                $attachment->setPermission("ctf.team.select", true);
                $attachment->setPermission("select.beast", true);
                $attachment->setPermission("vip.lw.access", true);
            }
            elseif($r == "§f§kiiii§r §4Inmortal §f§kiiii§r ")
            {
                $event->setJoinMessage(TE::RED."§f§kiiii§r §4Inmortal §f§kiiii§r ".TE::AQUA.$player->getName().TE::RED." ha entrado al juego");
                $player->setNameTag($r."§3".$player->getName());
                $player->setDisplayName($r."§3".$player->getName());
                $player->sendMessage(TE::DARK_PURPLE."Puedes elegir algunos kits");
                $attachment = $this->getAttachment($player);
                $attachment->setPermission("pocketmine.command.say", true);
                $attachment->setPermission("pocketmine.command.gamemode", true);
                $attachment->setPermission("pocketmine.command.kick", true);
                $attachment->setPermission("pocketmine.command.ban.ip", true);
                $attachment->setPermission("pocketmine.command.ban.player", true);
                $attachment->setPermission("pocketmine.command.teleport", true);
                $attachment->setPermission("break.lobby", true);
                $attachment->setPermission("iprotector.access", true);
                $attachment->setPermission("mw.cmd.tp", true);
                $attachment->setPermission("select.hero", true);
                $attachment->setPermission("ctf.team.select", true);
                $attachment->setPermission("select.beast", true);
                $attachment->setPermission("vip.lw.access", true);
            }
            elseif($r == "§f§kiiii§r §7BUILDER §f§kiiii§r ")
            {
                $event->setJoinMessage(TE::RED."§f§kiiii§r §7BUILDER §f§kiiii§r  ".TE::AQUA.$player->getName().TE::RED." ha entrado al juego");
                $player->setNameTag($r."§3".$player->getName());
                $player->setDisplayName($r."§3".$player->getName());
                $player->sendMessage(TE::DARK_PURPLE."Puedes elegir algunos kits");
                $attachment = $this->getAttachment($player);
                $attachment->setPermission("pocketmine.command.say", true);
                $attachment->setPermission("pocketmine.command.gamemode", true);
                $attachment->setPermission("pocketmine.command.kick", true);
                $attachment->setPermission("pocketmine.command.ban.ip", true);
                $attachment->setPermission("pocketmine.command.ban.player", true);
                $attachment->setPermission("pocketmine.command.teleport", true);
                $attachment->setPermission("break.lobby", true);
                $attachment->setPermission("iprotector.access", true);
                $attachment->setPermission("mw.cmd.tp", true);
                $attachment->setPermission("select.hero", true);
                $attachment->setPermission("ctf.team.select", true);
                $attachment->setPermission("select.beast", true);
                $attachment->setPermission("vip.lw.access", true);
            }
            elseif($r == "§f§kiiii§r §6Creador §f§kiiii§r ")
            {
                $event->setJoinMessage(TE::RED."§f§kiiii§r §6Creador §f§kiiii§r  ".TE::AQUA.$player->getName().TE::RED." ha entrado al juego");
                $player->setNameTag($r."§c".$player->getName());
                $player->setDisplayName($r."§c".$player->getName());
                $player->sendMessage(TE::DARK_PURPLE."Puedes elegir el Kit que mas te guste");
                $player->sendMessage(TE::RED."RANKS USA /RANKS");
                $this->getServer()->broadcastMessage(TE::YELLOW."El Owner Entro a CIRCOLAND");
                $sender->addTitle("Bienvenido");
                $this->getServer()->broadcastMessage(TE::YELLOW."El ganador es el numero ".TE::AQUA.$winner);
            }
            else
            {
                $event->setJoinMessage("");
            }
            unset($rank, $r);
            $this->getkit($player);
        }
        
        public function getAttachment(Player $player)
	{
            if(!isset($this->attachments[$player->getName()]))
            {
                    $this->attachments[$player->getName()] = $player->addAttachment($this);
            }
            return $this->attachments[$player->getName()];
	}
        
        public function onDamage(EntityDamageEvent $event){
        if($event instanceof EntityDamageByEntityEvent){
        if($event->getEntity() instanceof Player && $event->getDamager() instanceof Player){
            $damager = $event->getDamager();
            if(isset($this->KB[$damager->getName()])){
            $event->setKnockBack($event->getKnockback() * 1.5);
            }
            if(isset($this->gokus[$damager->getName()])){
            $damager->setAllowFlight(false);
            }
        }
        }
        }
        
        public function onQuit(PlayerQuitEvent $event)
        {
            $player = $event->getPlayer();
            $player->setNameTag($player->getName());
            $event->setQuitMessage("");
            $this->cleanman($player);
            $rank = new Config($this->getDataFolder() . "/rank.yml", Config::YAML);
            $r = $rank->get($player->getName());
            if($r == "§f§kiiii§r §6VIP§a+ §f§kiiii§r ")
            {
                unset($this->attachments[$player->getName()]);
            }
            elseif($r == "§f§kiiii§r §fYou§cTuber§6+ §f§kiiii§r ")
            {
                unset($this->attachments[$player->getName()]);
            }
            elseif($r == "§f§kiiii§r §4Admin §f§kiiii§r ")
            {
                unset($this->attachments[$player->getName()]);
            }
            elseif($r == "§f§kiiii§r §1Mod §f§kiiii§r ")
            {
                unset($this->attachments[$player->getName()]);
            }
            elseif($r == "§f§kiiii§r §4Inmortal §f§kiiii§r ")
            {
                unset($this->attachments[$player->getName()]);
            }
            elseif($r == "§f§kiiii§r §4MwP:§bSw §f§kiiii§r ")
            {
                unset($this->attachments[$player->getName()]);
            }
            elseif($r == "§f§kiiii§r §7BUILDER §f§kiiii§r ")
            {
                unset($this->attachments[$player->getName()]);
            }
        }
        
        public function onChat(PlayerChatEvent $event)
        {
            $player = $event->getPlayer();
            $message = $event->getMessage();
            $rank = new Config($this->getDataFolder() . "/rank.yml", Config::YAML);
            if($rank->get($player->getName()) != null)
		{
			$r = $rank->get($player->getName());
                        if(($r=="§f§kiiii§r §eSUB §f§kiiii§r ")||($r=="§f§kiiii§r §fYou§cTuber §f§kiiii§r "))
                        {
                        $event->setFormat($r ."§a". $player->getName() . "§6: §e" . $message);
                        }
                        elseif(($r=="§f§kiiii§r §6VIP§a+ §f§kiiii§r ")||($r=="§f§kiiii§r §fYou§cTuber§6+ §f§kiiii§r "))
                        {
                        $event->setFormat($r ."§b". $player->getName() . "§6: §b" . $message);
                        }
                        elseif($r=="§f§kiiii§r §4Admin §f§kiiii§r ")
                        {
                        $event->setFormat($r ."§b". $player->getName() . "§b: §6" . $message);
                        }
                        elseif($r=="§f§kiiii§r §1Mod §f§kiiii§r ")
                        {
                        $event->setFormat($r ."§3". $player->getName() . "§b: §6" . $message);
                        }
                        elseif($r == "§f§kiiii§r §eDeveloper §f§kiiii§r ")
                        {
                        $event->setFormat($r ."§e". $player->getName() . "§6: §d" . $message);
                        }
                        elseif($r == "§f§kiiii§r §6Creador §f§kiiii§r ")
                        {
                        $event->setFormat($r ."§c". $player->getName() . "§6: §l§c" . $message);
                        }
                        elseif($r == "§f§kiiii§r §4Inmortal §f§kiiii§r ")
                        {
                        $event->setFormat($r ."§c". $player->getName() . "§6: §l§c" . $message);
                        }
                        elseif($r == "§f§kiiii§r §4MwP:§bSW §f§kiiii§r ")
                        {
                        $event->setFormat($r ."§c". $player->getName() . "§6: §l§c" . $message);
                        }
                        elseif($r == "§f§kiiii§r §7BUILDER §f§kiiii§r ")
                        {
                        $event->setFormat($r ."§c". $player->getName() . "§1: §r§f" . $message);
		}
        }
        }
        
        public function getranks($pn){
                $rank = new Config($this->getDataFolder() . "/rank.yml", Config::YAML);
                if ($pn instanceof Player)
                {
		$r = "";
                if($rank->get($pn->getName()) != null)
		{
			$r = $rank->get($pn->getName());
		}
                }
		if ($r) return $r;
        }
        
        public function getVar(Player $player, array &$vars)
        {
                $vars["{rank}"] = $this->getranks($player);
        }
        
        public function enResp(PlayerRespawnEvent $event)
        {
            $player = $event->getPlayer();
            $this->cleanman($player);
        }

        public function cleanman($player) {
            if(isset($this->KB[$player->getName()])){
                unset ($this->KB[$player->getName()]);
            }
            if(isset($this->gokus[$player->getName()])){
            $player->setAllowFlight(false);
            unset ($this->gokus[$player->getName()]);
            }
            $rank = new Config($this->getDataFolder() . "/rank.yml", Config::YAML);
            $r = $rank->get($player->getName());
            if($r == "§f§kiiii§r §eSUB §f§kiiii§r ")
            {
                $player->setNameTag($r."§a".$player->getName());
                $player->setDisplayName($r."§a".$player->getName());
            }
            elseif($r == "§f§kiiii§r §6VIP§a+ §f§kiiii§r ")
            {
                $player->setNameTag($r."§b".$player->getName());
                $player->setDisplayName($r."§b".$player->getName());
            }
            elseif($r == "§f§kiiii§r §fYou§cTuber §f§kiiii§r ")
            {
                $player->setNameTag($r."§a".$player->getName());
                $player->setDisplayName($r."§a".$player->getName());
            }
            elseif($r == "§f§kiiii§r §fYou§cTuber§6+ §f§kiiii§r ")
            {
                $player->setNameTag($r."§b".$player->getName());
                $player->setDisplayName($r."§b".$player->getName());
            }
            elseif($r == "§f§kiiii§r §4Admin §f§kiiii§r ")
            {
                $player->setNameTag($r."§b".$player->getName());
                $player->setDisplayName($r."§b".$player->getName());
            }
            elseif($r == "§f§kiiii§r §1Mod §f§kiiii§r ")
            {
                $player->setNameTag($r."§3".$player->getName());
                $player->setDisplayName($r."§3".$player->getName());
            }
            elseif($r == "§f§kiiii§r §eDeveloper §f§kiiii§r ")
            {
                $player->setNameTag($r."§e".$player->getName());
                $player->setDisplayName($r."§e".$player->getName());
            }
            elseif($r == "§f§kiiii§r §6Creador §f§kiiii§r ")
            {
                $player->setNameTag($r."§c".$player->getName());
                $player->setDisplayName($r."§c".$player->getName());
            }
            elseif($r == "§f§kiiii§r §4Inmortal §f§kiiii§r ")
            {
                $player->setNameTag($r."§f".$player->getName());
                $player->setDisplayName($r."§f".$player->getName());
            }
            elseif($r == "§f§kiiii§r §4MwP:§bSw §f§kiiii§r ")
            {
                $player->setNameTag($r."§f".$player->getName());
                $player->setDisplayName($r."§f".$player->getName());
            }
            elseif($r == "§f§kiiii§r §7BUILDER §f§kiiii§r ")
            {
                $player->setNameTag($r."§f".$player->getName());
                $player->setDisplayName($r."§f".$player->getName());
            }
            }
        }