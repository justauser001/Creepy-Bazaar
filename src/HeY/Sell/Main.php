<?php

namespace HeY\Sell;

use pocketmine\Server;
use pocketmine\player\Player; 
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;
use pocketmine\utils\Config;
use onebone\coinapi\CoinAPI;
use onebone\economyapi\EconomyAPI;
use jojoe77777\FormAPI\SimpleForm; 

class Main extends PluginBase implements Listener {

    public function onEnable(): void {
        $this->getServer()->getPluginManager()->registerEvents($this, $this);
        $this->saveResource("config.yml");
        $this->config = new Config($this->getDataFolder() . "config.yml", Config::YAML, array());
    }

    public function onCommand(CommandSender $sender, Command $command, string $label, array $args): bool {
        if ($command->getName() === 'sellmenu') {
            if ($sender instanceof Player) {
                $this->formUI($sender);
            } else {
                $sender->sendMessage("Bazaar");
            }
        }
        return true;
    }

    public function formUI(Player $player) {
        $form = new SimpleForm(function (Player $player, $data) {
            if ($data === null) {
                $player->sendMessage($this->config->get("Message")["Exit"]);
                return;
            }
            switch ($data) {
                case 0:

                    break;
                case 1:
                    $this->getServer()->getCommandMap()->dispatch($player, $this->getConfig()->get("Menu-CMD-1"));
                    break;
                case 2:
                    $this->getServer()->getCommandMap()->dispatch($player, $this->getConfig()->get("Menu-CMD-2"));
                    break;
                case 3:
                    $this->getServer()->getCommandMap()->dispatch($player, $this->getConfig()->get("Menu-CMD-3"));
                    break;
            }
        });

        $form->setTitle($this->config->get("Title"));
        $form->addButton($this->config->get("Close-Button"), 0, $this->config->get("Close-Image"));
        $form->addButton($this->config->get("Name-Button-1"), 1, $this->config->get("Button-1-Image"));
        $form->addButton($this->config->get("Name-Button-2"), 1, $this->config->get("Button-2-Image"));
        $form->addButton($this->config->get("Name-Button-3"), 1, $this->config->get("Button-3-Image"));
        $player->sendForm($form);
    }
}
