$(document).ready(function () {
    setTimeout(function () {
        $('.loading-container').fadeOut('slow', function () {
            $(this).remove();
        });
    }, 1000);
});


function realizarPedido() {
    let user_id = $('#user_id').val();
    let nome = $('#nome').val();
    $.ajax({
        url: "/exibirFormulario",
        method: 'post',
        data: {
            user_id: user_id,
            nome_cliente: nome
        },
        success: (component) => {
            $('#painel_realizar_pedido').html(component);
            $('#produtoModal').modal('show');
        },
    })
}

function listarPedido() {
    $.ajax({
        url: "/listarPedidos",
        method: 'post',
        data: {},
        success: (component) => {
            $('#painel_listar_pedido').html(component);
            $('#pedidoModal').modal('show');
        },
    })
}
function abrirMenuEnvio() {
    $.ajax({
        url: "/abrirMenuEnvio",
        method: 'post',
        data: {},
        success: (component) => {
            $('#painel_menu_envio').html(component);
            $('#menuEnvioModal').modal('show');
        },
    })
}

function salvarEnvios() {
    let tipos = $('.tipo');
    let lista_envios = [];
    $(tipos).each((index, element) => {
        let envio = {
            id: $(element).find('.campo_id').val(),
            valor: $(element).find('.valor').val()
        };
        lista_envios.push(envio);
    });

    $.ajax({
        url: "/atualizarValores",
        method: 'post',
        data: {lista_envios:lista_envios},
        success: (response) => {
           toastr.success('Valores atualizados com sucesso !')
        },
    })
    
    
}
function abrirPedido(id) {
    Swal.close();
    $.ajax({
        url: "/visualizarPedido",
        method: 'get',
        data: {id:id},
        success: (component) => {
            $('.modal-backdrop').remove();
            $('#produtoModal').modal('hide');
            $('#pedidoModal').modal('hide');
            $('#painel_realizar_pedido').html('');
            $('#painel_listar_pedido').html('');
            $('#painel_visualizar_pedido').html(component);
            $('#visualizarPedidoModal').modal('show');
        },
    })
}
function updatePedido(id) {
    let endereco_id = $('#endereco_id').val();
    let cep = $('#cep').val();
    let uf = $('#uf').val();
    let cidade = $('#cidade').val();
    let bairro = $('#bairro').val();
    let rua = $('#rua').val();
    let numero = $('#numero').val();
    let envio_id = $('#envio_id').val();
    let valor = $('#valor').val();
    $.ajax({
        url: "/updatePedido",
        method: 'POST',
        data: {
            id_pedido: id,
            endereco_id: endereco_id,
            cep: cep,
            uf: uf,
            cidade: cidade,
            bairro: bairro,
            rua: rua,
            numero: numero,
            envio_id: envio_id,
            valor: valor
        },
        success: (response) => {
            $('#visualizarPedidoModal').fadeOut(() => {
                $('button.close').trigger('click');
                Swal.fire({
                    icon: 'success',
                    title: 'Pedido alterado com Sucesso!',
                    confirmButtonText: 'OK'
                  });
            })
        },
    })
}
function calcularValor(id) {
    $.ajax({
        url: "/getValorEnvio",
        method: 'post',
        data: {id:id},
        success: (envio) => {
            let envioJson = JSON.parse(envio);
            $('#valor').val(envioJson[0].valor);
        },
    })
}

function excluirPedido(id) {
    Swal.fire({
        title: 'Você tem certeza que deseja excluir?',
        text: 'Esta ação não pode ser desfeita!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sim',
        cancelButtonText: 'Não'
      }).then((result) => {
        if (result.isConfirmed) {
          $.ajax({
            url: "/excluirPedido",
            method: 'POST',
            data: {
                id_pedido: id
            },
            success: (response) => {
                $(`#pedido_${id}`).fadeOut(() => {
                    $(`#pedido_${id}`).remove()
                    Swal.fire({
                        icon: 'success',
                        title: 'Pedido excluído com sucesso!',
                        confirmButtonText: 'OK'
                      });
                })
                if ($('#visualizarPedidoModal').hasClass('show')) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Pedido excluído com sucesso!',
                        confirmButtonText: 'OK'
                    }).then((confirm) => {
                        if (confirm.isConfirmed) {
                            $('#visualizarPedidoModal').fadeOut(() => {
                                $('#visualizarPedidoModal').modal('hide');
                            });
                          }
                      });
                }
            },
        })
        }
      });
   
}

function enviaPedido() {
    let user_id = $('#user_id').val();
    let cep = $('#cep').val();
    let uf = $('#uf').val();
    let cidade = $('#cidade').val();
    let bairro = $('#bairro').val();
    let rua = $('#rua').val();
    let numero = $('#numero').val();
    let envio_id = $('#envio_id').val();
    let valor = $('#valor').val();

    if (cep != '' && cep != undefined &&
        uf != '' && uf != undefined &&
        envio_id != '' && envio_id != undefined &&
        valor != '' && valor != undefined) {
        $.ajax({
            url: "/realizarPedido",
            method: "POST",
            data: {
                user_id: user_id,
                cep: cep,
                uf: uf,
                cidade: cidade,
                bairro: bairro,
                rua: rua,
                numero: numero,
                envio_id: envio_id,
                valor: valor
            },
            success: (pedido) => {
                let pedidoJson = JSON.parse(pedido);
                $('#produtoModal').fadeOut(() => {
                    $('button.close').trigger('click');
                    Swal.fire({
                        icon: 'success',
                        title: 'Pedido Realizado com Sucesso!',
                        html: `<a href='#' onclick="abrirPedido(${pedidoJson.pedido.id})"> Ver Pedido!! </a>`,
                        confirmButtonText: 'OK'
                      });
                })
            },
        });
    } else {
        toastr.error('Informações inválidas, certifique de preencher todos os campos');
    }
}

function obterInformacoesCEP() {
    try {
        let cep = $('#cep').val();
        if (cep.length == 9) {
            $.get(`https://viacep.com.br/ws/${cep}/json/`, function (endereco) {
                // Verifica se o CEP foi encontrado
                if (endereco.erro) {
                    throw new Error('CEP não encontrado');
                }
                // Preenche os campos do formulário com as informações
                $("#rua").val(endereco.logradouro);
                $("#bairro").val(endereco.bairro);
                $("#cidade").val(endereco.localidade);
                $("#uf").val(endereco.uf);

            });
        } else {
            throw new Error('CEP Inválido');
        }
    } catch (error) {
        // Exibe um toast de erro caso ocorra uma exceção
        toastr.error('CEP inválido ou não encontrado');
        $('#cep').val('');
    }
}

function mascaraCEP(cep) {
    cep = cep.replace(/\D/g, ''); // Remove caracteres não numéricos
    cep = cep.replace(/^(\d{5})(\d)/, '$1-$2'); // Adiciona o hífen após os primeiros 5 dígitos
    return cep;
}