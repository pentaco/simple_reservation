const reserveBtn = document.getElementById('reserveBtn');
const reservationBtn = document.getElementById('reservationBtn');

reservationBtn.addEventListener('click', () => {
    const inputCode = document.getElementById('inputCode').value;
    if (inputCode) {
        location.href = reservationBtn.dataset.reservationUrl + `/?reservation_code=${inputCode}`;
    } else {
        inputCode || alert('予約番号を入力してください。')
    }
})

reserveBtn.addEventListener('click', () => {
    location.href = reserveBtn.dataset.reserveUrl;
})