<?php

namespace App\Jobs;

use App\Models\Donation;
use App\Models\Follower;
use App\Models\MerchSale;
use App\Models\Subscriber;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class RetrieveUserEvents implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(
        private User $user,
    ) {}

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        //
        Donation::factory()->count(rand(300, 500))->for($this->user)->create();
        Follower::factory()->count(rand(300, 500))->for($this->user)->create();
        MerchSale::factory()->count(rand(300, 500))->for($this->user)->create();
        Subscriber::factory()->count(rand(300, 500))->for($this->user)->create();
    }
}
