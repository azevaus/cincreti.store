var App = function() {
    var calcula_frete = function() {
        $("#btn_calcula_frete").on('click', function() {
            var produto_id = $(this).attr('data-id');
            var cep = $("#cep").val();
            $.ajax({
                type: 'post',
                url: BASE_URL + 'ajax/index',
                dataType: 'json',
                data: {
                    cep: cep,
                    produto_id: produto_id,
                },
                beforeSend: function() {
                    $("#btn_calcula_frete").html('<span class="text-white"><i class="fa fa-cog fa-spin"></i>&nbsp;Processando...</span>');
                },
            }).then(function(response) {
                $("#btn_calcula_frete").html('Calcular');
                $("#retorno_frete").html(response.retorno_endereco);
                console.log(response);
            });
        });
    };
    var add_item_cart = function() {
        $(".btn-add-produto").on('click', function() {
            var produto_id = $(this).attr('data-id');
            var produto_quantidade = $('#produto_quantidade').val();
            $.ajax({
                type: 'post',
                url: BASE_URL + 'cart/insert',
                dataType: 'json',
                data: {
                    produto_id: produto_id,
                    produto_quantidade: produto_quantidade,
                },
                beforeSend: function() {
                    $(".btn-add-produto").html('<span class="text-white"><i class="fa fa-cog fa-spin"></i>&nbsp;Adicionando...</span>');
                },
            }).then(function(response) {
                $('#top-cart').load(' #top-cart > *');
                $('#list-itens').load(' #list-itens > *');
                $(".btn-add-produto").html('Add ao carrinho');
                $("#mensagem").html('<div style="width:52.5%" class="alert alert-success alert-dismissible fade show mt-2" role="alert">' + response.mensagem + '<button type="button" class="close" data-dismiss="alert" arial-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                console.log(response);
            });

        });
    }
    var add_item_favoritos = function() {
        $(".btn-add-favoritos").on('click', function() {
            var produto_id = $(this).attr('data-id');
            $.ajax({
                type: 'post',
                url: BASE_URL + 'favoritos/insert',
                dataType: 'json',
                data: {
                    produto_id: produto_id,
                },
                beforeSend: function() {
                    $(".btn-add-favoritos").html('<span class="text-black"><i class="fa fa-cog fa-spin"></i>&nbsp;Adicionando...</span>');
                },
            }).then(function(response) {
                $('#top-cart').load(' #top-cart > *');
                $('#list-itens').load(' #list-itens > *');
                $(".btn-add-favoritos").html('Add ao carrinho');
                $("#mensagem").html('<div style="width:52.5%" class="alert alert-success alert-dismissible fade show mt-2" role="alert">' + response.mensagem + '<button type="button" class="close" data-dismiss="alert" arial-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                console.log(response);
            });

        });
    }
    var add_item_cart_home = function() {
        $(".btn-add-produto-home").on('click', function() {
            var produto_id = $(this).attr('data-id');
            $.ajax({
                type: 'post',
                url: BASE_URL + 'welcome/insert',
                dataType: 'json',
                data: {
                    produto_id: produto_id,
                },
                beforeSend: function() {
                    $(".btn-add-produto-home").html('<span class="text-white"><i class="fa fa-cog fa-spin"></i>&nbsp;Adicionando...</span>');
                },
            }).then(function(response) {
                $('#top-cart').load(' #top-cart > *');
                $('#list-itens').load(' #list-itens > *');
                $(".btn-add-produto-home").html('Add ao carrinho');
                $("#mensagem").html('<div style="width:52.5%" class="alert alert-success alert-dismissible fade show mt-2" role="alert">' + response.mensagem + '<button type="button" class="close" data-dismiss="alert" arial-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                console.log(response);
            });

        });
    }
    return {
        init: function() {
            calcula_frete();
            add_item_cart();
            add_item_favoritos();
            add_item_cart_home();
        }
    }
}(); //Inicializa ao carregar
jQuery(document).ready(function() {
    $(window).keydown(function(event) {
        if (event.keyCode == 13) {
            event.preventDefault();
            return false;
        }
    });
    App.init(); //Inicializa app
});