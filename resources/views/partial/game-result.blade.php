@if($isWin)
    <p>{{__('messages.you_win')}}</p>
    <p>{{__('messages.game_score', ['score' => $score])}}</p>
    <p>{{__('messages.win_amount', ['amount' => $winAmount])}}</p>
@else
    <p>{{__('messages.you_lose')}}</p>
    <p>{{__('messages.game_score', ['score' => $score])}}</p>
@endif
