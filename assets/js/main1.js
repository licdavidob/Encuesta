const formulario = document.getElementById('full_form');
// const inputs = document.querySelectorAll('#formulario input');




// Preguntas
function miVal() {
    const auxj       = formulario.juzgado.value;
    const expediente = formulario.expediente.value;
    const juzgado    = parseInt(auxj.substring(0,2));
    const parte      = parseInt(formulario.parte.value);
    const in1        = parseInt(formulario.questionOne.value);
    const in2        = parseInt(formulario.questionTwo.value);
    const in3        = parseInt(formulario.questionThree.value);
    const in4        = parseInt(formulario.questionFour.value);
    const in5        = parseInt(formulario.questionFive.value);
    const in6        = parseInt(formulario.questionSix.value);
    const in7        = parseInt(formulario.questionSeven.value);
    const in8        = formulario.comments.value; 

    const respuestas = [juzgado, expediente, parte, in1, in2, in3, in4, in5, in6 ,in7, in8];
    // AgregarEncuesta(juzgado, expediente, parte, in1, in2, in3, in4, in5, in6 ,in7, in8);
    console.log(respuestas);
}

// Base
// function validarCheck(){
//     let aux = formulario.questionOne;
//     for (let i = 0; i < aux.length; i++) {
//         if (aux[i].checked) {
//             console.log('Cool');
//             break
//         }
//         else {
//             console.log('Agrega tu respuesta');
//         }
        
//     }
// }

function validarCheck(){

    const parte      = formulario.parte;
    const in1        = formulario.questionOne;
    const in2        = formulario.questionTwo;
    const in3        = formulario.questionThree;
    const in4        = formulario.questionFour;
    const in5        = formulario.questionFive;
    const in6        = formulario.questionSix;
    const in7        = formulario.questionSeven;

    const respuestas = [parte, in1, in2, in3, in4, in5, in6 ,in7];
    let validar = false;

    for (let i = 0; i < respuestas.length; i++) {
        for (let j = 0; j < respuestas[i].length; j++) {
            if (!respuestas[i][j].checked) {
                validar = false;
                break
            }
            else {
                console.log('Cool');
                validar = true;
            }
        }
    }
    return validar;
}

// function holi() {
//     validarCheck();
//     if (validar) {
//         console.log('Ok');
//     }
//     else {
//         console.log('Error');
//     }
// }





formulario.addEventListener('submit', (e) => {
    e.preventDefault();
    miVal();
    formulario.reset();
    // document.getElementById('formulario__mensaje-exito').classList.add('formulario__mensaje-exito-activo');
        // setTimeout(() => {
        //     document.getElementById('formulario__mensaje-exito').classList.remove('formulario__mensaje-exito-activo');
        // }, 4000);
        document.getElementById('formulario__mensaje').classList.add('formulario__mensaje-activo');
        setTimeout(() => {
            document.getElementById('formulario__mensaje').classList.remove('formulario__mensaje-activo');
        }, 4000);

});



// function AgregarEncuesta(juzgado, parte, in1, in2, in3, in4, in5, in6 ,in7, in8) {
// var parametros = {
//     Juzgado: juzgado,
//     Expediente: expediente,
//     Parte: parte,
//     P1: in1,
//     P2: in2,
//     P3: in3,
//     P4: in4,
//     P5: in5,
//     P6: in6,
//     P7: in7,
//     Comentario: in8,

// };
// $.ajax({
//     data: parametros,
//     url: "/api/CRUD_Encuesta.php",
//     dataType: "json",
//     type: "post",
//     beforeSend: function () {
//     console.log(parametros);
//     },
//     success: function (response) {
//     console.log(response);
//     alert('Todo ok')
//     },
//     error: (e) => {
//         console.log(e.error);
//     }
// });
// }