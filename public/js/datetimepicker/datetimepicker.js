// 任意の日時を取得
// ----------------------------------------------- */
const msec_current = 0;
const msec_tenMinutesLater = 10 * 60 * 1000; // 10分をミリ秒に変換
const msec_twoHourLater = 2 * 60 * 60 * 1000; // 120分をミリ秒に変換
const msec_oneWeekLater = 7 * 24 * 60 * 60 * 1000; // 1週間をミリ秒に変換

const getCustomTime = (offset, started_at = "") => {
    let start_time
    if (started_at !== "") {
        start_time = new Date(started_at);
    } else {
        start_time = new Date(); // 現在の日時を取得
    }
    const futureTime = new Date(start_time.getTime() + offset); // 指定されたオフセットに応じて未来の日時を計算
    const year = futureTime.getFullYear();
    const month = String(futureTime.getMonth() + 1).padStart(2, '0');
    const day = String(futureTime.getDate()).padStart(2, '0');
    const hours = String(futureTime.getHours()).padStart(2, '0');
    const minutes = String(futureTime.getMinutes()).padStart(2, '0');

    const customTime = `${year}/${month}/${day} ${hours}:${minutes}`;
    return customTime;
}

// チェックボックスの操作
// -----------------------------------------------
const startCheckbox = document.getElementById("startCheckbox")
const startedAt = document.getElementById("startedAt")
const endCheckbox = document.getElementById("endCheckbox")
const endedAt = document.getElementById("endedAt")

const checkedStart = () => {
    if (startCheckbox.checked) {
        startedAt.value = getCustomTime(msec_current);
    } else {
        startedAt.value = "";
    }
}

const checkedEnd = () => {
    if (endCheckbox.checked) {
        endedAt.value = getCustomTime(msec_twoHourLater, startedAt.value);
    } else {
        endedAt.value = "";
    }
}

startCheckbox.addEventListener('change', () => {
    checkedStart();
})

endCheckbox.addEventListener('change', () => {
    checkedEnd();
})

startedAt.addEventListener('click', () => {
    startCheckbox.checked = false;
})
endedAt.addEventListener('click', () => {
    endCheckbox.checked = false;
})


/* datetimepickerの設定
----------------------------------------------- */
let times = [];
for (let hour = 0; hour < 24; hour++) {
    for (let index = 0; index < 4; index++) {
        const minutes = index * 15;
        times.push(`${hour}:${minutes}`)
    }
}

// 現在の日時
const currentTime = getCustomTime(msec_current);

// 10分後の日時
const tenMinutesLater = getCustomTime(msec_tenMinutesLater); // 10分をミリ秒に変換

// 1週間後の日時
const oneWeekLater = getCustomTime(msec_oneWeekLater); // 1週間をミリ秒に変換

$.datetimepicker.setLocale('ja');
jQuery('#startedAt').datetimepicker({
    lang: 'ja',
    allowTimes: times,
    mask: true,
    minDate: currentTime,
});

jQuery('#endedAt').datetimepicker({
    lang: 'ja',
    allowTimes: times,
    mask: true,
    minDate: currentTime,
});

window.addEventListener('load', () => {
    if (startCheckbox.checked) {
        checkedStart()
    }
    if (endCheckbox.checked) {
        checkedEnd()
    }
})