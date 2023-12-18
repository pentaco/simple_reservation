const cancelBtn = document.getElementById('cancelBtn');
const cancelUrl = document.getElementById('cancelUrl').value;
const redirectUrl = document.getElementById('redirectUrl').value;
const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

const cancelReservation = () => {
    const reserveCode = document.getElementById('reserveCode');
    const data = {
        code: reserveCode.value,
    };
    const config = {
        method: "POST",
        url: cancelUrl,
        data: JSON.stringify(data),
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken
        }
    }
    axios(config)
        .then(response => {
            alert('キャンセルしました。')
            location.href = `${redirectUrl}`;
        })
        .catch(error => {
            alert('キャンセルに失敗しました。')
        });
}

if (cancelBtn) {
    cancelBtn.addEventListener('click', () => {
        const result = confirm('キャンセルしますか？');
        if (result) {
            // cancelBtn.disabled = true;
            cancelReservation();
        }
    })
}



