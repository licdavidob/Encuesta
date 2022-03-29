const formulario = document.getElementById("full_form");
const mensaje = document.getElementById('comment');
const contador = document.getElementById('contador');

mensaje.addEventListener('input', function(e) {
  const target = e.target;
  const longitudMax = target.getAttribute('maxlength');
  const longitudAct = target.value.length;
  contador.innerHTML = `${longitudAct}/${longitudMax}`;
});

// Preguntas
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

  let validador = false;
  if (pparte === true) {
    console.log("Falta definir la parte");
    document.getElementById("formulario__mensaje").classList.add("formulario__mensaje-activo");
  setTimeout(() => {
    document.getElementById("formulario__mensaje").classList.remove("formulario__mensaje-activo");
  }, 4000);
    return validador;
  } else if (p1 === true) {
    console.log("Falta definir la pregunta 1");
    document.getElementById("formulario__mensaje").classList.add("formulario__mensaje-activo");
  setTimeout(() => {
    document.getElementById("formulario__mensaje").classList.remove("formulario__mensaje-activo");
  }, 4000);
    return validador;
  } else if (p2 === true) {
    console.log("Falta definir la pregunta 2");
    document.getElementById("formulario__mensaje").classList.add("formulario__mensaje-activo");
  setTimeout(() => {
    document.getElementById("formulario__mensaje").classList.remove("formulario__mensaje-activo");
  }, 4000);

    return validador;
  } else if (p3 === true) {
    console.log("Falta definir la pregunta 3");
    document.getElementById("formulario__mensaje").classList.add("formulario__mensaje-activo");
  setTimeout(() => {
    document.getElementById("formulario__mensaje").classList.remove("formulario__mensaje-activo");
  }, 4000);

    return validador;
  } else if (p4 === true) {
    console.log("Falta definir la pregunta 4");
    document.getElementById("formulario__mensaje").classList.add("formulario__mensaje-activo");
  setTimeout(() => {
    document.getElementById("formulario__mensaje").classList.remove("formulario__mensaje-activo");
  }, 4000);

    return validador;
  } else if (p5 === true) {
    console.log("Falta definir la pregunta 5");
    document.getElementById("formulario__mensaje").classList.add("formulario__mensaje-activo");
  setTimeout(() => {
    document.getElementById("formulario__mensaje").classList.remove("formulario__mensaje-activo");
  }, 4000);

    return validador;
  } else if (p6 === true) {
    console.log("Falta definir la pregunta 6");
    document.getElementById("formulario__mensaje").classList.add("formulario__mensaje-activo");
  setTimeout(() => {
    document.getElementById("formulario__mensaje").classList.remove("formulario__mensaje-activo");
  }, 4000);

    return validador;
  } else if (p7 === true) {
    console.log("Falta definir la pregunta 7");
    document.getElementById("formulario__mensaje").classList.add("formulario__mensaje-activo");
  setTimeout(() => {
    document.getElementById("formulario__mensaje").classList.remove("formulario__mensaje-activo");
  }, 4000);

    return validador;
  } else {
    console.log("All ok");
    AgregarEncuesta(
      juzgado,
      expediente,
      parte,
      in1,
      in2,
      in3,
      in4,
      in5,
      in6,
      in7,
      in8
    );
  }

  // AgregarEncuesta(
  //   juzgado,
  //   expediente,
  //   parte,
  //   in1,
  //   in2,
  //   in3,
  //   in4,
  //   in5,
  //   in6,
  //   in7,
  //   in8
  // );
  // return validador
}
function AgregarEncuesta(
  juzgado,
  expediente,
  parte,
  in1,
  in2,
  in3,
  in4,
  in5,
  in6,
  in7,
  in8
) {
  // function AgregarEncuesta() {
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

  formulario.addEventListener("submit", (e) => {
    e.preventDefault();
  });

  $.ajax({
    data: parametros,
    url: "http://172.19.202.101:9090/Encuesta/api/CRUD_Encuesta.php",
    dataType: "json",
    type: "post",
    success: function (response) {

      console.log(response.Bandera);
      document.getElementById("formulario__mensaje-exito").classList.add("formulario__mensaje-exito-activo");
      formulario.reset();
      setTimeout(() => {
      document.getElementById("formulario__mensaje-exito").classList.remove("formulario__mensaje-exito-activo");
      }, 4000);
      // if (response.Bandera === false) {
      //   console.log(response.Mensaje);
      //   document
      //     .getElementById("formulario__mensaje")
      //     .classList.add("formulario__mensaje-activo");
      //   setTimeout(() => {
      //     document
      //       .getElementById("formulario__mensaje")
      //       .classList.remove("formulario__mensaje-activo");
      //   }, 4000);
      // } else {
      //   document
      //     .getElementById("formulario__mensaje-exito")
      //     .classList.add("formulario__mensaje-exito-activo");
      //   formulario.reset();
      //   setTimeout(() => {
      //     document
      //       .getElementById("formulario__mensaje-exito")
      //       .classList.remove("formulario__mensaje-exito-activo");
      //   }, 4000);
      // }
    },
  });
}
