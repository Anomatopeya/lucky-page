@extends('app')

@section('content')
    <div class="text-center">
        <h1 class="text-4xl font-bold text-gray-700 p-5">
            {{__('messages.welcome_lucky_page', ['name' => $user->name])}}
        </h1>
    </div>

    <x-link-block :userLink="$userLink"/>

    <div class="mt-5 p-5 bg-white rounded-lg shadow-xl">
        <button id="imFeelingLucky" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">I'm Feeling Lucky</button>
        <button id="history" class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded ml-2">History</button>
    </div>

    <div id="luckyResult" class="mt-5 p-5 bg-white rounded-lg shadow-xl hidden">
        <!-- Результаты будут добавлены здесь -->
    </div>

    <div id="historyResults" class="mt-5 p-5 bg-white rounded-lg shadow-xl hidden">
        <!-- История результатов будет добавлена здесь -->
    </div>

    <script>
        const luckyResult = document.getElementById('luckyResult');
        const historyResults = document.getElementById('historyResults');
        let history = [];

        document.getElementById('imFeelingLucky').addEventListener('click', () => {
            const randomNumber = Math.floor(Math.random() * 1000) + 1;
            const isWin = randomNumber % 2 === 0;
            const winAmount = calculateWinAmount(randomNumber);
            const result = isWin ? `Win: ${winAmount}` : 'Lose';

            history.unshift({ randomNumber, result, winAmount });
            if (history.length > 3) history.pop();

            luckyResult.innerHTML = `<p>Random Number: ${randomNumber}</p><p>Result: ${result}</p>`;
            luckyResult.classList.remove('hidden');
        });

        document.getElementById('history').addEventListener('click', () => {
            historyResults.innerHTML = history.map(h => `<p>Random Number: ${h.randomNumber}, Result: ${h.result}, Win Amount: ${h.winAmount}</p>`).join('');
            historyResults.classList.remove('hidden');
        });

        function calculateWinAmount(randomNumber) {
            if (randomNumber > 900) return randomNumber * 0.7;
            if (randomNumber > 600) return randomNumber * 0.5;
            if (randomNumber > 300) return randomNumber * 0.3;
            return randomNumber * 0.1;
        }

    </script>

@endsection

