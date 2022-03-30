const URLAPI = "https://encuestaoralidadcivil.poderjudicialcdmx.gob.mx:2087/Encuesta/api/CRUD_Encuesta.php";
function Iniciar() {
  let Dia_Actual = moment().startOf("day").format("YYYY-MM-DD");
  let Fecha_Inicio = "2022-01-01";
  let Tabla = DataTable(Fecha_Inicio, Dia_Actual);
  Datos(Tabla);
}

function DataTable(Fecha_Inicio, Dia_Actual) {
  let table = $("#tabla").DataTable({
    language: {
      url: "//cdn.datatables.net/plug-ins/1.10.11/i18n/Spanish.json",
    },
    select: true,
    ajax: {
      url: URLAPI,
      data: function (d) {
        d.Fecha_Inicio = Fecha_Inicio;
        d.Fecha_Fin = Dia_Actual;
      },
      type: "get",
    },
    columns: [
      { data: "ID_Encuesta" },
      { data: "Juzgado" },
      { data: "Expediente" },
      {
        data: "Parte",
        render: function (data, type, row) {
          if (data == 1) {
            data = "Actor";
            return data;
          }
          if (data == 2) {
            data = "Demandado";
            return data;
          } else {
            data = "Otro";
            return data;
          }
        },
      },
      {
        data: "Fecha",
        render: function (data, type, row) {
          var data = moment(data).format("DD-MM-YYYY");
          return data;
        },
      },
    ],
    pagingType: "simple",
    createdRow: function (row, data) {
      $(row).addClass("text-center");
    },
    columnDefs: [
      { targets: 0, width: "10%", visible: false },
      { targets: 1, width: "20%" },
      { targets: 2, width: "20%" },
      { targets: 3, width: "20%" },
      { targets: 4, width: "20%" },
      {
        targets: 5, //Celda Acciones
        width: "10%",
        data: null,
        defaultContent:
          `
          <div class ='row'>
          <button type="button" class='consultar'>
          <i class='fa-solid fa-circle-info'></i>
          </button>
          `,
      },
    ],
  });
  // Búsquedas personalizadas 
  $('.filter-select').change(function () {
    table.column($(this).data('column'))
    .search(`"${$(this).val()}"`)
    .draw();
  })
  return table;
}
// Gráfica pastel (Chart) Top 10
function grafica_top_juzgados(id, data) {
  let nombres = Object.keys(data);
  let numeros = Object.values(data);

  let chart_top_juzgados = new Chart(id, {
    type: "doughnut",
    data: {
      labels: nombres,
      datasets: [
        {
          data: numeros,
          backgroundColor: [
            "#92BCE7",
            "#9292E7",
            "#E7BC92",
            "#E7E792",
            "#BCE792",
          ],
        },
      ],
    },
    options: {
      legend: {
        position: "center",
      },
      maintainAspectRatio: false,
    },
  });
  return chart_top_juzgados;
}
function Datos(table) {
  // Modal
  modalEncuesta("#tabla", table);
  table.on("xhr", function () {
    //Todos los datos recibidos en mi AJAX, se encuentran en esta variable "data"
    let data = table.ajax.json();
    // Datos de tarjetas
    $("#Tarjeta_Total_Encuestas").html(data["Total_Encuestas"]);
    $("#Tarjeta_Total_Actor").html(data["Total_Actor"]);
    $("#Tarjeta_Total_Demandado").html(data["Total_Demandado"]);
    $("#Tarjeta_Total_Otro").html(data["Total_Otro"]);

    // Datos gráfica
    let general = data["Top_10"];
    let idTopDiez = $("#Chart_Top10");
    globalThis.objeto_grafica_top_juzgado = grafica_top_juzgados(
      idTopDiez,
      general
    );
  });
}

function modalEncuesta(tbody, table) {
  $(tbody).on("click", "button.consultar", function () {
    var data = table.row($(this).parents("tr")).data();

    const parametros = {
      Encuesta: data["ID_Encuesta"],
    };

    $.ajax({
      data: parametros,
      url: URLAPI,
      dataType: "json",
      type: "get",
      success: function (response) {
        encuestabyId(response);
        $("#info").modal("show");
      },
    });
  });
}

function encuestabyId(datos) {

  $("#juzgado").html(datos["Juzgado"]);
  $("#expediente").html(datos["Expediente"]);
  let parte = "";
  if (datos["Parte"] === "1") {
    parte = "Actor";
  } else if (datos["Parte"] === "2") {
    parte = "Demandado";
  } else {
    parte = "Otros";
  }
  $("#parte").html(parte);

  let p1 = asignarPregunta(datos["P1"]);
  $("#p1").html(p1);
  let p2 = asignarPregunta(datos["P2"]);
  $("#p2").html(p2);
  let p3 = asignarPregunta(datos["P3"]);
  $("#p3").html(p3);
  let p4 = asignarPregunta(datos["P4"]);
  $("#p4").html(p4);
  let p5 = asignarPregunta(datos["P5"]);
  $("#p5").html(p5);
  let p6 = asignarPregunta(datos["P6"]);
  $("#p6").html(p6);
  let p7 = asignarPregunta(datos["P7"]);
  $("#p7").html(p7);
  $("#comentario").html(datos["P8"]);
}
function asignarPregunta(respuesta) {
  if (respuesta === "1") {
    return "Si";
  } else {
    return "No";
  }
}
