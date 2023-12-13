const TOKEN = document.querySelector('meta[name="csrf-token"]').getAttribute("content")
const sentimentStoreUrl = document.getElementById('sentimentStoreUrl').value
const roomCode = document.getElementById('roomCode').value
const sentimentButtons = Array.from(document.getElementsByClassName('sentimentButton'))
const modalToggle = document.getElementById('modalToggle')
const modalBg = document.getElementById('modalBg')
const reverseCards = Array.from(document.getElementsByClassName('reverseCard'))
let roomNames = []
let tapCount = 0;

const displayImage = () => {
    const randomNumber = Math.floor(Math.random() * reverseCards.length) + 1;

    // すべてのimageX要素に対してdisplay="none"を設定
    for (let i = 1; i <= reverseCards.length; i++) {
        const imageElement = document.getElementById(`image${i}`);
        if (imageElement) {
            if (randomNumber === i) {
                imageElement.style.display = "";
            } else {
                imageElement.style.display = "none";
            }
        }
    }
}

const storeSentiment = (buttonId) => {
    const data = {
        room_code: roomCode,
        button_id: buttonId,
    };
    const fetchConfig = {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": TOKEN
        },
        body: JSON.stringify(data)
    }

    fetch(sentimentStoreUrl, fetchConfig)
        .then(response => {
            if (!response.ok) {
                throw new Error("Network response was not ok");
            }
            return response.json();
        })
        .then(data => {
        })
        .catch(error => {
        });
}

const disabledButtons = (disabled) => {
    sentimentButtons.forEach(sentimentButton => {
        sentimentButton.disabled = disabled;
    })
}
sentimentButtons.forEach(sentimentButton => {
    roomNames.push(sentimentButton.dataset.name)
    sentimentButton.addEventListener('click', () => {
        tapCount += 1;
        if (tapCount <= 20) {
            storeSentiment(sentimentButton.dataset.id)
        } else {
            modalToggle.click()
            displayImage()
            modalBg.classList.remove('modal-background')
            disabledButtons(true)
            const intervalId = setInterval(() => {
                modalBg.classList.add('modal-background')
                disabledButtons(false)
                clearInterval(intervalId);
            }, 500);
        }
    })
})

// 1分ごとにtapCountを0にリセット
setInterval(() => {
    tapCount = 0;
}, 60000); // 60000ミリ秒（1分）


//
// chart.js
//--------------------------------------------------------------------
let intervalConts = []
let intervalTimes = []
let includeDateFlag = false;

const formatTime = (time, includeDate) => {
    const formatOptions = {
        hour: "2-digit",
        minute: "2-digit",
        hour12: false, // 24時間制
    };
    if (includeDate) {
        // formatOptions.month = "2-digit";
        // formatOptions.day = "2-digit";
    }
    const datetime = new Date(time.replace(/-/g,"/"))
    const formatedTime = datetime.toLocaleString("en-US", formatOptions)
    return formatedTime
}

const setIntervalTimes = (intervalTimesData) => {
    intervalTimes = []
    intervalTimesData.forEach(intervalTimeData => {
        intervalTimes.push(formatTime(intervalTimeData, includeDateFlag))
    })
}

const ctx = document.getElementById('myChart');
const plotChart = () => {
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: intervalTimes,
            datasets: [{
                label: roomNames[0],
                data: intervalConts[0],
                borderWidth: 1,
                borderColor: '#FFC857',
                backgroundColor: '#FFC857',
            }, {
                label: roomNames[1],
                data: intervalConts[1],
                borderWidth: 1,
                borderColor: '#F29492',
                backgroundColor: '#F29492',
            }, {
                label: roomNames[2],
                data: intervalConts[2],
                borderWidth: 1,
                borderColor: '#647D8E',
                backgroundColor: '#647D8E',
            }, {
                label: roomNames[3],
                data: intervalConts[3],
                borderWidth: 1,
                borderColor: '#A2D9CE',
                backgroundColor: '#A2D9CE',
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
}

//
// 期間の判定
// ---------------------------------------------------------------------
const checkDateRange = () => {
    let isDuringPeriod = false
    // 現在の日時を取得
    const now = new Date();

    const startedAt = document.getElementById('startedAt').value
    const endedAt = document.getElementById('endedAt').value

    // 開始日時と終了日時を指定
    const startDate = new Date(startedAt.replace(/-/g,"/"));
    const endDate = new Date(endedAt.replace(/-/g, "/"));

    // 期間の比較
    if (now < startDate) {
        alert("開始前のルームです。");
    } else if (now > endDate) {
        alert("終了したルームです。");
    } else {
        isDuringPeriod = true
        return isDuringPeriod
    }
    return isDuringPeriod
}
//
// データの取得
// ---------------------------------------------------------------------
const sentimentResultUrl = document.getElementById('sentimentResultUrl').value
const fetchData = (buttonId) => {
    const fetchConfig = {
        method: "get",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": TOKEN
        },
    }

    fetch(sentimentResultUrl, fetchConfig)
        .then(response => {
            if (!response.ok) {
                throw new Error("Network response was not ok");
            }
            return response.json();
        })
        .then(data => {
            checkDateRange() || disabledButtons(true)
            setIntervalTimes(data.interval_times)
            intervalConts = data.interval_counts
            plotChart();
        })
        .catch(error => {
        });
}


window.addEventListener('load', () => {
    fetchData();
})
