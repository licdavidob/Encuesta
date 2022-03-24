const formulario = document.getElementById("full_form");
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

  // const respuestas = [
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
  //   in8,
  // ];
  // console.log(respuestas);
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
    url: "http://172.19.40.90/api/CRUD_Encuesta.php",
    dataType: "json",
    type: "post",
    beforeSend: function () {
      console.log(parametros);
    },
    success: function (response) {
      console.log(response.Bandera);
      if (response.Bandera == false) {
        document
          .getElementById("formulario__mensaje")
          .classList.add("formulario__mensaje-activo");
      } else {
        document
          .getElementById("formulario__mensaje-exito")
          .classList.add("formulario__mensaje-exito-activo");
        formulario.reset();
        setTimeout(() => {
          document
            .getElementById("formulario__mensaje-exito")
            .classList.remove("formulario__mensaje-exito-activo");
        }, 4000);
      }
    },
  });
}
