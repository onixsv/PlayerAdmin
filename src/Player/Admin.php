<?PHP

namespace Player;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\item\Item;
use pocketmine\item\ItemFactory;
use pocketmine\permission\DefaultPermissions;
use pocketmine\player\Player;
use pocketmine\plugin\PluginBase;

class Admin extends PluginBase{

	public $prefix = "§b§l[알림] §r§7";

	public function onCommand(CommandSender $sender, Command $command, string $label, array $args) : bool{
		if($command->getName() == "관리"){
			if(!$sender->hasPermission(DefaultPermissions::ROOT_OPERATOR)){
				$sender->sendMessage($this->prefix . "명령어를 사용 할 권한이 없습니다");
				return true;
			}
			if(!isset($args[0])){
				//$sender->sendMessage($this->prefix . "/관리 아이템 (아이템코드:데미지) (수량) | 모든 플레이어 에게 아이템을 줍니다");
				$sender->sendMessage($this->prefix . "/관리 주기 (수량) | 들고있는 아이템을 모든 플레이어 에게 줍니다");
				return true;
			}
			switch($args[0]){
				/*
				case "아이템":
					$p = explode(":", $args[1]);
					if(!isset($args[1]) || !isset($args[2]) || !is_numeric($args[2])){
						$sender->sendMessage($this->prefix . "/관리 아이템 (아이템코드:데미지) (수량) | 모든 플레이어 에게 아이템을 줍니다");
						return true;
					}
					if($p[0] <= 0){
						$sender->sendMessage($this->prefix . "/관리 아이템 (아이템코드:데미지) (수량) | 모든 플레이어 에게 아이템을 줍니다");
						return true;
					}
					$item = ItemFactory::getInstance()->get((int) $p[0], (int) $p[1], (int) $args[2]);
					foreach($this->getServer()->getOnlinePlayers() as $player){
						$player->getInventory()->addItem($item);
					}
					$this->getServer()->broadcastMessage($this->prefix . "§f" . $sender->getName() . " §r§7님이 모든 플레이어에게 §f" . $item->getName() . "§r§7 을(를) §f" . $args[2] . "§r§7 개 지급 하였습니다!");
					break;
				*/
				case "주기":
					if(!$sender instanceof Player){
						return false;
					}
					$handItem = clone $sender->getInventory()->getItemInHand();

					if(!isset($args[1]) || !is_numeric($args[1])){
						$sender->sendMessage($this->prefix . "/관리 주기 (수량) | 들고있는 아이템을 모든 플레이어에게 줍니다");
						return true;
					}
					if($args[1] <= 0){
						$sender->sendMessage($this->prefix . "/관리 주기 (수량) | 들고있는 아이템을 모든 플레이어에게 줍니다");
						return true;
					}
					$handItem->setCount((int) $args[1]);
					foreach($this->getServer()->getOnlinePlayers() as $player){
						$player->getInventory()->addItem($handItem);
					}
					$this->getServer()->broadcastMessage($this->prefix . "§d" . $sender->getName() . "§f님이 모든 플레이어에게 §d" . $handItem->getName() . "§r§f을(를) §d" . $args[1] . "§r§f개 지급했습니다.");
					break;
			}
		}
		return true;
	}

}