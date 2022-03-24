function Iniciar_Sesion(Usuario, Contraseña) {
  var parametros = {
    Peticion: "Iniciar_Sesion",
    Usuario: Usuario,
    Contraseña: Contraseña,
  };

  $.ajax({
    data: parametros,
    url: "Sesion.php",
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
