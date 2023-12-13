const upfiles = Array.from(document.getElementsByClassName('fileInput'));
const base64Upfiles = Array.from(document.getElementsByClassName('base64Upfile'));
// const deleteBtns = Array.from(document.getElementsByClassName('closeBtn'));


// const deleteInputFile = (upfileId) => {
//     const upfile = document.getElementById(upfileId);
//     const imageTag = document.getElementById(`image_${upfileId}`);
//     const base64Upfile = document.getElementById(`base64_${upfileId}`);
//     const imageSelection = document.getElementById(`selection_${upfileId}`);
//     upfile.value = '';
//     base64Upfile.value = '';
//     imageTag.src = '';
//     imageTag.style.display = 'none';
//     imageSelection.style.display = '';
// }

// deleteBtns.forEach(deleteBtn => {
//     deleteBtn.addEventListener('click', () => {
//         const result = confirm('画像を削除しますか？');
//         if (result) {
//             deleteInputFile(deleteBtn.dataset.for);
//         }
//     })
// });

const changeLabel = (fileNameId, fileName) => {
    const label = document.getElementById(`span_${fileNameId}`)
    label.innerText = fileName
}

function blobToBase64(blob) {
    return new Promise((resolve, _) => {
        const reader = new FileReader();
        reader.onloadend = () => resolve(reader.result);
        reader.readAsDataURL(blob);
    });
}

const compressImage = (e, upfile) => {
    const upfileId = upfile.id
    const imageFile = e.target.files[0];
    console.log(imageFile.name, upfileId);

    const options = {
        maxSizeMB: 1,
        maxWidthOrHeight: 1024
    }
    imageCompression.getDataUrlFromFile(imageFile, options)
    imageCompression(imageFile, options)
        .then(async function (compressedFile) {
            const uploadDataurl = document.getElementById(`base64_${upfileId}`);
            uploadDataurl.value = await blobToBase64(compressedFile);
            // const imageTag = document.getElementById(`image_${upfileFor}`);
            // const imageSelection = document.getElementById(`selection_${upfileFor}`);
            // imageTag.src = URL.createObjectURL(compressedFile);;
            // imageTag.style.display = '';
            // imageSelection.style.display = 'none';
            changeLabel(upfileId, imageFile.name)
            console.log(compressedFile);
        })
        .catch(function (error) {
            console.log(error);
            // console.log(error.message);
        });
}

upfiles.forEach(upfile => {
    upfile.addEventListener("change", (e) => {
        compressImage(e, upfile);
    }, false);
});

window.addEventListener('load', () => {
    base64Upfiles.forEach(base64Upfile => {
        base64Upfile.value = '';
    });
})
