<div class="p-5 bg-white rounded-lg shadow-xl">
    <div>
        <h3 class="text-2xl text-gray-700">{{__('messages.available_link_time')}}</h3>
        <div id="countdownTimer" class="mt-5 mb-5 p-5 bg-white rounded-lg shadow-xl" data-expires-at="{{$userLink->expires_at}}">
        </div>
    </div>

    <button id="generateLink" onclick="linkUpdate(this)" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded"
            data-text="{{__('messages.generate_new_link_alert_text')}}"
            data-url="{{route('lucky-page.generate-new-link', ['token' => $userLink->token])}}"
    >
        {{__('messages.generate_new_link')}}
    </button>
    <button id="deactivateLink" onclick="linkUpdate(this)" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded ml-2"
            data-text="{{__('messages.deactivate_link_alert_text')}}"
            data-url="{{route('lucky-page.deactivate-link', ['token' => $userLink->token])}}"
    >
        {{__('messages.deactivate_link')}}
    </button>
</div>

<script>
    const countdownTimer = document.getElementById("countdownTimer");
    const countDownDate = new Date(countdownTimer.dataset.expiresAt).getTime();

    const x = setInterval(function() {
        const now = new Date().getTime();
        const distance = countDownDate - now;
        const days = Math.floor(distance / (1000 * 60 * 60 * 24));
        const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
        const seconds = Math.floor((distance % (1000 * 60)) / 1000);

        countdownTimer.innerHTML = days + "d " + hours + "h " + minutes + "m " + seconds + "s ";
        if (distance < 0) {
            clearInterval(x);
            countdownTimer.innerHTML = "EXPIRED";
        }
    }, 1000);


    function linkUpdate(button) {
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        Swal.fire({
            title: 'Are you sure?',
            text: button.dataset.text ?? '',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
        }).then((result) => {
            if (result.isConfirmed) {
                // Send POST request to the server
                axios.post(button.dataset.url, {
                }, {
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Content-Type': 'application/json'
                    }
                })
                    .then(function (response) {
                        window.location.href = response.data.url;
                    })
                    .catch(function (error) {
                        console.error('Request failed:', error);
                    });
            }
        });
    }
</script>
