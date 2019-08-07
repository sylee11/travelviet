<?php

namespace App\Listeners;

use App\Events\CreatePostHandler;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Str;
class CreatePostListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  CreatePostHandler  $event
     * @return void
     */
    public function handle(CreatePostHandler $event)
    {
        $str = $event->post->title.' '.$event->post->id;
        $event->post->slug =Str::slug($str, '-');
        $event->post->save();
      
    }
}
