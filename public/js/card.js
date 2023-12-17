const cardTime = document.getElementById('cardTime');
const cardTable = document.getElementById('cardTable');
const reserveTimeslot = document.getElementById('reserveTimeslot');
const radioTimeslots = Array.from(document.getElementsByClassName('radioTimeslot'));

radioTimeslots.forEach(radioTimeslot => {
    radioTimeslot.addEventListener('change', () => {
        cardTime.innerHTML = radioTimeslot.dataset.start
        cardTable.innerHTML = radioTimeslot.dataset.table
        reserveTimeslot.value = radioTimeslot.value
    })
});

