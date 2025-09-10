document.addEventListener('DOMContentLoaded', function () {
    // Seleccionar las miniaturas y la imagen principal
    const thumbnails = document.querySelectorAll('.pthumbnail');
    const largeImage = document.getElementById('largeImage');
    let currentImageIndex = 0;

    // Cambiar imagen principal al pasar el cursor por una miniatura
    thumbnails.forEach((thumbnail, index) => {
        thumbnail.addEventListener('mouseover', () => {
            largeImage.src = thumbnail.src;
            currentImageIndex = index;
        });
    });

    // Cambiar imagen al hacer clic en flechas
    function changeImage(direction) {
        currentImageIndex += direction;
        if (currentImageIndex < 0) {
            currentImageIndex = thumbnails.length - 1;
        } else if (currentImageIndex >= thumbnails.length) {
            currentImageIndex = 0;
        }
        largeImage.src = thumbnails[currentImageIndex].src;
    }

    document.querySelector('.left-arrow').addEventListener('click', () => changeImage(-1));
    document.querySelector('.right-arrow').addEventListener('click', () => changeImage(1));
});