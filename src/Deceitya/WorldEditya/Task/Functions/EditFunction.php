<?php
namespace Deceitya\WorldEditya\Task\Functions;

use pocketmine\Player;
use pocketmine\level\Position;
use Deceitya\WorldEditya\WorldEdityaConfig;
use Deceitya\WorldEditya\Selection\Selection;

abstract class EditFunction
{
    /** @var Player */
    protected $sender;

    /** @var Position */
    protected $startPos;
    /** @var Position */
    protected $endPos;

    /** @var int */
    protected $processes;

    public function __construct(Player $sender, Position $pos1, Position $pos2)
    {
        $this->sender = $sender;
        $level = $pos1->level;
        $this->startPos = Position::fromObject(Selection::minComponents($pos1, $pos2), $level);
        $this->endPos = Position::fromObject(Selection::maxComponents($pos1, $pos2), $level);
        $this->processes = WorldEdityaConfig::getNumOfBlockProcesses();
    }

    abstract public function execute(): \Generator;
}
