<?php
namespace Deceitya\WorldEditya\Command;

use pocketmine\command\PluginCommand;
use pocketmine\command\CommandSender;
use pocketmine\Player;
use pocketmine\level\Position;
use Deceitya\WorldEditya\Main;
use Deceitya\WorldEditya\TextContainer;
use Deceitya\WorldEditya\Selection\Selection;

class Pos2Command extends PluginCommand
{
    public function __construct()
    {
        parent::__construct('/pos2', Main::getInstance());
        $this->setUsage(TextContainer::get('command.pos2.usage'));
        $this->setDescription(TextContainer::get('command.pos2.description'));
        $this->setPermission('worldeditya.command.pos2');
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args): bool
    {
        if (!parent::execute($sender, $commandLabel, $args)) {
            return false;
        }

        if (!($sender instanceof Player)) {
            return true;
        }

        $pos = Position::fromObject($sender->floor(), $sender->level);
        $selection = Selection::getSelection($sender);
        $selection->setPos2($pos);
        $sender->sendMessage(TextContainer::get('selection.set2', $pos->getFloorX(), $pos->getFloorY(), $pos->getFloorZ(), $selection->countBlocks()));

        return true;
    }
}
