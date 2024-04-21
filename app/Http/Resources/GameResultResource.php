<?php

namespace App\Http\Resources;

use App\Models\GameResult;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class GameResultResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        /** @var GameResult $this */
        return [
            'score' => $this->score,
            'isWin' => $this->is_win,
            'winAmount' => $this->win_amount,
        ];
    }
}
