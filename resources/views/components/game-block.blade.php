<div class="mt-5 p-5 bg-white rounded-lg shadow-xl">
    <button class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded" onclick="playGame(this)"
            data-url="{{route('lucky-page.play-game', ['token' => $userLink->token])}}">
        {{__('messages.im_feeling_lucky')}}
    </button>
    <button class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded ml-2" onclick="getHistory(this)"
            data-url="{{route('lucky-page.history', ['token' => $userLink->token])}}">
        {{__('messages.history')}}
    </button>
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
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    let history = [];
    let historyDBLoaded = false;

    function playGame(button) {
        axios.get(button.dataset.url, {
        }, {
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'Content-Type': 'application/json'
            }
        })
        .then(function (response) {
            const data = response.data;
            luckyResult.innerHTML = `
                <p>${data.isWin ? "You win!" : "Sorry, you lose"}</p>
                <p>${"Score: " + data.score}</p>
                ${data.isWin ? `<p>${"Win amount: " + data.winAmount}</p>` : ''}
            `;
            luckyResult.classList.remove('hidden');
            historyResults.classList.add('hidden');
            history.unshift(data);
            if (history.length > 3) history.pop();
        })
        .catch(function (error) {
            console.error('Request failed:', error);
        });
    }

    function getHistory(button) {

        if (historyDBLoaded) {
            displayHistory(history);
        } else {
            axios.get(button.dataset.url, {
            }, {
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Content-Type': 'application/json'
                }
            })
            .then(function (response) {
                displayHistory(response.data)
                history = response.data;
                historyDBLoaded = true;
            })
            .catch(function (error) {
                console.error('Request failed:', error);
            });
        }

        function displayHistory(history) {
            historyResults.innerHTML = history.map(h => `
            <p>${h.isWin ? "Win!" : "Lose."} ${"Score: " + h.score}
            ${h.isWin ? `${"Win amount: " + h.winAmount}` : ''}
            `).join('');
            luckyResult.classList.add('hidden');
            historyResults.classList.remove('hidden');
        }
    }

</script>
