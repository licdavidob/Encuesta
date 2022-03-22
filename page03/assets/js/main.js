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

    const respuestas = [juzgado, parte, in1, in2, in3, in4, in5, in6 ,in7, in8];

}

function AgregarCJP(juzgado, parte, in1, in2, in3, in4, in5, in6 ,in7, in8) {
var parametros = {
    Juzgado: juzgado,
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
$.ajax({
    data: parametros,
    url: "..",
    dataType: "json",
    type: "post",
    beforeSend: function () {
    console.log(parametros);
    },
    success: function (response) {
    if (response.Bandera == false) {
        alert(response.Mensaje);
    } else {
        var table = $("#tabla").DataTable();
        table.ajax.reload(null, false);
        $("#Modal_Agregar").modal("hide");
        LimpiarModal();
    }
    },
});
}