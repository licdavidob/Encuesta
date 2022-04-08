const formulario = document.getElementById("full_form");
const mensaje = document.getElementById('comment');
const contador = document.getElementById('contador');

// Funcionalidad del contador de caracteres
mensaje.addEventListener('input', function(e) {
  const target = e.target;
  const longitudMax = target.getAttribute('maxlength');
  const longitudAct = target.value.length;
  contador.innerHTML = `${longitudAct}/${longitudMax}`;
});
// Control del envío de encuesta
formulario.addEventListener("submit", (e) => {
  e.preventDefault();
});

// Captura de preguntas
function miVal() {
  const auxj = document.full_form.juzgado.value;
  const expediente = document.full_form.expediente.value;
  const juzgado = parseInt(auxj.substring(0, 2));
  const parte = parseInt(document.full_form.parte.value);
  const in1 = parseInt(document.full_form.questionOne.value);
  const in2 = parseInt(document.full_form.questionTwo.value);
  const in3 = parseInt(document.full_form.questionThree.value);
  const in4 = parseInt(document.full_form.questionFour.value);
  const in5 = parseInt(document.full_form.questionFive.value);
  const in6 = parseInt(document.full_form.questionSix.value);
  const in7 = parseInt(document.full_form.questionSeven.value);
  const in8 = document.full_form.comments.value;

  let pparte = isNaN(parte);
  let p1 = isNaN(in1);
  let p2 = isNaN(in2);
  let p3 = isNaN(in3);
  let p4 = isNaN(in4);
  let p5 = isNaN(in5);
  let p6 = isNaN(in6);
  let p7 = isNaN(in7);

  // Validación de las preguntas
  let validador = false;

  if (pparte === true) {
    document.getElementById("formulario__mensaje").classList.add("formulario__mensaje-activo");
    setTimeout(() => {
      document.getElementById("formulario__mensaje").classList.remove("formulario__mensaje-activo");
  }, 4000);
    return validador;

  } else if (p1 === true) {
    document.getElementById("formulario__mensaje").classList.add("formulario__mensaje-activo");
    setTimeout(() => {
      document.getElementById("formulario__mensaje").classList.remove("formulario__mensaje-activo");
  }, 4000);
    return validador;

  } else if (p2 === true) {
    document.getElementById("formulario__mensaje").classList.add("formulario__mensaje-activo");
    setTimeout(() => {
      document.getElementById("formulario__mensaje").classList.remove("formulario__mensaje-activo");
  }, 4000);
    return validador;

  } else if (p3 === true) {
    document.getElementById("formulario__mensaje").classList.add("formulario__mensaje-activo");
    setTimeout(() => {
      document.getElementById("formulario__mensaje").classList.remove("formulario__mensaje-activo");
  }, 4000);
    return validador;

  } else if (p4 === true) {
    document.getElementById("formulario__mensaje").classList.add("formulario__mensaje-activo");
    setTimeout(() => {
      document.getElementById("formulario__mensaje").classList.remove("formulario__mensaje-activo");
  }, 4000);
    return validador;

  } else if (p5 === true) {
    document.getElementById("formulario__mensaje").classList.add("formulario__mensaje-activo");
    setTimeout(() => {
      document.getElementById("formulario__mensaje").classList.remove("formulario__mensaje-activo");
  }, 4000);
    return validador;

  } else if (p6 === true) {
    document.getElementById("formulario__mensaje").classList.add("formulario__mensaje-activo");
    setTimeout(() => {
      document.getElementById("formulario__mensaje").classList.remove("formulario__mensaje-activo");
  }, 4000);
    return validador;

  } else if (p7 === true) {
    document.getElementById("formulario__mensaje").classList.add("formulario__mensaje-activo");
    setTimeout(() => {
      document.getElementById("formulario__mensaje").classList.remove("formulario__mensaje-activo");
  }, 4000);
    return validador;

  } else {
    AgregarEncuesta(juzgado, expediente, parte, in1, in2, in3, in4, in5, in6, in7, in8);
  }
}
// Asignación de los parámetros 
function AgregarEncuesta(juzgado, expediente, parte, in1, in2, in3, in4, in5, in6, in7, in8) {
  const parametros = {
    Juzgado: juzgado,
    Expediente: expediente,
    Parte: parte,
    P1: in1,
    P2: in2,
    P3: in3,
    P4: in4,
    P5: in5,
    P6: in6,
    P7: in7,
    Comentario: in8,
  };

  // Comunicación con back
  $.ajax({
    data: parametros,
    url: "https://encuestaoralidadcivil.poderjudicialcdmx.gob.mx:2087/Encuesta/api/CRUD_Encuesta.php",
    dataType: "json",
    type: "post",
    success: function (response) {
      document.getElementById("formulario__mensaje-exito").classList.add("formulario__mensaje-exito-activo");
      formulario.reset();
      setTimeout(() => {
      document.getElementById("formulario__mensaje-exito").classList.remove("formulario__mensaje-exito-activo");
      }, 4000);
      contador.innerHTML = `0/255`;
    },
  });
}
