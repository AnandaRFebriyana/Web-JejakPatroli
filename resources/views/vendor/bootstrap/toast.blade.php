<div class="toast-container position-fixed end-0 p-3">
    <div id="liveToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="toast-header">
            <img src="{{ asset('assets/img/success.png') }}" class="rounded me-2" style="width: 24px; height: 24px;">
            <strong class="me-auto">Success</strong>
            <button class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
        <div class="toast-body">
            {{-- {{ Session::get('toast_message', '') }} --}}
        </div>
    </div>
</div>

<script>
var toastMessage = "{{ Session::get('toast_message', '') }}";

function showToast(message) {
    var toast = document.getElementById('liveToast');
    var toastBody = document.querySelector('#liveToast .toast-body');

    toastBody.textContent = message;
    var toastBS = new bootstrap.Toast(toast);
    toastBS.show();
}
if (toastMessage) {
    showToast(toastMessage);
    "{{ Session::forget('toast_message') }}";
}
</script>