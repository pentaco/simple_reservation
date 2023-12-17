const modal = document.getElementById('modal');
const modalOverlay = document.getElementById('modalOverlay');
const modalToggles = Array.from(document.getElementsByClassName('modalToggle'));
const closeBtns = Array.from(document.getElementsByClassName('closeBtn'));

const openModal = () => {
    modal.classList.add('activeModal')
    modalOverlay.classList.add('activeOverlay')
    document.body.style.overflow = 'hidden';
}

const closeModal = () => {
    modal.classList.remove('activeModal')
    modalOverlay.classList.remove('activeOverlay')
    document.body.style.overflow = '';
}

modalToggles.forEach(modalToggle => {
    modalToggle.addEventListener('click', () => {
        openModal()
    });
});
closeBtns.forEach(closeBtn => {
    closeBtn.addEventListener('click', () => {
        closeModal()
    });
});
modalOverlay.addEventListener('click', closeModal)

