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
function visualizarPedido(id) {
    $.ajax({
        url: "/visualizarPedido",
        method: 'get',
        data: {id:id},
        success: (component) => {
            $('#painel_visualizar_pedido').html(component);
            $('#visualizarPedidoModal').modal('show');
        },
    })
}

function enviaPedido() {
    let user_id = $('#user_id').val();
    let cep = $('#cep').val();
    let uf = $('#uf').val();
    let cidade = $('#cidade').val();
    let bairro = $('#bairro').val();
    let rua = $('#rua').val();
    if (cep != '' && cep != undefined && uf != ''&& uf != undefined) {
        $.ajax({
            url: "/realizarPedido",
            method: "POST",
            data: {
                user_id: user_id,
                cep: cep,
                uf: uf,
                cidade: cidade,
                bairro: bairro,
                rua: rua
            },
            success: (pedido) => {
                let pedidoJson = JSON.parse(pedido);
                $('#produtoModal').fadeOut(() => {
                    $('button.close').trigger('click');
                    Swal.fire({
                        icon: 'success',
                        title: 'Pedido Realizado com Sucesso!',
                        html: `<a href='/exibirPedido?id=${pedidoJson.pedido.id}'> Ver Pedido!! </a>`,
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