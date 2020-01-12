<?php
namespace Deceitya\WorldEditya\Task;

use pocketmine\scheduler\Task;

class TimeLimitedCoroutineTask extends Task
{
    /** @var \Generator */
    private $generator;
    /** @var float */
    private $limit;

    public function __construct(\Generator $generator, float $limit)
    {
        $this->generator = $generator;
        $this->limit = $this->limit;
    }

    public function onRun(int $currentTick)
    {
        $start = microtime(true);
        while ($this->generator->valid() && (microtime(true) - $start) < $this->limit) {
            $this->generator->next();
        }
        if (!$this->generator->valid()) {
            $this->getHandler()->cancel();
        }
    }
}
