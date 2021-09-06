<style>
    * {
        font-family: 'Montserrat', sans-serif;
        margin: 0px;
        background-color: #cccccc;
    }
    img{
        width:250px;
    }
    h3{
        font-size: 14px;
    }
    .download h3 {
        margin-bottom: 50px;
        font-size: 25px;
    }
    a{
        text-decoration: none;
        list-style: none;
        font-size: 20px;
    }
    .logo{
        background-color: #616161;
        width: 100%;
        height: 180px;
    }
    .download p {
        color: #2d3033;
        font-weight: 600;
        text-transform: uppercase; 
    }
    .download .btn {
        margin-top: 30px; 
    }
    
    .btn {
        background-color: #1c1c1c;
        color: #fff;
        font-size: 23px;
        font-weight: 600;
        border: 0;
        -moz-border-radius: 2px;
        -webkit-border-radius: 2px;
        border-radius: 2px;
        display: inline-block;
        text-transform: uppercase; 
    }
    .btn:hover, .btn:focus {
        background-color: #1c1c1c;
        color: #fff; 
    }
    .btn-large {
        padding: 15px 40px; 
    }
    .mycontainer{
        display: flex;
        justify-content: center;
        text-align: center;
        align-items: center;
        flex-direction: column;
    }

    .container{
        z-index: 9999;
        background-color: white;
        padding-top: 90px;
        position: fixed;
        margin-top: 32%;
        border-radius: 3px;
    }
    .footer{
        background-color: #1c1c1c;
        width: 100%;
        padding: 40px 0px 40px 0px;
        margin-top: 60px;
    }
    .footer-h3{
        color: #fff;
    }
    .info{
        padding-top: 15px;
        text-align: start;
        padding-left: 10px;
        font-size: 14px;
        display: flex;
        flex-direction: column;
    }
</style>
<section id="download" class="section download mycontainer">
    <div class="logo"> 
        <div>           
        </div>
    </div>
    <div class="container ">
        <div class="col-md-8 col-md-offset-2 text-center" style="background-color: white;">
            <h3 style="background-color: white;">Cadastro realizado com sucesso!</h3>
            <p style="font-size: 14px; padding: 0px 50px; text-transform:none; background-color: white;">Olá Fulano, seu codigo para ativação da sua conta na Cincreti Store é:</p>
            <a href="" class="btn btn-large">&nbsp;1234&nbsp;</a>
        </div>
        <div class="footer">
            <h3 class="footer-h3" style="font-size: 14px; margin-bottom:30px; background-color: #1c1c1c;">Não reconhece esse e-mail?</h3>
            <p style="color:#fff; font-size: 14px; padding: 0px 50px; text-transform:none; background-color: #1c1c1c;">Entre em contato com nossos atendentes para maiores explicações.</p>
        </div>
        <div class="info">
            <span style="margin-bottom: 5px;">Cincreti Store</span>
            <span style="margin-bottom: 5px;">cincreti@cincreti.com</span>
            <span>Areado/MG</span>
        </div>
    </div>
</section>
<script src="<?php echo base_url('public/assets/js/util.js'); ?>"></script>
