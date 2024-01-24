function Iniciar_Sesion(Correo, Contraseña) {
  var parametros = {
    Correo: Correo,
    Contraseña: Contraseña,
  };

  $.ajax({
    data: parametros,
    url: REST_Sesion,
    dataType: "json",
    type: "POST",
    success: function (response) {
      if (response.Bandera) {
        window.location.replace(response.URL);
      } else {
        document
          .getElementById("formulario__mensaje")
          .classList.add("formulario__mensaje-activo");
        setTimeout(() => {
          document
            .getElementById("formulario__mensaje")
            .classList.remove("formulario__mensaje-activo");
        }, 4000);
      }
    },
    complete: function () {
      console.log("Petición finalizada");
    },
  });
}

function Cerrar_Sesion() {
  $.ajax({
    data: "",
    url: REST_Sesion,
    dataType: "json",
    type: "delete",
    success: function (response) {
      if (response.Bandera) {
        window.location.replace(response.URL);
      } else {
      }
    },
  });
}
