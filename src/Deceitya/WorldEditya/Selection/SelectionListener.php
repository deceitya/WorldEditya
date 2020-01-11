<?php
namespace Deceitya\WorldEditya\Selection;

use pocketmine\event\Listener;
use pocketmine\event\player\PlayerInteractEvent;
use pocketmine\event\block\BlockBreakEvent;
use pocketmine\item\ItemIds;
use Deceitya\WorldEditya\TextContainer;

class SelectionListener implements Listener
{
    public function setPos1OnBlockTap(PlayerInteractEvent $event)
    {
        if ($event->getAction() !== PlayerInteractEvent::RIGHT_CLICK_BLOCK) {
            return;
        }

        $player = $event->getPlayer();
        if ($player->isOp() && $player->getInventory()->getItemInHand()->getId() === ItemIds::GOLD_PICKAXE) {
            $event->setCancelled();

            $pos = $event->getBlock()->asPosition();
            $selection = Selection::getSelection($player);
            $selection->setPos1($pos);
            $player->sendMessage(TextContainer::get('selection.set1', $pos->x, $pos->y, $pos->z, $selection->countBlocks()));
        }
    }

    public function setPos2OnBlockBreak(BlockBreakEvent $event)
    {
        $player = $event->getPlayer();
        if ($player->isOp() && $player->getInventory()->getItemInHand()->getId() === ItemIds::GOLD_PICKAXE) {
            $event->setCancelled();

            $pos = $event->getBlock()->asPosition();
            $selection = Selection::getSelection($player);
            $selection->setPos2($pos);
            $player->sendMessage(TextContainer::get('selection.set2', $pos->x, $pos->y, $pos->z, $selection->countBlocks()));
        }
    }
}
