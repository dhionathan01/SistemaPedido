function realizarPedido() {
    $.ajax({
        url: "/exibirFormulario",
        method: 'post',
        data: {},
        success: (component) => {
            $('#painel_cadastro_produto').html(component);
            $('#produtoModal').modal('show');
        },
    })
}
