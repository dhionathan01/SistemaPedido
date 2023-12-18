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
function obterInformacoesCEP() {
    let cep = $('#cep').val();
    $.get(`https://viacep.com.br/ws/${cep}/json/`, function(endereco) {
        console.log(endereco);
    });
  }