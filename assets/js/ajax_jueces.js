function Iniciar() {
  var FechaInicioAño = moment().startOf("year").format("YYYY-MM-DD");
  var FechaActual = moment().format("YYYY-MM-DD");
  $("#fecha_inicio").val(FechaInicioAño);
  $("#fecha_fin").val(FechaActual);
  LimpiarModal();
  var table = DataTable();
  Datos(table);
}

function ConsultarDatos() {
  var table = $("#tabla").DataTable();
  var data = table.ajax.reload();
  destruir_gráficas();
}

function DataTable() {
  var table = $("#tabla").DataTable({
    language: {
      url: "//cdn.datatables.net/plug-ins/1.10.11/i18n/Spanish.json",
    },
    ajax: {
      url: "../api/CRUD_Juez.php",
      data: function (d) {
        d.peticion = "Consultar";
        d.fecha_inicio = $("#fecha_inicio").val();
        d.fecha_fin = $("#fecha_fin").val();
      },
      type: "post",
    },
    columns: [
      { data: "ID" },
      { data: "Total" },
      { data: "Genero" },
      {
        data: "Administrativo",
        render: function (data, type, row) {
          if (data == 1) {
            data = "Si";
            return data;
          } else {
            data = "No";
            return data;
          }
        },
      },
      {
        data: "Control",
        render: function (data, type, row) {
          if (data == 1) {
            data = "Si";
            return data;
          } else {
            data = "No";
            return data;
          }
        },
      },
      {
        data: "Enjuiciamiento",
        render: function (data, type, row) {
          if (data == 1) {
            data = "Si";
            return data;
          } else {
            data = "No";
            return data;
          }
        },
      },
      {
        data: "Ejecucion",
        render: function (data, type, row) {
          if (data == 1) {
            data = "Si";
            return data;
          } else {
            data = "No";
            return data;
          }
        },
      },
      {
        data: "Fecha",
        render: function (data, type, row) {
          //Formato a la hora
          var data = moment(data).format("DD-MM-YYYY");
          return data;
        },
      },
      { data: "Estado" },
    ],
    pagingType: "simple",
    createdRow: function (row, data) {
      $(row).attr("id", data["id"]);
      $(row).addClass("text-center");
    },
    columnDefs: [
      {
        targets: 0, //Celda ID
        visible: false,
        searchable: false,
        createdCell: function (td, cellData, rowData, row, col) {
          $(td).attr("id", rowData["ID"]);
        },
      },
      {
        targets: 1, //Celda Cantidad
        width: "12.5%",
      },
      {
        targets: 2, //Celda Genero
        width: "12.5%",
      },
      {
        targets: 3, //Celda Admin
        width: "12.5%",
      },
      {
        targets: 4, //Celda Control
        width: "12.5%",
      },
      {
        targets: 5, //Celda Enjuiciamiento
        width: "12.5%",
      },
      {
        targets: 6, //Celda Ejecución
        width: "12.5%",
      },
      {
        targets: 7, //Celda Fecha
        width: "12.5%",
      },
      {
        targets: 8, //Celda Estado
        width: "12.5%",
      },
    ],
  });

  return table;
}

function Datos(table) {
  table.on("xhr", function () {
    //Todos los datos recibidos en mi AJAX, se encuentran en esta variable "data"
    var data = table.ajax.json();

    var general = data["total_general"];
    $("#tarjeta_total_jueces").html(general["Total_Indefinido"]);
    $("#tarjeta_total_hombres").html(general["Total_Masculino"]);
    $("#tarjeta_total_mujeres").html(general["Total_Femenino"]);

    var JuecesCompetencia = $("#chart_total_jueces_competencia");
    var Total_Jueces_Competencia = data["total_competencia"];
    //Con esto creo un objeto al que puedo acceder de forma global
    //Lo necesito para que al momento de modificar la información, se actualicen las gráficas
    globalThis.objeto_grafica_jueces_competencia = grafica_jueces_competencia(
      JuecesCompetencia,
      Total_Jueces_Competencia
    );

    var JuecesCompetencia = $("#chart_total_jueces");
    globalThis.objeto_grafica_jueces_genero = grafica_jueces_genero(
      JuecesCompetencia,
      general
    );

    var Jueces_Administracion = $("#chart_Jueces_de_Administracion");
    var Jueces_Control = $("#chart_Jueces_de_Control");
    var Jueces_Enjuiciamiento = $("#chart_Jueces_de_Enjuiciamiento");
    var Jueces_Ejecucion = $("#chart_Jueces_de_Ejecucion");
    var Total_Jueces_Competencia = data["total_competencia_genero"];

    globalThis.objeto_grafica_administracion = grafica_administracion(
      Jueces_Administracion,
      Total_Jueces_Competencia
    );
    globalThis.objeto_grafica_control = grafica_control(
      Jueces_Control,
      Total_Jueces_Competencia
    );
    globalThis.objeto_grafica_enjuiciamiento = grafica_enjuiciamiento(
      Jueces_Enjuiciamiento,
      Total_Jueces_Competencia
    );
    globalThis.objeto_grafica_ejecucion = grafica_ejecucion(
      Jueces_Ejecucion,
      Total_Jueces_Competencia
    );
  });
}

