<?php
namespace Deceitya\WorldEditya\Task;

use pocketmine\scheduler\Task;
use Deceitya\WorldEditya\WorldEdityaConfig;

class TimeLimitedCoroutineTask extends Task
{
    /** @var \Generator */
    private $generator;
    /** @var float */
    private $limit;

    public function __construct(\Generator $generator)
    {
        $this->generator = $generator;
        $this->limit = WorldEdityaConfig::getLimitSeconds();
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
