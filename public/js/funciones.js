

//Funciones para cambiar imagen cuando le las al enlace de cambiar imagen en el formulario de la ventana modal de registro
document.getElementById('changeImageLink').addEventListener('click', function (e) {
  e.preventDefault();
  document.getElementById('imageInput').click();
});

document.getElementById('imageInput').addEventListener('change', function () {
  const file = this.files[0];
  if (file) {
    const reader = new FileReader();
    reader.onload = function (e) {
      document.getElementById('profileImage').src = e.target.result;
    }
    reader.readAsDataURL(file);
  }
});

//Funcion para que el formulario de la ventana modal de registo no carge la pagina
/*document.querySelector('.form-grid').addEventListener('submit', function(event) {
  event.preventDefault(); // Previene la recarga de la página
  // Aquí puedes manejar la lógica para procesar los datos del formulario
  alert("Registro exitoso!");
  this.reset();
});*/

//Funcion para que el formulario de la ventana modal de iniciar sesion no carge la pagina
document.querySelector('.form-iniciarses').addEventListener('submit', function (event) {
  event.preventDefault(); // Previene la recarga de la página
  // Aquí puedes manejar la lógica para procesar los datos del formulario
  alert("Inicio de sesion exitoso!");
  this.reset();
});

//Funcion para que el formulario del encabezado de la pagina no carge la pagina
document.querySelector('.buscar').addEventListener('submit', function (event) {
  event.preventDefault(); // Previene la recarga de la página
  // Aquí puedes manejar la lógica para procesar los datos del formulario
  this.reset();
});