<?php
namespace Deceitya\WorldEditya;

use pocketmine\plugin\PluginBase;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\permission\Permission;
use pocketmine\permission\PermissionManager;
use Deceitya\WorldEditya\Selection\SelectionListener;
use Deceitya\WorldEditya\Command\SetCommand;
use Deceitya\WorldEditya\Command\Pos1Command;
use Deceitya\WorldEditya\Command\Pos2Command;

class Main extends PluginBase
{
    private static $instance;

    public static function getInstance(): Main
    {
        return self::$instance;
    }

    public function onLoad()
    {
        self::$instance = $this;
    }

    public function onEnable()
    {
        $this->reloadConfig();
        WorldEdityaConfig::init();
        TextContainer::init();
        $this->registerCommands();
        $this->getServer()->getPluginManager()->registerEvents(new SelectionListener(), $this);
    }

    public function onCommand(CommandSender $sender, Command $command, string $label, array $args): bool
    {
        return true;
    }

    private function registerCommands()
    {
        $manager = PermissionManager::getInstance();
        $manager->addPermission(new Permission('worldeditya.command.set', 'Allows the admin to run the set command', Permission::DEFAULT_OP));
        $manager->addPermission(new Permission('worldeditya.command.pos1', 'Allows the admin tu run the pos1 command', Permission::DEFAULT_OP));
        $manager->addPermission(new Permission('worldeditya.command.pos2', 'Allows the admin tu run the pos2 command', Permission::DEFAULT_OP));

        $map = $this->getServer()->getCommandMap();
        $map->register('worldeditya', new SetCommand());
        $map->register('worldeditya', new Pos1Command());
        $map->register('worldeditya', new Pos2Command());
    }
}
