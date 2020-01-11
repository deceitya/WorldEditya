<?php
namespace Deceitya\WorldEditya\Selection;

use pocketmine\Player;
use pocketmine\level\Position;
use pocketmine\math\Vector3;

class Selection
{
    /** @var array[string=>Selection] */
    private static $selections = [];

    public static function getSelection(Player $player): Selection
    {
        $name = $player->getName();
        if (!isset(self::$selections[$name])) {
            self::$selections[$name] = new Selection();
        }
        return self::$selections[$name];
    }

    private function __construct()
    {
    }

    /** @var Position */
    private $pos1 = null;
    /** @var Position */
    private $pos2 = null;

    public function getPos1(): ?Position
    {
        return $this->pos1;
    }

    public function setPos1(Position $pos)
    {
        $this->pos1 = $pos;
    }

    public function getPos2(): ?Position
    {
        return $this->pos2;
    }

    public function setPos2(Position $pos)
    {
        $this->pos2 = $pos;
    }

    public function countBlocks(): int
    {
        if ($this->pos1 instanceof Position && $this->pos2 instanceof Position) {
            $min = self::minComponents($this->pos1, $this->pos2);
            $max = self::maxComponents($this->pos1, $this->pos2);
            return ($max->x - $min->x + 1) * ($max->y - $min->y + 1) * ($max->z - $min->z + 1);
        }

        return 0;
    }

    public static function maxComponents(Vector3 ...$positions): Vector3{
        $xList = $yList = $zList = [];
        foreach($positions as $position){
            $xList[] = $position->x;
            $yList[] = $position->y;
            $zList[] = $position->z;
        }

		return new Vector3(max($xList), max($yList), max($zList));
    }

    public static function minComponents(Vector3 ...$positions): Vector3{
        $xList = $yList = $zList = [];
        foreach($positions as $position){
            $xList[] = $position->x;
            $yList[] = $position->y;
            $zList[] = $position->z;
        }

		return new Vector3(min($xList), min($yList), min($zList));
	}
}
