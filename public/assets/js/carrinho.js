var App_carrinho = function() {
    var del_item_cart = function() {
        $(".btn-del-item").on('click', function() {
            var produto_id = $(this).attr('data-id');
            var produto_quantidade = $('#produto_quantidade').val();
            $.ajax({
                type: 'post',
                url: BASE_URL + 'carrinho/delete',
                dataType: 'json',
                data: {
                    produto_id: produto_id,
                },

            }).then(function(response) {
                if (response.erro === 0) {
                    $(this).parent().parent().remove(); //REMOVE A LINHA
                    window.location.href = BASE_URL + 'carrinho';
                } else {
                    alert('Nao foi possivel excluir o produto. Contacte o suporte.')
                }
                console.log(response);
            });

        });
    }
    var altera_qtd_cart = function() {
        $(".btn-altera-quantidade").on('click', function() {
            var produto_id = $(this).attr('data-id');
            var produto_quantidade = $("#produto_" + produto_id).val();
            if (produto_quantidade == "" || produto_quantidade < 1) {
                $("#mensagem").html('<div class="alert alert-danger alert-dismissible fade show mb-2" role="alert">Informe a quantidade maior que zero.<button type="button" class="close" data-dismiss="alert" arial-label="Close"><span aria-hidden="true">&times;</span></button></div>');
            } else {
                $.ajax({
                    type: 'post',
                    url: BASE_URL + 'carrinho/update',
                    dataType: 'json',
                    data: {
                        produto_id: produto_id,
                        produto_quantidade: produto_quantidade,
                    },
                }).then(function(response) {
                    if (response.erro === 0) {
                        window.location.href = BASE_URL + 'carrinho';
                    } else {
                        $("#mensagem").html('<div class="alert alert-danger alert-dismissible fade show mb-2" role="alert">' + response.mensagem + '<button type="button" class="close" data-dismiss="alert" arial-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                    }
                    console.log(response);
                });
            }
        });
    }
    var limpa_cart = function() {
        $(".btn-limpa-cart").on('click', function() {
            $.ajax({
                type: 'post',
                url: BASE_URL + 'carrinho/clean',
                dataType: 'json',
                data: {
                    clean: true
                },
            }).then(function(response) {
                if (response.erro === 0) {
                    window.location.href = BASE_URL + 'carrinho';
                } else {
                    alert('Houve um erro ao limpar o carrinho, entre em contato com nosso suporte');
                }
                console.log(response);
            });
        });
    }
    var calucula_frete = function() {
        $("#btn-calcula-frete").on('click', function() {
            var cep = $('#cep').val();
            $.ajax({
                type: 'post',
                url: BASE_URL + 'carrinho/calcula_frete',
                dataType: 'json',
                data: {
                    cep: cep,
                },
                beforeSend: function() {
                    $("#btn-calcula-frete").html('<span class="text-white"><i class="fa fa-cog fa-spin"></i>&nbsp;Calculando...</span>');
                },
            }).then(function(response) {
                if (response.erro === 0) {
                    $('#retorno_frete').html(response.retorno_endereco);
                    $("#btn-calcula-frete").html('Calcular');
                    get_opcao_frete_carrinho(); //chama a funcao no response para criar o name
                } else {
                    //erro
                    $('#retorno_frete').html(response.retorno_endereco);
                }
                console.log(response);
            });

        });
    }
    var get_opcao_frete_carrinho = function() {
        $('[name="opcao_frete_carrinho"]').on('click', function() {
            var opcao_frete_escolhido = $(this).attr('data-valor-frete');
            var total_final_carrinho = $(this).attr('data-valor-final-carrinho');
            $('#opcao_frete_ecolhido').html('R$&nbsp;' + opcao_frete_escolhido);
            $('#total_final_carrinho').html('R$&nbsp;' + total_final_carrinho);
        });
    }
    return {
        init: function() {
            del_item_cart();
            altera_qtd_cart();
            limpa_cart();
            calucula_frete();
        }
    }
}();
jQuery(document).ready(function() {
    $(window).keydown(function(event) {
        if (event.keyCode == 13) {
            event.preventDefault();
            return false;
        }
    });
    App_carrinho.init();
});