function grafica_jueces_competencia(id, data) {
  var chart_jueces_competencia = new Chart(id, {
    type: "horizontalBar",
    data: {
      labels: ["Administracion", "Control", "Enjuiciamiento", "Ejecucion"],
      datasets: [
        {
          label: [""],
          data: [
            data["Total_Jueces_Administrativo"],
            data["Total_Jueces_Control"],
            data["Total_Jueces_Enjuiciamiento"],
            data["Total_Jueces_Ejecucion"],
          ],
          backgroundColor: [
            "rgba(255, 99, 132, 0.6)",
            "rgba(54, 162, 235, 0.6)",
            "rgba(255, 206, 86, 0.6)",
            "rgba(75, 192, 192, 0.6)",
          ],
        },
      ],
    },
    options: {
      maintainAspectRatio: false,
      scales: {
        yAxes: [
          {
            ticks: {
              min: 0,
            },
          },
        ],
        xAxes: [
          {
            ticks: {
              min: 0,
            },
          },
        ],
      },
    },
  });

  return chart_jueces_competencia;
}

function grafica_jueces_genero(id, data) {
  var chart_jueces_genero = new Chart(id, {
    type: "doughnut",
    data: {
      labels: ["Hombre", "Mujer", "Indefinido"],
      datasets: [
        {
          label: "Population",
          data: [
            data["Total_Masculino"],
            data["Total_Femenino"],
            data["Total_Indefinido"],
          ],
          backgroundColor: [
            "rgba(54, 162, 235, 0.6)",
            "rgba(255, 99, 132, 0.6)",
            "rgba(75, 192, 192, 0.6)",
          ],
        },
      ],
    },
    options: {
      maintainAspectRatio: false,
    },
  });
  return chart_jueces_genero;
}

function grafica_administracion(id, data) {
  var chart_administracion = new Chart(id, {
    type: "doughnut",
    data: {
      labels: ["Hombre", "Mujer", "Indefinido"],
      datasets: [
        {
          label: "Population",
          data: [
            data["Total_Jueces_Administrativo_Masculino"],
            data["Total_Jueces_Administrativo_Femenino"],
            data["Total_Jueces_Administrativo_Indefinido"],
          ],
          backgroundColor: [
            "rgba(54, 162, 235, 0.6)",
            "rgba(255, 99, 132, 0.6)",
            "rgba(75, 192, 192, 0.6)",
          ],
        },
      ],
    },
    options: {
      maintainAspectRatio: false,
    },
  });
  return chart_administracion;
}

function grafica_control(id, data) {
  var chart_control = new Chart(id, {
    type: "doughnut",
    data: {
      labels: ["Hombre", "Mujer", "Indefinido"],
      datasets: [
        {
          label: "Population",
          data: [
            data["Total_Jueces_Control_Masculino"],
            data["Total_Jueces_Control_Femenino"],
            data["Total_Jueces_Control_Indefinido"],
          ],
          backgroundColor: [
            "rgba(54, 162, 235, 0.6)",
            "rgba(255, 99, 132, 0.6)",
            "rgba(75, 192, 192, 0.6)",
          ],
        },
      ],
    },
    options: {
      maintainAspectRatio: false,
    },
  });
  return chart_control;
}

function grafica_enjuiciamiento(id, data) {
  var chart_enjuiciamiento = new Chart(id, {
    type: "doughnut",
    data: {
      labels: ["Hombre", "Mujer", "Indefinido"],
      datasets: [
        {
          label: "Population",
          data: [
            data["Total_Jueces_Enjuiciamiento_Masculino"],
            data["Total_Jueces_Enjuiciamiento_Femenino"],
            data["Total_Jueces_Enjuiciamiento_Indefinido"],
          ],
          backgroundColor: [
            "rgba(54, 162, 235, 0.6)",
            "rgba(255, 99, 132, 0.6)",
            "rgba(75, 192, 192, 0.6)",
          ],
        },
      ],
    },
    options: {
      maintainAspectRatio: false,
    },
  });
  return chart_enjuiciamiento;
}

function grafica_ejecucion(id, data) {
  var chart_ejecucion = new Chart(id, {
    type: "doughnut",
    data: {
      labels: ["Hombre", "Mujer", "Indefinido"],
      datasets: [
        {
          label: "Population",
          data: [
            data["Total_Jueces_Ejecucion_Masculino"],
            data["Total_Jueces_Ejecucion_Femenino"],
            data["Total_Jueces_Ejecucion_Indefinido"],
          ],
          backgroundColor: [
            "rgba(54, 162, 235, 0.6)",
            "rgba(255, 99, 132, 0.6)",
            "rgba(75, 192, 192, 0.6)",
          ],
        },
      ],
    },
    options: {
      maintainAspectRatio: false,
    },
  });
  return chart_ejecucion;
}

