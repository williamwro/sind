var usuario_global;
var divisao;
var tabela_dados;
$(document).ready(function(){

    $('#operation').val("Add");
    divisao = sessionStorage.getItem("divisao");
    usuario_global = sessionStorage.getItem("usuario_global");
    $.getJSON( "pages/empregador/divisao.php", function( data ) {
        $.each(data, function (index, value) {
            $('#C_divisao').append('<option value="' + value.id_divisao + '">' + value.nome + '</option>');
        });
    });
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
            "url": 'pages/empregador/datatable.php',
            "method": 'POST',
            "data": function (data) {
                data.divisao = divisao;
            },
            "dataType": 'json'
        },
        "order": [[ 0, "asc" ]],
        "columns": [
            { "data": "id" },
            { "data": "nome" },
            { "data": "responsavel" },
            { "data": "telefone" },
            { "data": "abreviacao" },
            { "data": "nome_divisao" },
            { "data": "cidade" },
            { "data": "botao" },
            { "data": "botaoexcluir" }
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
    var cod_empregador = tdobj[0].innerHTML;
    var nome = tdobj[1].innerHTML;
    var divisao = tdobj[5].innerHTML;
    $("#rotulo_associado").html("Alterando");
    $.ajax({
        url: "pages/empregador/exibe.php",
        method: "POST",
        data: {cod_empregador : cod_empregador,nome : nome,divisao : divisao},
        dataType: "json",
        success:function (data) {
            debugger;
            $.fn.modal.Constructor.prototype.enforceFocus = function() {};
            $("#ModalEdita").modal("show");
            $("#C_codigo").val(data.id);
            $("#C_nome").val(data.nome);
            $("#C_nome_original").val(data.nome);
            $("#C_responsavel").val(data.responsavel);
            $("#C_telefone").val(data.telefone);
            $("#C_abreviacao").val(data.abreviacao);
            $("#C_divisao").val(data.divisao);
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
   var divisao = $("#C_divisao").val();
   var campo_vazio = validar();
   if (campo_vazio === "validou") {
       debugger;
       if( $('#operation').val() === "Add") {
           debugger;
           $.ajax({
               url: "pages/empregador/verifica_repitido.php",
               method: "POST",
               data: $('#frmFormulario').serialize(),
               success: function (data) {

                   if (data === "nao repitido") {

                       $.ajax({
                           url: "pages/empregador/salvar.php",
                           method: "POST",
                           data: $('#frmFormulario').serialize(),
                           success: function (data) {
                               $("#frmFormulario")[0].reset();
                               if (data === "atualizado") {
                                   $.notify({
                                           message: 'Salvo com Sucesso!'
                                       }, {
                                           type: 'success'
                                       }, {
                                           position: 'center'
                                       }
                                   );
                               } else if (data === "cadastrado") {

                                   $.notify({
                                           message: 'Cadastrado com Sucesso!'
                                       }, {
                                           type: 'success'
                                       }, {
                                           position: 'center'
                                       }
                                   );
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
                           message: 'O empregador : '+$("#C_nome").val()+' já existe na divisão: '+$( "#C_divisao option:selected" ).text()+'.',
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
               url: "pages/empregador/salvar.php",
               method: "POST",
               data: $('#frmFormulario').serialize(),
               success: function (data) {
                   $("#frmFormulario")[0].reset();
                   if (data === "atualizado") {
                       $.notify({
                               message: 'Salvo com Sucesso!'
                           }, {
                               type: 'success'
                           }, {
                               position: 'center'
                           }
                       );
                   } else if (data === "cadastrado") {

                       $.notify({
                               message: 'Cadastrado com Sucesso!'
                           }, {
                               type: 'success'
                           }, {
                               position: 'center'
                           }
                       );
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
           case 'C_cidade':
               nome_campo = "C_cidade";
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
$('#tabela_dados').on('click', 'tbody .btnexcluir', function () {
    debugger;
    var data_row = tabela_dados.row($(this).closest('tr')).data();
    var cod_empregador = data_row.id;
    var nome = data_row.nome;
    var divisao = data_row.nome_divisao;
    $.ajax({
        url: "pages/empregador/valid_excluir.php",
        method: "POST",
        dataType: "json",
        data: {"cod_empregador": cod_empregador},
        success: function (data) {
        debugger;
            if (data.Resultado === "nao existe conta") {
                BootstrapDialog.confirm({
                    message: '<table style="width: 100%;"><tr><th style="text-align: right;padding: 8px;background-color: #dddddd;">CODIGO:</th><th style="background-color: #dddddd;"><b>' + cod_empregador + '</b></th>' +
                        '<tr><th style="text-align: right;padding: 8px;">NOME:</th><th><b>' + nome + '</th>' +
                        '<tr><th style="text-align: right;padding: 8px;background-color: #dddddd;">DIVISÃO:</th><th style="background-color: #dddddd;"><b>' + divisao + '</th>',
                    title: 'Confirma a exclusão do empregador ?',
                    type: BootstrapDialog.TYPE_PRIMARY,
                    closable: true,
                    draggable: true,
                    btnCancelLabel: 'Não',
                    btnOKLabel: 'Sim',
                    btnOKClass: 'btn btn-success',
                    btnCancelClass: 'btn btn-warning',
                    callback: function (result) {
                        if (result) {
                            waitingDialog.show('Excluindo, aguarde ...');
                            $.ajax({
                                url: "pages/empregador/excluir.php",
                                method: "POST",
                                dataType: "json",
                                data: {"cod_empregador": cod_empregador},
                                success: function (data) {
                                    debugger;
                                    if (data.Resultado === "excluido") {

                                        //tabela_dados.row( $button.parents('tr') ).remove().draw();
                                        //alert("Excluido com sucesso");
                                        waitingDialog.hide();
                                        BootstrapDialog.show({
                                            closable: false,
                                            title: 'Atenção',
                                            message: 'Excluído com Sucesso!!!',
                                            buttons: [{
                                                cssClass: 'btn-warning',
                                                label: 'Ok',
                                                action: function (dialogItself) {
                                                    dialogItself.close();
                                                    //$("#C_Senha").focus();
                                                }
                                            }]
                                        });
                                    }else{
                                        alert("Não Excluiu");
                                        waitingDialog.hide();
                                    }
                                    tabela_dados.ajax.reload();
                                }
                            });
                        } else {
                            //alert('No');
                        }
                    }
                });
            }else if (data.Resultado === "existe conta") {
                BootstrapDialog.show({
                    closable: false,
                    title: 'Atenção',
                    message: 'Não é possível exluir, existem lançamentos para este empregador!',
                    buttons: [{
                        cssClass: 'btn-warning',
                        label: 'Ok',
                        action: function(dialogItself){
                            dialogItself.close();
                            $("#C_nome").focus();
                        }
                    }]
                });
            }
        }
    });
});
function validar(){
    debugger;
    var nome       = $('#C_nome').val();
    var abreviacao = $('#C_abreviacao').val();
    var divisao    = $('#C_divisao').val();
    if (nome === ""){
        return $('#C_nome').attr('name');
    }else if (abreviacao === "") {
        return $('#C_abreviacao').attr('name');
    }else if (divisao === "") {
        return $('#C_divisao').attr('name');
    }else{
        return "validou";
    }
}