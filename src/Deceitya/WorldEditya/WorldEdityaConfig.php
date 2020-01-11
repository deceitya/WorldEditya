<?php
namespace Deceitya\WorldEditya;

class WorldEdityaConfig
{
    /** @var int */
    private static $cooltimeTick;
    /** @var float */
    private static $limitSeconds;
    /** @var int */
    private static $blockProcesses;

    public static function init()
    {
        $config = Main::getInstance()->getConfig();
        self::$cooltimeTick = (int) $config->get('cooltime', 5);
        self::$limitSeconds = (float) $config->get('limit', 1.0);
        self::$blockProcesses = (int) $config->get('blocks', 200);
    }

    public static function getCooltimeTick(): int
    {
        return self::$cooltimeTick;
    }

    public static function getLimitSeconds(): float
    {
        return self::$limitSeconds;
    }

    public static function getNumOfBlockProcesses(): int
    {
        return self::$blockProcesses;
    }
}
