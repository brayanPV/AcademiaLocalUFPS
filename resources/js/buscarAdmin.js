$('body').on('keyup', '#buscar', function() {
    var buscarAdmin = $(this).val();
    console.log(buscarAdmin);
    $.ajax({
        method: "POST",
        url: "{{ url('administradores/buscarAdmin') }}",
        dateType: "json",
        data: {
            "_token": "{{ csrf_token() }}",
            buscarAdmin: buscarAdmin,
        },
        success: function(res) {
            console.log(res);
            $('#dynamic-row').html("");
            var con = 0;
            $.each(JSON.parse(res), function(index, value) {
                con++;
                var tableRow = "<tr> <td class='col-md-auto'> " + value.cedula +
                    " </td>"
                tableRow += "<td class='col-md-auto'>" + value.nombre + " </td>";
                tableRow += "<td class='col-md-auto'>" + value.correo + " </td>";
                tableRow += "<td class='col-md-auto'>" + value.telfijo + " </td>";
                tableRow += "<td class='col-md-auto'>" + value.telcel + " </td>";
                tableRow += "<td class='col-md-auto'>" + value.direccion + "</td>";
                var link = value.id;
                console.log(link);
                tableRow += `<td class="d-flex"><a href="/administradores/${link}/edit " class="btn btn-primary" id="editar" role="button">
                        <i class="fas fa-user-edit"></i></a>`
                tableRow += `<p> ⠀ </p>
                        <form action="/administradores/${link}" method = "post">
                        @csrf
                        @method('DELETE') <button type = "submit" class = "btn btn-danger" onclick =
                        'return confirm("¿Esta seguro que desea eliminar este administrador?");' >
                        <i class = "fas fa-user-times"> </i> </button > </form> </td > </tr>`;
                $('#dynamic-row').append(tableRow);
            });
            var t = document.getElementById('total');
            t.innerHTML = "Total de administradores: " + con;
        },
    });
});