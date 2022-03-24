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
    beforeSend: function () {
      console.log(parametros);
    },
    success: function (response) {
      console.log(response);
    },
  });
}
