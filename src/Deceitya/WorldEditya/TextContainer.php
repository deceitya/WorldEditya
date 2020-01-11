<?php
namespace Deceitya\WorldEditya;

use pocketmine\utils\TextFormat;

class TextContainer
{
    /** @var array[string=>string] */
    private static $messages = [];

    public static function init()
    {
        $stream = Main::getInstance()->getResource('message.json');
        self::$messages = json_decode(stream_get_contents($stream), true);

        fclose($stream);
    }

    public static function get(string $key, ...$params): string
    {
        $keys = explode('.', $key);
        $msg = self::$messages;
        foreach ($keys as $k) {
            if (isset($msg[$k])) {
                $msg = $msg[$k];
            } else {
                $msg = $key;
                break;
            }
        }

        $search = ['&n'];
        $replace = [TextFormat::EOL];
        $i = 0;
        foreach ($params as $param) {
            $search[] = '%' . ++$i;
            $replace[] = $param;
        }

        return TextFormat::colorize(str_replace($search, $replace, $msg));
    }

    private function __construct()
    {
    }
}
