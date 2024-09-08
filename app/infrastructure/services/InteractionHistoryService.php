<?php

namespace App\infrastructure\services;

use App\domain\Models\InteractionHistory;
use App\infrastructure\repositories\InteractionHistoryRepository;

readonly class InteractionHistoryService
{

    public function __construct(
        private InteractionHistoryRepository $interactionHistoryRepository,
    )
    {
    }

    /**
     * @param array $interactionData
     * @return void
     */
    public function registerHistoryData(array $interactionData): void
    {
        $interaction = new InteractionHistory();
        $interaction->user_id = $interactionData['user_id'];
        $interaction->service = $interactionData['service'];
        $interaction->request_body = $interactionData['request_body'];
        $interaction->response_code = $interactionData['response_code'];
        $interaction->ip_address = $interactionData['ip_address'];

        $this->interactionHistoryRepository->save($interaction);
    }
}
