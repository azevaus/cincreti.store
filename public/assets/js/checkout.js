var App_checkout = function() {
    var set_session_payment = function() {
        $.ajax({
            url: BASE_URL + 'pagar/pagseguro_session_id',
            dataType: 'json',
            success: function(response) {
                if (response.erro === 0) {
                    var session_id = response.session_id;
                    if (session_id) {
                        PagSeguroDirectPayment.setSessionId(session_id);
                    } else {
                        window.location.href = BASE_URL + 'checkout';
                    }
                } else {
                    console.log(response.mensagem);
                }
            },
            error: function(error) {
                alert('Nao foi possivel integrar com o pagseguro');
            }
        });
    }
    var forma_pagamento = function() {
        $('.forma_pagamento').on('change', function() {
            var opcao = $(this).val();
            switch (opcao) {
                case '1':
                    $('.cartao').removeClass('d-none');
                    $('.opcao_debito_conta').addClass('d-none');
                    $('.opcao_boleto').addClass('d-none');
                    $('.cartao input').prop('disabled', false);
                    $('.opcao_debito_conta select').prop('disabled', true);
                    break;
                case '2':
                    $('.cartao').addClass('d-none');
                    $('.opcao_boleto').removeClass('d-none');
                    $('.opcao_debito_conta').addClass('d-none');
                    $('.cartao input').prop('disabled', true);
                    $('.opcao_debito_conta select').prop('disabled', true);
                    break;
                case '3':
                    $('.cartao').addClass('d-none');
                    $('.opcao_debito_conta').removeClass('d-none');
                    $('.opcao_boleto').addClass('d-none');
                    $('.cartao input').prop('disabled', true);
                    $('.opcao_debito_conta select').prop('disabled', false);
                    break;
            }
            //alert(opcao);
        });
    }
    var calcula_frete = function() {
        $("#btn_busca_cep").on('click', function() {
            var client_state = $('#client_state').val();
            $.ajax({
                type: 'post',
                url: BASE_URL + 'checkout/calcula_frete',
                dataType: 'json',
                data: {
                    client_state: client_state,
                },
                beforeSend: function() {
                    $('#erro_frete').html('');
                    $('.endereco').addClass('d-none');
                    $("#btn_busca_cep").html('<span class="text-white"><i class="fa fa-cog fa-spin"></i>&nbsp;Calculando...</span>');
                },
            }).then(function(response) {
                if (response.erro === 0) {
                    $('.endereco').removeClass('d-none'); //exibe os campos excondidos
                    $("#btn_busca_cep").html('Calcular');
                    $('#retorno_frete').html(response.retorno_endereco);
                    //preenchendo os inputs com os valores adequados
                    $('[name="client_address"]').val(response.endereco);
                    $('[name="client_district"]').val(response.bairro);
                    $('[name="client_city]').val(response.cidade);
                    get_opcao_frete_carrinho(); //chama a funcao no response para criar o name
                } else {
                    //erro
                    $("#btn_busca_cep").html('Calcular');
                    $('#erro_frete').html(response.retorno_endereco);
                }
                console.log(response);
            });

        });
    }
    var pagar_boleto = function() {
        $('#btn_pagar_boleto').on('click', function() {
            $('[name="hash_pagamento"]').val(PagSeguroDirectPayment.getSenderHash());
            var form = $('.do-payment');
            $.ajax({
                type: "post",
                url: BASE_URL + 'pagar/boleto',
                dataType: 'json',
                data: form.serialize(),
                beforeSend: function() {
                    //apagar erros quando ouver
                    $("#btn_pagar_boleto").html('<span class="text-white"><i class="fa fa-cog fa-spin"></i>&nbsp;Processando...</span>');
                    $('#cliente_nome').html('');
                    $('#cliente_sobrenome').html('');
                    $('#cliente_data_nascimento').html('');
                    $('#cliente_cpf').html('');
                    $('#cliente_email').html('');
                    $('#cliente_telefone_movel').html('');
                    $('#erro_frete').html(''); //erro frete pois ja existe o id cliente_cep
                    $('#cliente_endereco').html('');
                    $('#cliente_numero_endereco').html('');
                    $('#cliente_bairro').html('');
                    $('#cliente_cidade').html('');
                    $('#cliente_estado').html('');
                    $('#cliente_senha').html('');
                    $('#confirmacao').html('');
                    $('#opcao_frete_carrinho').html('');
                },
                success: function(response) {
                    if (response.erro === 0) {
                        window.location = BASE_URL + 'sucesso';
                        $("#btn_pagar_boleto").html('Pagar com boleto');
                    } else {
                        console.log(response.mensagem);
                        $("#btn_pagar_boleto").html('Pagar com boleto');
                        $('#cliente_nome').html(response.cliente_nome);
                        $('#cliente_sobrenome').html(response.cliente_sobrenome);
                        $('#cliente_data_nascimento').html(response.cliente_data_nascimento);
                        $('#cliente_cpf').html(response.cliente_cpf);
                        $('#cliente_email').html(response.cliente_email);
                        $('#cliente_telefone_movel').html(response.cliente_telefone_movel);
                        $('#erro_frete').html(response.cliente_cep); //erro frete pois ja existe o id cliente_cep
                        $('#cliente_endereco').html(response.cliente_endereco);
                        $('#cliente_numero_endereco').html(response.cliente_numero_endereco);
                        $('#cliente_bairro').html(response.cliente_bairro);
                        $('#cliente_cidade').html(response.cliente_cidade);
                        $('#cliente_estado').html(response.cliente_estado);
                        $('#cliente_senha').html(response.cliente_senha);
                        $('#confirmacao').html(response.confirmacao);
                        $('#opcao_frete_carrinho').html(response.opcao_frete_carrinho);
                    }
                },
                error: function(error) {
                    alert('Nao foi possivel processar o pagamento. Contacte o suporte.');
                }
            });
        });
    }
    var pagar_debito = function() {
        $('#btn_pagar_debito').on('click', function() {
            $('[name="hash_pagamento"]').val(PagSeguroDirectPayment.getSenderHash());
            var form = $('.do-payment');
            $.ajax({
                type: "post",
                url: BASE_URL + 'pagar/debito_conta',
                dataType: 'json',
                data: form.serialize(),
                beforeSend: function() {
                    //apagar erros quando ouver
                    $("#btn_pagar_debito").html('<span class="text-white"><i class="fa fa-cog fa-spin"></i>&nbsp;Processando...</span>');
                    $('#cliente_nome').html('');
                    $('#cliente_sobrenome').html('');
                    $('#cliente_data_nascimento').html('');
                    $('#cliente_cpf').html('');
                    $('#cliente_email').html('');
                    $('#cliente_telefone_movel').html('');
                    $('#erro_frete').html(''); //erro frete pois ja existe o id cliente_cep
                    $('#cliente_endereco').html('');
                    $('#cliente_numero_endereco').html('');
                    $('#cliente_bairro').html('');
                    $('#cliente_cidade').html('');
                    $('#cliente_estado').html('');
                    $('#cliente_senha').html('');
                    $('#confirmacao').html('');
                    $('#opcao_frete_carrinho').html('');
                },
                success: function(response) {
                    if (response.erro === 0) {
                        window.location = BASE_URL + 'sucesso';
                        $("#btn_pagar_debito").html('Pagar com débito em conta');
                    } else {
                        console.log(response.mensagem);
                        $("#btn_pagar_debito").html('Pagar com boleto');
                        $('#cliente_nome').html(response.cliente_nome);
                        $('#cliente_sobrenome').html(response.cliente_sobrenome);
                        $('#cliente_data_nascimento').html(response.cliente_data_nascimento);
                        $('#cliente_cpf').html(response.cliente_cpf);
                        $('#cliente_email').html(response.cliente_email);
                        $('#cliente_telefone_movel').html(response.cliente_telefone_movel);
                        $('#erro_frete').html(response.cliente_cep); //erro frete pois ja existe o id cliente_cep
                        $('#cliente_endereco').html(response.cliente_endereco);
                        $('#cliente_numero_endereco').html(response.cliente_numero_endereco);
                        $('#cliente_bairro').html(response.cliente_bairro);
                        $('#cliente_cidade').html(response.cliente_cidade);
                        $('#cliente_estado').html(response.cliente_estado);
                        $('#cliente_senha').html(response.cliente_senha);
                        $('#confirmacao').html(response.confirmacao);
                        $('#opcao_frete_carrinho').html(response.opcao_frete_carrinho);
                        $('#opcao_banco').html(response.opcao_banco);
                    }
                },
                error: function(error) {
                    alert('Nao foi possivel processar o pagamento. Contacte o suporte.');
                }
            });
        });
    }
    var pagar_credito = function() {
        $('#btn_pagar_cartao').on('click', function() {
            gerar_token_pagamento();
            $('[name="hash_pagamento"]').val(PagSeguroDirectPayment.getSenderHash());
            var form = $('.do-payment');
            $.ajax({
                type: "post",
                url: BASE_URL + 'pagar/cartao_credito',
                dataType: 'json',
                data: form.serialize(),
                beforeSend: function() {
                    //apagar erros quando ouver
                    $("#btn_pagar_cartao").html('<span class="text-white"><i class="fa fa-cog fa-spin"></i>&nbsp;Processando...</span>');
                    $('#cliente_nome').html('');
                    $('#cliente_sobrenome').html('');
                    $('#cliente_data_nascimento').html('');
                    $('#cliente_cpf').html('');
                    $('#cliente_email').html('');
                    $('#cliente_telefone_movel').html('');
                    $('#erro_frete').html(''); //erro frete pois ja existe o id cliente_cep
                    $('#cliente_endereco').html('');
                    $('#cliente_numero_endereco').html('');
                    $('#cliente_bairro').html('');
                    $('#cliente_cidade').html('');
                    $('#cliente_estado').html('');
                    $('#cliente_senha').html('');
                    $('#confirmacao').html('');
                    $('#opcao_frete_carrinho').html('');
                },
                success: function(response) {
                    if (response.erro === 0) {
                        window.location = BASE_URL + 'sucesso';
                    } else {
                        if (response.token_pagamento) {
                            $('#erro_cartao').html('<span class="text-white">Verifique os dados do cartao e tente novamente.</span>');
                            gerar_token_pagamento();
                        }

                        $("#btn_pagar_cartao").html('Pagar com cartao de crédito');
                        $('#cliente_nome').html(response.cliente_nome);
                        $('#cliente_sobrenome').html(response.cliente_sobrenome);
                        $('#cliente_data_nascimento').html(response.cliente_data_nascimento);
                        $('#cliente_cpf').html(response.cliente_cpf);
                        $('#cliente_email').html(response.cliente_email);
                        $('#cliente_telefone_movel').html(response.cliente_telefone_movel);
                        $('#erro_frete').html(response.cliente_cep); //erro frete pois ja existe o id cliente_cep
                        $('#cliente_endereco').html(response.cliente_endereco);
                        $('#cliente_numero_endereco').html(response.cliente_numero_endereco);
                        $('#cliente_bairro').html(response.cliente_bairro);
                        $('#cliente_cidade').html(response.cliente_cidade);
                        $('#cliente_estado').html(response.cliente_estado);
                        $('#cliente_senha').html(response.cliente_senha);
                        $('#confirmacao').html(response.confirmacao);
                        $('#opcao_frete_carrinho').html(response.opcao_frete_carrinho);
                    }
                },
                error: function(error) {
                    alert('Nao foi possivel processar o pagamento. Contacte o suporte.');
                }
            });
        });

        function gerar_token_pagamento() {
            var card_titular = $('[name="cliente_nome_titular"]').val();
            if (!card_titular) {
                $('#cliente_nome_titular').html("Obrigatório");
                return false;
            }
            var card_number = $('[name="numero_cartao"]').val();
            if (!card_number) {
                $('#numero_cartao').html("Obrigatório");
                return false;
            }
            var card_validade = $('[name="validade_cartao"]').val();
            if (!card_validade) {
                $('#validade_cartao').html("Obrigatório");
                return false;
            } else {
                card_validade = card_validade.split('/');
                var mes_validade = card_validade[0];
                var ano_validade = card_validade[1];
            }
            var card_ccv = $('[name="codigo_seguranca"]').val();
            if (!card_ccv) {
                $('#codigo_seguranca').html("Obrigatório");
                return false;
            }
            var bandeira = "";
            PagSeguroDirectPayment.getBrand({
                cardBin: card_number.replace(" ", ""), //fazemos um replace no primeiro espaco para ser gerado o cardBin
                success: function(response) {
                    bandeira = response.brand['name'];
                    if (bandeira) {
                        //sucesso... bandeira foi gerada
                        PagSeguroDirectPayment.createCardToken({ //gerar o token do cartao de credito
                            cardNumber: card_number,
                            brand: bandeira,
                            cvv: card_ccv,
                            expirationMonth: mes_validade,
                            expirationYear: ano_validade,
                            success: function(response) { //foi gerado o token do cartao de credito
                                var token_pagamento = response.card.token;
                                if (token_pagamento) {
                                    $("#token_pagamento").val(token_pagamento);
                                } else {
                                    alert('Houve um erro ao gerar o token do cartao')
                                }
                            },
                            error: function(response) {
                                alert('Houve um erro ao gerar o token do cartao' + response.message);
                            }
                        });
                    } else {
                        alert('Nao foi possivel gerar a bandeira do cartao' + response.statusMessage);
                    }
                },
                error: function(response) {
                    alert(response);
                }
            });

        }
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
            set_session_payment();
            forma_pagamento();
            calcula_frete();
            pagar_boleto();
            pagar_debito();
            pagar_credito();
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
    App_checkout.init();
});