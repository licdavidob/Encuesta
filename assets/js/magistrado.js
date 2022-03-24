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
    ajax: {
      url: "http://172.19.40.90/api/CRUD_Encuesta.php",
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
      { targets: 0, width: "10%" },
      { targets: 1, width: "20%" },
      { targets: 2, width: "20%" },
      { targets: 3, width: "20%" },
      { targets: 4, width: "20%" },
      {
        targets: 5, //Celda Acciones
        width: "10%",
        data: null,
        defaultContent:
          `<div class ='row'> <button class='btn btn-outline-primary text-center'><i class='fa-solid fa-circle-info'></i></i></button><div/>`,
      },
    ],
  });
  return table;
}

function Datos(table) {
  table.on("xhr", function () {
    //Todos los datos recibidos en mi AJAX, se encuentran en esta variable "data"
    var data = table.ajax.json();

    $("#Tarjeta_Total_Encuestas").html(data["Total_Encuestas"]);
    $("#Tarjeta_Total_Actor").html(data["Total_Actor"]);
    $("#Tarjeta_Total_Demandado").html(data["Total_Demandado"]);
    $("#Tarjeta_Total_Otro").html(data["Total_Otro"]);

  });
}




