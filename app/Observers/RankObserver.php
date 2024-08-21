<?php

namespace App\Observers;

use App\Models\Team;

class RankObserver
{
    public function creating(Team $staff)
    {
        if (is_null($staff->order_by)){
            $staff->order_by=Team::max('order_by')+1;

            return;
        }
    }

    public function updating(Team $staff)
    {
        if ($staff->isClean('order_by')){
            return;
        }
        if (is_null($staff->order_by)){
            $staff->order_by=Team::max('order_by');
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




    public function deleting(Team $staff)
    {
        $staff->order_by--;
        return;
    }

}
