<?php

namespace App\Observers;

use App\Models\Page;

class PageObserver
{
    public function creating(Page $service)
    {
        if (is_null($service->order_by)){
            $service->order_by=Page::where('type', 'service')->max('order_by')+1;

            return;
        }
    }

    public function updating(Page $service)
    {
        if ($service->isClean('order_by')){
            return;
        }
        if (is_null($service->order_by)){
            $service->order_by=Page::where('type', 'service')->max('order_by');
        }
        if ($service->getOriginal('order_by') > $service->order_by) {
            $positionRange = [
                $service->order_by, $service->getOriginal('order_by'),
            ];
        } else {
            $positionRange = [
                $service->getOriginal('order_by'), $service->order_by,
            ];
        }
    }




    public function deleting(Page $service)
    {
        $service->order_by--;
        return;
    }
}
