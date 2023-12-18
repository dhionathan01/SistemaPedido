$(document).ready(function () {
    setTimeout(function() {
        $('.loading-container').fadeOut('slow', function() {
          $(this).remove();
        });
      }, 5000);
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
            $('#painel_cadastro_produto').html(component);
            $('#produtoModal').modal('show');
        },
    })
}
function obterInformacoesCEP() {
    try {
        let cep = $('#cep').val();
        if (cep.length == 9) {
            $.get(`https://viacep.com.br/ws/${cep}/json/`, function(endereco) {
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