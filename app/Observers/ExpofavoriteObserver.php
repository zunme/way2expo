<?php

namespace App\Observers;

use App\Models\ExpoFavorite;
use App\Models\ExpoMeta;

class ExpofavoriteObserver
{
    /**
     * Handle the expo favorite "created" event.
     *
     * @param  \App\Models\ExpoFavorite  $expoFavorite
     * @return void
     */
    public function created(ExpoFavorite $expoFavorite)
    {
        //
        $expo = ExpoMeta::where('expo_id', $expoFavorite->expo_id)->increment('favorite_count');
        dd($expo);
    }

    /**
     * Handle the expo favorite "updated" event.
     *
     * @param  \App\Models\ExpoFavorite  $expoFavorite
     * @return void
     */
    public function updated(ExpoFavorite $expoFavorite)
    {
        //
    }

    /**
     * Handle the expo favorite "deleted" event.
     *
     * @param  \App\Models\ExpoFavorite  $expoFavorite
     * @return void
     */
    public function deleted(ExpoFavorite $expoFavorite)
    {
      ExpoMeta::where('expo_id', $expoFavorite->expo_id)->decrement('favorite_count');
    }

    /**
     * Handle the expo favorite "restored" event.
     *
     * @param  \App\Models\ExpoFavorite  $expoFavorite
     * @return void
     */
    public function restored(ExpoFavorite $expoFavorite)
    {
        //
    }

    /**
     * Handle the expo favorite "force deleted" event.
     *
     * @param  \App\Models\ExpoFavorite  $expoFavorite
     * @return void
     */
    public function forceDeleted(ExpoFavorite $expoFavorite)
    {
        //
    }
}
