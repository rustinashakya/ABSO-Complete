<?php

namespace App\Observers;

use App\Models\SlideImage;

class HomePageObserver
{
    public function creating(SlideImage $staff)
    {
        if (is_null($staff->order_by)){
            $staff->order_by=SlideImage::max('order_by')+1;

            return;
        }
    }

    public function updating(SlideImage $staff)
    {
        if ($staff->isClean('order_by')){
            return;
        }
        if (is_null($staff->order_by)){
            $staff->order_by=SlideImage::max('order_by');
        }
        if ($staff->getOriginal('order_by') > $staff->order_by) {
            $positionRange = [
                $staff->order_by, $staff->getOriginal('order_by'),
            ];
        } else {
            $positionRange = [
                $staff->getOriginal('order_by'), $staff->order_by,
            ];
        }
    }




    public function deleting(SlideImage $staff)
    {
        $staff->order_by--;
        return;
    }
}
