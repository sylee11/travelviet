<?php

namespace App\Listeners;

use App\Events\ViewPostHandler;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Session\Store;
class SendPostNotification
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    private $session;
    public function __construct(Store $session)
    {
        $this->session = $session;
    }

    /**
     * Handle the event.
     *
     * @param  ViewPostHandler  $event
     * @return void
     */
    public function handle(ViewPostHandler $event)
    {
       // $event->post->increment('view_count');
        if (!$this->isPostViewed($event->post))
	    {
	        $event->post->increment('view_count');
	        $this->storePost($event->post);
	    }
        
    }
    private function isPostViewed($post)
	{
	    $viewed = $this->session->get('viewed_posts', []);

	    return array_key_exists($post->id, $viewed);
	}

	private function storePost($post)
	{
	    $key = 'viewed_posts.' . $post->id;

	    $this->session->put($key, time());
	}
    
}
