// const api =
// "https://encuestaoralidadcivil.poderjudicialcdmx.gob.mx:2087/Encuesta/api/CRUD_Encuesta.php";
// const api = "api/CRUD_Encuesta.php";

const formulario = document.getElementById("full_form");

//Estas variables solo son para contar los caracteres
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

/**
 * Se encarga de inicializar las funciones
 * necesarias para capturar y enviar la
 * encuesta
 */
function main() {
  var Encuesta = CapturaEncuesta();
  Encuesta = AsignarDefaultValoresEncuesta(Encuesta);
  if (!DefinirVariablesObligatorias(Encuesta)) {
    return false;
  }
  AgregarEncuesta(Encuesta);
}

/**
 * Captura los valores del formulario de la encuesta
 * @returns array
 */
function CapturaEncuesta() {
  //Obtener el valor del select
  const auxj = document.full_form.juzgado.value;

  //Obtener el valor de los radio buttons
  var Encuesta = {
    Juzgado: parseInt(auxj.substring(0, 2)),
    Expediente: document.full_form.expediente.value,
    Parte: document.full_form.parte.value,
    P1: document.full_form.questionOne.value,
    P2: document.full_form.questionTwo.value,
    P3: document.full_form.questionThree.value,
    P4: document.full_form.questionFour.value,
    P5: document.full_form.questionFive.value,
    P6: document.full_form.questionSix.value,
    P7: document.full_form.questionSeven.value,
    Comentario: document.full_form.comments.value,
  };

  return Encuesta;
}

/**
 * Se encarga de asignar los valores del formulario
 * que no hayan sido contestados
 * @param {array} Encuesta
 * @returns array
 */
function AsignarDefaultValoresEncuesta(Encuesta) {
  for (var Variable in Encuesta) {
    if (Encuesta[Variable] == "" || Number.isNaN(Encuesta[Variable])) {
      Encuesta[Variable] = 0;
    }
  }

  return Encuesta;
}

/**
 * Define las variables obligatorias y las valida posteriormente
 * @param {array} Encuesta
 * @returns bool
 */
function DefinirVariablesObligatorias(Encuesta) {
  const Obligatorias = {
    Juzgado: Encuesta["Juzgado"],
    P1: Encuesta["P1"],
    P2: Encuesta["P2"],
    P3: Encuesta["P3"],
    P4: Encuesta["P4"],
    P5: Encuesta["P5"],
    P6: Encuesta["P6"],
    P7: Encuesta["P7"],
  };
  return ValidarObligatorias(Obligatorias);
}

/**
 * Se encarga de validar que hayan sido registradas las variables
 * obligatorias
 * @param {array} Obligatorias
 * @returns bool
 */
function ValidarObligatorias(Obligatorias) {
  for (var Variable in Obligatorias) {
    if (Obligatorias[Variable] == 0) {
      console.log("Falto definir la variable: " + Variable);
      MostrarError();
      return false;
    }
  }
  return true;
}

/**
 * Consulta la API para registrar los datos de la
 * encuesta
 * @param {array} Encuesta
 */
function AgregarEncuesta(Encuesta) {
  // Comunicación con back
  $.ajax({
    data: Encuesta,
    url: registroEncuesta,
    dataType: "json",
    type: "post",
    success: function (response) {
      console.log(response);
      MostrarExito();
    },
  });
}

/**
 * Muestra un mensaje de error si falto registrar un
 * campo del formulario
 */
function MostrarError() {
  document
    .getElementById("formulario__mensaje")
    .classList.add("formulario__mensaje-activo");
  setTimeout(() => {
    document
      .getElementById("formulario__mensaje")
      .classList.remove("formulario__mensaje-activo");
  }, 4000);
}

/**
 * Muestra un mensaje de exito una vez que haya sido
 * registrada la encuesta
 */
function MostrarExito() {
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
}

// Aqui comienza mi código
