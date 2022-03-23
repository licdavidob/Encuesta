function Cerrar_Sesion() {
  var parametros = {
    Peticion: "Cerrar_Sesion",
  };

  $.ajax({
    data: parametros,
    url: "../Sesion.php",
    dataType: "json",
    type: "post",
    beforeSend: function () {},

    success: function (response) {
      if (response.Bandera == false) {
        alert(response.Mensaje);
      } else {
        window.location = response.URL;
      }
    },
  });
}
