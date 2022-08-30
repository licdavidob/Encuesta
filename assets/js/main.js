const api = "api/CRUD_Encuesta.php";

const formulario = document.getElementById("full_form");
const mensaje = document.getElementById("comment");
const contador = document.getElementById("contador");

// Funcionalidad del contador de caracteres
mensaje.addEventListener("input", function (e) {
  const target = e.target;
  const longitudMax = target.getAttribute("maxlength");
  const longitudAct = target.value.length;
  contador.innerHTML = `${longitudAct}/${longitudMax}`;
});

// Control del envío de encuesta
formulario.addEventListener("submit", (e) => {
  e.preventDefault();
});

// Captura de preguntas
function miVal() {
  var Variables_Encuesta = {};
  const auxj = document.full_form.juzgado.value;

  Variables_Encuesta["Juzgado"] = parseInt(auxj.substring(0, 2));
  Variables_Encuesta["Expediente"] = document.full_form.expediente.value
    ? document.full_form.expediente.value
    : 0;
  Variables_Encuesta["Parte"] = document.full_form.parte.value
    ? document.full_form.expediente.value
    : 3;
  Variables_Encuesta["P1"] = document.full_form.questionOne.value
    ? document.full_form.questionOne.value
    : 0;
  Variables_Encuesta["P2"] = document.full_form.questionTwo.value;
  Variables_Encuesta["P3"] = document.full_form.questionThree.value;
  Variables_Encuesta["P4"] = document.full_form.questionFour.value;
  Variables_Encuesta["P5"] = document.full_form.questionFive.value;
  Variables_Encuesta["P6"] = document.full_form.questionSix.value;
  Variables_Encuesta["P7"] = document.full_form.questionSeven.value;
  Variables_Encuesta["Comentario"] = document.full_form.comments.value;

  //Valida que ninguna variable sea de tipo NAN
  for (var Variable in Variables_Encuesta) {
    console.log(typeof Variables_Encuesta[Variable]);
    if (typeof Variables_Encuesta[Variable] === "string") {
      continue;
    }

    if (isNaN(Variables_Encuesta[Variable])) {
      document
        .getElementById("formulario__mensaje")
        .classList.add("formulario__mensaje-activo");
      setTimeout(() => {
        document
          .getElementById("formulario__mensaje")
          .classList.remove("formulario__mensaje-activo");
      }, 4000);
      console.log("La variable " + Variable + " tiene el valor NAN");
      return false;
    }
  }

  //Se envia la petición de registrar la encuesta
  AgregarEncuesta(Variables_Encuesta);
}

// Asignación de los parámetros
function AgregarEncuesta(Variables_Encuesta) {
  // Comunicación con back
  $.ajax({
    data: Variables_Encuesta,
    url: api,
    dataType: "json",
    type: "post",
    success: function (response) {
      console.log(response);
      document
        .getElementById("formulario__mensaje-exito")
        .classList.add("formulario__mensaje-exito-activo");
      formulario.reset();
      setTimeout(() => {
        document
          .getElementById("formulario__mensaje-exito")
          .classList.remove("formulario__mensaje-exito-activo");
      }, 4000);
      contador.innerHTML = `0/255`;
    },
  });
}
