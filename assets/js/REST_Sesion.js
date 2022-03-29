function Iniciar_Sesion(Correo, Contraseña) {
  var parametros = {
    Correo: Correo,
    Contraseña: Contraseña,
  };

  $.ajax({
    data: parametros,
    url: "https://encuestaoralidadcivil.poderjudicialcdmx.gob.mx:2087/Encuesta/api/REST_Sesion.php",
    dataType: "json",
    type: "post",
    beforeSend: function () {},

    success: function (response) {
      if (response.Bandera) {
        window.location.replace(response.URL);
      } else {
        document.getElementById("formulario__mensaje").classList.add("formulario__mensaje-activo");
        setTimeout(() => {
          document.getElementById("formulario__mensaje").classList.remove("formulario__mensaje-activo");
        }, 4000)
        // alert("Por favor revisa tus datos")
        // console.log(response.Mensaje);
        // alert(response.Mensaje)
      }
    },
  });
}

function Cerrar_Sesion() {
  $.ajax({
    data: "",
    url: "https://encuestaoralidadcivil.poderjudicialcdmx.gob.mx:2087/Encuesta/api/REST_Sesion.php",
    dataType: "json",
    type: "delete",
    beforeSend: function () {},

    success: function (response) {
      if (response.Bandera) {
        // console.log(response.URL);
        window.location.replace(response.URL);
      } else {
        console.log(response.Mensaje);
      }
    },
  });
}
