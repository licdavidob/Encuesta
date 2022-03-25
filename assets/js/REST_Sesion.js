function Iniciar_Sesion(Correo, Contraseña) {
  var parametros = {
    Correo: Correo,
    Contraseña: Contraseña,
  };

  $.ajax({
    data: parametros,
    url: "api/REST_Sesion.php",
    dataType: "json",
    type: "post",
    beforeSend: function () {},

    success: function (response) {
      if (response.Bandera) {
        window.location.replace(response.URL);
      } else {
        console.log(response.Mensaje);
      }
    },
  });
}

function Cerrar_Sesion() {
  $.ajax({
    data: "",
    url: "api/REST_Sesion.php",
    dataType: "json",
    type: "delete",
    beforeSend: function () {},

    success: function (response) {
      if (response.Bandera) {
        window.location.replace(response.URL);
      } else {
        console.log(response.Mensaje);
      }
    },
  });
}