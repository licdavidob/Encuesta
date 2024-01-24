// const PREGUNTAS = [
//   {pregunta: '¿La Jueza o Juez utilizó un lenguaje claro y entendible?'},
//   {pregunta: '¿La Jueza o Juez explicó el motivo de la audiencia?'},
//   {pregunta: '¿La Jueza o Juez, durante la audiencia, se comunicó en forma directa y constante con usted?'},
//   {pregunta: '¿La Jueza o Juez le permitió hablar, si usted pidió el uso de la palabra?'},
//   {pregunta: '¿Por parte de la Jueza o Juez, recibió usted el mismo trato que su contrarío?'},
//   {pregunta:'¿La Jueza o Juez le preguntarón si quería hacer uso de la palabra?'},
//   {pregunta:'¿Usted entendió y comprendió lo sucedido en la audiencia?'}
//   ];
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
      url: consultarPanel,
      data: function (d) {
        // d.Fecha_Inicio = Fecha_Inicio;
        // d.Fecha_Fin = Dia_Actual;
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
        defaultContent: `
          <div class ='row'>
          <button type="button" class='consultar'>
          <i class='fa-solid fa-circle-info'></i>
          </button>
          `,
      },
    ],
  });
  // Búsquedas personalizadas
  $(".filter-select").change(function () {
    table
      .column($(this).data("column"))
      .search(`"${$(this).val()}"`)
      .draw();
  });
  return table;
}

// Gráfica pastel (Chart) Top 10
function grafica_top_juzgados(id, data, type = "doughnut") {
  let nombres = Object.keys(data);
  let numeros = Object.values(data);

  let chart_top_juzgados = new Chart(id, {
    type: type,
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
          borderWidth: 5,
          // cutout: '40%',
          // borderRadius:20,
          offset: 5,
        },
      ],
    },
    options: {
      plugins: {
        legend: {
          position: "bottom",
          labels: {
            usePointStyle: true,
            // font: {
            //   size: 10
            // }
          },
        },
      },
      maintainAspectRatio: false,
    },
  });
  return chart_top_juzgados;
}
function grafica_general(id, data, type = "bar") {
  let pSi = Object.keys(data["Si"]);
  let valSi = Object.values(data["Si"]);
  // let pNo = Object.keys(data['No']);
  let valNo = Object.values(data["No"]);

  // let titleTooltip = 'test';

  //
  // const PREGUNTAS = [
  //   '¿La Jueza o Juez utilizó un lenguaje claro y entendible?',
  //   '¿La Jueza o Juez explicó el motivo de la audiencia?',
  //   '¿La Jueza o Juez, durante la audiencia, se comunicó en forma directa y constante con usted?',
  //   '¿La Jueza o Juez le permitió hablar, si usted pidió el uso de la palabra?',
  //   '¿Por parte de la Jueza o Juez, recibió usted el mismo trato que su contrarío?',
  //   '¿La Jueza o Juez le preguntarón si quería hacer uso de la palabra?',
  //   '¿Usted entendió y comprendió lo sucedido en la audiencia?'
  // ];
  //
  // const titleTooltip = PREGUNTAS.map(({pregunta}) => pregunta);
  const PREGUNTAS = {
    P1: "¿La Jueza o Juez utilizó un lenguaje claro y entendible?",
    P2: "¿La Jueza o Juez explicó el motivo de la audiencia?",
    P3: "¿La Jueza o Juez, durante la audiencia, se comunicó en forma directa y constante con usted?",
    P4: "¿La Jueza o Juez le permitió hablar, si usted pidió el uso de la palabra?",
    P5: "¿Por parte de la Jueza o Juez, recibió usted el mismo trato que su contrarío?",
    P6: "¿La Jueza o Juez le preguntarón si quería hacer uso de la palabra?",
    P7: "¿Usted entendió y comprendió lo sucedido en la audiencia?",
  };
  // console.log(a);

  const titleTooltip = (item) => {
    // let b = item;
    // console.log(b);
    let a = `${item[0]["label"]}`;
    // console.log(a);
    // console.log( typeof a);
    // console.log(PREGUNTAS[a]);
    return PREGUNTAS[a];
    // item.forEach(i => {
    //   console.log(item[0]['label']=PREGUNTAS[i]);
    //   return item[0]['label'] = PREGUNTAS[i];
    // });
    // return item[0]['label'];
  };

  let chart_bar = new Chart(id, {
    type: type,
    data: {
      // labels: PREGUNTAS,
      labels: pSi,
      // labels: ['P1','P2','P3','P4','P5','P6','P7'],
      datasets: [
        {
          label: "Preguntas con si",
          data: valSi,
          // data: [11,24,45,12,10,130,1],
          backgroundColor: [
            "#ADB4C4",
            "#F17455",
            "#F1F1CF",
            "#324833",
            "#0F4B49",
            "#366A68",
            "#8DBBBA",
          ],
          // order:1,
          // borderWidth:5,
          // cutout: '40%',
          // borderRadius:20,
          // offset:5,
        },
        {
          label: "Preguntas con no",
          data: valNo,
          borderColor: "#9292E7",
          // data: [11,24,45,12,10,130,1],
          backgroundColor: [
            "#101919",
            "#224443",
            "#115552",
            "#27B9B4",
            "#66E1DD",
            "#67A2A2",
            "#7EB4B2",
          ],
          // borderWidth:5,
          // cutout: '40%',
          // borderRadius:20,
          // offset:5,
        },
      ],
    },
    //
    options: {
      sccales: {
        y: {
          beginAtZero: true,
        },
      },
      plugins: {
        tooltip: {
          // yAlign:'bottom',
          displayColors: false,
          callbacks: {
            title: titleTooltip,
          },
        },
        legend: {
          position: "top",
          labels: {
            usePointStyle: true,
            // font: {
            //   size: 10
            // }
          },
        },
      },
      maintainAspectRatio: false,
    },
  });
  return chart_bar;
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
    let estadistica = data["Estadistica"];
    let general = estadistica["Top_Juzgados"];
    let idTop = $("#Chart_Top10");
    globalThis.objeto_grafica_top_juzgado = grafica_top_juzgados(
      idTop,
      general
    );
    // Tabla Yes
    let idYes = $("#Chart_Yes");
    let datosPreguntas = data["Estadistica"];
    let pregunta = datosPreguntas["Preguntas"];
    // let preguntaSi = pregunta["Si"];
    globalThis.objeto_grafica_top_juzgado = grafica_general(
      idYes,
      pregunta,
      "bar"
    );
    // // Tabla No
    // let idNo = $("#Chart_No");
    // globalThis.objeto_grafica_top_juzgado = grafica_general(
    //   idNo,
    //   pregunta,
    //   'bar'
    //   );
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
      url: consultarPanel,
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
