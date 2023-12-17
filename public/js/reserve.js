const reserveBtn = document.getElementById('reserveBtn');
const reserveUrl = document.getElementById('reserveUrl').value;
const detailUrl = document.getElementById('detailUrl').value;
const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
let postPalams;


const makeAndvalidatePalams = () => {
    const customerName = document.getElementById('inputName');
    const email = document.getElementById('inputEmail');
    const tel = document.getElementById('inputTel');
    const numberOfPeople = document.getElementById('inputNumber');
    const note = document.getElementById('inputNote');
    const date = document.getElementById('reserveDate');
    const timeslotId = document.getElementById('reserveTimeslot').value;
    const agreement = document.getElementById('agreement');
    postPalams = {
        customer_name: customerName.value,
        email: email.value,
        tel: tel.value,
        number_of_people: Number(numberOfPeople.value),
        note: note.value,
        date: date.value,
        timeslot_id: timeslotId ? Number(timeslotId) : null,
    };
    if (postPalams.timeslot_id === null) {
        alert('予約枠を選択してください');
        return false;
    }
    if (postPalams.customer_name == "") {
        alert('お客様名を入力してください');
        return false;
    }
    if (postPalams.email == "") {
        alert('メールアドレスを入力してください');
        return false;
    }
    if (postPalams.tel == "") {
        alert('電話番号を入力してください');
        return false;
    }
    console.log(agreement.checked);
    if (!agreement.checked) {
        alert('個人情報保護方針に同意してください。');
        return false;
    }
    return true;
}
const makeReservation = () => {
    const config = {
        method: "POST",
        url: reserveUrl,
        data: JSON.stringify(postPalams),
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken
        }
    }
    axios(config)
        .then(response => {
            const reservationCode = response.data
            alert('予約が完了しました。\n予約確認ページへ移動します。');
            location.href = `${detailUrl}/?reservation_code=${reservationCode}`;
        })
        .catch(error => {
            alert(error.response.data)
        });
}

reserveBtn.addEventListener('click', () => {
    // const result = confirm('予約します');
    // result && makeReservation();
    makeAndvalidatePalams() && makeReservation();
})