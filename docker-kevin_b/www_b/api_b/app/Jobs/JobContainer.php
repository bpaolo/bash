<?php

namespace App\Jobs;

use App\PayloadConsumers\Contracts\HandlesPayload;

class JobContainer extends Job
{
    /**
     * Consumer
     *
     * @var App\Consumers\AbstractConsumer 
     */
    protected $consumer;
    /**
     * Payload
     *
     * @var void
     */
    protected $payload;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($payload,HandlesPayload $consumer)
    {
        $this->payload = $payload;
        $this->consumer = $consumer;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->consumer->handle($this->payload);
        $this->job->delete();
    }
}