function destruir_gráficas() {
  objeto_grafica_jueces_competencia.destroy();
  objeto_grafica_jueces_genero.destroy();
  objeto_grafica_administracion.destroy();
  objeto_grafica_control.destroy();
  objeto_grafica_enjuiciamiento.destroy();
  objeto_grafica_ejecucion.destroy();
}

function AgregarJuez(Total, Genero, Estado, Fecha) {
  var AgregarAdministrativo = document.getElementById(
    "AgregarAdministrativo"
  ).checked;
  var AgregarControl = document.getElementById("AgregarControl").checked;
  var AgregarEnjuiciamiento = document.getElementById(
    "AgregarEnjuiciamiento"
  ).checked;
  var AgregarEjecucion = document.getElementById("AgregarEjecucion").checked;

  if (AgregarAdministrativo) {
    var AgregarAdministrativo = 1;
  } else {
    var AgregarAdministrativo = 0;
  }
  if (AgregarControl) {
    var AgregarControl = 1;
  } else {
    var AgregarControl = 0;
  }
  if (AgregarEnjuiciamiento) {
    var AgregarEnjuiciamiento = 1;
  } else {
    var AgregarEnjuiciamiento = 0;
  }
  if (AgregarEjecucion) {
    var AgregarEjecucion = 1;
  } else {
    var AgregarEjecucion = 0;
  }

  var parametros = {
    peticion: "Agregar",
    total: Total,
    genero: Genero,
    administrativo: AgregarAdministrativo,
    control: AgregarControl,
    enjuiciamiento: AgregarEnjuiciamiento,
    ejecucion: AgregarEjecucion,
    estado: Estado,
    fecha: Fecha,
  };

  $.ajax({
    data: parametros,
    url: "../api/CRUD_JUEZ.php",
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
        destruir_gráficas();
      }
    },
  });
}

function EliminarJuez(Total, Genero, Estado, Fecha) {
  var EliminarAdministrativo = document.getElementById(
    "EliminarAdministrativo"
  ).checked;
  var EliminarControl = document.getElementById("EliminarControl").checked;
  var EliminarEnjuiciamiento = document.getElementById(
    "EliminarEnjuiciamiento"
  ).checked;
  var EliminarEjecucion = document.getElementById("EliminarEjecucion").checked;

  if (EliminarAdministrativo) {
    var EliminarAdministrativo = 1;
  } else {
    var EliminarAdministrativo = 0;
  }
  if (EliminarControl) {
    var EliminarControl = 1;
  } else {
    var EliminarControl = 0;
  }
  if (EliminarEnjuiciamiento) {
    var EliminarEnjuiciamiento = 1;
  } else {
    var EliminarEnjuiciamiento = 0;
  }
  if (EliminarEjecucion) {
    var EliminarEjecucion = 1;
  } else {
    var EliminarEjecucion = 0;
  }

  var parametros = {
    peticion: "Eliminar",
    total: Total,
    genero: Genero,
    administrativo: EliminarAdministrativo,
    control: EliminarControl,
    enjuiciamiento: EliminarEnjuiciamiento,
    ejecucion: EliminarEjecucion,
    estado: Estado,
    fecha: Fecha,
  };

  $.ajax({
    data: parametros,
    url: "../api/CRUD_JUEZ.php",
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
        $("#Modal_Eliminar").modal("hide");
        LimpiarModal();
        destruir_gráficas();
      }
    },
  });
}

function LimpiarModal() {
  $("#Modal_Agregar").find("input,textarea").val("");
  $("#Modal_Eliminar").find("input,textarea").val("");

  document.getElementById("AgregarAdministrativo").checked = 0;
  document.getElementById("AgregarControl").checked = 0;
  document.getElementById("AgregarEnjuiciamiento").checked = 0;
  document.getElementById("AgregarEjecucion").checked = 0;

  document.getElementById("EliminarAdministrativo").checked = 0;
  document.getElementById("EliminarControl").checked = 0;
  document.getElementById("EliminarEnjuiciamiento").checked = 0;
  document.getElementById("EliminarEjecucion").checked = 0;

  $("#Modal_Agregar").find("#AgregarGenero").val("Seleccione Género");
  $("#Modal_Agregar").find("#AgregarEstado").val("Seleccione un Estado");

  $("#Modal_Eliminar").find("#EliminarGenero").val("Seleccione Género");
  $("#Modal_Eliminar").find("#EliminarEstado").val("Seleccione un Estado");

  var FechaActual = moment().format("YYYY-MM-DD");
  $("#Agregar_Fecha").val(FechaActual);
  $("#EliminarFecha").val(FechaActual);
}
