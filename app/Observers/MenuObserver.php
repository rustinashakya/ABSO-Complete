<?php

namespace App\Observers;

use App\Models\Menu;

class MenuObserver
{
    /**
     * Handle the Menu "created" event.
     *
     * @param  \App\Models\Menu  $menu
     * @return void
     */
    public function creating(Menu $menu)
    {
        if (is_null($menu->order_by)) {
            $menu->order_by = Menu::max('order_by') + 1;
            return;
        }
        $lowerPriorityMonuments = Menu::where('order_by', '>=', $menu->order_by)->get();

        foreach ($lowerPriorityMonuments as $lowerPriorityMonument) {
            $lowerPriorityMonument->order_by++;
            $lowerPriorityMonument->saveQuietly();
        }

    }

    /**
     * Handle the Menu "updated" event.
     *
     * @param  \App\Models\Menu  $menu
     * @return void
     */
    public function updating(Menu $menu): void
    {
        if ($menu->isClean('order_by')) {
            return;
        }

        if (is_null($menu->order_by)) {
            $menu->order_by = Menu::max('order_by');
        }

        if ($menu->getOriginal('order_by') > $menu->order_by) {
            $positionRange = [
                $menu->order_by, $menu->getOriginal('order_by'),
            ];
        } else {
            $positionRange = [
                $menu->getOriginal('order_by'), $menu->order_by,
            ];
        }

        $lowerPriorityClassPrograms = Menu::whereBetween('order_by', $positionRange)
            ->where('id', '!=', $menu->id)
            ->get();

        foreach ($lowerPriorityClassPrograms as $lowerPriorityClassProgram) {
            if ($lowerPriorityClassProgram->getOriginal('order_by') < $lowerPriorityClassProgram->order_by) {
                $lowerPriorityClassProgram->order_by--;
            } else {
                $lowerPriorityClassProgram->order_by++;
            }
            $lowerPriorityClassProgram->saveQuietly();
        }
    }

    /**
     * Handle the Menu "deleted" event.
     *
     * @param  \App\Models\Menu  $menu
     * @return void
     */
    public function deleting(Menu $menu): void
    {
        $lowerPriorityMonuments = Menu::where('order_by', '>', $menu->order_by)
            ->get();

        foreach ($lowerPriorityMonuments as $lowerPriorityMonument) {
            $lowerPriorityMonument->order_by--;
            $lowerPriorityMonument->saveQuietly();
        }
    }
}
