var usuario_global;
var divisao;
var tabela_dados;
$(document).ready(function(){

    $('#operation').val("Add");
    divisao = sessionStorage.getItem("divisao");
    usuario_global = sessionStorage.getItem("usuario_global");
    // econstroi uma datatabe no primeiro carregamento da tela
    tabela_dados = $('#tabela_dados').DataTable({
        "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "todos"]],
        "processing": false,
        "bServerSide": false,
        "responsive": true,
        "autoWidth": true,
        "bJQueryUI": true,
        "bAutoWidth": false,
        "ajax": {
            "url": 'pages/categoria_convenio/datatable.php',
            "method": 'POST',
            "data":  '',
            "dataType": 'json'
        },
        "order": [[ 0, "asc" ]],
        "columns": [
            { "data": "codigo" },
            { "data": "nome" },
            { "data": "botao" },
        ],
        "language": {
            url: "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Portuguese-Brasil.json",
            "decimal": ",",
            "thousands": "."
        },
        "pagingType": "full_numbers"
    });
});
$(document).on('click','.update',function () {
    debugger;
    $("#C_codigo").prop( "disabled", true );
    //var cod_divisao = $(this).attr("id_divisao");
    var tdobj = $(this).closest('tr').find('td');
    var cod_categoria = tdobj[0].innerHTML;
    var nome = tdobj[1].innerHTML;
    $("#rotulo_associado").html("Alterando");
    $.ajax({
        url: "pages/categoria_convenio/exibe.php",
        method: "POST",
        data: {cod_categoria : cod_categoria, nome : nome},
        dataType: "json",
        success:function (data) {
            debugger;
            $.fn.modal.Constructor.prototype.enforceFocus = function() {};
            $("#ModalEdita").modal("show");
            $("#C_codigo").val(data.codigo);
            $("#C_nome").val(data.nome);
            $('#operation').val("Update");
        }
    })
});
$("#btnInserir").click(function(){
    $("#C_codigo").prop( "disabled", true );
    $("#frmFormulario")[0].reset();
    $("#rotulo_associado").html("Cadastrando");
    $.fn.modal.Constructor.prototype.enforceFocus = function() {};
    $("#ModalEdita").modal("show");
    $('#operation').val("Add");
    var d = new Date().toLocaleString("pt-BR", {timeZone: "America/Sao_Paulo"});
});
$("#btnSalvar").click(function(event){
    event.preventDefault();
    $("#C_codigo").prop( "disabled", false );
    $('#frmFormulario').validator('validate');
    var campo_vazio = validar();
    if (campo_vazio === "validou") {
        debugger;
        if( $('#operation').val() === "Add") {
            debugger;
            $.ajax({
                url: "pages/categoria_convenio/verifica_repitido.php",
                method: "POST",
                data: $('#frmFormulario').serialize(),
                success: function (data) {

                    if (data === "nao repitido") {

                        $.ajax({
                            url: "pages/categoria_convenio/salvar.php",
                            method: "POST",
                            data: $('#frmFormulario').serialize(),
                            success: function (data) {
                                $("#frmFormulario")[0].reset();
                                if (data === "atualizado") {
                                    Swal.fire({
                                        title: "Parabens!",
                                        text: "Categoria salva com sucesso !",
                                        icon: "success",
                                        showConfirmButton: false,
                                        timer: 1500
                                    });
                                } else if (data === "cadastrado") {
                                    Swal.fire({
                                        title: "Parabens!",
                                        text: "Categoria cadastrada com sucesso !",
                                        icon: "success",
                                        showConfirmButton: false,
                                        timer: 1500
                                    });
                                }
                                $("#frmFormulario")[0].reset();
                                $("#ModalEdita").modal('hide');
                                tabela_dados.ajax.reload();
                            }
                        });
                    } else if (data === "repitido") {
                        BootstrapDialog.show({
                            closable: false,
                            title: 'Atenção',
                            message: 'A categoria : '+$("#C_nome").val()+' já existe.',
                            buttons: [{
                                cssClass: 'btn-warning',
                                label: 'Ok',
                                action: function (dialogItself) {
                                    dialogItself.close();
                                    $("#C_nome").focus();
                                }
                            }]
                        });
                    }
                }
            });
        }else{
            $.ajax({
                url: "pages/categoria_convenio/salvar.php",
                method: "POST",
                data: $('#frmFormulario').serialize(),
                success: function (data) {
                    $("#frmFormulario")[0].reset();
                    if (data === "atualizado") {
                        Swal.fire({
                            title: "Parabens!",
                            text: "Salvo com Sucesso !",
                            icon: "success",
                            showConfirmButton: false,
                            timer: 1500
                        });
                    } else if (data === "cadastrado") {
                        Swal.fire({
                            title: "Parabens!",
                            text: "Cadastrado com Sucesso !",
                            icon: "success",
                            showConfirmButton: false,
                            timer: 1500
                        });
                    }
                    $("#frmFormulario")[0].reset();
                    $("#ModalEdita").modal('hide');
                    tabela_dados.ajax.reload();
                }
            });
        }
    }else {
        debugger;
        var nome_campo;
        switch (campo_vazio) {
            case 'C_nome':
                nome_campo = "Nome";
                break;
        }
        BootstrapDialog.show({
            closable: false,
            title: 'Atenção',
            message: 'O campo ' + nome_campo + ' é obrigatório !!!',
            buttons: [{
                cssClass: 'btn-warning',
                label: 'Ok',
                action: function (dialogItself) {
                    dialogItself.close();
                    $("#" + campo_vazio).focus();
                }
            }]
        });
    }
    tabela_dados.columns.adjust().draw();
});
function validar(){
    var nome       = $('#C_nome').val();
    if (nome === ""){
        return $('#C_nome').attr('name');
    }else{
        return "validou";
    }
}