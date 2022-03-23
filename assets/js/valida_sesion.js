function Validar_Sesion() {
  var URL_COMPLETA = window.location.pathname;
  URL_COMPLETA = URL_COMPLETA.toLowerCase();
  console.log("URL COMPLETA: " + URL_COMPLETA);
  if (URL_COMPLETA != "/") {
    var URL = URL_COMPLETA.split("/", 2);
    var URL = URL[1];
  } else {
    var URL = URL_COMPLETA;
  }

  //Según donde se encuentre el usuario, la URL a donde se dispara mi AJAX
  console.log("URL RECORTADA: " + URL);
  var ruta = "";
  if (
    URL == "/conatrib/" ||
    URL == "/conatrib/index.html" ||
    URL == "/" ||
    URL == "index.html"
  ) {
    ruta = "Sesion.php";
  } else {
    ruta = "../Sesion.php";
  }

  //Parametros que recibe mi AJAX
  var parametros = {
    Peticion: "Validar_Sesion",
    URL: URL,
  };

  $.ajax({
    data: parametros,
    url: ruta,
    dataType: "json",
    type: "post",
    beforeSend: function () {},

    success: function (response) {
      if (response.Bandera == false) {
        console.log(response);
        //location.href = response.URL;
      } else {
        //Con este IF evito que la funcion "ConsultarDatos" se ejecute en el iniciar sesion
        if (response.Mensaje != "Sin problema, puedes iniciar sesion") {
          Iniciar();
        }
      }
    },
  });
}
