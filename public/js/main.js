
// const stars = document.querySelectorAll('.star');
// const ratingValue = document.getElementById('rating-value');
// let currentRating = 0; // Variable para rastrear la calificación actual

// stars.forEach(star => {
//   star.addEventListener('click', function() {
//     const rating = parseInt(this.getAttribute('data-value'));

//     // Si se hace clic en la misma estrella dos veces, resetea la calificación
//     if (currentRating === rating) {
//       updateSelection(0);
//       ratingValue.textContent = 'Rating: 0';
//       currentRating = 0;
//     } else {
//       updateSelection(rating);
//       ratingValue.textContent = `Rating: ${rating}`;
//       currentRating = rating;
//     }
//   });
// });

// function updateSelection(rating) {
//   stars.forEach(star => {
//     if (parseInt(star.getAttribute('data-value')) <= rating) {
//       star.src = '/imagenes/estrella.png';  // Cambia a la imagen de estrella llena
//     } else {
//       star.src = '/imagenes/estrellavacia.png';  // Cambia a la imagen de estrella vacía
//     }
//   });
// }
$('.slide').hiSlide();
document.getElementById('fileInput').addEventListener('change', function(event) {
const file = event.target.files[0];
if (file) {
    const reader = new FileReader();
    reader.onload = function(e) {
        document.getElementById('profileImage2').src = e.target.result;
    };
    reader.readAsDataURL(file);
}
document.getElementById('removeButton').addEventListener('click', function() {
document.getElementById('profileImage').src = 'https://avatar.iran.liara.run/public'; // URL de la imagen predeterminada
document.getElementById('fileInput').value = ''; // Limpiar el archivo seleccionado
});
});

const stars = document.querySelectorAll('.star');
const ratingValue = document.getElementById('rating-value');
let currentRating = 0; // Variable para rastrear la calificación actual

stars.forEach(star => {
  star.addEventListener('click', function() {
    const rating = parseInt(this.getAttribute('data-value'));

    // Si se hace clic en la misma estrella dos veces, resetea la calificación
    if (currentRating === rating) {
      updateSelection(0);
      ratingValue.textContent = 'Rating: 0';
      currentRating = 0;
    } else {
      updateSelection(rating);
      ratingValue.textContent = `Rating: ${rating}`;
      currentRating = rating;
    }
  });
});

function updateSelection(rating) {
  stars.forEach(star => {
    if (parseInt(star.getAttribute('data-value')) <= rating) {
      star.src = '/imagenes/estrella.png';  // Cambia a la imagen de estrella llena
    } else {
      star.src = '/imagenes/estrellavacia.png';  // Cambia a la imagen de estrella vacía
    }
  });
}


