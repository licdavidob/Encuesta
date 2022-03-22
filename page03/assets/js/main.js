// Preguntas
function miVal() {
    const auxj    = document.full_form.juzgado.value;
    const juzgado = parseInt(auxj.substring(0,2));
    const parte   = parseInt(document.full_form.parte.value);
    const in1     = parseInt(document.full_form.questionOne.value);
    const in2     = parseInt(document.full_form.questionTwo.value);
    const in3     = parseInt(document.full_form.questionThree.value);
    const in4     = parseInt(document.full_form.questionFour.value);
    const in5     = parseInt(document.full_form.questionFive.value);
    const in6     = parseInt(document.full_form.questionSix.value);
    const in7     = parseInt(document.full_form.questionSeven.value);
    const in8     = document.full_form.comments.value; 

    // if (document.full_form.checked === true) {
    //     console.log("revisa tus datos");
    // }
    // else {
    //     console.log("todo ok");
    //     // const respuestas = [juzgado, parte, in1, in2, in3, in4, in5, in6 ,in7, in8];
    // }
    const respuestas = [juzgado, parte, in1, in2, in3, in4, in5, in6 ,in7, in8];






    // for (let i = 0; i < respuestas.length; i++) {

    //     console.log(`Respuesta[${i}]: ${respuestas[i]}`);
    //     // if (isNaN(respuestas)=== false) {
    //     //     console.log("todo ok");
    //     // } else {
    //     //     console.log("alto ahí loca");
    //     //     break;
    //     // }

    // }
}