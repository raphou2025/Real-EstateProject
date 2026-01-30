
// function previewImage(event) {
//     const img = document.getElementById('imgPreview');
//     img.src = URL.createObjectURL(event.target.files[0]);
//     img.style.display = 'block';
// }

// function previewImage(event) {
//         const img = document.getElementById('imgPreview');
//         img.src = URL.createObjectURL(event.target.files[0]);
//     }

 var reader = new FileReader();
        reader.onload = function() {
            var output = document.getElementById('imgPreview');
            output.src = reader.result;
        };
        reader.readAsDataURL(event.target.files[0]);