$('body').on('keyup', '#buscar', function() {
    var buscarCursoAsignado = $(this).val();
    var profesor = "{{{ (Auth::user()->hasrole('profesor')) ? true : false }}}";
    var cedula = "{{{ Auth::user()->cedula }}}";
    console.log(cedula);
    $.ajax({
        method: "POST",
        url: "{{ url('profesores/buscarCursoAsignado') }}",
        dateType: "json",
        data: {
            "_token": "{{ csrf_token() }}",
            buscarCursoAsignado: buscarCursoAsignado,
            cedula: cedula,
        },
        success: function(res) {
            $("#pagination").remove();
            $('#dynamic-row').html("");
            console.log(res);
            var con = 0;
            $.each(JSON.parse(res), function(index, value) {
                con++;
                console.log(res);
                var tableRow = "<tr> <td class='col-md-auto'> " + value.id_cisco + " </td>";
                tableRow += "<td class='col-md-auto'> " + value.nombre_modulo + " </td>";
                tableRow += "<td class='col-md-auto'> " + value.nombre + " </td>";
                tableRow += "<td class='col-md-auto'> " + value.nombreper + " </td>";
                tableRow += "<td class='col-md-auto'> " + value.fecha_inicio + " </td>";
                tableRow += "<td class='col-md-auto'> " + value.fecha_fin + " </td>";
                tableRow += "<td class='col-md-auto'> " + value.nombre_certificacion + " </td>";



                var id = value.id;
                if (profesor) {
                    tableRow += `<td class="d-flex justify-content-center">
                            <form method="post" action="/materialapoyo/listmaterial" class="form">
                                @csrf
                                <input class="form-control" type="hidden" name="id" id="id" value="${id}">
                                <div class="input-group" id="submit-group" >
                                    <button type="submit" class="btn btn-success">
                                        <i class="fas fa-book"></i> Material
                                    </button>
                                </div>
                            </form> 
                            <p> ⠀ </p>

                            <a class="btn btn-info p-1" href="/profesores/${id}/cursoestudiantes"
                                style="display: inline"><i class="fas fa-users"></i> Estudiantes </a>

                        </td>`
                }
                tableRow += `</tr>`
                $('#dynamic-row').append(tableRow);
            });
            var t = document.getElementById('total');
            t.innerHTML = "Total de estudiantes: " + con;
        },
    });
});