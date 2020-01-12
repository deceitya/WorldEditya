<?php
namespace Deceitya\WorldEditya\Command;

use pocketmine\command\PluginCommand;
use pocketmine\command\CommandSender;
use pocketmine\Player;
use pocketmine\level\Position;
use pocketmine\block\BlockFactory;
use Deceitya\WorldEditya\Main;
use Deceitya\WorldEditya\WorldEdityaConfig;
use Deceitya\WorldEditya\TextContainer;
use Deceitya\WorldEditya\Selection\Selection;
use Deceitya\WorldEditya\Task\TimeLimitedCoroutineTask;
use Deceitya\WorldEditya\Task\Functions\SetFunction;

class SetCommand extends PluginCommand
{
    public function __construct()
    {
        parent::__construct('/set', Main::getInstance());
        $this->setUsage(TextContainer::get('command.set.usage'));
        $this->setDescription(TextContainer::get('command.set.description'));
        $this->setPermission('worldeditya.command.set');
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args): bool
    {
        if (!parent::execute($sender, $commandLabel, $args)) {
            return false;
        }

        if (!($sender instanceof Player)) {
            return true;
        }

        if (count($args) < 1) {
            $sender->sendMessage($this->getUsage());
            return false;
        }

        $data = explode(':', $args[0]);
        for ($i = 0; $i < 2; $i++) {
            if (isset($data[$i])) {
                $value = $data[$i];
                if (!is_numeric($value) || $value - intval($value) > 0) {
                    $sender->sendMessage($this->getUsage());
                    return false;
                }
            } else {
                $data[$i] = 0;
            }
        }

        $selection = Selection::getSelection($sender);
        $pos1 = $selection->getPos1();
        $pos2 = $selection->getPos2();
        if ($pos1 instanceof Position && $pos2 instanceof Position) {
            $function = new SetFunction($sender, $pos1, $pos2, BlockFactory::get((int) $data[0], (int) $data[1]));
            $this->getPlugin()->getScheduler()->scheduleRepeatingTask(
                new TimeLimitedCoroutineTask($function->execute(), WorldEdityaConfig::getLimitSeconds()),
                WorldEdityaConfig::getCooltimeTick()
            );
            return true;
        } else {
            $sender->sendMessage(TextContainer::get('command.set.nopos'));
            return true;
        }
    }
}
