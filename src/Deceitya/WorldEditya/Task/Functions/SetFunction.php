<?php
namespace Deceitya\WorldEditya\Task\Functions;

use pocketmine\Player;
use pocketmine\level\Position;
use pocketmine\block\Block;
use pocketmine\math\Vector3;
use Deceitya\WorldEditya\Task\Functions\EditFunction;
use Deceitya\WorldEditya\TextContainer;

class SetFunction extends EditFunction
{
    /** @var Block */
    private $block;

    public function __construct(Player $sender, Position $pos1, Position $pos2, Block $block)
    {
        parent::__construct($sender, $pos1, $pos2);
        $this->block = $block;
    }

    public function execute(): \Generator
    {
        $this->sender->getServer()->broadcastMessage(TextContainer::get('function.set.start', $this->sender->getName()));

        $level = $this->startPos->level;
        $current = new Vector3();
        $count = 0;
        for ($y = $this->startPos->y; $y <= $this->endPos->y; ++$y) {
            for ($x = $this->startPos->x; $x <= $this->endPos->x; ++$x) {
                for ($z = $this->startPos->z; $z <= $this->endPos->z; ++$z) {
                    $current->setComponents($x, $y, $z);
                    $level->setBlock($current, $this->block, false, false);

                    if (++$count % $this->processes === 0) {
                        yield;
                    }
                }
            }
        }

        $this->sender->getServer()->broadcastMessage(TextContainer::get('function.set.completed', $this->sender->getName()));
    }
}
